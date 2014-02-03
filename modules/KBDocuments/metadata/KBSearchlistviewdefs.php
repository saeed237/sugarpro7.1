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




$listViewDefs['KBSearch'] = array(
    'KBDOCUMENT_NAME' => array(
        'width' => '25', 
        'label' => 'LBL_ARTICLE_TITLE', 
        'link' => true,
        'default' => true,
        'tablename'=>'kbdocuments',
        ),

    'VIEWS_NUMBER' => array(
        'width' => '5', 
        'label' => 'LBL_LIST_VIEWING_FREQUENCY',
        'tablename'=>'kbdocuments',
        'default' => true
        ),   

     'KBDOC_APPROVER_NAME' => array (
        'width' => '10', 
        'label' =>  'LBL_LIST_KBDOC_APPROVER_NAME',
        'default' => true,

        ),

    'ASSIGNED_USER_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_ARTICLE_AUTHOR_LIST',
        'default' => true,
        ),

    'DATE_ENTERED' => array(
        'width' => '10', 
        'label' => 'LBL_DATE_ENTERED',
        'default' => true,
        'tablename'=>'kbdocuments',
        ),  
         

     );
?>
