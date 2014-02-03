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


require_once('include/Sugarpdf/SugarpdfFactory.php');
require_once('modules/Reports/Report.php');


function preprocess($type = NULL, $reporter){
    $pdf = SugarpdfFactory::loadSugarpdf($type, "Reports", $reporter, array());
    return $pdf;
}

function process($pdf, $reportname, $stream){
    global $current_user;

    $pdf->process();
    @ob_clean();
    $filenamestamp = '';
    if(isset($current_user)){
        $filenamestamp .= '_'.$current_user->user_name;
    }
    $filenamestamp .= '_'.date(translate('LBL_PDF_TIMESTAMP', 'Reports'), time());
    $cr = array(' ',"\r", "\n","/");
    $filename = str_replace($cr, '_', $reportname.$filenamestamp.'.pdf');
    if(isset($_SERVER['HTTP_USER_AGENT']) && preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT'])) {
        $filename = urlencode($filename);
    }
    if($stream){
        //Force download as a file
        $pdf->Output($filename,'D');
    }else{
        $cachefile = sugar_cached('pdf/').$filename;
        $fp = sugar_fopen($cachefile, 'w');
        fwrite($fp, $pdf->Output('','S'));
        fclose($fp);

        return $cachefile;
    }
    return $filename;
}


/**
 * @return stream or string
 */
function template_handle_pdf(&$reporter, $stream = true) {
    $reporter->enable_paging = false;
    $reporter->plain_text_output = true;

    if($reporter->report_type == 'summary' && !empty($reporter->report_def['summary_columns'])) {
        if($reporter->show_columns
            && !empty($reporter->report_def['display_columns'])
            && !empty($reporter->report_def['group_defs'])) {
            $type = "summary_combo";
        } elseif($reporter->show_columns
            && !empty($reporter->report_def['display_columns'])
            && empty($reporter->report_def['group_defs'])) {
            $type = "detail_and_total";
        } elseif(!empty($reporter->report_def['group_defs'])) {
            $type = "summary";
        } else {
            $type = "total";
        }
    } elseif(!empty($reporter->report_def['display_columns'])) {
        $type = "listview";
    }

    $pdf=preprocess($type, $reporter);
    return process($pdf, $reporter->name, $stream);
}