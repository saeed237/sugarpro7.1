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


$connector_strings = array (
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Obtain a Key and Secret from IBM SmartCloud&copy; by registering your Sugar instance as a new application.<br>
&nbsp;<br>
Steps to register your instance:<br>
&nbsp;<br>
<ol>
<li>Log in to your IBM SmartCloud account (you must be an administrator)</li>
<li>Go to Administration -> Manage Organization</li>
<li>Go to the "Integrated Third-Party Apps" link on the sidebar and enable SugarCRM for all users.</li>
<li>Go to "Internal Apps" on the sidebar and "Register App"</li>
<li>Name this app whatever you want (say "SugarCRM Production"), and be sure _NOT_ to check the OAuth 2.x checkbox at the bottom of the pop up window.</li>
<li>After the app has been created, click on the little triangle thing to the right of the app name and select "Show Credentials" from the dropdown menu.</li>
<li>Copy the credentials below.</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'OAuth Consumer Key',
    'oauth_consumer_secret' => 'OAuth Consumer Secret',
);

