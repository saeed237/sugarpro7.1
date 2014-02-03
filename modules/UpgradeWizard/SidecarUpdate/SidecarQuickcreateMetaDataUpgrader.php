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
class SidecarQuickcreateMetaDataUpgrader extends SidecarAbstractMetaDataUpgrader
{
    // don't delete old files
    public $deleteOld = false;

    /**
     * Is this module enabled in DCActions?
     * @var bool
     */
    public $isDCEnabled = true;

    public function upgradeCheck()
    {
        $viewdefs = array();
        if (file_exists("custom/{$this->fullpath}")) {
            include "custom/{$this->fullpath}";
        } elseif (file_exists($this->fullpath)) {
            include $this->fullpath;
        }

        if(!empty($viewdefs[$this->module]['base']['menu']['quickcreate'])
                && !empty($viewdefs[$this->module]['base']['menu']['quickcreate']['layout'])
                && isset($viewdefs[$this->module]['base']['menu']['quickcreate']['visible'])
                && $viewdefs[$this->module]['base']['menu']['quickcreate']['visible'] == $this->isDCEnabled) {
                // don't need to upgrade this, it's ok
                return false;
        }
        return true;
    }

    public function setLegacyViewdefs()
    {
        $viewdefs = array();
        // require the file
        if (file_exists("custom/{$this->fullpath}")) {
            include "custom/{$this->fullpath}";
        } elseif (file_exists($this->fullpath)) {
            include $this->fullpath;
        } else {
            if (!$this->isDCEnabled) {
                // no need to write out a file for a module that doesn't currently have quickcreate defs and isn't
                // going to need them
                return true;
            }
            $viewdefs[$this->module]['base']['menu']['quickcreate'] = array(
                'layout' => 'create',
                'label' => translate($this->module),
            );
        }

        $viewdefs[$this->module]['base']['menu']['quickcreate']['visible'] = $this->isDCEnabled;

        $this->legacyViewdefs = $viewdefs;
    }

    /**
     * This converts custom legacy subpanel layout defs to
     * the new style layoutdefs
     *
     * @param $module the module to convert all the subpanel layoutdefs for
     */
    public function convertLegacyViewDefsToSidecar()
    {
        if(empty($this->legacyViewdefs)) {
            return true;
        }
        $this->sidecarViewdefs = $this->legacyViewdefs[$this->module]['base']['menu']['quickcreate'];
    }

    /**
     * Write out the new subpanel layout def
     */
    public function handleSave()
    {
        return $this->handleSaveArray("viewdefs['{$this->module}']['base']['menu']['quickcreate']",
            "custom/{$this->fullpath}");
    }
}

