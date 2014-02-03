
{*
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

*}
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>{sugar_translate label='LBL_BROWSER_TITLE' module=''}</title>
<link rel="apple-touch-icon" href="{sugar_getimagepath file='sugar_icon.png'}" />
<link href="include/SugarWireless/css/wireless.css" type="text/css" rel="stylesheet">
<link media="only screen and (max-device-width: 480px)" href="include/SugarWireless/css/iphone.css" type= "text/css" rel="stylesheet">
<meta name="viewport" content="user-scalable=no, width=device-width">
<meta name="apple-touch-fullscreen" content="yes" />
</head>
<body>
{sugar_getimage name="company_logo" ext=".png" width="212" height="40" alt=$app_strings.LBL_COMPANY_LOGO other_attributes='border="0" id="companylogo" '}
<hr />
{if $WELCOME}
<div class="sec welcome" align="right">
<small>{sugar_translate label='NTC_WELCOME' module=''}, {$user_name} [<a href="index.php?module=Users&action=Logout">{sugar_translate label='LBL_LOGOUT' module=''}</a>]</small><br />
</div>
{/if}
