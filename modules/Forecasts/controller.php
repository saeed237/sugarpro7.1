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



class ForecastsController extends SugarController
{
    /**
     * remap listview action to sidecar
     * @var array
     */
    protected $action_remap = array(
        'ListView' => 'sidecar'
    );

    /**
     * Actually remap the action if required.
     *
     */
    protected function remapAction(){
        $this->do_action = strtolower($this->do_action) == 'listview' ? 'ListView' : $this->do_action;
        if(!empty($this->action_remap[$this->do_action])){
            $this->action = $this->action_remap[$this->do_action];
            $this->do_action = $this->action;
        }
    }

    public function action_exportManagerWorksheet() {
        global $current_user;
        $this->view = 'ajax';

        // Load up a seed bean
        $seed = BeanFactory::getBean('ForecastManagerWorksheets');

        if (!$seed->ACLAccess('list')) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: ' . $seed->object_name);
        }

        $args = array();
        $args['timeperiod_id'] = isset($_REQUEST['timeperiod_id']) ? $_REQUEST['timeperiod_id'] : TimePeriod::getCurrentId();
        $args['user_id'] = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : $current_user->id;
        // don't allow encoding to html for data used in export
        $args['encode_to_html'] = false;

        // base file and class name
        $file = 'include/SugarForecasting/Export/Manager.php';
        $klass = 'SugarForecasting_Export_Manager';

        // check for a custom file exists
        SugarAutoLoader::requireWithCustom($file);
        $klass = SugarAutoLoader::customClass($klass);
        // create the class

        /* @var $obj SugarForecasting_AbstractForecast */
        $obj = new $klass($args);

        $content = $obj->process();

        $obj->export($content);
    }


    public function action_exportWorksheet() {
        global $current_user;

        // Load up a seed bean
        $seed = BeanFactory::getBean('ForecastWorksheets');

        if (!$seed->ACLAccess('list')) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: ' . $seed->object_name);
        }

        $args = array();
        $args['timeperiod_id'] = isset($_REQUEST['timeperiod_id']) ? $_REQUEST['timeperiod_id'] : TimePeriod::getCurrentId();
        $args['user_id'] = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : $current_user->id;
        // don't allow encoding to html for data used in export
        $args['encode_to_html'] = false;

        // base file and class name
        $file = 'include/SugarForecasting/Export/Individual.php';
        $klass = 'SugarForecasting_Export_Individual';

        // check for a custom file exists
        SugarAutoLoader::requireWithCustom($file);
        $klass = SugarAutoLoader::customClass($klass);
        // create the class

        /* @var $obj SugarForecasting_AbstractForecast */
        $obj = new $klass($args);

        $content = $obj->process();

        $obj->export($content);

        // Bug 59329 : Stack 88: CSV is created with some garbage info after the records
        // prevent rendering view
        sugar_cleanup(true);
    }


    /**
     * This function allows a user with Forecasts admin rights to reset the Forecasts settings so that the Forecasts wizard
     * dialog will appear once again.
     *
     */
    public function action_resetSettings() {
        global $current_user;
        if($current_user->isAdminForModule('Forecasts')) {
            $db = DBManagerFactory::getInstance();
            $db->query("UPDATE config SET value = 0 WHERE category = 'Forecasts' and name in ('is_setup', 'has_commits')");
            MetaDataManager::clearAPICache();
            //MetaDataManager::refreshModulesCache(array('Forecasts'));
            echo '<script>' . navigateToSidecar(buildSidecarRoute("Forecasts")) . ';</script>';
            exit();
        }

        $this->view = 'noaccess';
    }

}
