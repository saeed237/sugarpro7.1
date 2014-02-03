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

/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
require_once('include/vCard.php');

class ViewImportvcard extends SugarView
{
	var $type = 'edit';

    public function __construct()
    {
 		parent::SugarView();
 	}
 	
	/**
     * @see SugarView::display()
     */
	public function display()
    {
        global $mod_strings, $app_strings, $app_list_strings;

        $this->ss->assign("ERROR_TEXT", $app_strings['LBL_EMPTY_VCARD']);
        $this->ss->assign("HEADER", $app_strings['LBL_IMPORT_VCARD']);
        $this->ss->assign("MODULE", $_REQUEST['module']);
        $params = array();
        $params[] = "<a href='index.php?module={$_REQUEST['module']}&action=index'>{$mod_strings['LBL_MODULE_NAME']}</a>";
        $params[] = $app_strings['LBL_IMPORT_VCARD_BUTTON_LABEL'];
		echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], $params, true);
        $this->ss->display($this->getCustomFilePathIfExists('include/MVC/View/tpls/Importvcard.tpl'));
 	}
}
?>
