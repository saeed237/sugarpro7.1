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
  $searchdefs['EmailMan'] = array(
					'templateMeta' => array(
							'maxColumns' => '3', 'maxColumnsBasic' => '4', 
                            'widths' => array('label' => '10', 'field' => '30'),                 
                           ),
                    'layout' => array(  					
						'basic_search' => array(
						    array('name'=>'campaign_name', 'label'=>'LBL_LIST_CAMPAIGN',),
						 	array('name'=>'current_user_only', 'label'=>'LBL_CURRENT_USER_FILTER', 'type'=>'bool'),
						),
						'advanced_search' => array(
						    array('name'=>'campaign_name', 'label'=>'LBL_LIST_CAMPAIGN',),
						 	array('name'=>'to_name', 'label'=>'LBL_LIST_RECIPIENT_NAME'),
						 	array('name'=>'to_email', 'label'=>'LBL_LIST_RECIPIENT_EMAIL'),
						 	array('name'=>'current_user_only', 'label'=>'LBL_CURRENT_USER_FILTER', 'type'=>'bool'),
						),
					),
 			   );
?>
