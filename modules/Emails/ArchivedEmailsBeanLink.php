<?php
/*********************************************************************************
 * By installing or using this file, you are confirming on behalf of the entity
* subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
* the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
* http://www.sugarcrm.com/master-subscription-agreement
*
* If Company is not bound by the MSA, then by installing or using this file
* you are agreeing unconditionally that Company will be bound by the MSA and
* certifying that you have authority to bind Company accordingly.
*
* Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
********************************************************************************/

require_once 'modules/Emails/ArchivedEmailsLink.php';

/**
 * Link collects archived emails - both directly assigned and
 * related by email address, and also the same from related bean
 */
class ArchivedEmailsBeanLink extends ArchivedEmailsLink
{

    /**
     * Override to go to both direct emails and linked bean
     * @see ArchivedEmailsLink::getEmailsJoin()
     */
    protected function getEmailsJoin($params = array())
    {
        $relation = $this->def['link'];
        $this->focus->load_relationship($relation);
        if (empty($this->focus->$relation)) {
            $GLOBALS['log']->error("Bad relation '$relation' for bean '{$this->focus->object_name}' id '{$this->focus->id}'");
            // produce join that is always empty
            return "inner join (select null id) nothing on 1 != 1";
        }

        $rel_module = $this->focus->$relation->getRelatedModuleName();
        $rel_join = $this->focus->$relation->getJoin(array('join_table_alias' => 'link_bean', 'join_table_link_alias' => 'linkt'));

        $bean_id = $this->db->quoted($this->focus->id);
        if (!empty($params['join_table_alias'])) {
            $table_name = $params['join_table_alias'];
        } else {
            $table_name = 'emails';
        }
        $rel_join = str_replace("{$this->focus->table_name}.id", $bean_id, $rel_join);
        return "INNER JOIN (\n".
        // directly assigned emails
        	"select eb.email_id, 'direct' source FROM emails_beans eb where eb.bean_module = '{$this->focus->module_dir}'
                AND eb.bean_id = $bean_id AND eb.deleted=0\n" .
        " UNION ".
        // Assigned to contacts
        	"select DISTINCT eb.email_id, 'contact' source FROM emails_beans eb
                $rel_join AND link_bean.id = eb.bean_id
        		where eb.bean_module = '$rel_module' AND eb.deleted=0\n" .
        " UNION ".
        // Related by directly by email
            "select DISTINCT eear.email_id, 'relate' source  from emails_email_addr_rel eear INNER JOIN email_addr_bean_rel eabr
            	ON eabr.bean_id = $bean_id AND eabr.bean_module = '{$this->focus->module_dir}' AND
    			eabr.email_address_id = eear.email_address_id and eabr.deleted=0 where eear.deleted=0\n" .
        " UNION ".
        // Related by email to linked contact
            "select DISTINCT eear.email_id, 'relate_contact' source FROM emails_email_addr_rel eear INNER JOIN email_addr_bean_rel eabr
            	ON eabr.email_address_id=eear.email_address_id AND eabr.bean_module = '$rel_module' AND eabr.deleted=0
            	$rel_join AND link_bean.id = eabr.bean_id
            	where eear.deleted=0\n" .
      ") email_ids ON $table_name.id=email_ids.email_id ";
    }
}
