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







	
$object_name = strtolower($object_name);
$app_list_strings = array (
  $object_name.'_status_dom' => 
  array (
    'Pending Input' => 'Až do vstupu',
    'Rejected' => 'Odmítnuto',
    'Duplicate' => 'Duplikát',
    'New' => 'Nový',
    'Assigned' => 'Přiřazený',
    'Closed' => 'Zavřený',
  ),
  $object_name.'_priority_dom' => 
  array (
    'P1' => 'Vysoký',
    'P2' => 'Střední',
    'P3' => 'Nízký',
  ),
  $object_name.'_resolution_dom' => 
  array (
    '' => '',
    'Accepted' => 'Přijatý',
    'Duplicate' => 'Duplikát',
    'Closed' => 'Zavřený',
    'Out of Date' => 'Zastaralý',
    'Invalid' => 'Neplatný',
  ),
  $object_name.'_type_dom' => 
  array (
    'Administration' => 'Administrace',
    'Product' => 'Produkt',
    'User' => 'Uživatel',
  ),
);

