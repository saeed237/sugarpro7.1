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


$subpanel_layout = array(
	'top_buttons' => array(
			/*array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Queues'),*/
	),
	'where' => "",

	'fill_in_additional_fields'=>true,
	'list_fields' => array(
/*		'mass_update' => array (
			
		),
*/		
		'id'=>array(
	//		 'widget_class' => 'SubPanelDetailViewLink',
			 'vname' => 'LBL_EXECUTE_TIME',
			 'width' => '20%',
		),
	),
);		

?>