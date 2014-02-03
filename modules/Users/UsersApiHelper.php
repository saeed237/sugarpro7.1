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

class UsersApiHelper extends SugarBeanApiHelper
{
    /**
     * Formats the bean so it is ready to be handed back to the API's client.
     * Checks if user has access to a given record (if record module/id is specified in the api args)
     *
     * @param $bean SugarBean The bean you want formatted
     * @param $fieldList array Which fields do you want formatted and returned (leave blank for all fields)
     * @param $options array Currently no options are supported
     * @return array The bean in array format, ready for passing out the API to clients.
     */
    public function formatForApi(SugarBean $bean, array $fieldList = array(), array $options = array())
    {
        $data = parent::formatForApi($bean, $fieldList, $options);

        $args = $options['args'];
        if (!empty($args['has_access_module']) && !empty($args['has_access_record'])) {
            $data['has_access'] = $this->checkUserAccess($bean, $args['has_access_module'], $args['has_access_record']);
        }

        return $data;
    }

    /**
     * Uses the checkUserAccess SugarBean method to see if the user being formatted has access to the given record
     *
     * @param SugarBean $user The user to check access for
     * @param $module The module of the record we're checking access to
     * @param $recordId The id of the record we're checking access to
     * @return bool True if the user has access, false otherwise
     */
    protected function checkUserAccess(SugarBean $user, $module, $recordId)
    {
        $record = BeanFactory::getBean($module);
        $record->id = $recordId;
        return $record->checkUserAccess($user);
    }


    public function populateFromApi(SugarBean $bean, array $submittedData, array $options = array())
    {
        parent::populateFromApi($bean, $submittedData, $options);
        if (!$bean->new_with_id && !empty($bean->id)) {
            return true;
        }

        if (empty($submittedData) || empty($submittedData['user_name'])) {
            throw new SugarApiExceptionMissingParameter("Missing username");
        }

        return true;
    }
}
