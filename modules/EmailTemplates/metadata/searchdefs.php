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
  $searchdefs['EmailTemplates'] = array(
					'templateMeta' => array(
							'maxColumns' => '2', 
  							'maxColumnsBasic' => '2',
                            'widths' => array('label' => '10', 'field' => '30'),                 
                           ),
                    'layout' => array(  					
						'basic_search' => array(
						 	'name',
                            'type' => array('name' => 'type', 'type'=>'enum', 'function' => array('name' => 'EmailTemplate::getTypeOptionsForSearch'))
							),
					    'advanced_search' => array('name',
                                                        'type' => array('name' => 'type', 'type'=>'enum', 'function' => array('name' => 'EmailTemplate::getTypeOptionsForSearch')),
                                                        'subject','description',
                                					    'assigned_user_id' => 
                                					      array (
                                					        'name' => 'assigned_user_id',
                                					        'type' => 'enum',
                                					        'label' => 'LBL_ASSIGNED_TO',
                                					        'function' => 
                                					         array (
                                    					          'name' => 'get_user_array',
                                    					          'params' => array ( 0 => false,), ),
                                					        'default' => true
                                					      ),
					    )
					),
 			   );
?>
