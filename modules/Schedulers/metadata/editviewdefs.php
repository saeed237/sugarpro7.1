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



$viewdefs['Schedulers']['EditView'] = array(
    'templateMeta' => array(
                            'maxColumns' => '2',
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'),
                                            array('label' => '10', 'field' => '30'),
                                           ),
                            'includes'=> array(
                                            array('file'=>'modules/Schedulers/Schedulers.js'),
                                         ),
                           ),

    'panels' => array(
    		'default'=>array(
                           array('name', 'status'),
                           array('job_function', "job_url"),
                           array('adv_interval'),
                           array(array('name'=>'job_interval', 'label' => 'LBL_INTERVAL', 'customCode'=>'
				<div id="job_interval_advanced">
				<script>
					var adv_interval = {$adv_interval};
				</script>
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td>{$MOD.LBL_MINS}</td>
						<td>{$MOD.LBL_HOURS}</td>
						<td>{$MOD.LBL_DAY_OF_MONTH}</td>
						<td>{$MOD.LBL_MONTHS}</td>
						<td>{$MOD.LBL_DAY_OF_WEEK}</td>
					</tr><tr>
						<td><input name="mins" maxlength="25" type="text" size="3" value="{$mins}"></td>
						<td><input name="hours" maxlength="25" type="text" size="3" value="{$hours}"></td>
						<td><input name="day_of_month" maxlength="25" type="text" size="3" value="{$day_of_month}"></td>
						<td><input name="months" maxlength="25" type="text" size="3" value="{$months}"></td>
						<td><input name="day_of_week" maxlength="25" type="text" size="3" value="{$day_of_week}"></td>
					</tr><tr>
						<td colspan="5">
							<em>{$MOD.LBL_CRONTAB_EXAMPLES}</em>
						</td>
					</tr>
				</table>
				</div>
				')),
				array(array('name'=>'job_interval', 'label' => 'LBL_INTERVAL','customCode'=>'
				<div id="job_interval_basic">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td valign="top" width="25%">
							&nbsp;{$MOD.LBL_EVERY}&nbsp;
							<select name="basic_interval">{html_options options=$basic_intervals selected=$basic_interval}</select>&nbsp;
							<select name="basic_period">{html_options options=$basic_periods selected=$basic_period}</select>
						</td>
						<td valign="top" width="25%">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td><slot><input type="checkbox" name="all" value="true" id="all" {$ALL} onClick="allDays();">&nbsp;<i>{$MOD.LBL_ALL}</i></slot></td>
							</tr>
							<tr>
								<td><slot><input type="checkbox" name="mon" value="true" id="mon" {$MON}>&nbsp;{$MOD.LBL_MON}</slot></td>
							</tr>
							<tr>
								<td><slot><input type="checkbox" name="tue" value="true" id="tue"  {$TUE}>&nbsp;{$MOD.LBL_TUE}</slot></td>
							</tr>
							<tr>
								<td><slot><input type="checkbox" name="wed" value="true" id="wed"  {$WED}>&nbsp;{$MOD.LBL_WED}</slot></td>
							</tr>
						</table>
						</td>

						<td valign="top" width="25%">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td><slot><input type="checkbox" name="thu" value="true" id="thu"  {$THU}>&nbsp;{$MOD.LBL_THU}</slot></td>
							</tr>
							<tr>
								<td><slot><input type="checkbox" name="fri" value="true" id="fri"  {$FRI}>&nbsp;{$MOD.LBL_FRI}</slot></td>
							</tr>
							<tr>
								<td><slot><input type="checkbox" name="sat" value="true" id="sat"  {$SAT}>&nbsp;{$MOD.LBL_SAT}</slot></td>
							</tr>
							<tr>
								<td><slot><input type="checkbox" name="sun" value="true" id="sun"  {$SUN}>&nbsp;{$MOD.LBL_SUN}</slot></td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
				</div>
				'))
                           ),
            'lbl_adv_options'=>array(
                            array(array('name' => 'catch_up', 'prefix' => '{sugar_help text=$MOD.LBL_CATCH_UP_WARNING}')),
                           	array('date_time_start','time_from'),
                           	array('date_time_end','time_to'),
                           	),
	),

);
