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


class TabController{

var $required_modules = array('Home');

    /**
     * @var bool flag of validation of the cache
     */
    static protected $isCacheValid = false;

function is_system_tabs_in_db(){

        $administration = Administration::getSettings('MySettings');
        if(isset($administration->settings) && isset($administration->settings['MySettings_tab']))
        {
            return true;
        }
        else
        {
            return false;
        }
}

function get_system_tabs(){
	global $moduleList;

	static $system_tabs_result = null;

	// if the value is not already cached, then retrieve it.
    if (empty($system_tabs_result) || !self::$isCacheValid)
	{

		$administration = Administration::getSettings('MySettings');
		if(isset($administration->settings) && isset($administration->settings['MySettings_tab'])){
			$tabs= $administration->settings['MySettings_tab'];
			$trimmed_tabs = trim($tabs);
			//make sure serialized string is not empty
			if (!empty($trimmed_tabs)){
				$tabs = base64_decode($tabs);
				$tabs = unserialize($tabs);
				//Ensure modules saved in the prefences exist.
				foreach($tabs as $id => $tab) {
					if (!in_array($tab, $moduleList))
						unset($tabs[$id]);
				}
				$tabs = $this->get_key_array(SugarACL::filterModuleList($tabs, 'access', true));
				$system_tabs_result = $tabs;
			}else{
				$system_tabs_result = $this->get_key_array($moduleList);
			}
		}
		else
		{
			$system_tabs_result = $this->get_key_array($moduleList);
		}
        self::$isCacheValid = true;
	}

	return $system_tabs_result;
}

function get_tabs_system(){
	global $moduleList;
	$tabs = $this->get_system_tabs();
	$unsetTabs = $this->get_key_array($moduleList);
	foreach($tabs as $tab){
		unset($unsetTabs[$tab]);
	}

	$should_hide_iframes = !SugarAutoLoader::fileExists('modules/iFrames/iFrame.php');
	if($should_hide_iframes) {
	   if(isset($unsetTabs['iFrames'])) {
	      unset($unsetTabs['iFrames']);
	   } else if(isset($tabs['iFrames'])) {
	   	  unset($tabs['iFrames']);
	   }
	}

	return array($tabs,$unsetTabs);
}




function set_system_tabs($tabs){

	$administration = BeanFactory::getBean('Administration');
	$serialized = base64_encode(serialize($tabs));
	$administration->saveSetting('MySettings', 'tab', $serialized);
    self::$isCacheValid = false;
}

function get_users_can_edit(){

	$administration = Administration::getSettings('MySettings');
	if(isset($administration->settings) && isset($administration->settings['MySettings_disable_useredit'])){
		if($administration->settings['MySettings_disable_useredit'] == 'yes'){
			return false;
		}
}
return true;
}

function set_users_can_edit($boolean){
	global $current_user;
	if(is_admin($current_user)){

		$administration = BeanFactory::getBean('Administration');
		if($boolean){
			$administration->saveSetting('MySettings', 'disable_useredit', 'no');
		}else{
			$administration->saveSetting('MySettings', 'disable_useredit', 'yes');
		}
	}
}


function get_key_array($arr){
	$new = array();
	if(!empty($arr)){
	foreach($arr as $val){
		$new[$val] = $val;
	}
	}
	return $new;
}

function set_user_tabs($tabs, &$user, $type='display'){
    if(empty($user)){
		global $current_user;
		$current_user->setPreference($type .'_tabs', $tabs);
	}else{
		$user->setPreference($type .'_tabs', $tabs);
	}

}

function get_user_tabs(&$user, $type='display'){
	$system_tabs = $this->get_system_tabs();
	$tabs = $user->getPreference($type .'_tabs');
	if(!empty($tabs)){
		$tabs = $this->get_key_array($tabs);
		if($type == 'display')
			$tabs['Home'] =  'Home';
		return $tabs;
	}
	else
	{
		if($type == 'display')
			return $system_tabs;
		else
			return array();
	}


}

function get_unset_tabs($user){
	global $moduleList;
	$tabs = $this->get_user_tabs($user);
	$unsetTabs = $this->get_key_array($moduleList);
	foreach($tabs as $tab){
		unset($unsetTabs[$tab]);
	}
	return $unsetTabs;


}

function get_tabs($user)
{
	$display_tabs = $this->get_user_tabs($user, 'display');
	$hide_tabs = $this->get_user_tabs($user, 'hide');
	$remove_tabs = $this->get_user_tabs($user, 'remove');
	$system_tabs = $this->get_system_tabs();

	// remove access to tabs that roles do not give them permission to

	foreach($system_tabs as $key=>$value)
	{
		if(!isset($display_tabs[$key]))
			$display_tabs[$key] = $value;
	}

    ////////////////////////////////////////////////////////////////////
    // Jenny - Bug 6286: If someone has "old school roles" defined (before 4.0) and upgrades,
    // then they can't remove those old roles through the UI. Also, when new tabs are added,
    // users who had any of those "old school roles" defined have no way of being able to see
    // those roles. We need to disable role checking.

    //$roleCheck = query_user_has_roles($user->id);
    $roleCheck = 0;
    ////////////////////////////////////////////////////////////////////
		if($roleCheck)
		{
			//grabs modules a user has access to via roles
			$role_tabs = get_user_allowed_modules($user->id);

			// adds modules to display_tabs if existant in roles
			foreach($role_tabs as $key=>$value)
			{
				if(!isset($display_tabs[$key]))
					$display_tabs[$key] = $value;
			}
		}

		// removes tabs from display_tabs if not existant in roles
		// or exist in the hidden tabs
		foreach($display_tabs as $key=>$value)
		{
			if($roleCheck)
			{
				if(!isset($role_tabs[$key]))
					unset($display_tabs[$key]);
			}

			if(!isset($system_tabs[$key]))
				unset($display_tabs[$key]);
			if(isset($hide_tabs[$key]))
				unset($display_tabs[$key]);
		}

		// removes tabs from hide_tabs if not existant in roles
		foreach($hide_tabs as $key=>$value)
		{
			if($roleCheck)
			{
				if(!isset($role_tabs[$key]))
					unset($hide_tabs[$key]);
			}

			if(!isset($system_tabs[$key]))
				unset($hide_tabs[$key]);
		}

	// remove tabs from user if admin has removed specific tabs
	foreach($remove_tabs as $key=>$value)
	{
		if(isset($display_tabs[$key]))
			unset($display_tabs[$key]);
		if(isset($hide_tabs[$key]))
			unset($hide_tabs[$key]);
	}
    $display_tabs = array_intersect($display_tabs, $GLOBALS['moduleList']);
	return array($display_tabs, $hide_tabs, $remove_tabs);
}

function restore_tabs($user){
	global $moduleList;
	$this->set_user_tabs($moduleList, $user);

}

function restore_system_tabs(){
	global $moduleList;
	$this->set_system_tabs($moduleList);

}


}
