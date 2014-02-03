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

/*********************************************************************************

 * Description:  Saves an Account record and then redirects the browser to the
 * defined return URL.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$focus = BeanFactory::getBean('EmailTemplates');
require_once('include/formbase.php');
$focus = populateFromPost('', $focus);

require_once('modules/EmailTemplates/EmailTemplateFormBase.php');
$form = new EmailTemplateFormBase();
sugar_cache_clear('select_array:'.$focus->object_name.'namebase_module=\''.$focus->base_module.'\'name');
if(isset($_REQUEST['inpopupwindow']) and $_REQUEST['inpopupwindow'] == true) {
	$focus=$form->handleSave('',false, false); //do not redirect.
	$body1 = "
		<script type='text/javascript'>
			function refreshTemplates() {
				window.opener.refresh_email_template_list('$focus->id','$focus->name')
				window.close();
			}

			refreshTemplates();
		</script>";
	echo  $body1;
} else {
	$form->handleSave('',true, false);
}
?>