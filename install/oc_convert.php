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

require_once('include/utils/disc_client_utils.php');

global $beanList, $beanFiles;

////    errors
$errors = '';
if( isset($validation_errors) ){
    if( count($validation_errors) > 0 ){
        $errors  = '<div id="errorMsgs">';
        $errors .= '<p>'.$mod_strings['LBL_SITECFG_FIX_ERRORS'].'</p><ul>';
        foreach( $validation_errors as $error ){
            $errors .= '<li>' . $error . '</li>';
        }
        $errors .= '</ul></div>';
    }
}

$convert = true;
if(!isset($_SESSION['oc_server_url']) || $_SESSION['oc_server_url'] == 'http://' ||
         !isset($_SESSION['oc_username']) || empty($_SESSION['oc_username']) ||
         !isset($_SESSION['oc_password']) || empty($_SESSION['oc_password'])
  ){
  $convert = false;
}
///////////////////////////////////////////////////////////////////////////////
////    START OUTPUT
$langHeader = get_language_header();
$out =<<<EOQ
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html {$langHeader}>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Script-Type" content="text/javascript">
   <meta http-equiv="Content-Style-Type" content="text/css">
    <title>{$mod_strings['LBL_OC_INSTALL_TITLE']}</title>
   <link rel="stylesheet" href="install/install.css" type="text/css" />
   <script type="text/javascript" src="install/installCommon.js"></script>
</head>
<body>
<form action="install.php" method="post" name="oc_convert" id="form">
<input type="hidden" name="goto" value="oc_convert">
<input type="hidden" name="current_step" value="{$next_step}">
<table cellspacing="0" cellpadding="0" border="0" align="center" class="shell">
      <tr><td colspan="2" id="help">&nbsp;</td></tr>
    <tr>
      <th width="500">
		<p>
		<img src="{$sugar_md}" alt="SugarCRM" border="0">
		</p>{$mod_strings['LBL_OC_INSTALL_TITLE']}</th>

   <th width="200" style="text-align: right;"><a href="http://www.sugarcrm.com" target="_blank">
        <IMG src="include/images/sugarcrm_login.png" alt="SugarCRM" border="0"></a></th>
   </tr>
EOQ;
if($convert){
    $errors = convert_disc_client();
    $converted = true;
    if(!empty($errors)){
$out2 =<<<EOQ2
<tr>
    <td colspan="2">
    <p>{$mod_strings['LBL_OC_INSTALL_DIRECTIONS']}</p>
   <table width="100%" cellpadding="0" cellpadding="0" border="0" class="StyleDottedHr">
   <tr><th colspan="3" align="left">{$mod_strings['LBL_OC_INSTALL_TITLE']}</td></tr>
   <tr><td colspan="3"><div class="required">{$errors}</div></td></tr>
   <tr><td colspan="3"><div class="required">{$mod_strings['LBL_OC_ADMIN']}</div></td></tr>
 </table>
</td>
</tr>
EOQ2;
$out3 = "</table>
</form>
<br>
</body>
</html>";
    }else{
$out2 =<<<EOQ5
<tr>
    <td colspan="2">
    <p>{$mod_strings['LBL_OC_INSTALL_DIRECTIONS']}</p>
   <table width="100%" cellpadding="0" cellpadding="0" border="0" class="StyleDottedHr">
   <tr><th colspan="3" align="left">{$mod_strings['LBL_OC_INSTALL_TITLE']}</td></tr>
   <tr><td colspan="3">{$mod_strings['LBL_OC_SUCCESS']}</td></tr>
 </table>
</td>
</tr>
EOQ5;
$out3 =<<<EOQ3
<tr>
   <td align="right" colspan="2">
   <hr>
   <table cellspacing="0" cellpadding="0" border="0" class="stdTable">
   <tr>
   <td><input class="button" type="button" onclick="window.open('http://www.sugarcrm.com/forums/');" value="{$mod_strings['LBL_HELP']}" /></td>
   <td><input class="button" type="button" onclick="location.href='index.php';" value="{$mod_strings['LBL_NEXT']}" /></td>
   </tr>
   </table>
</td>
</tr>
</table>
</form>
<br>
</body>
</html>
EOQ3;
    }
}else{
$out2 =<<<EOQ2
<tr>
    <td colspan="2">
    <p>{$mod_strings['LBL_OC_INSTAL_DIRECTIONS']}</p>
    {$errors}
   <div class="required">{$mod_strings['LBL_REQUIRED']}</div>
   <table width="100%" cellpadding="0" cellpadding="0" border="0" class="StyleDottedHr">
   <tr><th colspan="3" align="left">{$mod_strings['LBL_OC_INSTALL_TITLE']}</td></tr>
<tr><td><span class="required">*</span></td>
       <td><b>{$mod_strings['LBL_OC_INSTALL_SERVER_URL']}</td>
       <td align="left"><input type="text" name="oc_server_url" id="oc_server_url" value="{$_SESSION['oc_server_url']}" size="40" /></td></tr>
   <tr><td><span class="required">*</span></td>
       <td><b>{$mod_strings['LBL_OC_INSTALL_USERNAME']}</b><br>
            <i>{$mod_strings['LBL_OC_INSTALL_USERNAME_DETAILS']}</i></td>
       <td align="left"><input type="text" name="oc_username" value="{$_SESSION['oc_username']}" size="20" /></td></tr>
       <tr><td><span class="required">*</span></td>
       <td><b>{$mod_strings['LBL_OC_INSTALL_PASS']}</b></td>
       <td align="left"><input type="password" name="oc_password" value="{$_SESSION['oc_password']}" size="20" /></td></tr>

</table>
</td>
</tr>

EOQ2;
$out3 =<<<EOQ3
<tr>
   <td align="right" colspan="2">
   <hr>
   <table cellspacing="0" cellpadding="0" border="0" class="stdTable">
   <tr>
   <td><input class="button" type="button" onclick="window.open('http://www.sugarcrm.com/forums/');" value="{$mod_strings['LBL_HELP']}" /></td>
   <td>
   <input class="button" type="button" name="goto" value="{$mod_strings['LBL_NEXT']}" onclick="document.getElementById('form').submit();" />
        <input type="hidden" name="goto" value="oc_convert" />
        </td>
   </tr>
   </table>
</td>
</tr>
</table>
</form>
<br>
</body>
</html>
EOQ3;
}

echo $out.$out2.$out3;
?>
