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


$dictionary['kbdocuments_viwes_ratings'] = array (
	'table' => 'kbdocuments_views_ratings',
	'fields' => array (
       array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
      , array ('name' => 'date_modified','type' => 'datetime')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required' => false,)
      , array('name' =>'kbdocument_id', 'type' =>'varchar', 'len'=>'36', )
      , array('name' =>'views_number', 'type' =>'int', 'default'=>'0','required' => false,)
      , array('name' =>'ratings_number', 'type' =>'int', 'default'=>'0','required' => false,)           
	),
	'indices' => array (
       array('name' =>'kbdoc_views_ratingspk', 'type' =>'primary', 'fields'=>array('id'))
       , array('name' =>'idx_kbvr_kbdoc', 'type' =>'index', 'fields'=>array('kbdocument_id'))                  
	),		
);
?>
