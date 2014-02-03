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


require_once('include/MVC/View/views/view.list.php');

class HomeViewList extends ViewList{
 	function ActivitiesViewList(){
 		parent::ViewList();
 		
 	}

 	function display(){
 		global $mod_strings, $export_module, $current_language, $theme, $current_user, $dashletData, $sugar_flavor;
         $this->processMaxPostErrors();
 		include('modules/Home/index.php');
 	}

    function processMaxPostErrors() {
        if($this->checkPostMaxSizeError()){
            $this->errors[] = $GLOBALS['app_strings']['UPLOAD_ERROR_HOME_TEXT'];
            $contentLength = $_SERVER['CONTENT_LENGTH'];

            $maxPostSize = ini_get('post_max_size');
            if (stripos($maxPostSize,"k"))
                $maxPostSize = (int) $maxPostSize * pow(2, 10);
            elseif (stripos($maxPostSize,"m"))
                $maxPostSize = (int) $maxPostSize * pow(2, 20);

            $maxUploadSize = ini_get('upload_max_filesize');
            if (stripos($maxUploadSize,"k"))
                $maxUploadSize = (int) $maxUploadSize * pow(2, 10);
            elseif (stripos($maxUploadSize,"m"))
                $maxUploadSize = (int) $maxUploadSize * pow(2, 20);

            $max_size = min($maxPostSize, $maxUploadSize);
            if ($contentLength > $max_size) {
                $errMessage = string_format($GLOBALS['app_strings']['UPLOAD_MAXIMUM_EXCEEDED'],array($contentLength,  $max_size));
            } else {
                $errMessage =$GLOBALS['app_strings']['UPLOAD_REQUEST_ERROR'];
            }

            $this->errors[] = '* '.$errMessage;
            $this->displayErrors();
        }
    }

}
?>
