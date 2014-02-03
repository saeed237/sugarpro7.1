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

class TrackerUtility {

/**
 * getSQLHash
 * This method attempts to remove the values between single quotes in a SQL statement
 * in an effort to check if the same SQL (with different values between quotes or numerical values) 
 * has been run. A good portion of this code is similar to the appendN method found 
 * in include/database/FreeTDSManager.php file.
 * 
 * @param $sql SQL statement
 * @return String of SQL statement with unique values removed
 */
static function getGenericSQL($sql) {
	
	//Replace all escaped string sequences
	$sql = str_replace('\\\'', '*', $sql);

    // If there are odd number of single quotes, just return
    if((substr_count($sql, "'") & 1)) {
        return $sql;
    } 
          
    // Remove any remaining '' and do not parse... replace later (hopefully we don't even have any)
    $pairs = array();
    $regexp = '/(\'{2})/';
    preg_match_all($regexp, $sql, $pair_matches);
    if ($pair_matches) {
        foreach (array_unique($pair_matches[0]) as $key=>$value) {
           $pairs['<@PAIR-'.$key.'@>'] = $value;
        }
        if (!empty($pairs)) {
           $sql = str_replace($pairs, array_keys($pairs), $sql);
        }
    }

    $regexp = "/(N?\'.+?\')/is";
    preg_match_all($regexp, $sql, $matches);
    $replace = array();
    if (!empty($matches)) {
        foreach ($matches[0] as $key=>$value) {
                   // We are assuming that all nvarchar columns are no more than 200 characters in length
                   // One problem we face is the image column type in reports which cannot accept nvarchar data
                   if (!empty($value)) {
                       $replace[$value] = "'?'";
                   }
        }
    }
    
    if (!empty($replace)) {
        $sql = str_replace(array_keys($replace), $replace, $sql);
    }
    
    if (!empty($pairs)) {
        $sql = str_replace(array_keys($pairs), $pairs, $sql);
    }    

    if(strpos($sql, '<@#@#@PAIR@#@#@>')) {
       $sql = str_replace(array('<@#@#@PAIR@#@#@>'), array("''"), $sql);
    }

    if(preg_match('/^(INSERT.+?VALUES\s+?\()(.*?)(\).*?)/Ui', $sql, $matches)) {
       if(count($matches) == 4) {
          $sql = $matches[1] . preg_replace('/(\d{1,})/', '?', $matches[2]) . $matches[3];
       }
    }

    //Lastly replace all unquoted parameters with digits only
    $sql = preg_replace('/=\s*?(\d{1,})\s*?/', ' = ? ', $sql);
    
    return $sql;
}	
	
}



?>
