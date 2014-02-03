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
<form name='StudioWizard' id='StudioWizard' enctype='multipart/form-data' method='post' action='index.php?module=ModuleBuilder&action=portalstylesave&to_pdf=1' onsubmit="document.getElementById('uploadLabel').innerHTML=''; document.getElementById('StudioWizard').target = 'upload_target';">
<table>
	<tr>
		<td><input type ='file' name='filename'></td>
		<td><input type ='submit' value='{$mod.LBL_BTN_UPLOAD}' class='button'></td>
    </tr>
</table>
<iframe name="upload_target" id="upload_target" src="" title="" style="width:0;height:0;border:0px solid #fff;">
</iframe>
</form>
<br>
<span id='uploadLabel' class='error'>&nbsp;</span>
<br>
<h3>{$mod.LBL_SP_PREVIEW}</h3>
{literal}
<iframe name="style_preview" id="style_preview" width='90%' height=600 src='index.php?module=ModuleBuilder&action=portalpreview' title='index.php?module=ModuleBuilder&action=portalpreview'>
</iframe>
{/literal}
{literal}
<script>
ModuleBuilder.helpRegister('StudioWizard');
ModuleBuilder.helpSetup('portalStyle','default');
</script>
{/literal}
