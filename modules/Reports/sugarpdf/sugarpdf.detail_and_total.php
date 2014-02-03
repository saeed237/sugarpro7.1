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

class ReportsSugarpdfDetail_and_total extends ReportsSugarpdfReports
{
    function display(){
        global $report_modules, $app_list_strings;
        global $mod_strings, $locale;
        $this->bean->run_query();
        
        //Create new page
        $this->AddPage();
            
        $item = array();
        $header_row = $this->bean->get_header_row('display_columns', false, true, true);
        $count = 0;
    
        while($row = $this->bean->get_next_row('result', 'display_columns', false, true)) {
            for($i= 0 ; $i < sizeof($header_row); $i++) {
                $label = $header_row[$i];
                $value = '';
                if(!empty($row['cells'][$i])) {
                  $value = $row['cells'][$i];
                }
                $item[$count][$label] = $value;
            }
            $count++;
        }
        $this->writeCellTable($item, $this->options);
        $this->Ln1();
        
        $this->bean->clear_results();
        
        $this->bean->run_total_query();
        $total_header_row = $this->bean->get_total_header_row();
    
        $total_row = $this->bean->get_summary_total_row();
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


