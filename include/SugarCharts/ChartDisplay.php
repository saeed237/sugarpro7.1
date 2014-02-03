<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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



/**
 * Handle setting up the Charting for Display
 *
 * @api
 */
class ChartDisplay
{
    /**
     * Report Class
     *
     * @var Report
     */
    protected $reporter;

    /**
     * What type of chart are we displaying
     *
     * @var string
     */
    protected $chartType;

    /**
     * Can we draw a chart?
     *
     * @var bool
     */
    protected $canDrawChart = true;

    /**
     * Is this a stackable chart?
     *
     * @var bool
     */
    protected $stackChart = false;

    /**
     * What's the title for this chart
     *
     * @var string
     */
    protected $chartTitle = '';

    /**
     * Rows to display in the chart
     *
     * @var array
     */
    protected $chartRows = array();

    /**
     * Set the Reporter (Report Object) to use
     *
     * @param Report $reporter
     */
    public function setReporter(Report $reporter)
    {
        $this->reporter = $reporter;

        // set the default stuff we need on the reporter
        // and run the queries
        $this->reporter->is_saved_report = true;
        // only run if the chart_rows variable is empty
        if (empty($this->reporter->chart_rows)) {
            $this->reporter->get_total_header_row();
            $this->reporter->run_chart_queries();
        }

        // set the chart type
        $this->chartType = $this->reporter->chart_type;

        $this->parseReportHeaders();
        $this->parseChartTitle();
        $this->parseChartRows();
    }

    /**
     * Get the Reporter (Report Object)
     *
     * @return Report
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * Return the SugarChart's object with all the values set and ready for display/consumption.
     *
     * @return JitReports|string
     */
    public function getSugarChart()
    {
        if ($this->canDrawChart()) {
            require_once('include/SugarCharts/SugarChartFactory.php');

            /* @var $sugarChart JitReports */
            $sugarChart = SugarChartFactory::getInstance('', 'Reports');

            $sugarChart->setData($this->chartRows);
            $sugarChart->setProperties($this->chartTitle, '', $this->chartType);

            if (isset($this->reporter->report_def['group_defs'])) {
                $groupByNames = array();
                foreach ($this->reporter->report_def['group_defs'] as $group_def)
                {
                    $groupByNames[] = $group_def['name'];
                }
                $sugarChart->group_by = $groupByNames;
            }

            return $sugarChart;
        } else {
            global $current_language;
            $mod_strings = return_module_language($current_language, 'Reports');
            return $mod_strings['LBL_NO_CHART_DRAWN_MESSAGE'];
        }
    }

    /**
     * Parse the Report Headers and such set the values we need for items later in the string
     */
    protected function parseReportHeaders()
    {
        $group_key = (isset($this->reporter->report_def['group_defs'][0]['table_key']) ? $this->reporter->report_def['group_defs'][0]['table_key'] : '') .
            ':' .
            (isset($this->reporter->report_def['group_defs'][0]['name']) ? $this->reporter->report_def['group_defs'][0]['name'] : '');

        if (!empty ($this->reporter->report_def['group_defs'][0]['qualifier'])) {
            $group_key .= ':' . $this->reporter->report_def['group_defs'][0]['qualifier'];
        }

        $i = 0;
        foreach ($this->reporter->chart_header_row as $header_cell) {
            if ($header_cell['column_key'] == 'count') {
                $header_cell['column_key'] = 'self:count';
            }
            if ($header_cell['column_key'] == $this->reporter->report_def['numerical_chart_column']) {
                $this->reporter->chart_numerical_position = $i;
            }
            if ($header_cell['column_key'] == $group_key) {
                $this->reporter->chart_group_position = $i;
            }
            $i++;
        }
    }

    /**
     * Generate the Title for the Chart
     */
    protected function parseChartTitle()
    {
        global $current_language, $do_thousands;
        if (isset($this->reporter->report_def['layout_options'])) {
            // This is for matrix report
            $this->reporter->run_total_query();
            // start template_total_table code
            $total_row = $this->reporter->get_summary_total_row();
            for ($i = 0; $i < count($this->reporter->chart_header_row); $i++) {
                if ($this->reporter->chart_header_row[$i]['column_key'] == 'count') {
                    $this->reporter->chart_header_row[$i]['column_key'] = 'self:count';
                } // if
                if ($this->reporter->chart_header_row[$i]['column_key'] == $this->reporter->report_def['numerical_chart_column']) {
                    $total = $i;
                    //break;
                }
                if ($this->reporter->chart_header_row[$i]['column_key'] == 'self:count') {
                    $this->reporter->chart_header_row[$i]['column_key'] = 'count';
                } // if
            } // for
            if (empty($total)) {
                $total = 0;
            }
            $total = $total_row['cells'][$total];
            if (unformat_number($total) > 100000) {
                $do_thousands = true;
                $total = round(unformat_number($total) / 1000);
            } else {
                $do_thousands = false;
                $total = unformat_number($total);
            }
            array_pop($this->reporter->chart_rows);
        } else {
            $total_row = array_pop($this->reporter->chart_rows);
            $total = $this->get_total($total_row);
        }

        $symbol = $this->print_currency_symbol();

        $mod_strings = return_module_language($current_language, 'Reports');

        $this->chartTitle = $mod_strings['LBL_TOTAL_IS'] . ' ' . $symbol . format_number($total, 0, 0) . $this->get_k();
    }

    /**
     * Format the ChartRows from the Reporting engine
     */
    protected function parseChartRows()
    {
        $chart_rows = array();
        $chart_groupings = array();
        foreach ($this->reporter->chart_rows as $row) {
            $row_remap = $this->get_row_remap($row);
            if (!isset($row_remap['group_base_text'])) {
                continue;
            }
            $chart_groupings[$row_remap['group_base_text']] = true; // store all the groupingstem
            if (empty($chart_rows[$row_remap['group_text']][$row_remap['group_base_text']])) {
                $chart_rows[$row_remap['group_text']][$row_remap['group_base_text']] = $row_remap;
            } else {
                $chart_rows[$row_remap['group_text']][$row_remap['group_base_text']]['numerical_value'] += $row_remap['numerical_value'];
            }
        }

        // check to see if the chart can be stackable
        foreach ($chart_rows as $element) {
            if (count($element) > 1) {
                $this->stackChart = true;
                break;
            }
        }
        switch ($this->chartType) {
            case 'hBarF':
                if ($this->isStackable()) {
                    $this->chartType = 'horizontal group by chart';
                } else {
                    $this->chartType = 'horizontal bar chart';
                }
                break;
            case 'vBarF':
                if ($this->isStackable()) {
                    $this->chartType = 'stacked group by chart';
                } else {
                    $this->chartType = 'bar chart';
                }
                break;
            case 'pieF':
                $this->chartType = 'pie chart';
                break;
            case 'lineF':
                if ($this->isStackable()) {
                    $this->chartType = 'line chart';
                } else {
                    $this->canDrawChart = false;
                }
                break;
            case 'funnelF':
                $this->chartType = 'funnel chart 3D';
                break;
            default:
                break;
        }

        $this->chartRows = $chart_rows;
    }

    /**
     * Can we draw the chart?
     *
     * @return bool
     */
    public function canDrawChart()
    {
        return $this->canDrawChart;
    }

    /**
     * Is the chart Stackable
     *
     * @return bool
     */
    public function isStackable()
    {
        return $this->stackChart;
    }


    protected function print_currency_symbol()
    {
        $report_defs = $this->reporter->report_def;
        $currency_symbol = '';
        if (isset($report_defs['numerical_chart_column_type']) && $report_defs['numerical_chart_column_type'] == 'currency') {
            $currency = BeanFactory::getBean('Currencies')->getUserCurrency();

            $currency_symbol = $currency->symbol;
        } else if (!isset($report_defs['numerical_chart_column_type'])) {
            return '';
        }

        return $currency_symbol;
    }

    /**
     * Remap the row to conform to how the charting engine needs the data
     *
     * @param $row
     * @return array
     */
    protected function get_row_remap($row)
    {
        $row_remap = array();
        if (!isset($row['cells'][$this->reporter->chart_numerical_position]['val'])) {
            return $row_remap; 
        }
        $row_remap['numerical_value'] = $numerical_value = unformat_number(strip_tags($row['cells'][$this->reporter->chart_numerical_position]['val']));
        global $do_thousands;
        if ($do_thousands) {
            // MRF - Bug # 13501, 47148 - added floor() below:
            $row_remap['numerical_value'] = round(unformat_number(floor($row_remap['numerical_value'])) / 1000);
        }
        $row_remap['group_text'] = $group_text = (isset($this->reporter->chart_group_position) && !is_array($this->reporter->chart_group_position)) ? chop($row['cells'][$this->reporter->chart_group_position]['val']) : '';
        $row_remap['group_key'] = ((isset($this->reporter->chart_group_position) && !is_array($this->reporter->chart_group_position)) ? $row['cells'][$this->reporter->chart_group_position]['key'] : '');
        $row_remap['count'] = (isset($row['count'])) ? $row['count'] : 0;
        $row_remap['group_label'] = ((isset($this->reporter->chart_group_position) && !is_array($this->reporter->chart_group_position)) ? $this->reporter->chart_header_row[$this->reporter->chart_group_position]['label'] : '');
        $row_remap['numerical_label'] = $this->reporter->chart_header_row[$this->reporter->chart_numerical_position]['label'];
        $row_remap['numerical_key'] = $this->reporter->chart_header_row[$this->reporter->chart_numerical_position]['column_key'];
        $row_remap['module'] = $this->reporter->module;
        if (count($this->reporter->report_def['group_defs']) > 1) { // multiple group by, use second group by as legend
            $second_group_by_key = $this->reporter->report_def['group_defs'][1]['table_key'] . ':' . $this->reporter->report_def['group_defs'][1]['name'];
            foreach ($row['cells'] as $cell) {
                if ($cell['key'] == $second_group_by_key) {
                    $row_remap['group_base_text'] = $cell['val'];
                }
            }
        } else { // single group by
            $row_remap['group_base_text'] = $row['cells'][0]['val'];
        }

        //jclark - bug 47329 - report charts show html link text
        $row_remap['group_text'] = strip_tags($row_remap['group_text']);
        $row_remap['group_base_text'] = strip_tags($row_remap['group_base_text']);
        //end jclark fix

        return $row_remap;

    }

    /**
     * Generate a total amount for a row
     *
     * @param $total_row
     * @return float|string
     */
    protected function get_total($total_row)
    {
        $total_index = 0;
        if (!empty ($this->reporter->chart_total_header_row)) {
            for ($i = 0; $i < count($this->reporter->chart_total_header_row); $i++) {
                if ($this->reporter->chart_total_header_row[$i]['column_key'] == $this->reporter->report_def['numerical_chart_column']) {
                    $total_index = $i;
                    break;
                }
            }
        } else {
            $total_index = 0; // special for dashlets!!
        }
        $total = $total_row['cells'][$total_index]['val'];
        global $do_thousands;
        if ($this->get_maximum() > 100000 && (!isset($this->reporter->report_def['do_round'])
            || (isset($this->reporter->report_def['do_round']) && $this->reporter->report_def['do_round'] == 1))
        ) {
            $do_thousands = true;
            $total = round(unformat_number($total) / 1000);
            return $total;
        } else {
            $do_thousands = false;
            return unformat_number($total);
        }

    }

    /**
     * Return a Thousands Symbol if one is required
     *
     * @return string
     */
    protected function get_k()
    {
        global $do_thousands, $app_strings;
        if ($do_thousands) {
            return $app_strings['LBL_THOUSANDS_SYMBOL'];
        } else {
            return '';
        }
    }

    /**
     * Get the Maximum Number from the rows
     *
     * @return float|int|mixed
     */
    protected function get_maximum()
    {
        $numbers = array();
        foreach ($this->reporter->chart_rows as $row) {
            $row_remap = $this->get_row_remap($row);
            array_push($numbers, $row_remap['numerical_value']);
        }
        return $this->get_max_from_numbers($numbers);
    }

    /**
     * Get the Maximum Number of an array of numbers
     *
     * @param $numbers
     * @return float|int|mixed
     */
    protected function get_max_from_numbers($numbers)
    {
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

    /**
     * Figure out the cache name for a chart
     *
     * @param null|Report $reporter         If Null, this will use the set reporter, other wise it will use the passed in one
     * @return string                       File name for the cache file.
     */
    public function get_cache_file_name($reporter = null)
    {
        if(is_null($reporter)) {
            $reporter = $this->reporter;
        }
        global $current_user;

        $xml_cache_dir = sugar_cached("xml/");
        if ($reporter->is_saved_report == true) {
            $filename = $xml_cache_dir . $current_user->getUserPrivGuid(). '_' . $reporter->saved_report_id . '_saved_chart.xml';
        } else {
            $filename = $xml_cache_dir . $current_user->getUserPrivGuid() . '_' . time() . '_curr_user_chart.xml';
        }

        if (!is_dir(dirname($filename))) {
            create_cache_directory("xml/");
        }

        return $filename;
    }

    /**
     * Method for displaying the old legacy way that was done.
     *
     * @param $id                       ID use for the guid
     * @param bool $is_dashlet          Are we displaying a dashlet or not
     * @return JitReports|string        Return the HTML
     */
    public function legacyDisplay($id, $is_dashlet = false)
    {

        if ($is_dashlet) {
            $height = '480';
            $width = '100%';
            $guid = $id;
        } else {
            $width = '100%';
            $height = '480';
            $guid = $this->reporter->saved_report_id;
        }

        // Bug #57213 : Reports with data series removed render charts inconsistently
        if ( $this->reporter && !$this->reporter->has_summary_columns() )
        {
            global $current_language;
            $mod_strings = return_module_language($current_language, 'Reports');
            return $mod_strings['LBL_CANNOT_DISPLAY_CHART_MESSAGE'];
        }

        $sugarChart = $this->getSugarChart();
        if (is_object($sugarChart)) {
            $xmlFile = $this->get_cache_file_name();
            $sugarChart->saveXMLFile($xmlFile, $sugarChart->generateXML());
            return $sugarChart->display($guid, $xmlFile, $width, $height);
        }

        return $sugarChart;
    }

    /**
     * Generate the xml string from the SugarChart Object
     *
     * @return string
     */
    public function generateXML()
    {
        return $this->getSugarChart()->generateXML();
    }

    /**
     * Generate JSON
     *
     * @return mixed|string
     */
    public function generateJson()
    {
        return $this->getSugarChart()->buildJson($this->generateXML(), true);
    }
}
