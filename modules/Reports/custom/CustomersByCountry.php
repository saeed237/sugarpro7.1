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

$result = $GLOBALS['db']->query('SELECT accounts.billing_address_country as country, COUNT( accounts.billing_address_country ) as amount
FROM opportunities
RIGHT JOIN accounts_opportunities ao ON ao.opportunity_id = opportunities.id
AND ao.deleted =0
RIGHT JOIN accounts ON accounts.id = ao.account_id
AND accounts.deleted =0
WHERE opportunities.sales_stage =  \'Closed Won\'
AND opportunities.deleted =0 GROUP BY accounts.billing_address_country');
while($row = $GLOBALS['db']->fetchByAssoc($result)){
    $data[] = $row;
}