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




$GLOBALS['studioDefs']['Users'] = array(
	'LBL_DETAILVIEW'=>array(
        'template'=>'DetailView',
        'meta_file'=>'modules/Users/detailviewdefs.php',
        'type'=>'Detailview',
    ),
	'LBL_EDITVIEW'=>array(
        'template'=>'EditView',
        'meta_file'=>'modules/Users/editviewdefs.php',
        'type'=>'EditView',
    ),
	'LBL_LISTVIEW'=>array(
        'template'=>'listview',
        'meta_file'=>'modules/Users/listviewdefs.php',
        'type'=>'ListView',
    ),
	'LBL_SEARCHFORM'=>array(
        'template'=>'xtpl',
        'template_file'=>'modules/Users/SearchForm.html',
        'php_file'=>'modules/Users/ListView.php',
        'type'=>'SearchForm',
    ),
);
