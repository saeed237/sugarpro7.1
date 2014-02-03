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


require_once('clients/base/api/ModuleApi.php');
require_once('modules/Leads/LeadConvert.php');

class LeadConvertApi extends ModuleApi {

    public function registerApiRest()
    {
        //Extend with test method
        $api= array (
            'convertLead' => array(
                'reqType' => 'POST',
                'path' => array('Leads', '?', 'convert'),
                'pathVars' => array('','leadId',''),
                'method' => 'convertLead',
                'shortHelp' => 'Convert Lead to Account/Contact/Opportunity',
                'longHelp' => 'include/api/html/modules/Leads/LeadsConversionsApi.html#conversions',
            ),
        );

        return $api;
    }

    /**
     * This method handles the /Lead/:id/convert REST endpoint
     *
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return Array of worksheet data entries
     * @throws SugarApiExceptionNotAuthorized
     */
    public function convertLead($api, $args)
    {
        $leadConvert = new LeadConvert($args['leadId']);
        $modules = $this->loadModules($api, $leadConvert->getAvailableModules(), $args['modules']);
        $modules = $leadConvert->convertLead($modules);

        return array (
            'modules' => $this->formatBeans($api, $args, $modules)
        );
    }

    /**
     * This method loads a bean from posted data through api
     *
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $module The module name to be loaded/created.
     * @param $data The posted data
     * @return SugarBean The loaded bean
     */
    protected function loadModule($api, $module, $data) {
        if (isset($data['id'])) {
            $moduleDef = array (
                'module' => $module,
                'record' => $data['id']
            );
            $bean = $this->loadBean($api, $moduleDef);
        }
        else {
            $bean = BeanFactory::newBean($module);
            $this->updateBean($bean,$api, $data);
        }
        return $bean;
    }

    /**
     * This method loads an array of beans based on available modules for lead convert
     *
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $module Array The modules that will be loaded/created.
     * @param $data The posted data
     * @return Array SugarBean The loaded beans
     */
    protected function loadModules($api, $modulesToConvert, $data) {
        $beans = array();

        foreach ($modulesToConvert as $moduleName) {
            if (!isset($data[$moduleName])) {
                continue;
            }
            $beans[$moduleName] = $this->loadModule($api, $moduleName, $data[$moduleName]);
        }
        return $beans;
    }
}
