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


class SugarWidgetFieldteam_set_id extends SugarWidgetReportField{
	
/**
 * Format the display to be similiar to what we do in a listview
 * Difference is since we already have the team_set_id we will grab all of the teams and not do an ajax request like
 * we do in a list view.
 * @param string $cell
 */
function & displayListPlain($layout_def){
		$value = $this->_get_list_value($layout_def);
		if(!empty($value)){
			$teams = TeamSetManager::getTeamsFromSet($value);
			if(!empty($teams)){
				if(!empty($teams[0]['display_name'])){
					$result = $teams[0]['display_name'];

	            	if((! empty($_REQUEST['to_csv']))|| (! empty($_REQUEST['to_pdf']) )) {
                            // if for csv export, we don't generate html
                            $result = '';
                            foreach($teams as $row) {
                                $result .= $row['display_name'].", ";
                            }
                            //get rid of the trailing comma

                            $result = substr($result, 0, -2);
                    } else {
                            $body = '';
                            foreach($teams as $row){
                                $body .= $row['display_name'].'<br/>';
                            }

                            $result .= "&nbsp;<a href=\"#\" style='text-decoration:none;' id='more_feather' onclick=\"SUGAR.utils.showHelpTips(this,'".$body."')\" >+</a>";
                    }

					return $result;
				}else{
					return '';
				}
			}else{
				return '';
			}
		}else{
			return '';
		}
}

/**
 * Perform the Any type query
 *
 * @param array $layout_def
 * @return string the subquery to be run
 */
 function queryFilterany(&$layout_def){
		require_once('include/SugarFields/SugarFieldHandler.php');
		$sfh = new SugarFieldHandler();
        $sf = $sfh->getSugarField('teamset');
        $teams = array();
        $field_value = '';
        if(!empty($layout_def['input_name0'])) {
           foreach($layout_def['input_name0'] as $team) {
           	   $teams[$team] = $team;
           	   if (!empty($field_value)) {
	           	$field_value .= ',';
	           }
	           $field_value .= "'" . $GLOBALS['db']->quote($team) . "'";
           }
        }
        
        $searchParams = $sf->getTeamSetIdSearchField('team_set_id', 'any', $teams);
        $query = string_format($searchParams['subquery'], array($field_value));
		return $this->_get_column_select($layout_def)." IN ({$query}) " . $this->queryPrimaryTeam($layout_def) . "\n";
 }
 
 /**
  * Perform the All type query
  *
  * @param array $layout_def
  * @return string the subquery to be run
  */
 function queryFilterall(&$layout_def){
		require_once('include/SugarFields/SugarFieldHandler.php');
		$sfh = new SugarFieldHandler();
        $sf = $sfh->getSugarField('teamset');
        $teams = array();
        $field_value = '';
        if(!empty($layout_def['input_name0'])) {
           foreach($layout_def['input_name0'] as $team) {
           	   $teams[$team] = $team;
           	   if (!empty($field_value)) {
	           	$field_value .= ',';
	           }
	           $field_value .= "'" . $GLOBALS['db']->quote($team) . "'";
           }
        }
        
        $searchParams = $sf->getTeamSetIdSearchField('team_set_id', 'all', $teams);
        $query = string_format($searchParams['subquery'], array($field_value));
        return $this->_get_column_select($layout_def)." IN ({$query}) " . $this->queryPrimaryTeam($layout_def) . "\n";
 }

 /**
  * Perform the Exact type query
  *
  * @param array $layout_def
  * @return string the subquery to be run
  */
 function queryFilterexact(&$layout_def){
 	require_once('include/SugarFields/SugarFieldHandler.php');
	$sfh = new SugarFieldHandler();
    $sf = $sfh->getSugarField('teamset');
    $teams = array();
    if(!empty($layout_def['input_name0'])) {
    	foreach($layout_def['input_name0'] as $team) {
        	$teams[$team] = $team;
        }
    }

    $searchParams = $sf->getTeamSetIdSearchField('team_set_id', 'exact', $teams);
    $query = string_format($searchParams['subquery'], array($searchParams['value']));
	return $this->_get_column_select($layout_def)."= ({$query}) " . $this->queryPrimaryTeam($layout_def) . "\n";
 }
 
 
 /**
  * This method creates the additional SQL to query for the primary team value
  * 
  * @param array $layout_def
  * @return String SQL to be appended blank String if no primary team specified
  */
 private function queryPrimaryTeam(&$layout_def) {
 	if(isset($layout_def['input_name2']) && isset($layout_def['input_name0'][$layout_def['input_name2']])) {
 	   return "AND {$layout_def['table_alias']}.team_id = '{$layout_def['input_name0'][$layout_def['input_name2']]}'";
 	}
 	return '';
 }
 
}

?>
