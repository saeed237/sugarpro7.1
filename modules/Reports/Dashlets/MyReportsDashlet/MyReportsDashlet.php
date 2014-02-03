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


class MyReportsDashlet extends DashletGeneric { 
    
    function MyReportsDashlet($id, $def = null) {
        global $current_user, $app_strings, $dashletData;
		require('modules/Reports/Dashlets/MyReportsDashlet/MyReportsDashlet.data.php');
        
        parent::DashletGeneric($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_FAVORITE_REPORTS_TITLE', 'Reports');
        $this->isConfigurable = false;
        $this->searchFields = $dashletData['MyReportsDashlet']['searchFields'];
        $this->columns = $dashletData['MyReportsDashlet']['columns'];
        $this->seedBean = BeanFactory::getBean('Reports');        
    }
    
    function process() {
        $this->lvs->quickViewLinks = false;
        parent::process();
    }
    
    function buildWhere() {
        global $current_user;
        $where_clauses = array();
        
        $sugaFav = BeanFactory::getBean('SugarFavorites');
        $current_favorites_beans = $sugaFav->getUserFavoritesByModule('Reports', $current_user);
        $current_favorites = array();
        foreach ($current_favorites_beans as $key=>$val) {
        	array_push($current_favorites,$val->record_id);
        }
        if(is_array($current_favorites) && !empty($current_favorites))
            array_push($where_clauses, 'saved_reports.id IN (\'' . implode("','", array_values($current_favorites)) . '\')');
        else {
            array_push($where_clauses, 'saved_reports.id IN (\'-1\')');
        }
        return $where_clauses; 
    }
    
}

?>
