<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

require_once('data/SugarBeanApiHelper.php');

class CampaignLogApiHelper extends SugarBeanApiHelper
{
    /**
     * This function adds support for the related_name field (of type 'function' which is no longer supported)
     * @param $bean SugarBean The bean you want formatted
     * @param $fieldList array Which fields do you want formatted and returned (leave blank for all fields)
     * @param $options array Currently no options are supported
     * @return array The bean in array format, ready for passing out the API to clients.
     */
    public function formatForApi(SugarBean $bean, array $fieldList = array(), array $options = array())
    {
        $data = parent::formatForApi($bean, $fieldList, $options);

        if(in_array('related_name', $fieldList) && !empty($bean->related_id) && !empty($bean->related_type)) {
            $relatedBean = BeanFactory::getBean($bean->related_type, $bean->related_id);
            if(!empty($relatedBean)) {
                if ($bean->related_type == 'CampaignTrackers') {
                    $relatedNameField = 'tracker_url';
                } elseif ($bean->related_type == 'Contacts' || $bean->related_type == 'Leads' || $bean->related_type == 'Prospects') {
                    $relatedNameField = 'full_name';
                } else {
                    $relatedNameField = 'name';
                }

                $data['parent_id'] = $bean->related_id;
                $data['parent_type'] = $bean->related_type;
                $data['related_name'] = $relatedBean->$relatedNameField;
            }
        }
        return $data;
    }
}
