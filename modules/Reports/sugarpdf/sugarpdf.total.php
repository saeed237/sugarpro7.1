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


require_once('modules/Reports/sugarpdf/sugarpdf.reports.php');

class ReportsSugarpdfTotal extends ReportsSugarpdfReports
{
    function display(){
        global $locale;
    
        //Create new page
        $this->AddPage();
        
        $this->bean->clear_results();
        $this->bean->run_total_query();
    
        $total_header_row = $this->bean->get_total_header_row(true);
        $total_row = $this->bean->get_summary_total_row(true);
    
        $item = array();
        $count = 0;
        for($j=0; $j < sizeof($total_header_row); $j++) {
          $label = $total_header_row[$j];
          $value = $total_row['cells'][$j];
          $item[$count][$label] = $value;
        }
        
        $this->writeCellTable($item, $this->options);
    }
}


