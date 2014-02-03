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




SUGAR.PdfManager = {};

SUGAR.PdfManager.fieldInserted = false;

/**
 * Change the HelpTip for WYSIWYG
 */
SUGAR.PdfManager.changeHelpTips = function() {
    if ($("#base_module").attr("value") == 'Quotes') {
        $("#body_html_label").find(".inlineHelpTip").click(function() {return SUGAR.util.showHelpTips(this, SUGAR.language.get('PdfManager', 'LBL_BODY_HTML_POPUP_QUOTES_HELP'),'','' )});
    } else {
        $("#body_html_label").find(".inlineHelpTip").click(function() {return SUGAR.util.showHelpTips(this, SUGAR.language.get('PdfManager', 'LBL_BODY_HTML_POPUP_HELP'),'','' )});
    }
}

/**
 * Returns a list of fields for a module
 */
SUGAR.PdfManager.loadFields = function(moduleName, linkName) {

    if (!SUGAR.PdfManager.fieldInserted && $("#field").closest("form").find("input[name=duplicateSave]").size()) {
        SUGAR.PdfManager.fieldInserted = true;
    }
    
    if (SUGAR.PdfManager.fieldInserted && linkName.length == 0) {
        if (!confirm(SUGAR.language.get('PdfManager', 'LBL_ALERT_SWITCH_BASE_MODULE'))) {
            $('#base_module').val($('#base_module_history').val());
            return true;
        }
    }

    if (linkName.length == 0 ) {
        $('#base_module_history').val($('#base_module').val());
        SUGAR.PdfManager.changeHelpTips();
    }

    if (linkName.length > 0 && linkName.indexOf('pdfManagerRelateLink_') == -1) {
        $('#subField').empty();
        $('#subField').hide();
        return true;
    }
    var url = "index.php?" + SUGAR.util.paramsToUrl({
        module : "PdfManager",
        action : "getFields",
        to_pdf : "1",
        sugar_body_only : "true",
        baseModule : moduleName,
        baseLink : linkName
    });

    var resp = http_fetch_sync(url);

    var field = YAHOO.util.Dom.get('field');

    if (field != null) {
        var inputTD = YAHOO.util.Dom.getAncestorByTagName(field, 'TD');
        if (resp.responseText.length > 0 && inputTD != null) {
            inputTD.innerHTML = resp.responseText;
            SUGAR.forms.AssignmentHandler.register('field', 'EditView');
        }
    }
}

/**
 * Push var to WYSIWYG
 */
SUGAR.PdfManager.insertField = function(selField, selSubField) {

    SUGAR.PdfManager.fieldInserted = true;

    var fieldName = "";

    if ( selField && selField.value != "") {
        fieldName += selField.value;

        if ( selSubField && selSubField.value != "") {
            fieldName += "."+selSubField.value;
        }
    }

    var cleanFieldName = fieldName.replace('pdfManagerRelateLink_', '');
	var inst = tinyMCE.getInstanceById("body_html");
	if (fieldName.length > 0 && inst) {
		inst.getWin().focus();
		inst.execCommand('mceInsertRawHTML', false, '{$fields.' + cleanFieldName + '}');
	}
}

YAHOO.util.Event.onContentReady('EditView', SUGAR.PdfManager.changeHelpTips);
