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

  $object_name.'_type_dom' =>
  array (
  	'Administration' => 'Administration',
    'Product' => 'Produkt',
    'User' => 'Benutzer',
  ),
   $object_name.'_status_dom' =>
  array (
    'New' => 'Neu',
    'Assigned' => 'Zugewiesen',
    'Closed' => 'Abgeschlossen',
    'Pending Input' => 'Rückmeldung ausstehend',
    'Rejected' => 'Abgelehnt',
    'Duplicate' => 'Duplizieren',
  ),
  $object_name.'_priority_dom' =>
  array (
    'P1' => 'Hoch',
    'P2' => 'Mittel',
    'P3' => 'Niedrig',
  ),
  $object_name.'_resolution_dom' =>
  array (
  	'' => '',
  	'Accepted' => 'Akzeptiert',
    'Duplicate' => 'Duplizieren',
    'Closed' => 'Abgeschlossen',
    'Out of Date' => 'Abgelaufen',
    'Invalid' => 'Ungültig',
  ),
  );
?>