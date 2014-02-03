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
<form name="formEmailSettingsGeneral" id="formEmailSettingsGeneral">
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="view">
	<tr>
		<th colspan="4" align="left" colspan="4" scope="row">
			<h4>{$app_strings.LBL_EMAIL_SETTINGS_TITLE_PREFERENCES}</h4>
		</th>
	</tr>
	<tr>
		<td  scope="row" width="20%">
			{$app_strings.LBL_EMAIL_SETTINGS_CHECK_INTERVAL}:
		</td>
		<td >
			{html_options options=$emailCheckInterval.options selected=$emailCheckInterval.selected name='emailCheckInterval' id='emailCheckInterval'}
		</td>
		<td scope="row" width="20%">
			{$app_strings.LBL_EMAIL_SIGNATURES}:
		</td>
		<td >
			{$signaturesSettings} {$signatureButtons} 
        	<input type="hidden" name="signatureDefault" id="signatureDefault" value="{$signatureDefaultId}">
		</td>
	</tr>
	<tr>
		<td  scope="row">
			{$app_strings.LBL_EMAIL_SETTINGS_SEND_EMAIL_AS}:
		</td>
		<td >
			<input class="checkbox" type="checkbox" id="sendPlainText" name="sendPlainText" value="1" {$sendPlainTextChecked} />
		</td>
		<td NOWRAP scope="row">
		  {$mod_strings.LBL_SIGNATURE_PREPEND}:
		</td>
		<td NOWRAP>
		<input type="checkbox" name="signature_prepend" {$signaturePrepend}>
		</td>
	</tr>
	<tr>
		<td NOWRAP scope="row">
        	{$app_strings.LBL_EMAIL_CHARSET}:
        </td>
		<td NOWRAP>
        	{html_options options=$charset.options selected=$charset.selected name='default_charset' id='default_charset'}
        </td>
		<td NOWRAP scope="row">
        	&nbsp;
        </td>
		<td NOWRAP>
        	&nbsp;
        </td>
	</tr>
</table>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="view">
	<tr>
		<th colspan="4">
			<h4>{$app_strings.LBL_EMAIL_SETTINGS_TITLE_LAYOUT}</h4>
		</th>
	</tr>
	<tr>
		<td NOWRAP scope="row" width="20%">
			{$app_strings.LBL_EMAIL_SETTINGS_SHOW_NUM_IN_LIST}:
			<div id="rollover">
                            <a href="#" class="rollover">{sugar_getimage alt=$mod_strings.LBL_HELP name="helpInline" ext=".gif" other_attributes='border="0" '}<span>{$app_strings.LBL_EMAIL_SETTINGS_REQUIRE_REFRESH}</span></a>
            </div>
		</td>
		<td NOWRAP >
			<select name="showNumInList" id="showNumInList">
			{$showNumInList}
			</select>
		</td>
		<td NOWRAP scope="row" width="20%">&nbsp;</td>
		<td NOWRAP >&nbsp;</td>
	</tr>
</table>

{include file="modules/Emails/templates/emailSettingsFolders.tpl"}


</form>

