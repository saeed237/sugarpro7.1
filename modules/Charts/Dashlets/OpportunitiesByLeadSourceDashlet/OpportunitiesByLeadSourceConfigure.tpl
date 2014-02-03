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


<div style='width: 400px'>
<form name='configure_{$id}' action="index.php" method="post" onSubmit='return SUGAR.dashlets.postForm("configure_{$id}", SUGAR.mySugar.uncoverPage);' />
<input type='hidden' name='id' value='{$id}' />
<input type='hidden' name='module' value='{$module}' />
<input type='hidden' name='action' value='DynamicAction' />
<input type='hidden' name='DynamicAction' value='configureDashlet' />
<input type='hidden' name='to_pdf' value='true' />
<input type='hidden' name='configure' value='true' />
<input type='hidden' id='dashletType' name='dashletType' value='{$dashletType}' />

<table width="400" cellpadding="10" cellspacing="0" border="0" class="edit view" align="center">
<tr>
    <td valign='top' nowrap class='dataLabel'>{$LBL_LEAD_SOURCES}</td>
    <td valign='top' class='dataField'>
    	<select name="pbls_lead_sources[]" multiple size='3'>
    		{$selected_datax}
    	</select>
    </td>
</tr>
<tr>
    <td valign='top' nowrap class='dataLabel'>{$LBL_USERS}</td>
	<td valign='top' class='dataField'>
		<select name="pbls_ids[]" multiple size='3'>
			{$pbls_ids}
		</select>
	</td>
</tr>

<tr>
    <td align="right" colspan="2">
        <input type='submit' onclick="" class='button' value='{$LBL_SUBMIT_BUTTON_LABEL}'>
   	</td>
</tr>
</table>
</form>
</div>