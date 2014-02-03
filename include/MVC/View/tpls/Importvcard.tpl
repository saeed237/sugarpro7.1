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

<b>{$MOD.LBL_IMPORT_VCARDTEXT}</b>
{literal}
<script type="text/javascript" src="cache/include/javascript/sugar_grp_yui_widgets.js"></script>
<script type="text/javascript">
<!--
function validate_vcard()
{
    if (document.getElementById("vcard_file").value=="") {
        YAHOO.SUGAR.MessageBox.show({msg: '{/literal}{$ERROR_TEXT}{literal}'} );
    }
    else
        document.EditView.submit();
}
-->
</script>
{/literal}
<form name="EditView" method="POST" ENCTYPE="multipart/form-data" action="index.php">
<input type="hidden" name="max_file_size" value="30000">
<input type='hidden' name='action' value='ImportVCardSave'>
<input type='hidden' name='module' value='{$MODULE}'>
<input type='hidden' name='from' value='ImportVCard'>

<input size="60" name="vcard" id="vcard_file" type="file" />&nbsp;
<input class='button' type="button" onclick='validate_vcard()' value="{$APP.LBL_IMPORT_VCARD_BUTTON_LABEL}" 
    title="{$APP.LBL_IMPORT_VCARD_BUTTON_TITLE}" />
</form>

