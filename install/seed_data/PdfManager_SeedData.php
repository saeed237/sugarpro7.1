<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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


require_once 'include/Sugarpdf/sugarpdf_config.php';
global $mod_strings, $installer_mod_strings;

include_once('modules/PdfManager/PdfManagerHelper.php');
$templatesArray = PdfManagerHelper::getPublishedTemplatesForModule('Quotes');

if (empty($templatesArray)) {

    $modStringSrc = return_module_language($GLOBALS['current_language'], 'PdfManager');
    
    $logoUrl = './themes/default/images/pdf_logo.jpg';
    if (defined('PDF_HEADER_LOGO')) {
        $logoUrl = K_PATH_CUSTOM_IMAGES.PDF_HEADER_LOGO;
        $imsize = @getimagesize($logoUrl);
        if ($imsize === FALSE) {
            // encode spaces on filename
            $logoUrl = str_replace(' ', '%20', $logoUrl);
            $imsize = @getimagesize($logoUrl);
            if ($imsize === FALSE) {
                    $logoUrl = K_PATH_IMAGES.PDF_HEADER_LOGO;
            }
        }
            $logoUrl = './' . $logoUrl;
    }

    $ss = new Sugar_Smarty();
    $ss->assign('logoUrl', $logoUrl);
    $ss->assign('MOD', $modStringSrc);
    $pdfTemplate = new PdfManager();
    $pdfTemplate->base_module = 'Quotes';
    $pdfTemplate->name = $modStringSrc['LBL_TPL_QUOTE_NAME'];
    $pdfTemplate->description = $modStringSrc['LBL_TPL_QUOTE_DESCRIPTION'];
    $pdfTemplate->body_html = to_html($ss->fetch('modules/PdfManager/tpls/templateQuote.tpl'));
    $pdfTemplate->template_name = $modStringSrc['LBL_TPL_QUOTE_TEMPLATE_NAME'];;
    $pdfTemplate->author = PDF_AUTHOR;
    $pdfTemplate->title = PDF_TITLE;
    $pdfTemplate->subject = PDF_SUBJECT;
    $pdfTemplate->keywords = PDF_KEYWORDS;
    $pdfTemplate->published = 'yes';
    $pdfTemplate->deleted = 0;
    $pdfTemplate->team_id = 1;
    $pdfTemplate->save();

    $pdfTemplate = new PdfManager();
    $pdfTemplate->base_module = 'Quotes';
    $pdfTemplate->name = $modStringSrc['LBL_TPL_INVOICE_NAME'];
    $pdfTemplate->description = $modStringSrc['LBL_TPL_INVOICE_DESCRIPTION'];
    $pdfTemplate->body_html = to_html($ss->fetch('modules/PdfManager/tpls/templateInvoice.tpl'));
    $pdfTemplate->template_name = $modStringSrc['LBL_TPL_INVOICE_TEMPLATE_NAME'];;
    $pdfTemplate->author = PDF_AUTHOR;
    $pdfTemplate->title = PDF_TITLE;
    $pdfTemplate->subject = PDF_SUBJECT;
    $pdfTemplate->keywords = PDF_KEYWORDS;
    $pdfTemplate->published = 'yes';
    $pdfTemplate->deleted = 0;
    $pdfTemplate->team_id = 1;
    $pdfTemplate->save();
}

