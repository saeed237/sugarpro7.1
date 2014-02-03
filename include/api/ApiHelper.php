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


/**
 * This class is here to provide functions to easily call in to the individual module api helpers
 */
class ApiHelper
{
    static $moduleHelpers = array();

    /**
     * This method looks up the helper class for the bean and will provide the default helper
     * if there is not one defined for that particular bean
     *
     * @param $api ServiceBase The API that will be associated to this helper class
     *                         This is used so the formatting functions can handle different
     *                         API's with varying formatting requirements.
     * @param $bean SugarBean Grab the helper module for this bean
     * @returns SugarBeanApiHelper A API helper class for beans
     */
    public static function getHelper(ServiceBase $api, SugarBean $bean) {
        $module = $bean->module_dir;
        if ( !isset(self::$moduleHelpers[$module]) ) {

            require_once('data/SugarBeanApiHelper.php');
            if(SugarAutoLoader::requireWithCustom('modules/'.$module.'/'.$module.'ApiHelper.php')) {
                $moduleHelperClass = SugarAutoLoader::customClass($module.'ApiHelper');
            } else {
                $moduleHelperClass = 'SugarBeanApiHelper';
            }

            self::$moduleHelpers[$module] = new $moduleHelperClass($api);
        }

        $moduleHelperClass = self::$moduleHelpers[$module];
        return $moduleHelperClass;
    }
}
