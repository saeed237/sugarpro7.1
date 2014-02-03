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


require_once('include/export_utils.php');

function template_handle_export(&$reporter)
{
    ini_set('zlib.output_compression', 'Off');
$reporter->plain_text_output = true;
//disable paging so we get all results in one pass
$reporter->enable_paging = false;
$reporter->run_query();
$reporter->_load_currency();
$header_arr = array();
$header_row = $reporter->get_header_row();
$content = '';
        foreach ($header_row as $cell)
        {
                array_push($header_arr, $cell);
        }
        $header = implode("\"".getDelimiter() ."\"",array_values($header_arr));
        $header = "\"" .$header;
        $header .= "\"\r\n";
        $content .= $header;

        while (( $row = $reporter->get_next_row('result', 'display_columns', false, true) ) != 0 )
        {
                $new_arr = array();

                for($i=0;$i < count($row['cells']);$i++)
                {
                        array_push($new_arr, preg_replace("/\"/","\"\"", from_html($row['cells'][$i])));
                }

                $line = implode("\"".getDelimiter() ."\"",$new_arr);
                $line = "\"" .$line;
                $line .= "\"\r\n";

                $content .= $line;
        }
global $locale;

$transContent = $GLOBALS['locale']->translateCharset($content, 'UTF-8', $GLOBALS['locale']->getExportCharset());

ob_clean();
header("Pragma: cache");
header("Content-type: application/octet-stream; charset=".$locale->getExportCharset());
header("Content-Disposition: attachment; filename={$_REQUEST['module']}.csv");
header("Content-transfer-encoding: binary");
header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header( "Last-Modified: " . TimeDate::httpTime() );
header( "Cache-Control: post-check=0, pre-check=0", false );
header("Content-Length: ".mb_strlen($transContent, '8bit'));

print $transContent;

}
