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

// This will need to be pathed properly when packaged
require_once 'SidecarAbstractMetaDataUpgrader.php';
require_once 'modules/ModuleBuilder/Module/StudioModuleFactory.php';

class SidecarFilterMetaDataUpgrader extends SidecarAbstractMetaDataUpgrader
{

    /**
     * Load search fields defs from SearchFields.php
     * @return array
     */
    protected function loadSearchFields()
    {
        $filename = dirname($this->fullpath)."/SearchFields.php";

        if(!file_exists($filename)) {
            // try without custom
            if(substr($filename, 0, 7) == 'custom/') {
                $filename = substr($filename, 7);
            }

            if(!file_exists($filename)) {
                 // try going to module directly
                $filename = "modules/{$this->module}/metadata/SearchFields.php";

                if(!file_exists($filename)) {
                    // try template now
                    $sm = StudioModuleFactory::getStudioModule($this->module);
                    $moduleType = $sm->getType();
                    $filename = 'include/SugarObjects/templates/' . $moduleType . '/metadata/SearchFields.php';

                    if(!file_exists($filename)) {
                        // OK, I give up, no way I can find it, let's use basic ones
                        $filename = 'include/SugarObjects/templates/basic/metadata/SearchFields.php';
                    }
                }
            }
        }
        $searchFields = array();
        $module_name = $this->module;
        include $filename;
        return $searchFields[$module_name];
    }

    /**
     * Check if we actually want to upgrade this file
     * @return boolean
     */
    public function upgradeCheck()
    {
        $target = $this->getNewFileName($this->viewtype);
        if(file_exists($target)) {
            // if we already have the target, skip the upgrade
            return false;
        }
        return true;
    }

    /**
     * Does nothing for search since search is simply a file move.
     */
    public function convertLegacyViewDefsToSidecar()
    {
        // load SearchFields.php
        $searchFields = $this->loadSearchFields();

        $fields = array();
        if(!empty($this->legacyViewdefs['layout']['basic_search'])) {
            $old_fields = $this->legacyViewdefs['layout']['basic_search'];
        } else {
            $old_fields = array();
        }
        if(!empty($this->legacyViewdefs['layout']['advanced_search'])) {
            $old_fields = array_merge($old_fields, $this->legacyViewdefs['layout']['advanced_search']);
        }
        foreach($old_fields as $name => $data) {
            if(!empty($data['name'])) {
                $name = $data['name'];
            }
            // We'll add those later
            if($name == 'favorites_only' || $name == 'current_user_only') continue;

            // We don't know this field
            if(empty($searchFields[$name])) {
                // may be a custom field
                if(substr($name, -2) == '_c') {
                    $fields[$name] = $data;
                    if(isset($fields[$name]['label']) && !isset($fields[$name]['vname'])) {
                        $fields[$name]['vname'] = $fields[$name]['label'];
                        unset($fields[$name]['label']);
                    }
                }
                continue;
            }

            // Subqueries not supported yet
            if(!empty($searchFields[$name]['operator']) && $searchFields[$name]['operator'] == 'subquery') continue;

            if(!empty($searchFields[$name]['db_field'])) {
                $label = '';
                if(isset($data['label'])) {
                    $label = $data['label'];
                }
                if(isset($searchFields[$name]['vname'])) {
                    $label = $searchFields[$name]['vname'];
                }
                $fields[$name] = array(
                    'dbFields' => $searchFields[$name]['db_field'],
                    'type' => isset($searchFields[$name]['type'])?$searchFields[$name]['type']:"text",
                );
                if(!empty($label)) {
                    $fields[$name]['vname'] = $label;
                }
            } else {
                $fields[$name] = array();
            }
        }
        $fields['$owner'] = array(
            'predefined_filter' => true,
            'vname' => 'LBL_CURRENT_USER_FILTER',
        );
        $fields['$favorite'] = array(
                'predefined_filter' => true,
                'vname' => 'LBL_FAVORITES_FILTER',
        );
        $this->sidecarViewdefs = array(
            'default_filter' => 'all_records',
        );
        $this->sidecarViewdefs['fields'] = $fields;
    }

    public function getNewFileName($viewname)
    {
        $client = $this->client == 'wireless' ? 'mobile' : $this->client;
        // Cut off metadata/searchdefs.php
        $dirname = dirname(dirname($this->fullpath));
        return $dirname . "/clients/$client/filters/default/default.php";
    }

    public function getNewFileContents($viewname)
    {
        $module = $this->getNormalizedModuleName();
        $viewname = MetaDataFiles::getName($viewname);
        $client = $this->client == 'wireless' ? 'mobile' : $this->client;
        $out  = "<?php\n\$viewdefs['{$module}']['{$client}']['filter']['default'] = " . var_export($this->sidecarViewdefs, true) . ";\n";
        return $out;
    }

}