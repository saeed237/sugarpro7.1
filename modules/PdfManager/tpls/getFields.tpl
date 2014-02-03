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
{html_options name="field" id="field" selected=$selectedField values=$fieldsForSelectedModule options=$fieldsForSelectedModule onChange="SUGAR.PdfManager.loadFields(YAHOO.util.Dom.get('base_module').value, this.value)"}{if $fieldsForSubModule} {html_options name="subField" id="subField" values=$fieldsForSubModule options=$fieldsForSubModule}{/if} <input type="button" class="button" name="pdfManagerInsertField" id="pdfManagerInsertField" value="{sugar_translate module="PdfManager" label="LBL_BTN_INSERT"}" onclick="SUGAR.PdfManager.insertField(YAHOO.util.Dom.get('field'), YAHOO.util.Dom.get('subField'));" />