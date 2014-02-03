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
$queries = array(
    'amounts'=>array(
        'Possible'=>'SELECT sum(amount) val FROM opportunities where sales_stage NOT IN (\'Closed Lost\') and deleted=0',
        'Committed'=>'SELECT sum(amount) val FROM opportunities where sales_stage = \'Closed Won\' and deleted=0',
        'Average'=>'SELECT AVG(amount) val FROM opportunities where sales_stage = \'Closed Won\' and deleted=0',
    ),
    'counts'=>array(
        'New Deals'=>'SELECT count(id) val FROM opportunities where sales_stage = \'Prospecting\' and deleted=0',
        //'Open Deals'=>'SELECT count(id) val FROM opportunities where sales_stage NOT IN (\'Closed Won\',\'Closed Lost\') and deleted=0',
        'Closed Won Deals'=>'SELECT count(id) val FROM opportunities where sales_stage = (\'Closed Won\') and deleted=0',
        'Closed Lost Deals'=>'SELECT count(id) val FROM opportunities where sales_stage = (\'Closed Lost\') and deleted=0',
        'Total Deals'=>'SELECT count(id) val FROM opportunities where deleted=0',
    )
);

$styles = array(
    'amounts'=>array(
        'Average'=>'',
        'Possible'=>'blue',
        'Committed'=>'green',
    ),
    'counts'=>array(
        'Total Deals'=>'',
        'New Deals'=>'blue',
        'Open Deals'=>'yellow',
        'Closed Won Deals'=>'green',
        'Closed Lost Deals'=>'red',
    )
);

foreach ($queries as $catname => $catQueries) {
    foreach ($catQueries as $queryName => $query) {
        $result = $GLOBALS['db']->query($query);
        while($row = $GLOBALS['db']->fetchByAssoc($result)){
            if(isset($row['val'])) {
                if ($catname == 'amounts') {
                    $row['val'] = '$'.number_format($row['val']);
                }
                $row['label'] = $queryName;
                $row['style'] = $styles[$catname][$queryName];
                $data[$catname][] = $row;
            }
        }
    }
}