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
  $searchdefs['TimePeriods'] = array(
					'templateMeta' => array(
							'maxColumns' => '3', 
  							'maxColumnsBasic' => '4', 
                            'widths' => array('label' => '10', 'field' => '30'),                 
                           ),
                    'layout' => array(  					
						'basic_search' => array(
						    'name' => array('name' => 'name', 'label' => 'LBL_TP_NAME', 'type' => 'name',),
						    ),
						'advanced_search' => array(
						    'name' => array('name' => 'name', 'label' => 'LBL_TP_NAME', 'type' => 'name',),
						    'parent_id' => array('name' => 'parent_id', 'label' => 'LBL_TP_FISCAL_YEAR',
						        'type' => 'enum',
						        'size' => 1,
						        'function' => 
                                array (
                                  'name' => 'get_fiscal_year_dom',
                                  'params' => 
                                  array (
                                    0 => false,
                                  ),
                                ),
                                'default' => true,),
						    'start_date' => array('name' => 'start_date', 'label' => 'LBL_TP_START_DATE',),
						    'end_date' => array('name' => 'end_date', 'label' => 'LBL_TP_END_DATE',),
						    ),
					),
 			   );
?>
