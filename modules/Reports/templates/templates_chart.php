<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
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


/*

This code has been moved into include/SugarCharts/ChartDisplay.php as a class so that it can be:
1. unittested
2. more reusable
3. cleaner!

$do_thousands = false;

function template_chart(& $reporter, $chart_display_style, $is_dashlet = false, $id = '') {
    $group_key = (isset($reporter->report_def['group_defs'][0]['table_key']) ? $reporter->report_def['group_defs'][0]['table_key'] : '') .
    ':' .
    (isset($reporter->report_def['group_defs'][0]['name']) ?  $reporter->report_def['group_defs'][0]['name'] : '');

    if (!empty ($reporter->report_def['group_defs'][0]['qualifier'])) {
        $group_key .= ':' . $reporter->report_def['group_defs'][0]['qualifier'];
    }
    $i = 0;
    foreach ($reporter->chart_header_row as $header_cell) {
     	if($header_cell['column_key'] == 'count') {
          $header_cell['column_key'] = 'self:count';
        }
        if ($header_cell['column_key'] == $reporter->report_def['numerical_chart_column']) {
            $reporter->chart_numerical_position = $i;
        }
        if ($header_cell['column_key'] == $group_key) {
            $reporter->chart_group_position = $i;
        }
        $i++;
    }
    print '</P>';
    if (!$is_dashlet){
	    print "<span class='chartFootnote'>" . $reporter->chart_description . "</span>";
    }
    draw_chart($reporter, $reporter->chart_type, $is_dashlet, $id, $chart_display_style);
    print '<br/>';

}

function print_currency_symbol($report_defs) {
    static $currency = null;

    $currency_symbol = '';
    if (isset($report_defs['numerical_chart_column_type']) && $report_defs['numerical_chart_column_type'] == 'currency'){
    	global $current_user;
	    $currency = BeanFactory::getBean('Currencies');
	    if ($current_user->getPreference('currency'))
	        $currency->retrieve($current_user->getPreference('currency'));
	    else
	        $currency->retrieve('-99');

	    $currency_symbol = $currency->symbol;
    }
    else if (!isset($report_defs['numerical_chart_column_type'])){
        return '';
    }

    return $currency_symbol;
}

function get_row_remap(& $row, & $reporter) {
    $row_remap = array ();
    $row_remap['numerical_value'] = $numerical_value = unformat_number(strip_tags($row['cells'][$reporter->chart_numerical_position]['val']));
    global $do_thousands;
    if ($do_thousands) {
        // MRF - Bug # 13501, 47148 - added floor() below:
        $row_remap['numerical_value'] = round(unformat_number(floor($row_remap['numerical_value'])) / 1000);
    }
    $row_remap['group_text'] = $group_text = (isset($reporter->chart_group_position) && !is_array($reporter->chart_group_position)) ? chop($row['cells'][$reporter->chart_group_position]['val']) : '';
    $row_remap['group_key'] = ((isset($reporter->chart_group_position) && !is_array($reporter->chart_group_position)) ? $row['cells'][$reporter->chart_group_position]['key'] : '');
    $row_remap['count'] = isset($row['count'])?$row['count']:'';
    $row_remap['group_label'] = ((isset($reporter->chart_group_position) && !is_array($reporter->chart_group_position)) ? $reporter->chart_header_row[$reporter->chart_group_position]['label'] : '');
    $row_remap['numerical_label'] = $reporter->chart_header_row[$reporter->chart_numerical_position]['label'];
    $row_remap['numerical_key'] = $reporter->chart_header_row[$reporter->chart_numerical_position]['column_key'];
    $row_remap['module'] = $reporter->module;
    if(count($reporter->report_def['group_defs']) > 1) { // multiple group by, use second group by as legend
        $second_group_by_key = $reporter->report_def['group_defs'][1]['table_key'] . ':' . $reporter->report_def['group_defs'][1]['name'];
        foreach($row['cells'] as $cell) {
            if($cell['key'] == $second_group_by_key) {
                $row_remap['group_base_text'] = $cell['val'];
            }
        }
    }
    else { // single group by
        $row_remap['group_base_text'] = $row['cells'][0]['val'];
    }

    //jclark - bug 47329 - report charts show html link text
    $row_remap['group_text'] = strip_tags($row_remap['group_text']);
    $row_remap['group_base_text'] = strip_tags($row_remap['group_base_text']);
    //end jclark fix

    // Bug #54294: We should add currency symbol to row_remap
    $row_remap['numerical_is_currency'] = false;
    if (!empty($row['cells'][$reporter->chart_numerical_position]['key']))
    {
        $fieldKey = $row['cells'][$reporter->chart_numerical_position]['key'];

        if (!empty($reporter->all_fields[$fieldKey]))
        {
            $fieldDef = $reporter->all_fields[$fieldKey];
            if ($fieldDef['type'] == 'currency')
            {
                $row_remap['numerical_is_currency'] = true;
            }
        }
    }

    return $row_remap;

}

function get_total(& $reporter, & $total_row) {
    $total_index = 0;
    if (!empty ($reporter->chart_total_header_row)) {
        for ($i = 0; $i < count($reporter->chart_total_header_row); $i++) {
            if ($reporter->chart_total_header_row[$i]['column_key'] == $reporter->report_def['numerical_chart_column']) {
                $total_index = $i;
                break;
            }
        }
    } else {
		$total_index = 0; // special for dashlets!!
    }
    $total = $total_row['cells'][$total_index]['val'];
    global $do_thousands;
    if (get_maximum($reporter) > 100000 && (!isset($reporter->report_def['do_round'])
    	|| (isset($reporter->report_def['do_round'])  && $reporter->report_def['do_round'] == 1))) {
        $do_thousands = true;
        $total = round(unformat_number($total) / 1000);
        return $total;
    } else {
        $do_thousands = false;
        return unformat_number($total);
    }

}

function get_k() {
    global $do_thousands, $app_strings;
    if ($do_thousands) {
        return $app_strings['LBL_THOUSANDS_SYMBOL'];
    } else {
        return '';
    }
}
function get_maximum(& $reporter) {
    $numbers = array ();
    foreach ($reporter->chart_rows as $row) {
        $row_remap = get_row_remap($row, $reporter);
        array_push($numbers, $row_remap['numerical_value']);
    }
    return get_max_from_numbers($numbers);
}

function get_max_from_numbers($numbers) {
    if (!empty ($numbers)) {
        $max = max($numbers);
        if ($max < 1)
            return $max;
        $base = pow(10, floor(log10($max)));
        return ceil($max / $base) * $base;
    } else {
        return 0;
    }
}

function draw_chart(& $reporter, $chart_type, $is_dashlet=false, $id='', $reportChartDivStyle){
	$total = "";
	if(isset($reporter->report_def['layout_options'])) {
    	// This is for matrix report
		$reporter->run_total_query();
		// start template_total_table code
		$total_row = $reporter->get_summary_total_row();
        for ($i = 0; $i < count($reporter->chart_header_row); $i++) {
        	if ($reporter->chart_header_row[$i]['column_key'] == 'count') {
        		$reporter->chart_header_row[$i]['column_key'] = 'self:count';
        	} // if
            if ($reporter->chart_header_row[$i]['column_key'] == $reporter->report_def['numerical_chart_column']) {
                $total = $i;
                //break;
            }
        	if ($reporter->chart_header_row[$i]['column_key'] == 'self:count') {
        		$reporter->chart_header_row[$i]['column_key'] = 'count';
        	} // if
        } // for
        if (empty($total)) {
        	$total = 0;
        }
    	$total = $total_row['cells'][$total];
	    global $do_thousands;
	    if (unformat_number($total) > 100000) {
	        $do_thousands = true;
	        $total = round(unformat_number($total) / 1000);
	    } else {
	        $do_thousands = false;
	        $total = unformat_number($total);
	    }
	    array_pop($reporter->chart_rows);
	} else {
	    $total_row = array_pop($reporter->chart_rows);
	    $total = get_total($reporter, $total_row);
	}

    $symbol = print_currency_symbol($reporter->report_def);
    global $current_language, $do_thousands;

    $mod_strings = return_module_language($current_language, 'Reports');

    $chartTitle = $mod_strings['LBL_TOTAL_IS'] . ' ' . $symbol . format_number($total, 0, 0) . get_k();

    $chart_rows = array();
    $chart_totals = array();
    $chart_groupings = array();
    foreach ($reporter->chart_rows as $row) {
        $row_remap = get_row_remap($row, $reporter);
        $chart_groupings[$row_remap['group_base_text']] = true; // store all the groupings
        if(empty($chart_rows[$row_remap['group_text']][$row_remap['group_base_text']])) {
            $chart_rows[$row_remap['group_text']][$row_remap['group_base_text']] = $row_remap;
        }
        else {
            $chart_rows[$row_remap['group_text']][$row_remap['group_base_text']]['numerical_value'] += $row_remap['numerical_value'];
        }
    }
    $drawChart = true;
    $stack = false;

    foreach($chart_rows as $element){
    	if (count($element) > 1){
    		$stack = true;
			break;
    	}
    }
	switch ($chart_type){
		case 'hBarF':
			if ($stack){
				$chartType = 'horizontal group by chart';
			}
			else{
				$chartType = 'horizontal bar chart';
			}
			break;
    	case 'vBarF':
			if ($stack){
				$chartType = 'stacked group by chart';
			}
			else{
				$chartType = 'bar chart';
			}
    		break;
    	case 'pieF':
			$chartType = 'pie chart';
    		break;
    	case 'lineF':
			if ($stack){
				$chartType = 'line chart';
			}
			else{
				$drawChart = false;
			}
    		break;
    	case 'funnelF':
			$chartType = 'funnel chart 3D';
    		break;
    	default:
    		break;
	}

	if ($is_dashlet){
		$height = '480';
		$width = '100%';
		$guid = $id;
	}
	else{
		$width = '100%';
		$height = '480';
		$guid = $reporter->saved_report_id;
	}

	if ($drawChart){
		require_once('include/SugarCharts/SugarChartFactory.php');

		$sugarChart = SugarChartFactory::getInstance('','Reports');


		$sugarChart->setData($chart_rows);

        $sugarChart->setProperties($chartTitle, '', $chartType, 'on', 'value', 'on', $do_thousands);

		$xmlFile = get_cache_file_name($reporter);

		$sugarChart->saveXMLFile($xmlFile, $sugarChart->generateXML());
		echo $sugarChart->display($guid, $xmlFile, $width, $height, $reportChartDivStyle);
	}
	else{
		echo '<h3>' . $mod_strings['LBL_NO_CHART_DRAWN_MESSAGE'] . '</h3>';
	}
}

function get_cache_file_name($reporter) {
    global $current_user, $sugar_config;

    $xml_cache_dir = sugar_cached("xml/");
    if ($reporter->is_saved_report == true) {
        $filename = $xml_cache_dir . $current_user->getUserPrivGuid(). '_' . $reporter->saved_report_id . '_saved_chart.xml';
    } else {
        $filename = $xml_cache_dir . $current_user->getUserPrivGuid() . '_' . time() . '_curr_user_chart.xml';
    }

    if ( !is_dir(dirname($filename)) ) {
        create_cache_directory("xml/");
    }

    return $filename;
}
*/
