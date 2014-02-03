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




$expect_versions = array();

//$expect_versions['Custom Labels'] = array('name'=>'Custom Labels', 'db_version' =>'3.0', 'file_version'=>'3.0');
$expect_versions['Chart Data Cache'] = array('name'=>'Chart Data Cache', 'db_version' =>'3.5.1', 'file_version'=>'3.5.1');
$expect_versions['htaccess'] = array('name'=>'htaccess', 'db_version' =>'3.5.1', 'file_version'=>'3.5.1');
//$expect_versions['DST Fix'] = array('name'=>'DST Fix', 'db_version' =>'3.5.1b', 'file_version'=>'3.5.1b');
$expect_versions['Rebuild Relationships'] = array('name'=>'Rebuild Relationships', 'db_version' =>'4.0.0', 'file_version'=>'4.0.0');
$expect_versions['Rebuild Extensions'] = array('name'=>'Rebuild Extensions', 'db_version' =>'4.0.0', 'file_version'=>'4.0.0');
//$expect_versions['Studio Files'] = array('name'=>'Studio Files', 'db_version' =>'4.5.0', 'file_version'=>'4.5.0');
?>