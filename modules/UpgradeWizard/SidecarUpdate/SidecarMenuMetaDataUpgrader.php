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

class SidecarMenuMetaDataUpgrader extends SidecarAbstractMetaDataUpgrader
{
    protected $isExt = false;

    /**
     * name of the menu var
     * @var string
     */
    protected $menuName;

    public function setLegacyViewdefs()
    {
        global $current_language;
        $GLOBALS['mod_strings'] = return_module_language($current_language, $this->module);

        SugarACL::setACL($this->module, array(new SidecarMenuMetaDataUpgraderACL()));
        $module_menu = null;
        include $this->fullpath;

        SugarACL::resetACLs($this->module);
        $this->legacyViewdefs = $module_menu;
    }

    public function convertLegacyViewDefsToSidecar()
    {
        if(empty($this->legacyViewdefs)) {
            return true;
        }

        $this->isExt = (substr($this->fullpath, 0, 16) == 'custom/Extension');

        $newMenu = $this->metaDataConverter->fromLegacyMenu($this->module, $this->legacyViewdefs, $this->isExt);
        if(empty($newMenu['data'])) {
            return true;
        }
        $this->sidecarViewdefs = $newMenu['data'];
        $this->menuName = $newMenu['name'];
    }

    public function handleSave()
    {
        if(empty($this->sidecarViewdefs)) {
            return true;
        }
        if($this->isExt) {
            $newExtLocation = "custom/Extension/modules/{$this->module}/Ext/clients/base/menus/header/";
            if (!is_dir($newExtLocation)) {
                sugar_mkdir($newExtLocation, null, true);
            }

            $content = "<?php \n";
            foreach($this->sidecarViewdefs as $menuItem) {
                $content .= "\${$this->menuName}[] = ".var_export($menuItem, true).";\n";
            }
            return sugar_file_put_contents($newExtLocation . "/" . $this->filename, $content);
        } else {
            return $this->handleSaveArray($this->menuName, "custom/modules/{$this->module}/clients/base/menus/header/header.php");
        }
    }
}

/**
 * This is a mock ACL so that Menu files that have ACLs won't do weird things
 */
class SidecarMenuMetaDataUpgraderACL extends SugarACLStrategy
{
    public function checkAccess($module, $action, $context)
    {
        return true;
    }
}
