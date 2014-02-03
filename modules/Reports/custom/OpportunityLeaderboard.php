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

$month_start = date('Y-m-d',mktime(12,1,1,date('m'),-1,date('Y')));
$month_end = date('Y-m-d',mktime(12,1,1,date('m')+1,1,date('Y')));
$query = "SELECT u.id user_id, CONCAT(u.first_name, ' ', u.last_name)  user_name, SUM(o.amount) amount, count(o.id) sales
FROM opportunities o
LEFT JOIN users u ON o.assigned_user_id = u.id
WHERE o.sales_stage = 'Closed Won'
AND o.date_closed BETWEEN '$month_start' AND '$month_end'
GROUP BY u.id";

$result = $GLOBALS['db']->query($query,true);
$data = array();

while($row = $GLOBALS['db']->fetchByAssoc($result)){
    $data[] = $row;
}
