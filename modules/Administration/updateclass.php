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


require("include/modules.php");
require_once("include/utils/sugar_file_utils.php");

foreach ($beanFiles as $classname => $filename){
	if (file_exists($filename)){
		// Rename the class and its constructor adding SugarCore at the beginning  (Ex: class SugarCoreCall)
		$handle = file_get_contents($filename);
        $patterns = array ('/class '.$classname.'/','/function '.$classname.'/');
        $replace = array ('class SugarCore'.$classname,'function SugarCore'.$classname);
		$data = preg_replace($patterns,$replace, $handle);
		sugar_file_put_contents($filename,$data);

		// Rename the SugarBean file into SugarCore.SugarBean (Ex: SugarCore.Call.php)
		$pos=strrpos($filename,"/");
		$newfilename=substr_replace($filename, 'SugarCore.', $pos+1, 0);
		sugar_rename($filename,$newfilename);

		//Create a new SugarBean that extends CoreBean
		$fileHandle = sugar_fopen($filename, 'w') ;
$newclass = <<<FABRICE
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

if(!class_exists('$classname')){
    if (file_exists('custom/$filename')) {
	    require('custom/$filename');
	} else {
	    require('$newfilename');
	    class $classname extends SugarCore$classname{}
	}
}
?>
FABRICE;
		fwrite($fileHandle, $newclass);
		fclose($fileHandle);
	}
}
?>