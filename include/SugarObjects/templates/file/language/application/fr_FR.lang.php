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


 
$app_list_strings = array (
    strtolower($object_name).'_category_dom' =>
    array (
    '' => '',
    'Marketing' => 'Marketing',
    'Knowledege Base' => 'Base de Connaissances',
    'Sales' => 'ventes',
  ),

    strtolower($object_name).'_subcategory_dom' =>
    array (
    '' => '',
    'Marketing Collateral' => 'Marketing Secondaire',
    'Product Brochures' => 'Brochures Produits',
    'FAQ' => 'FAQ',
  ),

    strtolower($object_name).'_status_dom' =>
    array (
        'Active' => 'Actif',
        'Draft' => 'Brouillon',
        'FAQ' => 'FAQ',
        'Expired' => 'Périmé',
        'Under Review' => 'En cours de révision',
        'Pending' => 'En attente'
  ),
);
?>
