<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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


class DuplicateCheckApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'duplicateCheck' => array(
                'reqType' => 'POST',
                'path' => array('<module>','duplicateCheck'),
                'pathVars' => array('module',''),
                'method' => 'checkForDuplicates',
                'shortHelp' => 'Check for duplicate records within a module',
                'longHelp' => 'include/api/help/module_duplicatecheck_post_help.html',
            ),
        );
    }

    /**
     * Using the appropriate duplicate check service, search for duplicates in the system
     * TODO: we should refactor some of the bean loading in SugarApi so we can move some of this logic there
     *
     * @param ServiceBase $api
     * @param array $args
     */
    function checkForDuplicates(ServiceBase $api, array $args)
    {
        //create a new bean & check ACLs
        $bean = BeanFactory::newBean($args['module']);

        $this->handleEmptyBean($bean);

        $args=$this->trimArgs($args);

        if (!$bean->ACLAccess('read')) {
            throw new SugarApiExceptionNotAuthorized('No access to read records for module: '.$args['module']);
        }

        //populate bean
        $errors = $this->populateFromApi($api, $bean, $args);
        if ($errors !== true) {
            $displayErrors = print_r($errors, true);
            throw new SugarApiExceptionInvalidParameter("Unable to run duplicate check. There were validation errors on the submitted data: $displayErrors");
        }

        //retrieve possible duplicates
        $results = $bean->findDuplicates();

        if ($results) {
            return $results;
        } else {
            return array();
        }

    }

    protected function handleEmptyBean($bean)
    {
        if (empty($bean)) {
            throw new SugarApiExceptionInvalidParameter('Unable to run duplicate check. Bean was empty after attempting to populate from API');
        }
    }

    protected function trimArgs($args)
    {
        $args2 = array();
        foreach($args as $key => $value) {
            $args2[trim($key)] = (is_string($value)) ? trim($value) : $value;
        }
        return $args2;
    }

    protected function populateFromApi($api, $bean, $args, $options=array())
    {
        return ApiHelper::getHelper($api,$bean)->populateFromApi($bean,$args,$options);
    }
}
