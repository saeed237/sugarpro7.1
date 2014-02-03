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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/





// Contact is used to store customer information.
class ContactOpportunityRelationship extends SugarBean {
	// Stored fields
	var $id;
	var $contact_id;
	var $contact_role;
	var $opportunity_id;

	// Related fields
	var $contact_name;
	var $opportunity_name;

	var $table_name = "opportunities_contacts";
	var $object_name = "ContactOpportunityRelationship";
	var $column_fields = Array("id"
		,"contact_id"
		,"opportunity_id"
		,"contact_role"
		,'date_modified'
		);

	var $new_schema = true;
	
	var $additional_column_fields = Array();
		var $field_defs = array (
       'id'=>array('name' =>'id', 'type' =>'char', 'len'=>'36', 'default'=>'')
      , 'contact_id'=>array('name' =>'contact_id', 'type' =>'char', 'len'=>'36', )
      , 'opportunity_id'=>array('name' =>'opportunity_id', 'type' =>'char', 'len'=>'36',)
      , 'contact_role'=>array('name' =>'contact_role', 'type' =>'char', 'len'=>'50')
      , 'date_modified'=>array ('name' => 'date_modified','type' => 'datetime')
      , 'deleted'=>array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>true)
      );


    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function ContactOpportunityRelationship()
    {
        self::__construct();
    }


	public function __construct() {
		$this->db = DBManagerFactory::getInstance();
        $this->dbManager = DBManagerFactory::getInstance();

		$this->disable_row_level_security =true;

		}

	function fill_in_additional_detail_fields()
	{
		global $locale;
		if(isset($this->contact_id) && $this->contact_id != "")
		{
			$query = "SELECT first_name, last_name from contacts where id='$this->contact_id' AND deleted=0";
			$result =$this->db->query($query,true," Error filling in additional detail fields: ");
			// Get the id and the name.
			$row = $this->db->fetchByAssoc($result);

			if($row != null)
			{
				$this->contact_name = $locale->getLocaleFormattedName($row['first_name'], $row['last_name']);
			}
		}

		if(isset($this->opportunity_id) && $this->opportunity_id != "")
		{
			$query = "SELECT name from opportunities where id='$this->opportunity_id' AND deleted=0";
			$result =$this->db->query($query,true," Error filling in additional detail fields: ");
			// Get the id and the name.
			$row = $this->db->fetchByAssoc($result);

			if($row != null)
			{
				$this->opportunity_name = $row['name'];
			}
		}

	}
}



?>
