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


<form action="index.php" method="post" name="DetailView" id="form">

			<input type="hidden" name="module" value="ACLRoles">
			<input type="hidden" name="user_id" value="">
			<input type="hidden" name="record" value="{$ROLE.id}">
			<input type="hidden" name="isDuplicate" value=''>
			<input type='hidden' name='return_record' value='{$RETURN.record}'>
			<input type='hidden' name='return_action' value='{$RETURN.action}'>
			<input type='hidden' name='return_module' value='{$RETURN.module}'>
			<input type="hidden" name="action">

{php}
    $APP = $this->get_template_vars('APP');
    $this->append('buttons',
    <<<EOD
    <input title="{$APP['LBL_EDIT_BUTTON_TITLE']}" accessKey="{$APP['LBL_EDIT_BUTTON_KEY']}" class="button" onclick="var _form = $('#form')[0]; _form.action.value='EditView'; _form.submit();" type="submit" name="button" value="{$APP['LBL_EDIT_BUTTON']}" />
EOD
    );
    $this->append('buttons',
    <<<EOD
    <input title="{$APP['LBL_DUPLICATE_BUTTON_TITLE']}" accessKey="{$APP['LBL_DUPLICATE_BUTTON_KEY']}" class="button" onclick="this.form.isDuplicate.value='1'; this.form.action.value='EditView'" type="submit" name="button" value=" {$APP['LBL_DUPLICATE_BUTTON']} " />
EOD
    );
    $this->append('buttons',
    <<<EOD
    <input title="{$APP['LBL_DELETE_BUTTON_TITLE']}" accessKey="{$APP['LBL_DELETE_BUTTON_KEY']}" class="button" onclick="this.form.return_module.value='ACLRoles'; this.form.return_action.value='index'; this.form.action.value='Delete'; return confirm('{$APP['NTC_DELETE_CONFIRMATION']}')" type="submit" name="button" value=" {$APP['LBL_DELETE_BUTTON']} " />
EOD
    );
{/php}
            {sugar_action_menu id="userEditActions" class="clickMenu fancymenu" buttons="$buttons"}
		</form>
		</p>
		<p>
		<TABLE width='100%' class='detail view' border='0' cellpadding=0 cellspacing = 1  >
		<TR>
<td valign='top' width='15%' align='right'><b>{$MOD.LBL_NAME}:</b></td><td width='85%' colspan='3'>{$ROLE.name}</td>
</tr
><TR>
<td valign='top'  width='15%' align='right'><b>{$MOD.LBL_DESCRIPTION}:</b></td><td colspan='3' valign='top'  width='85%' align='left'>{$ROLE.description | nl2br}</td>
</tr></table>
</p>
		<p>

{include file="modules/ACLRoles/EditViewBody.tpl" }