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

 $listViewDefs['module_loader']['packages'] = array(
    'name' => array(
        'width' => '5', 
        'label' => 'LBL_LIST_NAME', 
        'link' => false,
        'default' => true,
        'show' => true), 
    'description' => array(
        'width' => '32', 
        'label' => 'LBL_ML_DESCRIPTION', 
        'default' => true,
        'link' => false,
        'show' => true),
);

$listViewDefs['module_loader']['releases'] = array(
    'description' => array(
        'width' => '32', 
        'label' => 'LBL_LIST_SUBJECT', 
        'default' => true,
        'link' => false),
     'version' => array(
        'width' => '32', 
        'label' => 'LBL_LIST_SUBJECT', 
        'default' => true,
        'link' => false),
);
?>
