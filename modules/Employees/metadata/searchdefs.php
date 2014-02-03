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

/*
 * Created on May 29, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
  $searchdefs['Employees'] = array(
  					'templateMeta' => array('maxColumns' => '3', 'maxColumnsBasic' => '4', 
                            'widths' => array('label' => '10', 'field' => '30'), 
                           ),
                    'layout' => array(
                    	'basic_search' => array(
                    		array('name'=>'search_name','label' =>'LBL_NAME', 'type' => 'name'),
                            array('name'=>'open_only_active_users', 'label'=>'LBL_ONLY_ACTIVE', 'type' => 'bool'),
							),
                    	'advanced_search' => array(
                    	    'first_name',
                    	    'last_name',
                    	    'employee_status',
                    	    'title',
                    	    'phone' => 
                              array (
                                'name' => 'phone',
                                'label' => 'LBL_ANY_PHONE',
                                'type' => 'name',
                                'default' => true,
                                'width' => '10%',
                              ),
                    	    'department',
                    	    'email' => 
                              array (
                                'name' => 'email',
                                'label' => 'LBL_ANY_EMAIL',
                                'type' => 'name',
                                'default' => true,
                                'width' => '10%',
                              ),
                    	    'address_street' => 
                              array (
                                'name' => 'address_street',
                                'label' => 'LBL_ANY_ADDRESS',
                                'type' => 'name',
                                'default' => true,
                                'width' => '10%',
                              ),
                              'address_city' => 
                              array (
                                'name' => 'address_city',
                                'label' => 'LBL_CITY',
                                'type' => 'name',
                                'default' => true,
                                'width' => '10%',
                              ),
                    	    'address_state' => 
                              array (
                                'name' => 'address_state',
                                'label' => 'LBL_STATE',
                                'type' => 'name',
                                'default' => true,
                                'width' => '10%',
                              ),
                              'address_postalcode' => 
                              array (
                                'name' => 'address_postalcode',
                                'label' => 'LBL_POSTAL_CODE',
                                'type' => 'name',
                                'default' => true,
                                'width' => '10%',
                              ),
                             
                    	    'address_country' => 
                              array (
                                'name' => 'address_country',
                                'label' => 'LBL_COUNTRY',
                                'type' => 'name',
                                'default' => true,
                                'width' => '10%',
                              ),
                    		),				
					),
 			   );
