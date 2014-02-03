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

	

$object_name = strtolower($object_name);
$app_list_strings = array (
  $object_name.'_status_dom' => 
  array (
    'Pending Input' => 'Të hyrat e pezulluara',
    'New' => 'E re',
    'Assigned' => 'Drejtuar',
    'Closed' => 'Mbyllur',
    'Rejected' => 'Anuluar',
    'Duplicate' => 'Dubluar',
  ),
  $object_name.'_resolution_dom' => 
  array (
    'Out of Date' => 'Jashtë datës',
    '' => '',
    'Accepted' => 'I pranuar',
    'Duplicate' => 'Dublo',
    'Closed' => 'Mbyll',
    'Invalid' => 'Jo valide',
  ),
  $object_name.'_type_dom' => 
  array (
    'Administration' => 'Administrimi',
    'Product' => 'Produkti',
    'User' => 'Përdorues',
  ),
  $object_name.'_priority_dom' => 
  array (
    'P1' => 'I lartë',
    'P2' => 'Mesatar',
    'P3' => 'I ulët',
  ),
);

