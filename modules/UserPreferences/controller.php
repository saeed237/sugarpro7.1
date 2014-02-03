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


class UserPreferencesController extends SugarController
{
	function action_save_rich_text_preferences() {
        $this->view = 'ajax';
        global $current_user;
        if(!empty($current_user)) {
           $height = isset($_REQUEST['height']) ? $_REQUEST['height'] : '325px';
           $width =  isset($_REQUEST['width']) ? $_REQUEST['width'] : '95%';
           $current_user->setPreference('text_editor_height', $height);
           $current_user->setPreference('text_editor_width', $width);
           $current_user->savePreferencesToDB();
		   $json = getJSONobj();
		   $retArray = array();
		   $retArray['height'] = $height;
		   $retArray['width'] = $width;
		   echo 'result = ' . $json->encode($retArray);           
        }
	}
	
}
?>