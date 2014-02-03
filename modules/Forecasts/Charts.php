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

/*********************************************************************************

* Description:  Includes the functions for Customer module specific charts.
********************************************************************************/


require_once('modules/Forecasts/Common.php');
require_once('include/SugarCharts/SugarChartFactory.php');

class forecast_charts extends SugarView {
    /**
     * @param string user_id Display forecast history for this user.
     * @param datetime timeperiod_date timperiod that ecompasses this date will be the starting point for the historical data.
     * @param integer no_timeperiods    Maximum number of timeperiods in the chart. default is 5.
     * @param string forecsat_type valid values are direct or rollup
     */
    function forecast_history($user,$timeperiod_date,$forecast_type='Direct', $no_of_timeperiods=5, $is_dashlet=false, $dashlet_id='') {
        $user_id=$user->id;
        global $sugar_config,$current_language, $current_user;
        $sugarChart = SugarChartFactory::getInstance();
        
        $current_module_strings = return_module_language($current_language, 'Forecasts');
        //currency files..
        $currency = BeanFactory::getBean('Currencies', $current_user->getPreference('currency'));

        $cache_file_name = sugar_cached("xml/").$current_user->getUserPrivGuid().$user->id.$forecast_type.".xml";
        $forecast = BeanFactory::getBean('Forecasts');
        $data=array();
        $d = array();
        $chart_data = array();
        $labels=array();
        //find timeperiods.
        $query="select * from timeperiods t";
        $query.=" where exists (select * from forecast_schedule s where t.id=s.timeperiod_id and forecast_start_date <= '$timeperiod_date')";
        $query.=" and (is_fiscal_year=0 or is_fiscal_year is null) ";
        $query.=" and deleted=0 ";
        $query.=" order by t.end_date desc";

        $result=$forecast->db->limitQuery($query, 0, $no_of_timeperiods);
        $max=0;
        $min=-1;

        while (($row=$forecast->db->fetchByAssoc($result)) != null) {
            //for each time period find the quota amount.

            $quota_query = "select * from quotas ";
            $quota_query.= " where user_id='$user_id' ";
            $quota_query.= " and timeperiod_id='{$row['id']}' ";
            $quota_query.= " and quota_type='$forecast_type' ";
            $quota_query.= " and deleted=0";

            $labels[$row['id']]=$row['name'];

            $quota_label = $current_module_strings['LBL_GRAPH_QUOTA_LEGEND'];
			$forecast_label = $current_module_strings['LBL_GRAPH_COMMIT_LEGEND'];
			$closed_label = $current_module_strings['LBL_GRAPH_OPPS_LEGEND'];

            //get quota
            $q_result=$forecast->db->query($quota_query);
            $quota=$forecast->db->fetchByAssoc($q_result);
            if (!empty($quota['amount_base_currency'])) {
                //add quota to the array.
                $data[$row['name']][$quota_label]= $currency->convertFromDollar($quota['amount_base_currency'],0);
            } else  {
				$data[$row['name']][$quota_label]=0;
            }
            //compare for max value.
            if ($data[$row['name']][$quota_label] > $max) {
                $max=$data[$row['name']][$quota_label];
            }
            if ($min==-1 or $data[$row['name']][$quota_label] < $min) {
                $min=$data[$row['name']][$quota_label];
            }

            $labels[$row['id'].'quota']=sprintf($current_module_strings['LBL_GRAPH_QUOTA_ALTTEXT'],$row['name']);
            $labels['LEGEND']['quota']['ID']='quota';
            $labels['LEGEND']['quota']['NAME']=$current_module_strings['LBL_GRAPH_QUOTA_LEGEND'];
//            $labels['LEGEND']['quota']['COLOR']=generate_graphcolor('quota',1);
            
            //get amount forecasted by the user. only the most recent forecasted amount will be considered
            //this forecasted amount may or maynot have been used by the user's manager
            $forecast_query ="select * from forecasts ";
            $forecast_query.=" where timeperiod_id='{$row['id']}'";
            $forecast_query.=" and user_id='$user_id'";
            $forecast_query.=" and forecast_type='$forecast_type'";
            $forecast_query.=" and deleted=0";
            $forecast_query.=" order by date_entered desc";

            $q_result=$forecast->db->query($forecast_query);
            $fcst=$forecast->db->fetchByAssoc($q_result);
            if (!empty($fcst['likely_case'])) {
                //add quota to the array.
                $data[$row['name']][$forecast_label]= $currency->convertFromDollar($fcst['likely_case'],0);
            } else {
                $data[$row['name']][$forecast_label]=0;
            }
            if ($data[$row['name']][$forecast_label] > $max) {
                $max=$data[$row['name']][$forecast_label];
            }
            if ($min==-1 or $data[$row['name']][$forecast_label] < $min) {
                $min=$data[$row['name']][$forecast_label];
            }

            $labels[$row['id'].'forecast']=sprintf($current_module_strings['LBL_GRAPH_COMMIT_ALTTEXT'],$row['name']);
            $labels['LEGEND']['forecast']['ID']='forecast';
            $labels['LEGEND']['forecast']['NAME']=$current_module_strings['LBL_GRAPH_COMMIT_LEGEND'];
//            $labels['LEGEND']['forecast']['COLOR']=generate_graphcolor('forecast',2);
            
            //get opportunities closed within this timne period. 
            //expected close date should not be empty and should fall with timeperiod start and end date.
            //Closed Won
            $common = new Common();
            $common->retrieve_downline($user_id);
            $my_downline = implode('\',\'', $common->my_downline);

            $opp_query  = "select sum(" . db_convert("amount_usdollar","IFNULL",array(0))." * (" .db_convert("probability","IFNULL",array(0)). "/100)) total_value";
            $opp_query .= " from opportunities";
            $opp_query .= " where assigned_user_id IN ('$user_id', '$my_downline')";
            $opp_query .= " and sales_stage='".Opportunity::STAGE_CLOSED_WON."'";
            $opp_query .= " and deleted=0";
            $opp_query .= " and date_closed >= ". db_convert("'".$row['start_date']."'","datetime")." and date_closed <= ". db_convert( "'".$row['end_date']."'","datetime");

            $opp_result=$forecast->db->query($opp_query);
            $opp_data=$forecast->db->fetchByAssoc($opp_result);
            if (!empty($opp_data['total_value'])) {
                $data[$row['name']][$closed_label]= $currency->convertFromDollar($opp_data['total_value'],0);
            } else {
                $data[$row['name']][$closed_label]=0;
            }
            if ($data[$row['name']][$closed_label] > $max) {
                $max=$data[$row['name']][$closed_label];
            }
            if ($min==-1 or $data[$row['name']][$closed_label] < $min) {
                $min=$data[$row['name']][$closed_label];
            }

            $labels[$row['id'].'closed']=sprintf($current_module_strings['LBL_GRAPH_OPPS_ALTTEXT'],$row['name']);
            $labels['LEGEND']['closed']['ID']='closed';
            $labels['LEGEND']['closed']['NAME']=$current_module_strings['LBL_GRAPH_OPPS_LEGEND'];
//            $labels['LEGEND']['closed']['COLOR']=generate_graphcolor('closed',3);
        }

		
		
		$width = ($is_dashlet) ? '100%' : '720px';
		
		$return = '<script>SUGAR.loadChart = true;</script>';
		if (!$is_dashlet){
			$return .= '<br />';
			$return .= SugarView::renderJavascript();
			$return .= $sugarChart->getChartResources();
		}
		$return .= '<div align="center">';
		$return .= '<div id="forecast_chart_container" style="width:' . $width . ';">';
		
		//bug: 40457 - was: $sugarChart->is_currency = true;, but changed to below since we already convert the values
		//above into the proper currency. Because this was set to true it was converting twice.
		$sugarChart->is_currency = false;
		$sugarChart->setData($data);
		
		$sugarChart->setProperties($current_module_strings['LBL_CHART_TITLE'], '', 'group by chart');

    	if (!$is_dashlet){
			$xmlFile = $sugarChart->getXMLFileName('forecasting_chart');
			$sugarChart->saveXMLFile($xmlFile, $sugarChart->generateXML());
			$return .= $sugarChart->display('forecast_chart', $xmlFile, $width, '480');
		}
		else{
			$xmlFile = $sugarChart->getXMLFileName($dashlet_id);
			$sugarChart->saveXMLFile($xmlFile, $sugarChart->generateXML());
			$return .= $sugarChart->display($dashlet_id, $xmlFile, $width, '480');
		}
		$return .= '</div>';
		$return .= '</div>';

		if (!$is_dashlet){
	        $table_rows="";
	        $oddRow=true;
	        global $odd_bg;
	        global $even_bg;
	        global $theme;
	        foreach ($data as $timeperiod=>$values) {
	            if($oddRow){
	                $ROW_COLOR = 'oddListRow';
	                $BG_COLOR =  $odd_bg;
	            }
	            else {
	                $ROW_COLOR = 'evenListRow';
	                $BG_COLOR =  $even_bg;
	            }
	            $oddRow = !$oddRow;

	            $table_rows.="<tr height=20>";
	            $table_rows.="<td valign=TOP class='{$ROW_COLOR}S1' bgcolor='{$BG_COLOR}'>" . $timeperiod . "</td>";
	            $table_rows.="<td valign=TOP class='{$ROW_COLOR}S1' bgcolor='{$BG_COLOR}'>" . $currency->symbol . $values[$quota_label]. "</td>";
	            $table_rows.="<td valign=TOP class='{$ROW_COLOR}S1' bgcolor='{$BG_COLOR}'>" . $currency->symbol . $values[$forecast_label]. "</td>";
	            $table_rows.="<td valign=TOP class='{$ROW_COLOR}S1' bgcolor='{$BG_COLOR}'>" . $currency->symbol . $values[$closed_label]. "</td>";
	            $table_rows.="</tr>";
	        }

	        $return .= SugarThemeRegistry::current()->getCSS();
	        $return .= <<<EOQ
	        <BR/>
			<div id="forecasting_table" style="width:720px;">
	        <table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view">
	        <tr height="20">
	            <td scope="col" width="25%"  NOWRAP>{$current_module_strings['LBL_TIMEPERIOD_NAME']}</td>
	            <td scope="col" width="25%"  NOWRAP>{$current_module_strings['LBL_GRAPH_QUOTA_LEGEND']}</td>
	            <td scope="col" width="25%"  NOWRAP>{$current_module_strings['LBL_GRAPH_COMMIT_LEGEND']}</td>
	            <td scope="col" width="25%"  NOWRAP>{$current_module_strings['LBL_GRAPH_OPPS_LEGEND']}</td>
	        </tr>
	        $table_rows
	        </table>
			</div>
</div>
EOQ;
		}
        return $return;

    }
}// end charts class
?>