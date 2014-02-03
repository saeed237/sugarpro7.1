<?php
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


require_once('include/SugarForecasting/Chart/AbstractChart.php');
require_once('include/SugarForecasting/Individual.php');
class SugarForecasting_Chart_Individual extends SugarForecasting_Chart_AbstractChart
{
    /**
     * Constructor
     *
     * @param array $args
     */
    public function __construct($args)
    {
        if (isset($args['data_array']) && $args['data_array']) {
            $this->dataArray = $args['data_array'];
        }
        parent::__construct($args);
    }

    /**
     * Process the data into the current JIT Chart Format
     *
     * @return array
     */
    public function process()
    {
        return $this->generateChartJson();
    }

    protected function generateChartJson()
    {
        global $app_list_strings, $app_strings;

        $arrData = array();
        $arrProbabilities = array();
        $forecast_strings = $this->getModuleLanguage('Forecasts');
        $config = $this->getForecastConfig();

        $acl = new SugarACLForecastWorksheets();

        $bestAccess = $acl->checkAccess(
            'ForecastWorksheets',
            'field',
            array('field' => 'best_case', 'action' => 'view')
        );
        $worstAccess = $acl->checkAccess(
            'ForecastWorksheets',
            'field',
            array('field' => 'worst_case', 'action' => 'view')
        );

        if (!empty($this->dataArray)) {
            foreach ($this->dataArray as $data) {
                $v = array(
                    'id' => $data['id'],
                    'record_id' => $data['parent_id'],
                    'forecast' => $data['commit_stage'],
                    'probability' => $data['probability'],
                    'sales_stage' => $data['sales_stage'],
                    'likely' => SugarCurrency::convertWithRate($data['likely_case'], $data['base_rate']),
                    'date_closed_timestamp' => intval($data['date_closed_timestamp'])
                );

                if ($config['show_worksheet_best'] && $bestAccess) {
                    $v['best'] = SugarCurrency::convertWithRate($data['best_case'], $data['base_rate']);
                }
                if ($config['show_worksheet_worst'] && $worstAccess) {
                    $v['worst'] = SugarCurrency::convertWithRate($data['worst_case'], $data['base_rate']);
                }

                $arrData[] = $v;

                $arrProbabilities[$data['probability']] = $data['probability'];
            }
            asort($arrProbabilities);
        }

        $tp = $this->getTimeperiod();
        $chart_info = array(
            'title' => string_format(
                $forecast_strings['LBL_CHART_FORECAST_FOR'],
                array($tp->name)
            ),
            'quota' => $this->getUserQuota(),
            'x-axis' => $tp->getChartLabels(array()),
            'labels' => array(
                'forecast' => $app_list_strings[$config['buckets_dom']],
                'sales_stage' => $app_list_strings['sales_stage_dom'],
                'probability' => $arrProbabilities,
                'dataset' => array(
                    'likely' => $app_strings['LBL_LIKELY'],
                    'best' => $app_strings['LBL_BEST'],
                    'worst' => $app_strings['LBL_WORST']
                )
            ),
            'data' => $arrData
        );

        return $chart_info;
    }

    /**
     * Return the quota for the current user and time period
     *
     * @return mixed
     */
    protected function getUserQuota()
    {
        /* @var $quota_bean Quota */
        $quota_bean = BeanFactory::getBean('Quotas');
        $quota = $quota_bean->getRollupQuota($this->getArg('timeperiod_id'), $this->getArg('user_id'));

        return SugarCurrency::convertAmountToBase($quota['amount'], $quota['currency_id']);
    }
}
