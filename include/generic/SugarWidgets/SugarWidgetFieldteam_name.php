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




class SugarWidgetFieldteam_name extends SugarWidgetFieldname
{
 function displayInput(&$layout_def) 
 {
        $selected_teams = empty($layout_def['input_name0']) ? '' : $layout_def['input_name0'];
 		$str = '<select multiple="true" size="3" name="' . $layout_def['name'] . '[]">' . get_select_options_with_id(get_team_array(false), $selected_teams) . '</select>';
 		return $str;
 }
    public function queryFilterone_of($layout_def, $rename_columns = true)
    {
        if($layout_def['name'] == 'team_id')
        {
            $ids = array();
            $db = DBManagerFactory::getInstance();
            foreach($layout_def['input_name0'] as $value)
            {
                array_push($ids, $db->quoted($value));
            }
            $query = 'select team_set_id from team_sets_teams where team_id IN (' . implode(', ', $ids) . ') group by team_set_id';
            $ids = array();
            $result = $db->query($query, true);
            while($row = $db->fetchByAssoc($result))
            {
                array_push($ids, $db->quoted($row['team_set_id']));
            }
            $layout_def['name'] = 'team_set_id';
            if(count($ids) == 0)
            {
                array_push($ids, '-1');
            }
            return $this->_get_column_select($layout_def) . ' IN (' . implode(', ', $ids) . ') ';

        }
        else
        {
            return parent::queryFilterone_of($layout_def, $rename_columns);
        }
    }

    public function queryFilterStarts_With(&$layout_def)
    {
        if($layout_def['name'] == 'team_id')
        {
            $db = DBManagerFactory::getInstance();
            $query = "select team_set_id from team_sets_teams where team_id LIKE {$db->quoted($layout_def['input_name0'] . '%')} group by team_set_id";
            $ids = array();
            $result = $db->query($query, true);
            while($row = $db->fetchByAssoc($result))
            {
                array_push($ids, $db->quoted($row['team_set_id']));
            }
            $layout_def['name'] = 'team_set_id';
            if(count($ids) == 0)
            {
                array_push($ids, '-1');
            }
            return $this->_get_column_select($layout_def) . ' IN (' . implode(', ', $ids) . ') ';
        }
        else
        {
            return parent::queryFilterStarts_With($layout_def);
        }
    }
}

?>
