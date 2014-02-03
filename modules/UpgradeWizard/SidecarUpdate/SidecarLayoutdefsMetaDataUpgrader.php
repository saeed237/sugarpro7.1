<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
require_once 'modules/UpgradeWizard/SidecarUpdate/SidecarAbstractMetaDataUpgrader.php';

/**
 * Sidecar Subpanel Layoutdefs Upgrader
 */
class SidecarLayoutdefsMetaDataUpgrader extends SidecarAbstractMetaDataUpgrader
{

    // we don't care about all the fields right now, we just care about
    // override_subpanel_name => override_subpanel_list_view
    // get_subpanel_data => link
    // title_key => label
    protected static $conversionKeys = array(
            'override_subpanel_name' => 'override_subpanel_list_view',
            'get_subpanel_data' => 'link',
            'title_key' => 'label',
    );

    // don't delete old layoutdefs
    public $deleteOld = false;
    /**
     * Subpanels full data by module
     * @var array
     */
    protected static $supanelData = array();

    public function loadSubpanelData($module)
    {
        if(!isset(self::$supanelData[$module])) {
            $layout_defs = null;
            if (file_exists("modules/{$module}/metadata/subpaneldefs.php")) {
                include "modules/{$module}/metadata/subpaneldefs.php";
            }
            if (file_exists("custom/modules/{$module}/metadata/subpaneldefs.php")) {
                include "custom/modules/{$module}/metadata/subpaneldefs.php";
            }
            if (file_exists("custom/modules/{$module}/Ext/Layoutdefs/layoutdefs.ext.php")) {
                include "custom/modules/{$module}/Ext/Layoutdefs/layoutdefs.ext.php";
            }
            if($layout_defs[$module]['subpanel_setup']) {
                self::$supanelData[$module] = $layout_defs[$module]['subpanel_setup'];
            } else {
                self::$supanelData[$module] = array();
            }
        }
    }

    public function setLegacyViewdefs()
    {
        $this->loadSubpanelData($this->module);
        $layout_defs = null;
        // no layoutdefs, nothing to upgrade
        if (empty(self::$supanelData[$this->module])) {
            return;
        }

        include $this->fullpath;
        if (empty($layout_defs[$this->module]['subpanel_setup'])) {
            return true;
        }
        $this->legacyViewdefs = $layout_defs[$this->module]['subpanel_setup'];
    }

    /**
     * This converts custom legacy subpanel layout defs to
     * the new style layoutdefs
     *
     * @param $module the module to convert all the subpanel layoutdefs for
     */
    public function convertLegacyViewDefsToSidecar()
    {
        // get the modules current layoutdefs converted to sidecar, use file_exists to remove warnings from log

        if(empty($this->legacyViewdefs)) {
            return true;
        }

        foreach ($this->legacyViewdefs as $name => $def) {
            $convertSubpanelDefs[$name] = array_intersect_key($def, self::$conversionKeys);
        }

        if (empty($convertSubpanelDefs)) {
            // no workable defs
            return true;
        }

        $newdefs = array();

        // find the subpaneldef that contains the $convertSubpanelDefs
        foreach (self::$supanelData[$this->module] as $key => $def) {
            // if no keys for this module, don't bother
            if(empty($convertSubpanelDefs[$key])) continue;

            // convert this section to sidecar
            $sidecarDef = $this->metaDataConverter->fromLegacySubpanelLayout(self::$supanelData[$this->module][$key]);
            foreach ($def as $k => $v) {
                if (!empty($convertSubpanelDefs[$key][$k]) && $convertSubpanelDefs[$key][$k] == $v) {
                    // take out the key we are trying to create
                    if (self::$conversionKeys[$k] == 'link') {
                        $newdefs['context']['link'] = $sidecarDef['context']['link'];
                    } else {
                        $newdefs[self::$conversionKeys[$k]] = $sidecarDef[self::$conversionKeys[$k]];
                    }
                }
            }
        }

        if (!empty($newdefs)) {
            if(empty($newdefs['override_subpanel_list_view'])) {
                $newdefs['layout'] = 'subpanel';
            }
            $this->sidecarViewdefs = $newdefs;
        }

    }

    /**
     * Write out the new subpanel layout def
     */
    public function handleSave()
    {
        return $this->handleSaveArray("viewdefs['{$this->module}']['{$this->client}']['layout']['subpanels']['components'][]",
            "custom/Extension/modules/{$this->module}/Ext/clients/base/layouts/subpanels/" . basename($this->fullpath));
    }
}

