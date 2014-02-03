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


/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r53409 - 2010-01-03 19:31:15 -0800 (Sun, 03 Jan 2010) - roger - merge -r50376:HEAD from fuji_newtag_tmp


*/


/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sugar_currency_format} function plugin
 *
 * Type:     function<br>
 * Name:     sugar_currency_format<br>
 * Purpose:  formats a number
 * 
 * @author Wayne Pan {wayne at sugarcrm.com}
 * @param array
 * @param Smarty
 */
function smarty_function_sugar_number_format($params, &$smarty) {
    global $locale;
    
	if(!isset($params['var']) || $params['var'] === '') {  
        return '';
    } 

    if ( !isset($params['precision']) ) {
        $params['precision'] = $locale->getPrecedentPreference('default_currency_significant_digits');
    }

    $_contents = format_number($params['var'], $params['precision'], $params['precision'], $params);

    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $_contents);
    } else {
        return $_contents;
    }
}

?>
