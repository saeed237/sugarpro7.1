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
{* && $vardef.type != 'date' && $vardef.type != 'datetimecombo' *}
{if $vardef.type != 'enum' && $vardef.type != 'address'
 && $vardef.type != 'multienum' && $vardef.type != 'radioenum'
 && $vardef.type != 'html' && $vardef.type != 'relate'
 && $vardef.type != 'url' && $vardef.type != 'iframe' && $vardef.type != 'parent'  && $vardef.type != 'image'
 && empty($vardef.function) && (!isset($vardef.studio.calculated) || $vardef.studio.calculated != false)
}

<tr><td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_CALCULATED"}:</td>
    <td style="line-height:1em"><input type="checkbox" name="calculated" id="calculated" value="1" onclick ="ModuleBuilder.toggleCF()"
        {if !empty($vardef.calculated) && !empty($vardef.formula)}CHECKED{/if} {if $hideLevel > 5}disabled{/if}/>
		{if $hideLevel > 5}
            <input type="hidden" name="calculated" value="{$vardef.calculated}">
        {/if}
		{sugar_help text=$mod_strings.LBL_POPHELP_CALCULATED FIXX=250 FIXY=80}
		<input type="hidden" name="enforced" id="enforced" value="{$vardef.enforced}">
    </td>
</tr>
<tr id='formulaRow' {if empty($vardef.formula)}style="display:none"{/if}>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_FORMULA"}:</td>
    <td>
        <input id="formula" type="hidden" name="formula" value="{$vardef.formula}" onchange="document.getElementById('formula_display').value = this.value"/>
        <input id="formula_display" type="text" name="formula_display" value="{$vardef.formula}" readonly="1" style="background-color:#eee"/>
	    <input type="button" class="button"  name="editFormula" style="margin-top: -2px"
		      value="{sugar_translate label="LBL_BTN_EDIT_FORMULA"}"
            onclick="ModuleBuilder.moduleLoadFormula(YAHOO.util.Dom.get('formula').value, 'formula')"/>
    </td>
</tr>
{/if}
{if $vardef.type != 'address'}
<tr id='depCheckboxRow'><td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_DEPENDENT"}:</td>
    <td><input type="checkbox" name="dependent" id="dependent" value="1" onclick ="ModuleBuilder.toggleDF(null, '#popup_form_id .toggleDep')"
        {if !empty($vardef.dependency)}CHECKED{/if} {if $hideLevel > 5}disabled{/if}/>
        {sugar_help text=$mod_strings.LBL_POPHELP_DEPENDENT FIXX=250 FIXY=80}
    </td>
</tr>
<tr id='visFormulaRow' {if empty($vardef.dependency)}style="display:none"{/if}><td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_VISIBLE_IF"}:</td> 
    <td>
        <input id="dependency" type="hidden" name="dependency" value="{$vardef.dependency|escape:'html'}" onchange="document.getElementById('dependency_display').value = this.value"/>
        <input id="dependency_display" type="text" name="dependency_display" value="{$vardef.dependency|escape:'html'}" readonly="1" style="background-color:#eee"/>
          <input class="button" type=button name="editFormula" value="{sugar_translate label="LBL_BTN_EDIT_FORMULA"}" 
            onclick="ModuleBuilder.moduleLoadFormula(YAHOO.util.Dom.get('dependency').value, 'dependency', 'boolean')"/>
    </td>
</tr>

{/if}