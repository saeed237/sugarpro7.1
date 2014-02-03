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

class SugarFavoritesController extends SugarController {
	public function __construct(){
	}
	public function loadBean(){
		if(empty($this->record))$this->record = SugarFavorites::generateGUID($_REQUEST['fav_module'], $_REQUEST['fav_id']);
		$this->bean = BeanFactory::getBean('SugarFavorites');
	}
	public function pre_save(){
	    global $current_user;

		if(!$this->bean->retrieve($this->record, true, false)){
			$this->bean->new_with_id = true;
		}
		$this->bean->id = $this->record;
		$this->bean->module = $_REQUEST['fav_module'];
		$this->bean->record_id = $_REQUEST['fav_id'];
		$this->bean->created_by = $current_user->id;
		$this->bean->assigned_user_id = $current_user->id;
		$this->bean->deleted = 0;
	}

	public function action_save(){
	    if(!empty($this->bean->fetched_row['deleted']) && empty($this->bean->deleted)) {
	        $this->bean->mark_undeleted($this->bean->id);
	    }
		$this->bean->save();

	}
	public function post_save(){
		echo $this->record;
	}
	public function action_delete(){
		$this->bean->mark_deleted($this->record);

	}
	public function post_delete(){
		echo $this->record;
	}
	public function action_tag(){
		return 'Favorite Tagged';

	}
}
?>