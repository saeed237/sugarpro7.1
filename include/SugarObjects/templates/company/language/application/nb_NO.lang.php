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
    'Partner' => 'Partner',
    'Prospect' => 'Prospect',
    '' => '',
    'Integrator' => 'Integrator',
    'Investor' => 'Investor',
    'Analyst' => 'Analytiker',
    'Competitor' => 'Konkurrent',
    'Customer' => 'Kunde',
    'Press' => 'Presse',
    'Reseller' => 'Distributør',
    'Other' => 'Annen',
  ),
);

