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

require_once('include/MVC/View/SugarView.php');
require_once('modules/SugarFavorites/SugarFavorites.php');

class ViewFavorites extends SugarView
{
 	public function __construct()
 	{
 		$this->options['show_title'] = false;
		$this->options['show_header'] = false;
		$this->options['show_footer'] = false;
		$this->options['show_javascript'] = false;
		$this->options['show_subpanels'] = false;
		$this->options['show_search'] = false;
 		parent::SugarView();
 	}

 	public function display()
 	{

        $favorites_max_viewed = (!empty($GLOBALS['sugar_config']['favorites_max_viewed']))? $GLOBALS['sugar_config']['favorites_max_viewed'] : 10;
 		$results = SugarFavorites::getUserFavoritesByModule($this->module,$GLOBALS['current_user'], "sugarfavorites.date_modified DESC ", $favorites_max_viewed);
 		$items = array();
 		foreach ( $results as $key => $row ) {
 				 $items[$key]['label'] = $row->record_name;
 				 $items[$key]['record_id'] = $row->record_id;
 				 $items[$key]['module'] = $row->module;
 		}
 		$this->ss->assign('FAVORITES',$items);
 		$this->ss->display('include/MVC/View/tpls/favorites.tpl');
 	}
}
?>
