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

$viewdefs['Bugs']['EditView'] = array(
    'templateMeta' => array('form'=>array('hidden'=>array('<input type="hidden" name="account_id" value="{$smarty.request.account_id}">',
    											          '<input type="hidden" name="contact_id" value="{$smarty.request.contact_id}">')
    											          ),
							'maxColumns' => '2',
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'),
                                            array('label' => '10', 'field' => '30')
                                            ),
                                            ),


 'panels' =>array (
	  'lbl_bug_information' =>
		  array (

		    array (
		      array (
		        'name' => 'bug_number',
		        'type' => 'readonly',
		      ),
		    ),

		    array (
		      array('name'=>'name', 'displayParams'=>array('size'=>60, 'required'=>true)),
		    ),

		    array (
		      'priority',
		      'type',
		    ),

		    array (
		      'source',
		      'status',

		    ),

		    array (
		      'product_category',
		      'resolution',
		    ),


		    array (
		      'found_in_release',
		      'fixed_in_release'
		    ),

		    array (
		      array (
			      'name' => 'description',
			      'nl2br' => true,
		      ),
		    ),


		    array (
		      array (
			      'name' => 'work_log',
			      'nl2br' => true,
		      ),
		    ),

	  ),

      'LBL_PANEL_ASSIGNMENT' =>
      array (
        array (
            array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
          'team_name',
        ),
      ),
),

);
?>