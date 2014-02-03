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




global $current_user;

$dashletData['SugarFavoritesDashlet']['searchFields'] = array();
$dashletData['SugarFavoritesDashlet']['columns'] =  array(   
                                                    'record_name' => array('width' => '29', 
                                                                         'label' => 'LBL_LIST_NAME',
                                                                         'sortable' => false,
                                                                         'dynamic_module' => 'MODULE',
                                                                         'link' => true,
                                                                         'id' => 'RECORD_ID',
                                                                         'ACLTag' => 'RECORD_NAME',
                                                                         'related_fields' => array('record_id', 'module'),
																		 'default' => true,
																		),
													
                                                      'module' => array('width'   => '15', 
                                                                              'label'   => 'LBL_LIST_MODULE',
                                                                              'default' => true),
                                                      'date_entered' => array('width'   => '15', 
                                                                              'label'   => 'LBL_DATE_ENTERED',
                                                                              'default' => true),
                                               );