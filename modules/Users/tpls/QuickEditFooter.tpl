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

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
    <tr>
        <td>
        <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accesskey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="quickEditSave(); return false;" type="submit" name="Users_dcmenu_save_button" id="Users_dcmenu_save_button" value="Save">
        {{foreach from=$form.buttons key=val item=button}}
           {{sugar_button module="$module" id="$button" view="$view"}}
        {{/foreach}}
        </td>
        <td align="right" nowrap>
            <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span> {$APP.NTC_REQUIRED}
        </td>
    </tr>
</table>
<script type='text/javascript'>
{literal}

function quickEditSave()
{
    document.form_DCQuickCreate_Users.action.value='Save';

    if(check_form('form_DCQuickCreate_Users'))
    {
        if(quickEditconfirmReassignRecords())
        {
        DCMenu.save(document.form_DCQuickCreate_Users.id, 'Users_subpanel_save_button');
        }
    }
}

function quickEditconfirmReassignRecords() {
        var status = document.getElementsByName('status');
        if(status[0] && status[0].value == 'Inactive')
        {
            var r = confirm(SUGAR.language.get('Users','LBL_REASS_CONFIRM_REASSIGN'));
            if(r == true)
            {
                document.form_DCQuickCreate_Users.return_action.value = 'reassignUserRecords';
                document.form_DCQuickCreate_Users.return_module.value = 'Users';
                document.form_DCQuickCreate_Users.submit();
                return false;
            }
        }
        return true;
}
{/literal}
</script>