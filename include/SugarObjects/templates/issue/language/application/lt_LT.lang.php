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





if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


	
$object_name = strtolower($object_name);
$app_list_strings = array (
  $object_name.'_type_dom' => 
  array (
    'Administration' => 'Administratorius',
    'Product' => 'Prekė',
    'User' => 'Vartotojas',
  ),
  $object_name.'_status_dom' => 
  array (
    'New' => 'Naujas',
    'Assigned' => 'Priskirtas',
    'Closed' => 'Užbaigtas',
    'Pending Input' => 'Laukiantis',
    'Rejected' => 'Atmestas',
    'Duplicate' => 'Dublikatas',
  ),
  $object_name.'_priority_dom' => 
  array (
    'P1' => 'Didelė',
    'P2' => 'Vidutinė',
    'P3' => 'Maža',
  ),
  $object_name.'_resolution_dom' => 
  array (
    '' => '',
    'Accepted' => 'Patvirtintas',
    'Duplicate' => 'Dublikatas',
    'Closed' => 'Užbaigtas',
    'Out of Date' => 'Pasenęs',
    'Invalid' => 'Neteisingas',
  ),
);

