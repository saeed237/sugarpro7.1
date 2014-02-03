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


class SugarWidgetFieldcurrency_id extends SugarWidgetFieldEnum
{
    /**
     * Returns list of beans of currencies including default system currency
     *
     * @param bool $refresh cache
     * @return array list of beans
     */
    static public function getCurrenciesList($refresh = false)
    {
        static $list = false;
        if ($list === false || $refresh == true)
        {
            $currency = new Currency();
            $list = $currency->get_full_list('name');
            $currency->retrieve('-99');
            if (is_array($list))
            {
                $list = array_merge(array($currency), $list);
            }
            else
            {
                $list = array($currency);
            }
        }
        return $list;
    }

    /**
     * Overriding display of value of currency because of currencies are not stored in app_list_strings
     *
     * @param array $layout_def
     * @return string for display
     */
    public function &displayListPlain($layout_def)
    {
        static $currencies;
        $value = $this->_get_list_value($layout_def);
        if (empty($currencies[$value]))
        {
            $currency = new Currency();
            $currency->retrieve($value);
            $currencies[$value] = $currency->symbol . ' ' . $currency->iso4217;
        }
        return $currencies[$value];
    }

    /**
     * Overriding sorting because of default currency is not present in DB
     *
     * @param array $layout_def
     * @return string for order by
     */
    public function queryOrderBy($layout_def)
    {
        $tmpList = self::getCurrenciesList();
        $list = array();
        foreach ($tmpList as $bean)
        {
            $list[$bean->id] = $bean->symbol . ' ' . $bean->iso4217;
        }

        $field_def = $this->reporter->all_fields[$layout_def['column_key']];
        if (!empty ($field_def['sort_on']))
        {
            $order_by = $layout_def['table_alias'].".".$field_def['sort_on'];
        }
        else
        {
            $order_by = $this->_get_column_select($layout_def);
        }

        if (empty ($layout_def['sort_dir']) || $layout_def['sort_dir'] == 'a')
        {
            $order_dir = "ASC";
        }
        else
        {
            $order_dir = "DESC";
        }
        return $this->reporter->db->orderByEnum($order_by, $list, $order_dir);
    }
}
