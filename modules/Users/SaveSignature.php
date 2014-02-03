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

require_once('modules/UserSignatures/UserSignature.php');
global $current_user;

$us = new UserSignature();
if(isset($_REQUEST['record']) && !empty($_REQUEST['record'])) {
	$us->retrieve($_REQUEST['record']);
} else {
	$us->id = create_guid();
	$us->new_with_id = true;
}

$us->name = $_REQUEST['name'];
$us->signature = strip_tags(br2nl(from_html($_REQUEST['description'])));
$us->signature_html = $_REQUEST['description'];
if(empty($us->user_id) && isset($_REQUEST['the_user_id'])){
	$us->user_id = $_REQUEST['the_user_id'];
}
else{
	$us->user_id = $current_user->id;
}
$us->save();

$js = '
<script type="text/javascript">
function refreshTemplates() {
	window.opener.refresh_signature_list("'.$us->id.'","'.$us->name.'");
	window.close();
}

refreshTemplates();
window.close();
</script>';

echo $js;
