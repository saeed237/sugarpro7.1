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
{literal}
<script type="text/javascript">
</script>
{/literal}
<table id="rollwiz_table">
    <tr>
        <td class="label">Type:</td>
        <td>{html_options name="rmodule" id="rollwiz_type" values=$rollup_types options=$rollup_types selected=$rollupType }</td>
    </tr><tr>
        <td class="label">Module:</td>
        <td>{html_options name="rmodule" id="rollwiz_rmodule" selected=$selLink  values=$rmodules options=$rmodules onChange="SUGAR.expressions.updateRollupWizard(this.value, \$('#rollwiz_type').val())" }</td>
    </tr><tr>
        <td scope="label">Field:</td>
        <td>{html_options name="rfield" id="rollwiz_rfield" values=$rfields options=$rfields onChange="console.log(this)"}</td>
    </tr>
</table>
<div style="width:100%;text-align:right">
    <button class='button' name='selrf_cancelbtn' onclick="SUGAR.rollupWindow.hide()" >
        {sugar_translate module="ModuleBuilder" label="LBL_BTN_CANCEL"}
    </button>
    <button class='button' name='selrf_insertbtn' onclick="SUGAR.expressions.insertRollup()" >
        {sugar_translate module="ModuleBuilder" label="LBL_BTN_INSERT"}
    </button>
</div>