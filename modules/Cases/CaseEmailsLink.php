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

require_once 'modules/Emails/ArchivedEmailsBeanLink.php';

/**
 * Links connected emails for a case
 */
class CaseEmailsLink extends ArchivedEmailsBeanLink
{

    /**
     * We need this one because cases have match by subject macro
     * @see ArchivedEmailsBeanLink::getEmailsJoin()
     */
    protected function getEmailsJoin($params = array())
    {
        $join = parent::getEmailsJoin($params);
        if ($this->focus instanceof aCase && !empty($this->focus->case_number)) {
            $where = str_replace("%1", $this->focus->case_number, $this->focus->getEmailSubjectMacro());
            if (!empty($params['join_table_alias'])) {
                $table_name = $params['join_table_alias'];
            } else {
                $table_name = 'emails';
            }
            $join .= " AND (email_ids.source = 'direct' OR {$table_name}.name LIKE '%$where%')";
        }
        return $join;
    }
}
