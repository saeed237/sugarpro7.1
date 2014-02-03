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

<!DOCTYPE html PUBLIC "-//W3C//DTD html 4.01 Transitional//EN">
<html {$langHeader}>
<head>
<link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">

<title>SugarCRM - Commercial Open Source CRM</title>
{if $useCustomFile}
<style type="text/css">@import url("custom/portal/custom/style.css");</style>
{else}
<style type="text/css">@import url("portal/themes/Sugar/style.css?s=&c=");</style>
{/if}

<link href="portal/themes/Sugar/navigation.css?s=&c=" rel="stylesheet" type="text/css" />


</head>

<body>

<div id='moduleLinks'>
				<ul id="tabRow"><div style="float: right;">
													<a href="javascript:void(0)" id="My AccountHandle">{$mod.LBL_MY_ACCOUNT}</a>
							 | 													<a href="javascript:void(0)" id="LogoutHandle">{$mod.LBL_LOGOUT}</a>

													
					</div>
																<li class=otherTab><a href="javascript:void(0)" class=otherTab>{$mod.LBL_HOME}</a></li>
																<li class=currentTab><a href="javascript:void(0)" class=currentTab>{$mod.LBL_CASES}</a></li>
																<li class=otherTab><a href="javascript:void(0)" class=otherTab>{$mod.LBL_NEWSLETTERS}</a></li>
																<li class=otherTab><a href="javascript:void(0)" class=otherTab>{$mod.LBL_BUG_TRACKER}</a></li>
				</ul>
					

</div>

<div id='shortCuts'>
			<a class='link' href='javascript:void(0)'>{$mod.LBL_CREATE_NEW}</a>
		 | 			<a class='link' href='javascript:void(0)'>{$mod.LBL_LIST}</a>
			</div>
<!-- crmprint --><p><table width='100%' cellpadding='0' cellspacing='0' border='0' class='moduleTitle'><tr><td valign='top'>
<h2>{$mod.LBL_CASES}</h2></td>
</tr></table>
</p><form id="CaseEditView" name="CaseEditView" method="POST" action="index.php" onsubmit='return false'>

<input type="hidden" name="module" value="Cases">
<input type="hidden" name="id" value="">
<input type="hidden" name="action" value="Save">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td>
			<input title="Save" class="button" type="submit" name="button" value="  {$mod.LBL_BTN_SAVE}  " > 
			<input title="Cancel"  class="button" type="submit" name="button" value="  {$mod.LBL_BTN_CANCEL}  ">
		</td>
		<td align="right" nowrap><span class="required"></span> </td>
		<td align='right'></td>

	</tr>
</table>
<table width='100%' border='0' cellspacing='1' cellpadding='0'  class='detail view'>
<tr>
					<td width='12.5%' scope='row'>
							{$mod.LBL_NUMBER} 					</td>
		<td width='37.5%' class='tabDetailViewDF' colspan='4'>
												


									</td>
	</tr>
<tr>

					<td width='12.5%' scope='row'>
							{$mod.LBL_PRIORITY} 					</td>
		<td width='37.5%' class='tabDetailViewDF' colspan='4'>
												
<select name='priority'>
	<option value='P1'>
		{$mod.LBL_HIGH}
	</option>
	<option value='P2'>
		{$mod.LBL_MEDIUM}
	</option>

	<option value='P3'>
		{$mod.LBL_LOW}
	</option>
</select>

									</td>
	</tr>
<tr>
					<td width='12.5%' scope='row'>
							{$mod.LBL_SUBJECT} <span class="required">*</span>					</td>

		<td width='37.5%' class='tabDetailViewDF' colspan='4'>
												
<input type='text' name='name' size='60' value=''>

									</td>
	</tr>
<tr>
					<td width='12.5%' scope='row'>
							{$mod.LBL_DESCRIPTION} 					</td>
		<td width='37.5%' class='tabDetailViewDF' colspan='4'>

												
<textarea name='description' rows='15' cols='100'></textarea>

									</td>
	</tr>
</table>
{literal}
</form><script type="text/javascript">
requiredTxt = 'Missing required field:';
invalidTxt = 'Invalid Value:';
</script><!-- crmprint --><div id='footer'><!--end body panes-->

	<table cellpadding='0' cellspacing='0' width='100%' border='0' class='underFooter'><tr><td align='center' class='copyRight'>{$app.LBL_SUGAR_COPYRIGHT}<br /><A href='http://www.sugarcrm.com' target='_blank'><img style='margin-top: 2px' border='0'  width='120' height='34' src='include/images/poweredby_sugarcrm_65.png' alt=$mod_strings.LBL_POWERED_BY_SUGAR></a>

</td></tr></table></div>
</body></html>
{/literal}