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


require_once('data/BeanFactory.php');
require_once('clients/base/api/FilterApi.php');

class DashboardListApi extends FilterApi
{
    protected static $mandatory_fields = array(
        'id',
        'name',
        'view'
    );

    /**
     * Rest Api Registration Method
     *
     * @return array
     */
    public function registerApiRest()
    {
        return array(
            'getDashboardsForModule' => array(
                'reqType' => 'GET',
                'path' => array('Dashboards', '<module>'),
                'pathVars' => array('', 'module'),
                'method' => 'getDashboards',
                'shortHelp' => 'Get dashboards for a module',
                'longHelp' => 'include/api/help/get_dashboards.html',
            ),
            'getDashboardsForHome' => array(
                'reqType' => 'GET',
                'path' => array('Dashboards'),
                'pathVars' => array(''),
                'method' => 'getDashboards',
                'shortHelp' => 'Get dashboards for home',
                'longHelp' => 'include/api/help/get_dashboards.html',
            ),
        );
    }

    /**
     * Get the dashboards for the current user
     *
     * @param ServiceBase $api      The Api Class
     * @param array $args           Service Call Arguments
     * @return mixed
     */
    public function getDashboards($api, $args)
    {
        if (empty($args['filter'])||!is_array($args_filter)) {
            $args['filter'] = array();
        }

        // Tack on some required filters.
        $module = empty($args['module']) ? 'Home' : $args['module'];
        $args['filter'][]['dashboard_module'] = $module;

        $args['module'] = 'Dashboards';

        if (!empty($args['view'])) {
            $args['filter'][]['view'] = $args['view'];
        }
        $args['fields'] = 'id,name,view';

        $ret = $this->filterList($api, $args);
        
        // Add dashboard URL's
        foreach ($ret['records'] as $idx => $dashboard) {
            $ret['records'][$idx]['url'] = $api->getResourceURI('Dashboards/'.$dashboard['id']);
        }
        
        return $ret;
    }

    /**
     * Redefine the getoptions to pull in the correct Dashboard filters
     */
    protected function parseArguments(ServiceBase $api, array $args, SugarBean $seed = null)
    {
        if (!isset($args['order_by'])) {
            $args['order_by'] = 'date_entered:DESC';
        }
        $options = parent::parseArguments($api, $args, $seed);
        
        return $options;
    }

}
