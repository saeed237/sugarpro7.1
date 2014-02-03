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




require_once('include/Dashlets/DashletGeneric.php');


class MyBugsDashlet extends DashletGeneric { 
    function MyBugsDashlet($id, $def = null) {
        global $current_user, $app_strings;
		require('modules/Bugs/Dashlets/MyBugsDashlet/MyBugsDashlet.data.php');
		
        parent::DashletGeneric($id, $def);
        
        $this->searchFields = $dashletData['MyBugsDashlet']['searchFields'];
        $this->columns = $dashletData['MyBugsDashlet']['columns'];
        
        if(empty($def['title'])) $this->title = translate('LBL_LIST_MY_BUGS', 'Bugs');
        $this->seedBean = BeanFactory::getBean('Bugs');        
    }
    
    function displayOptions() {
        
        $this->processDisplayOptions();
        
        $seedRelease = BeanFactory::getBean('Releases');
        
        if(!empty($this->searchFields['fixed_in_release'])) {
	        $this->currentSearchFields['fixed_in_release']['input'] = '<select multiple="true" size="3" name="fixed_in_release[]">' 
	                                                                  . get_select_options_with_id($seedRelease->get_releases(false, "Active"), (empty($this->filters['fixed_in_release']) ? '' : $this->filters['fixed_in_release'])) 
	                                                                  . '</select>';
        }
        
        if(!empty($this->searchFields['found_in_release'])) {
	        $this->currentSearchFields['found_in_release']['input'] = '<select multiple="true" size="3" name="found_in_release[]">' 
	                                                                  . get_select_options_with_id($seedRelease->get_releases(false, "Active"), (empty($this->filters['found_in_release']) ? '' : $this->filters['found_in_release']))
	                                                                  . '</select>'; 
        }
        $this->configureSS->assign('searchFields', $this->currentSearchFields);
        return $this->configureSS->fetch($this->configureTpl);
    }
}

?>
