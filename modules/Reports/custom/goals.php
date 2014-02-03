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

global $current_user;
$data = array();
$sc = Phaser::singleton();
 $dbgoal = $sc->getInstanceProperty('annual_revenue_goal');
if (!is_null($dbgoal) && is_int(intval($dbgoal))) {
    $goal=intval($dbgoal);
}else{
    $goal = 1000000;
}
$dayOfTheYear=date('z',strtotime('today'));
$goalsper = array(
        'Week'=>$goal/52,
        'Month'=>$goal/12,
        'Year'=>$goal,
        'YTD'=>$goal*($dayOfTheYear/365)
    );
$today = getdate(time());

$firstDayThisMonth=date('Y-m-d',strtotime('first day of this month'));
$lastDayThisMonth=date('Y-m-d',strtotime('last day of this month'));


$firstDayThisWeek=date('Y-m-d',strtotime('last monday'));
$lastDayThisWeek=date('Y-m-d',strtotime('next sunday'));

$data = array();
$queries = array(
        'Week'=>'SELECT sum(amount) val FROM opportunities where sales_stage = \'Closed Won\' and deleted=0 and date_closed >=\''.$firstDayThisWeek.'\' and date_closed <=\''.$lastDayThisWeek.'\'',
        'Month'=>'SELECT sum(amount) val FROM opportunities where sales_stage = \'Closed Won\' and deleted=0 and date_closed >=\''.$firstDayThisMonth.'\' and date_closed <=\''.$lastDayThisMonth.'\'',
        'Year'=>'SELECT sum(amount) val FROM opportunities where sales_stage = \'Closed Won\' and deleted=0 and date_closed >=\''.$today['year'].'-01-01\' and date_closed <=\''.$today['year'].'-12-31\'',
        'YTD'=>'SELECT sum(amount) val FROM opportunities where sales_stage = \'Closed Won\' and deleted=0 and date_closed >=\''.$today['year'].'-01-01\' and date_closed <=\''.$today['year'].'-12-31\'',
);

$styles = array(
);

$results = array();
    foreach ($queries as $queryName => $query) {
        $result = $GLOBALS['db']->query($query);
        var_dump($query);
        while($row = $GLOBALS['db']->fetchByAssoc($result)){
            if(isset($row['val'])) {
                var_dump($row);
                $results[$queryName]['committed'] = floatval($row['val']);
                $results[$queryName]['goal'] = $goalsper[$queryName];
               // $results[$queryName]['percent'] = floatval($row['val'])/$goalsper[$queryName];
            } else {
                $results[$queryName]['committed'] = floatval(0);
                $results[$queryName]['goal'] = $goalsper[$queryName];
            }
        }
    }
$data = $results;
//var_dump($data);
//die("asdf");