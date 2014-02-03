<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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

require_once('data/SugarACLStrategy.php');

class SugarACLOpi extends SugarACLStrategy
{
    protected static $syncingViews = array(
        'edit',
        'delete',
    );

    protected static $platformSourceMap = array(
        'base' => 'Sugar',
        'portal' => 'Sugar',
        'mobile' => 'Sugar',
        'opi' => 'Outlook',
        'lpi' => 'LotusNotes'
    );

    /**
     * Check recurring source to determine edit
     * @param string $module
     * @param string $view
     * @param array $context
     * @return bool|void
     */
    public function checkAccess($module, $view, $context)
    {
        $bean = self::loadBean($module, $context);

        // if there is no bean we have nothing to check
        if ($bean === false) {
            return true;
        }

        // if the recurring source is Sugar allow modifications
        if (in_array($view, self::$syncingViews)
            && !empty($bean->recurring_source)
            && !empty($bean->fetched_row['recurring_source'])
            && $bean->recurring_source == 'Sugar'
            && $bean->recurring_source == $bean->fetched_row['recurring_source']) {
            return true;
        }

        $view = SugarACLStrategy::fixUpActionName($view);

        if (in_array($view, self::$syncingViews)
            && isset($_SESSION['platform'])
            && isset(self::$platformSourceMap[$_SESSION['platform']])
            && !empty($bean->recurring_source) && !empty($bean->fetched_row['recurring_source'])
            && $bean->fetched_row['recurring_source'] != self::$platformSourceMap[$_SESSION['platform']]
            && $bean->recurring_source != self::$platformSourceMap[$_SESSION['platform']]) {
            return false;
        }

        return true;
    }

    /**
     * Load bean from context
     * @static
     * @param string $module
     * @param array $context
     * @return SugarBean
     */
    protected static function loadBean($module, $context = array())
    {
        if (isset($context['bean']) && $context['bean'] instanceof SugarBean
            && $context['bean']->module_dir == $module) {
            $bean = $context['bean'];
        } else {
            $bean = false;
        }
        return $bean;
    }

}
