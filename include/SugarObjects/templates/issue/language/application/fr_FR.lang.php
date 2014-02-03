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
    $object_name.'_type_dom' => array (
        'Administration' => 'Administration',
        'Product' => 'Produit',
        'User' => 'Utilisateur'
    ),
    $object_name.'_status_dom' => array (
        'New' => 'Nouveau',
        'Assigned' => 'Assigné',
        'Closed' => 'Fermé',
        'Pending Input' => 'En attente',
        'Rejected' => 'Rejeté',
        'Duplicate' => 'Doublon'
    ),
    $object_name.'_priority_dom' => array (
        'P1' => 'Haute',
        'P2' => 'Moyenne',
        'P3' => 'Basse'
    ),
    $object_name.'_resolution_dom' => array (
        '' => '',
        'Accepted' => 'Accepté',
        'Duplicate' => 'Doublon',
        'Closed' => 'Fermé',
        'Out of Date' => 'Périmé',
        'Invalid' => 'Invalide'
    ),
);

?>