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
global $genericAssocFieldsArray;
global $moduleAssocFieldsArray;

$genericAssocFieldsArray = array('assigned_user_id' =>
                                array('table_name' => 'users',
                                    'select_field_name' => 'user_name',
                                    'select_field_join'  => 'id',
                                ),
                                'team_id' =>
                                    array('table_name' => 'teams',
                                    'select_field_name' => 'name',
                                    'select_field_join'  => 'id',
                                  ),
                                  'account_id' =>
                                  array('table_name' => 'accounts',
                                    'select_field_name' => 'name',
                                    'select_field_join'  => 'id',
                                  ), 
                                  'contact_id' =>
                                  array('table_name' => 'contacts',
                                    'select_field_name' => 
                                    		array('first_name',
                                    			  'last_name',
                                    		),
                                    'select_field_join'  => 'id',
                                  ),
                                  'fixed_in_release' =>
                                  array('table_name' => 'releases',
                                    'select_field_name' => 'name',
                                    'select_field_join'  => 'id',
                                  ), 
                                  'found_in_release' =>
                                  array('table_name' => 'releases',
                                    'select_field_name' => 'name',
                                    'select_field_join'  => 'id',
                                  ),                                   
                            );
$moduleAssocFieldsArray = array('Account' =>
                                array('parent_id' =>
                                    array('table_name' => 'accounts',
                                        'select_field_name' => 'name',
                                        'select_field_join'  => 'id',
                                    )
                                ),
                            );

?>