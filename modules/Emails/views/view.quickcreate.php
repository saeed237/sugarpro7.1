<?php
//FILE SUGARCRM flav=pro
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

require_once('include/MVC/View/views/view.quickcreate.php');
require_once('modules/Emails/EmailUI.php');

class EmailsViewQuickcreate extends ViewQuickcreate 
{
    /**
     * @see ViewQuickcreate::display()
     */
    public function display()
    {
        $userPref = $GLOBALS['current_user']->getPreference('email_link_type');
		$defaultPref = $GLOBALS['sugar_config']['email_default_client'];
		if($userPref != '')
			$client = $userPref;
		else
			$client = $defaultPref;
		
        if ( $client == 'sugar' ) {
            $eUi = new EmailUI();
            if(!empty($this->bean->id) && !in_array($this->bean->object_name,array('EmailMan')) ) {
                $fullComposeUrl = "index.php?module=Emails&action=Compose&parent_id={$this->bean->id}&parent_type={$this->bean->module_dir}";
                $composeData = array('parent_id'=>$this->bean->id, 'parent_type' => $this->bean->module_dir);
            } else {
                $fullComposeUrl = "index.php?module=Emails&action=Compose";
                $composeData = array('parent_id'=>'', 'parent_type' => '');
            }
            
            $j_quickComposeOptions = $eUi->generateComposePackageForQuickCreate($composeData, $fullComposeUrl); 
            $json_obj = getJSONobj();
            $opts = $json_obj->decode($j_quickComposeOptions);
            $opts['menu_id'] = 'dccontent';
             
            $ss = new Sugar_Smarty();
            $ss->assign('json_output', $json_obj->encode($opts));
            $ss->display('modules/Emails/templates/dceMenuQuickCreate.tpl');
        }
        else {
            $emailAddress = '';
            if(!empty($this->bean->id) && !in_array($this->bean->object_name,array('EmailMan')) ) {
                $emailAddress = $this->bean->emailAddress->getPrimaryAddress($this->bean);
            }
            echo "<script>document.location.href='mailto:$emailAddress';lastLoadedMenu=undefined;DCMenu.closeOverlay();</script>";
            die();
        }
    } 
}