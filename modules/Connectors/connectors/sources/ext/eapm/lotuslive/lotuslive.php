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


require_once('include/connectors/sources/default/source.php');

class ext_eapm_lotuslive extends source {
	protected $_enable_in_wizard = false;
	protected $_enable_in_hover = false;
	protected $_has_testing_enabled = false;

    // DEPRECATED in favor of IBM SmartCloud
    protected $_enable_in_admin_display = false;
    protected $_enable_in_admin_properties = false;

	public function getItem($args=array(), $module=null){}
	public function getList($args=array(), $module=null) {}
}
