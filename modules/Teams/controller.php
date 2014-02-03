<?php
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


require_once('include/MVC/Controller/SugarController.php');
class TeamsController extends SugarController {


	public function action_DisplayInlineTeams(){
		$this->view = 'ajax';
		$body = '';
		$primary_team_id = isset($_REQUEST['team_id']) ? $_REQUEST['team_id'] : '';
		$caption = '';
		if(!empty($_REQUEST['team_set_id'])){
			require_once('modules/Teams/TeamSetManager.php');
			$teams = TeamSetManager::getTeamsFromSet($_REQUEST['team_set_id']);

			foreach($teams as $row){
				if($row['id'] == $primary_team_id) {
				   $body = $row['display_name'] . '*<br/>' . $body;
				} else {
				   $body .= $row['display_name'].'<br/>';
				}
			}
		}
		global $theme;
		$json = getJSONobj();
		$retArray = array();

		$retArray['body'] = $body;
		$retArray['caption'] = $caption;
	    $retArray['width'] = '100';
	    $retArray['theme'] = $theme;
	    echo 'result = ' . $json->encode($retArray);
	}
}
?>