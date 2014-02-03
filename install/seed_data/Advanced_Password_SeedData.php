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

require('config.php');
global $sugar_config;
global $timedate;
global $mod_strings;
require_once('modules/Teams/Team.php');
$Team = new Team();
$Team_id = $Team->retrieve_team_id('Administrator');

//Sent when the admin generate a new password
$EmailTemp = new EmailTemplate();
$EmailTemp->name = $mod_strings['advanced_password_new_account_email']['name'];
$EmailTemp->description = $mod_strings['advanced_password_new_account_email']['description'];
$EmailTemp->subject = $mod_strings['advanced_password_new_account_email']['subject'];
$EmailTemp->body = $mod_strings['advanced_password_new_account_email']['txt_body'];
$EmailTemp->body_html = $mod_strings['advanced_password_new_account_email']['body'];
$EmailTemp->deleted = 0;
$EmailTemp->team_id = $Team_id;
$EmailTemp->published = 'off';
$EmailTemp->text_only = 0;
$id =$EmailTemp->save();
$sugar_config['passwordsetting']['generatepasswordtmpl'] = $id;

//User generate a link to set a new password
$EmailTemp = new EmailTemplate();
$EmailTemp->name = $mod_strings['advanced_password_forgot_password_email']['name'];
$EmailTemp->description = $mod_strings['advanced_password_forgot_password_email']['description'];
$EmailTemp->subject = $mod_strings['advanced_password_forgot_password_email']['subject'];
$EmailTemp->body = $mod_strings['advanced_password_forgot_password_email']['txt_body'];
$EmailTemp->body_html = $mod_strings['advanced_password_forgot_password_email']['body'];
$EmailTemp->deleted = 0;
$EmailTemp->team_id = $Team_id;
$EmailTemp->published = 'off';
$EmailTemp->text_only = 0;
$id =$EmailTemp->save();
$sugar_config['passwordsetting']['lostpasswordtmpl'] = $id;

// set all other default settings
$sugar_config['passwordsetting']['forgotpasswordON'] = true;
$sugar_config['passwordsetting']['SystemGeneratedPasswordON'] = true;
$sugar_config['passwordsetting']['systexpirationtime'] = 7;
$sugar_config['passwordsetting']['systexpiration'] = 1;
$sugar_config['passwordsetting']['linkexpiration'] = true;
$sugar_config['passwordsetting']['linkexpirationtime'] = 24;
$sugar_config['passwordsetting']['linkexpirationtype'] = 60;
$sugar_config['passwordsetting']['minpwdlength'] = 6;
$sugar_config['passwordsetting']['oneupper'] = true;
$sugar_config['passwordsetting']['onelower'] = true;
$sugar_config['passwordsetting']['onenumber'] = true;

write_array_to_file( "sugar_config", $sugar_config, "config.php");