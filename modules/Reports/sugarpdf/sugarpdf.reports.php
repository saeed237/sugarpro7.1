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



require_once('include/Sugarpdf/Sugarpdf.php');

class ReportsSugarpdfReports extends Sugarpdf
{
    /**
     * Options array for the writeCellTable method of reports.
     * @var Array
     */
    protected $options = array(
        "evencolor"=>"#DCDCDC",
        "header"=>array("fill"=>"#4B4B4B", "fontStyle"=>"B", "textColor"=>"#FFFFFF"),
    );
    
    function preDisplay(){
        global $app_list_strings, $locale, $timedate;
        
        parent::preDisplay();
        
        //Set landscape orientation
        $this->setPageFormat(PDF_PAGE_FORMAT, "L");
        
        $this->SetFont(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN);
        
        //Set PDF document properties
   		if($this->bean->name == "untitled") {
            $this->SetHeaderData(PDF_SMALL_HEADER_LOGO, PDF_SMALL_HEADER_LOGO_WIDTH, $app_list_strings['moduleList'][$this->bean->module], $timedate->getNow(true));
        } else {
            $this->SetHeaderData(PDF_SMALL_HEADER_LOGO, PDF_SMALL_HEADER_LOGO_WIDTH, $this->bean->name, $timedate->getNow(true));
        }
        $cols = count($this->bean->report_def['display_columns']);
    }
}


