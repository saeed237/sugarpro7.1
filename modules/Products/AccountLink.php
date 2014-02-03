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


require_once("data/Link2.php");

class AccountLink extends Link2
{
    public function getSubpanelQuery($params = array(), $return_array = false)
    {
        $db = DBManagerFactory::getInstance();
        $result = parent::getSubpanelQuery($params, $return_array);
        if($return_array)
        {
            $result ['join'] .= ' LEFT JOIN quotes ON products.quote_id = quotes.id ';
            $result['where'] .= ' AND (quotes.quote_stage IS NULL OR quotes.quote_stage NOT IN (' . $db->quoted('Closed Lost') . ',' . $db->quoted('Closed Dead') . ')) AND ( quotes.deleted = 0 OR quotes.deleted IS NULL )';
            array_push($result['join_tables'], 'quotes');
        }
        return $result;
    }
}