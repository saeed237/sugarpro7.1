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



require_once('modules/Import/maps/ImportMapOther.php');

class ImportMapLinkedin extends ImportMapOther
{
	/**
     * String identifier for this import
     */
    public $name = 'linkedin';
    
    /**
     * Gets the default mapping for a module
     *
     * @param  string $module
     * @return array field mappings
     */
	public function getMapping()
    {
         $return_array = array(
             'first-name' => array('sugar_key' => 'first_name', 'sugar_label' => '', 'default_label' => 'First Name'),
             'last-name' => array('sugar_key' => 'last_name', 'sugar_label' => '', 'default_label' => 'Last Name'),
             'title' => array('sugar_key' => 'title', 'sugar_label' => '', 'default_label' => 'Title'),
             'industry' => array('sugar_key' => '', 'sugar_label' => '', 'default_label' => 'Industry'),
             'location-country-code' => array('sugar_key' => 'primary_address_country', 'sugar_label' => '', 'default_label' => 'Country Code'),
             'company_name' => array('sugar_key' => 'account_name', 'sugar_label' => '', 'default_label' => 'Company Name'),
             'position-summary' => array('sugar_key' => 'description', 'sugar_label' => '', 'default_label' => 'Position Summary'),
             
             'assigned_user_name' => array('sugar_key' => 'assigned_user_name', 'sugar_help_key' => 'LBL_EXTERNAL_ASSIGNED_TOOLTIP', 'sugar_label' => 'LBL_ASSIGNED_TO_NAME', 'default_label' => 'Assigned To'),
             'team_name' => array('sugar_key' => 'team_name', 'sugar_help_key' => 'LBL_EXTERNAL_TEAM_TOOLTIP','sugar_label' => 'LBL_TEAMS', 'default_label' => 'Teams'),

             );

         return $return_array;
    }
}


?>
