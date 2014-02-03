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




global $sugar_config, $mod_strings;

$search_dir=sugar_cached('');

$src_file = $search_dir . 'modules/unified_search_modules.php';
if(file_exists($src_file)) {
    print( $mod_strings['LBL_CLEAR_UNIFIED_SEARCH_CACHE_DELETING1'] . "<br>" );
    print( $mod_strings['LBL_CLEAR_UNIFIED_SEARCH_CACHE_DELETING2'] . " $src_file<BR>" ) ;
    unlink( "$src_file" );
}

echo "\n--- " . $mod_strings['LBL_DONE'] . "---<br />\n";
?>