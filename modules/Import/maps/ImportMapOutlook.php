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

/*********************************************************************************

 * Description: Holds import setting for Outlook files
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/

require_once('modules/Import/maps/ImportMapOther.php');

class ImportMapOutlook extends ImportMapOther
{
	/**
     * String identifier for this import
     */
    public $name = 'outlook';
	/**
     * Field delimiter
     */
    public $delimiter = ',';
    /**
     * Field enclosure
     */
    public $enclosure = '"';
	/**
     * Do we have a header?
     */
    public $has_header = true;
    
    /**
     * Gets the default mapping for a module
     *
     * @param  string $module
     * @return array field mappings
     */
	public function getMapping(
        $module
        )
    {
        $return_array = parent::getMapping($module);
        switch ($module) {
        case 'Contacts':
        case 'Leads':
            return $return_array + array(
                "Job Title"=>"title",
                "Home Country"=>"alt_address_country",
                "E-mail 2 Address"=>"email2",
                );
            break;
        case 'Accounts':
            return $return_array;
            break;
        default:
            return $return_array;
        }
    }
}


?>
