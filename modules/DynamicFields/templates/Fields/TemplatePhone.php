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


class TemplatePhone extends TemplateText{
    var $max_size = 25;
    var $type='phone';
    var $supports_unified_search = true;
    
    /**
     * __construct
     * 
     * Constructor for TemplatePhone class. This constructor ensures that TemplatePhone instances have the
     * validate_usa_format vardef value.
     */
    public function __construct()
	{
	}	
	
	/**
	 * get_field_def
	 * 
	 * @see parent::get_field_def
	 * This method checks to see if the validate_usa_format key/value entry should be
	 * added to the vardef entry representing the module
	 */	
    function get_field_def(){
		$def = parent::get_field_def();
		$def['dbType'] = 'varchar';
		
		return $def;	
	}
}


?>
