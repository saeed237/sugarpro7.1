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

 * Description: Holds import setting for standard delimited files
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/

class ImportMapOther
{
	/**
     * String identifier for this import
     */
    public $name = 'other';
	/**
     * Field delimiter
     */
    public $delimiter;
    /**
     * Field enclosure
     */
    public $enclosure;
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
        switch ($module) {
        case 'Contacts':
        case 'Leads':
            return array(
                "Salutation"=>"salutation",
                "Full Name"=>"full_name",
                "Company"=>"company",
                "First Name"=>"first_name",
                "Last Name"=>"last_name",
                "Title"=>"title",
                "Department"=>"department",
                "Birthday"=>"birthdate",
                "Home Phone"=>"phone_home",
                "Mobile Phone"=>"phone_mobile",
                "Business Phone"=>"phone_work",
                "Other Phone"=>"phone_other",
                "Business Fax"=>"phone_fax",
                "E-mail Address"=>"email1",
                "E-mail 2"=>"email2",
                "Assistant's Name"=>"assistant",
                "Assistant's Phone"=>"assistant_phone",
                "Business Street"=>"primary_address_street",
                "Business Street 2"=>"primary_address_street_2",
                "Business Street 3"=>"primary_address_street_3",
                "Business City"=>"primary_address_city",
                "Business State"=>"primary_address_state",
                "Business Postal Code"=>"primary_address_postalcode",
                "Business Country/Region"=>"primary_address_country",
                "Home Street"=>"alt_address_street",
                "Home Street 2"=>"alt_address_street_2",
                "Home Street 3"=>"alt_address_street_3",
                "Home City"=>"alt_address_city",
                "Home State"=>"alt_address_state",
                "Home Postal Code"=>"alt_address_postalcode",
                "Home Country/Region"=>"alt_address_country",
                );
            break;
        case 'Accounts':
            return array(
                "Company"=>"name",
                "Business Street"=>"billing_address_street",
                "Business City"=>"billing_address_city",
                "Business State"=>"billing_address_state",
                "Business Country"=>"billing_address_country",
                "Business Postal Code"=>"billing_address_postalcode",
                "Business Fax"=>"phone_fax",
                "Company Main Phone"=>"phone_office",
                "Web Page"=>"website",
                );
            break;
        case 'Opportunities':
            return array(
                "Opportunity Name"=>"name" ,
                "Type"=>"opportunity_type",
                "Lead Source"=>"lead_source",
                "Amount"=>"amount",
                "Created Date"=>"date_entered",
                "Close Date"=>"date_closed",
                "Next Step"=>"next_step",
                "Stage"=>"sales_stage",
                "Probability (%)"=>"probability",
                "Account Name"=>"account_name");
            break;
        case 'ProductTemplates':
            return array(
                "Product Name"=>"name",
                "Product URL"=>"website",
                "Tax Class"=>"tax_class",
                "Manufacturer Name"=>"manufacturer_name",
                "Manufacturer ID"=>"manufacturer_id",
                "Mft Part Number"=>"mft_part_num",
                "Vendor Part Number"=>"vendor_part_num",
                "Currency"=>"currency_name",
                "Cost"=>"cost_price",
                "List"=>"list_price",
                "Purchase Price"=>"discount_price",
                "Pricing Formula"=>"pricing_formula",
                "Availability"=>"status",
                "Date Available"=>"date_available",
                "Quantity in Stock"=>"qty_in_stock",
                "Weight"=>"weight",
                "Category Name"=>"category_name",
                "Category ID"=>"category_id",
                "Type Name"=>"type_name",
                "Type ID"=>"type_id",
                "Support Name"=>"support_name",
                "Support Contact"=>"support_contact",
                "Support Desc"=>"support_description",
                "Support Term"=>"support_term",
                "Description"=>"description",
                );
            break;
        case 'Tasks':
            return array(
                'Related To ID'=>'parent_id',
                'Related To Module'=>'parent_type',
            );
            break;
        default:
            return array();
        }
    }
	
	/**
     * Returns a list of fields that should be ignorred for the module during import
     *
     * @param  string $module
     * @return array of fields to ignor
     */
	public function getIgnoredFields(
		$module
		)
	{
		return array();
	}
}


?>
