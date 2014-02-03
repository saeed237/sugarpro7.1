<?php
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

$viewdefs['Employees']['EditView'] = array(
    'templateMeta' => array('maxColumns' => '2', 
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'), 
                                            array('label' => '10', 'field' => '30')
                                            ),
                            ),
 'panels' =>array (

  'default'=>array (
	    array (
	      'employee_status',
            array (
              'name'=>'picture',
              'label'=>'LBL_PICTURE_FILE',
            ),
	    ),
	    array (
	      'first_name',
	      array('name'=>'last_name', 'displayParams'=>array('required'=>true)),
	    ),
	    array (
          'title',
	      array('name'=>'phone_work','label'=>'LBL_OFFICE_PHONE'),
	    ),
	    array (
	      'department', 
	      'phone_mobile',
	    ),
	    array (
	      'reports_to_name',
	      'phone_other',
	    ),
	    array (
	      '',
	      array('name'=>'phone_fax', 'label'=>'LBL_FAX'),
	    ),
	    array (
	      '',
	      'phone_home',
	    ),
	    array (
	      'messenger_type',
	    ),
	    array (
	      'messenger_id',
	    ),
	    array (
	      array('name'=>'description', 'label'=>'LBL_NOTES'),
	    ),
	    array (
	      array('name'=>'address_street', 'type'=>'text', 'label'=>'LBL_PRIMARY_ADDRESS', 'displayParams'=>array('rows'=>2, 'cols'=>30)),
	      array('name'=>'address_city', 'label'=>'LBL_CITY'),
	    ),
	    array (
	      array('name'=>'address_state', 'label'=>'LBL_STATE'),
	      array('name'=>'address_postalcode', 'label'=>'LBL_POSTAL_CODE'),
	    ),
	    array (
	      array('name'=>'address_country', 'label'=>'LBL_COUNTRY'),
	    ),
        array(
          array (
              'name' => 'email1',
              'label' => 'LBL_EMAIL',
            ),
  		),
   ),
),

);
?>