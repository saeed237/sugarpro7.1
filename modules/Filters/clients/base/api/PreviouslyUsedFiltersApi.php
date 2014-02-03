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


require_once('data/BeanFactory.php');

/**
 * @api
 */
class PreviouslyUsedFiltersApi extends SugarApi {
    public function registerApiRest() {
        return array(
            'setUsed' => array(
                'reqType' => 'PUT',
                'path' => array('Filters', '?', 'used',),
                'pathVars' => array('module', 'module_name', 'used',),
                'method' => 'setUsed',
                'shortHelp' => 'This method sets the filter as used for the current user',
                'longHelp' => '',
            ),
            'getUsed' => array(
                'reqType' => 'GET',
                'path' => array('Filters', '?', 'used'),
                'pathVars' => array('module', 'module_name', 'used',),
                'method' => 'getUsed',
                'shortHelp' => 'This method gets the used filter for the current user',
                'longHelp' => '',
            ),
            'deleteUsed' => array(
                'reqType' => 'DELETE',
                'path' => array('Filters', '?', 'used', '?'),
                'pathVars' => array('module', 'module_name', 'used', 'record'),
                'method' => 'deleteUsed',
                'shortHelp' => 'This method deletes the used filter for the current user',
                'longHelp' => '',
            ),
            'deleteAllUsed' => array(
                'reqType' => 'DELETE',
                'path' => array('Filters', '?', 'used',),
                'pathVars' => array('module', 'module_name', 'used'),
                'method' => 'deleteUsed',
                'shortHelp' => 'This method deletes all used filters for the current user',
                'longHelp' => '',
            ),
        );
    }
    /**
     * Set filters as used
     * @param RestService $api 
     * @param array $args 
     * @return array of formatted Beans
     */
    public function setUsed($api, $args) {
        $user_preference = new UserPreference($GLOBALS['current_user']);
        
        $used_filters = $args['filters'];
        $user_preference->setPreference($args['module_name'], $used_filters, 'filters');
        $user_preference->savePreferencesToDB(true);
        // loop over and get the Filters to return
        $beans = $this->loadFilters($used_filters);
        
        $data = $this->formatBeans($api, $args, $beans);

        return $data;
    }
    /**
     * Get filters from previously used
     * @param RestService $api 
     * @param array $args 
     * @return array of formatted Beans
     */
    public function getUsed($api, $args) {
        $user_preference = new UserPreference($GLOBALS['current_user']);
        $used_filters = $user_preference->getPreference($args['module_name'], 'filters');
        // UserPreference::getPreference returns null if the preference does not exist
        if (empty($used_filters)) {
            $used_filters = array();
        }
        // loop over the filters and return them
        $beans = $this->loadFilters($used_filters);
        $data = array();
        if(!empty($beans)) {
            $data = $this->formatBeans($api, $args, $beans);
        }

        return $data;        
    }

    /**
     * Delete a filter from previously used
     * @param RestService $api 
     * @param array $args 
     * @return array of formatted Beans
     */
    public function deleteUsed($api, $args) {
        $data = array();
        $user_preference = new UserPreference($GLOBALS['current_user']);
        $used_filters = $user_preference->getPreference($args['module_name'], 'filters');

        if(isset($args['record']) && !empty($args['record'])) {
            // if the record exists unset it
            $key = array_search($args['record'], $used_filters);
            if($key !== false) {
                unset($used_filters[$key]);
            }
        }
        else {
            // delete them all
            $used_filters = array();
        }


        $user_preference->setPreference($args['module_name'], $used_filters, 'filters');
        $user_preference->savePreferencesToDB(true);

        if(!empty($used_filters)) {
            $beans = $this->loadFilters($used_filters);
        
            $data = $this->formatBeans($api, $args, $beans);
        }

        return $data;        
    }

    protected function loadFilters( &$used_filters ) {
        $return = array();
        foreach($used_filters AS $key => $id) {
            $bean = BeanFactory::getBean('Filters', $id);
            if($bean instanceof SugarBean && !empty($bean->id)) {
                $return[] = $bean;
            }
            else {
                unset($used_filters[$key]);
            }
        }
        return $return;
    }
}
