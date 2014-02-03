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

/**
 * Stub class, exists only to allow Link class easily use the SugarEmailAddress class
 */
class EmailAddress extends SugarEmailAddress
{
	var $disable_row_level_security = true;

	function save($id = '', $module = '', $new_addrs=array(), $primary='', $replyTo='', $invalid='', $optOut='', $in_workflow=false)
	{
		if ( func_num_args() > 1 ) {
		    parent::save($id, $module, $new_addrs, $primary, $replyTo, $invalid, $optOut, $in_workflow);
		}
		else {
		    SugarBean::save($id);
		}
	}
}