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

$dictionary['Administration'] = array('table' => 'config', 'comment' => 'System table containing system-wide definitions'
                               ,'fields' => array (
  'category' =>
  array (
    'name' => 'category',
    'vname' => 'LBL_LIST_SYMBOL',
    'type' => 'varchar',
    'len' => '32',
    'comment' => 'Settings are grouped under this category; arbitraily defined based on requirements'
  ),
  'name' =>
  array (
    'name' => 'name',
    'vname' => 'LBL_LIST_NAME',
    'type' => 'varchar',
    'len' => '32',
    'comment' => 'The name given to the setting'
  ),
  'value' =>
  array (
    'name' => 'value',
    'vname' => 'LBL_LIST_RATE',
    'type' => 'text',
    'comment' => 'The value given to the setting'
  ),
  'platform' =>
  array (
    'name' => 'platform',
    'vname' => 'LBL_LIST_PLATFORM',
    'type' => 'varchar',
    'len' => '32',
    'comment' => 'Which platform to send this back with vai the api'
  ),
), 'indices'=>array( array('name'=>'idx_config_cat', 'type'=>'index',  'fields'=>array('category')), array('name'=>'idx_config_platform', 'type'=>'index',  'fields'=>array('platform'))),
'acls' => array('SugarACLDeveloperForAny' => true, 'SugarACLStatic' => false),
                            );

$dictionary['UpgradeHistory'] = array(
    'table'  => 'upgrade_history', 'comment' => 'Tracks Sugar upgrades made over time; used by Upgrade Wizard and Module Loader',
    'fields' => array (
        'id' => array (
                'name'       => 'id',
                'type'       => 'id',
                'required'   => true,
                'reportable' => false,
    		    'comment' => 'Unique identifier'
        ),
        'filename' => array (
                'name' => 'filename',
                'type' => 'varchar',
                'len' => '255',
    		    'comment' => 'Cached filename containing the upgrade scripts and content'
        ),
        'md5sum' => array (
                'name' => 'md5sum',
                'type' => 'varchar',
                'len' => '32',
    		    'comment' => 'The MD5 checksum of the upgrade file'
        ),
        'type' => array (
                'name' => 'type',
                'type' => 'varchar',
                'len' => '30',
    		    'comment' => 'The upgrade type (module, patch, etc)'
        ),
        'status' => array (
                'name' => 'status',
                'type' => 'varchar',
                'len' => '50',
    		    'comment' => 'The status of the upgrade (ex:  "installed")',
        ),
        'version' => array (
                'name' => 'version',
                'type' => 'varchar',
                'len' => '64',
    		    'comment' => 'Version as contained in manifest file'
        ),
		'name' => array (
                'name'  => 'name',
                'type'  => 'varchar',
                'len'   => '255',
        ),
		'description' => array (
                'name'  => 'description',
                'type'  => 'text',
        ),
        'id_name' => array (
                'name' => 'id_name',
                'type' => 'varchar',
                'len' => '255',
    		    'comment' => 'The unique id of the module'
        ),
        'manifest' => array (
                'name' => 'manifest',
                'type' => 'longtext',
    		    'comment' => 'A serialized copy of the manifest file.'
        ),
        'date_entered' => array (
                'name' => 'date_entered',
                'type' => 'datetime',
                'required'=>true,
    		    'comment' => 'Date of upgrade or module load'
        ),
        'enabled' => array(
                                      'name' => 'enabled',
                                      'type' => 'bool',
                                      'len'  => '1',
                                      'default'   => '1',
        ),
    ),

    'indices' => array(
        array('name'=>'upgrade_history_pk',     'type'=>'primary', 'fields'=>array('id')),
        array('name'=>'upgrade_history_md5_uk', 'type'=>'unique',  'fields'=>array('md5sum')),

    ),
);

$dictionary['System'] = array ( 'table' => 'systems',
                         'fields' => array (
                                'id' => array(
                                      'name' =>'id',
                                      'type' =>'id'
                                     ),

                               'system_id' => array(
                                      'name' =>'system_id',
                                      'type' =>'int',
                                      'auto_increment'=>true,
                                      'required'=>true
                                     ),

                                'system_key' => array(
                                      'name' =>'system_key',
                                      'type' =>'varchar',
                                      'len'=>'36'
                                     ),

                                'user_id' => array(
                                      'name' =>'user_id',
                                      'type' =>'id'
                                     ),

                                'last_connect_date' => array(
                                      'name' =>'last_connect_date',
                                      'type' => 'datetime',
                                      'massupdate'=>false,
                                     ),

                                'status' => array(
                                      'name' =>'status',
                                      'vname' => 'LBL_OC_STATUS',
                                      'type' =>'enum',
                                      'len'=>'255',
                                      'options'=> 'oc_status_dom',
                                      'default'=>'Active',
                                      'massupdate'=>true,
                                     ),
                                 'num_syncs' => array(
                                      'name' =>'num_syncs',
                                      'type' =>'int',
                                      'default'=>'0'
                                     ),
                                 'system_name' => array(
                                      'name' =>'system_name',
                                      'type' =>'varchar',
                                      'len' => '100',
                                     ),
                                  'install_method' => array(
                                      'name' =>'install_method',
                                      'type' =>'varchar',
                                      'len' => '100',
                                     ),

                                'date_entered' => array (
                                      'name' => 'date_entered',
                                       'type' => 'datetime'
                                      ),

                                'date_modified' => array (
                                       'name' => 'date_modified',
                                       'type' => 'datetime'
                                      ),

                                'deleted' => array(
                                      'name' => 'deleted',
                                      'type' => 'bool',
                                      'len'  => '1',
                                      'default'   => '0',
                                      'required'  => true
                                ),
                             ),
                             'indices' => array (
                                array('name' =>'systems_pk',
                                      'type' =>'primary',
                                      'fields'=>array('id')
                                      ),
                                array('name' =>'system_id',
                                      'type' =>'index',
                                      'fields'=>array('system_id')
                                      ),
                             )
                    );

                    $dictionary['SessionManager'] = array ( 'table' => 'session_active',
                         'fields' => array (
                                'id' => array(
                                      'name' =>'id',
                                      'type' =>'id'
                                     ),

                               'session_id' => array(
                                      'name' =>'session_id',
                                      'type' =>'varchar',
                                      'len' => '100',
                                     ),
                                 'last_request_time' => array (
                                      'name' => 'last_request_time',
                                       'type' => 'datetime',
                                      ),
                                 'session_type' => array (
                                      'name' => 'session_type',
                                       'type' => 'varchar',
                                        'len' => '100',
                                      ),
                                'is_violation' => array(
                                      'name' => 'is_violation',
                                      'type' => 'bool',
                                      'len'  => '1',
                                      'default'   => '0',
                                ),
                                'num_active_sessions' => array (
                                      'name' => 'num_active_sessions',
                                       'type' => 'int',
                                       'default'=>'0',
                                      ),
                                'date_entered' => array (
                                      'name' => 'date_entered',
                                       'type' => 'datetime'
                                      ),
                                'date_modified' => array (
                                       'name' => 'date_modified',
                                       'type' => 'datetime'
                                      ),
                                 'deleted' => array(
                                      'name' => 'deleted',
                                      'type' => 'bool',
                                      'len'  => '1',
                                      'default'   => '0',
                                      'required'  => false
                                ),
                             ),
                             'indices' => array (
                                array('name' =>'session_active_pk',
                                      'type' =>'primary',
                                      'fields'=>array('id')
                                      ),
                               array('name' =>'idx_session_id' ,
                                     'type'=>'unique' ,
                                     'fields'=>array('session_id')),
                             )
                    );

?>
