<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA") which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

$default_modules_sources = array (
  'Accounts' =>
  array (
    //'ext_rest_linkedin' => 'ext_rest_linkedin',
     'ext_rest_twitter' => 'ext_rest_twitter',
     //'ext_rest_insideview' => 'ext_rest_insideview',
  ),
  'Contacts' =>
  array (
    //'ext_rest_linkedin' => 'ext_rest_linkedin',
     'ext_rest_twitter' => 'ext_rest_twitter',
     //'ext_rest_insideview' => 'ext_rest_insideview',
  ),

  'Leads' =>
  array (
    //'ext_rest_linkedin' => 'ext_rest_linkedin',
     'ext_rest_twitter' => 'ext_rest_twitter',
    // 'ext_rest_insideview' => 'ext_rest_insideview',
  ),
  'Prospects' =>
  array (
    ///'//ext_rest_linkedin' => 'ext_rest_linkedin',

     'ext_rest_twitter' => 'ext_rest_twitter',
  ),
  'Opportunities' =>
  array (
   // 'ext_rest_insideview' => 'ext_rest_insideview',
  ),
);

$previous_connectors = array();
if (file_exists('custom/modules/Connectors/metadata/connectors.php')) {
    require 'custom/modules/Connectors/metadata/connectors.php';

    foreach ($connectors as $connector_array) {
        $connector_id = $connector_array['id'];
        $previous_connectors[$connector_id] = $connector_id;
    }
}

// Merge in old modules the customer added instead of overriding it completely with defaults
// If they have customized their connectors modules
if (file_exists('custom/modules/Connectors/metadata/display_config.php')) {
    require 'custom/modules/Connectors/metadata/display_config.php';

    // Remove the default settings from being copied over since they already existed
    foreach ($default_modules_sources as $module => $sources) {
        foreach ($sources as $source_key => $source) {
            foreach ($previous_connectors as $previous_connector) {
                if (in_array($previous_connector, $default_modules_sources[$module])) {
                    unset($default_modules_sources[$module][$previous_connector]);
                }
            }
        }
    }

    // Merge in the new connector default settings with the current settings
    if ( isset($modules_sources) && is_array($modules_sources) ) {
        foreach ($modules_sources as $module => $sources) {
            if (!empty($default_modules_sources[$module])) {
                $merged = array_merge($modules_sources[$module], $default_modules_sources[$module]);
                $default_modules_sources[$module] = $merged;
            } else {
                $default_modules_sources[$module] = $modules_sources[$module];
            }
        }
    }
}

if (!file_exists('custom/modules/Connectors/metadata')) {
    mkdir_recursive('custom/modules/Connectors/metadata');
}

if (!write_array_to_file('modules_sources', $default_modules_sources, 'custom/modules/Connectors/metadata/display_config.php')) {
    $GLOBALS['log']->fatal('Cannot write file custom/modules/Connectors/metadata/display_config.php');
}
