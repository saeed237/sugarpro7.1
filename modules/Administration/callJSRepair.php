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
    **this is the ajax call that is called from RebuildJSLang.php.  It processes
    **the Request object in order to call correct methods for repairing/rebuilding JSfiles
    *Note that minify.php has already been included as part of index.php, so no need to include again.
    */ 

 
    //set default root directory
    $from = getcwd();
    if(isset($_REQUEST['root_directory'])  && !empty($_REQUEST['root_directory'])){
        $from = $_REQUEST['root_directory'];
    }
    //this script can take a while, change max execution time to 10 mins
    $tmp_time = ini_get('max_execution_time');
    ini_set('max_execution_time','600');
        
        //figure out which commands to call.  
        if($_REQUEST['js_admin_repair'] == 'concat' ){
            //concatenate mode, call the files that will concatenate javascript group files
            $_REQUEST['js_rebuild_concat'] = 'rebuild';
            require_once('jssource/minify.php');
        }else{
            $_REQUEST['root_directory'] = getcwd();
            require_once('jssource/minify.php');
        
            if($_REQUEST['js_admin_repair'] == 'replace'){
                //should replace compressed JS with source js
                $minifyUtils->reverseScripts("$from/jssource/src_files","$from");    
    
            }elseif($_REQUEST['js_admin_repair'] == 'mini'){
                //should replace compressed JS with minified version of source js
                $minifyUtils->reverseScripts("$from/jssource/src_files","$from");
                $minifyUtils->BackUpAndCompressScriptFiles("$from","",false);
                $minifyUtils->ConcatenateFiles("$from");
    
            }elseif($_REQUEST['js_admin_repair'] == 'repair'){
             //should compress existing javascript (including changes done) without overwriting original source files
                $minifyUtils->BackUpAndCompressScriptFiles("$from","",false);
                $minifyUtils->ConcatenateFiles("$from");
            }
        }
    //set execution time back to what it was   
    ini_set('max_execution_time',$tmp_time);

    
 
?>
