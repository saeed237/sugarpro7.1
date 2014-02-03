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
  'LBL_ID' => 'Twitter Username',
  'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Obtain a Consumer Key and Secret from Twitter&#169; by registering your Sugar instance as a new application.<br/><br>Steps to register your instance:<br/><br/><ol><li>Go to the Twitter&#169; Developers site: <a href=&#39;http://dev.twitter.com/apps/new&#39; target=&#39;_blank&#39;>http://dev.twitter.com/apps/new</a>.</li><li>Sign In using the Twitter account under which you would like to register the application.</li><li>Within the registration form, enter a name for the application. This is the name users will see when they authenticate their Twitter accounts from within Sugar.</li><li>Enter a Description.</li><li>Enter an Application Website URL (could be anything).</li><li>Select "Browser" for Application Type.</li><li>After selecting "Browser" for Application Type, enter a Callback URL (could be anything since Sugar bypasses this on authentication. Example: Enter your Sugar root URL).</li><li>Enter the security words.</li><li>Click "Register application".</li><li>Accept the Twitter API Terms of Service.</li><li>Within the application page, find the Consumer Key and Consumer Secret. Enter the Key and Secret below.</li></ol></td></tr></table>',
  'LBL_NAME' => 'Twitter Username',
  'company_url' => 'URL',
  'oauth_consumer_key' => 'Consumer Key',
  'oauth_consumer_secret' => 'Consumer Secret',
);

