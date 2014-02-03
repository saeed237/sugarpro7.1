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

global $selector_meta_array;
$selector_meta_array = Array(

'normal_trigger' => Array(
				'enum_multi' => true
				,'time_type' => false
				,'select_field' => false
			),
'time_trigger' => Array(
				'enum_multi' => true
				,'time_type' => true
				,'select_field' => false
			),
'alert_filter' => Array(
				'enum_multi' => false
				,'time_type' => false
				,'select_field' => true
			),
'count_trigger' => Array(
				'enum_multi' => false
				,'time_type' => false
				,'select_field' => true
			),									
);
?>