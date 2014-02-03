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


require_once "include/SugarMetric/Helper.php";

/**
 * SugarMetric hook handler class
 *
 * @see custom/Extension/application/Ext/LogicHooks/SugarMetricHoolks.php
 * contains hook configuration for SugarMetric
 */
class SugarMetric_HookManager
{
    /**
     * Initialization state
     *
     * @var bool
     */
    protected $initialized = false;

    /**
     * SugarMetric initialization hook
     *
     * Serve "after_entry_point" hook handling
     */
    public function afterEntryPoint()
    {
        if ($this->initialized) {
            return;
        }

        SugarMetric_Helper::run(false);
        $this->initialized = true;
    }

    /**
     * Called on sugar_cleanup
     *
     * Serve "server_round_trip" hook handling
     */
    public function serverRoundTrip()
    {
        $instance = SugarMetric_Manager::getInstance();

        // Check transaction name was set on endPoints
        if (!$instance->isNamedTransaction()) {
            if (isset($GLOBALS['log']) && !empty($_SERVER['REQUEST_URI'])) {

                // Log REQUEST_URI to debug "dead" entryPoints
                $GLOBALS['log']->debug('Unregistered Transaction name for URI: ' . $_SERVER['REQUEST_URI']);
            }
        }
    }

}
