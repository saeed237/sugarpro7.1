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
/**
 * Recreate hierarchy search stored procedures
 */
class SugarUpgradeProductCategoriesRemoveFiles extends UpgradeScript
{
    public $order = 8501;
    public $type = self::UPGRADE_CORE;

    public function run()
    {

        // we only need to remove these files if the from_version is less than 7.0.0
        if (version_compare($this->from_version, '7.0', '<')) {
            // files to delete
            $files = array(
                'modules/ProductCategories/controller.php',
                'modules/ProductCategories/Delete.php',
                'modules/ProductCategories/field_arrays.php',
                'modules/ProductCategories/index.php',
                'modules/ProductCategories/ListView.html',
                'modules/ProductCategories/ListView.php',
                'modules/ProductCategories/Menu.php',
                'modules/ProductCategories/Popup_picker.html',
                'modules/ProductCategories/Popup_picker.php',
                'modules/ProductCategories/Save.php',
                'modules/ProductCategories/TreeData.php',
                'modules/ProductCategories/views/view.detail.php',
                'modules/ProductCategories/views/view.edit.php',
                'modules/ProductCategories/metadata/editviewdefs.php',
            );

            $this->fileToDelete($files);
        }
    }
}
