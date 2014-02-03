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


class SugarWidgetFieldRelate extends SugarWidgetReportField
{
    /**
     * Method returns HTML of input on configure dashlet page
     *
     * @param array $layout_def definition of a field
     * @return string HTML of select for edit page
     */
    public function displayInput($layout_def)
    {
        $values = array();
        if (is_array($layout_def['input_name0']))
        {
            $values = $layout_def['input_name0'];
        }
        else
        {
            $values[] = $layout_def['input_name0'];
        }
        $html = '<select name="' . $layout_def['name'] . '[]" multiple="true">';

        $query = $this->displayInputQuery($layout_def);
        $result = $this->reporter->db->query($query);
        while ($row = $this->reporter->db->fetchByAssoc($result))
        {
            $html .= '<option value="' . $row['id'] . '"';
            if (in_array($row['id'], $values))
            {
                $html .= ' selected="selected"';
            }
            $html .= '>' . htmlspecialchars($row['title']) . '</option>';
        }

        $html .= '</select>';
        return $html;
    }

    /**
     * Method returns database query for generation HTML of input on configure dashlet page
     *
     * @param array $layout_def definition of a field
     * @return string database query HTML of select for edit page
     */
    private function displayInputQuery($layout_def)
    {
        $title = $layout_def['rname'];
        if (isset($layout_def['db_concat_fields'])) {
            $title = $this->reporter->db->concat($layout_def['table'], $layout_def['db_concat_fields']);
        }

        $query = "SELECT
                id,
                $title title
            FROM {$layout_def['table']}
            WHERE deleted = 0
            ORDER BY title ASC";
        return $query;
    }

    /**
     * Method returns part of where in style table_alias.id IN (...) because we can't join of relation
     *
     * @param array $layout_def definition of a field
     * @param bool $rename_columns unused
     * @return string SQL where part
     */
    public function queryFilterStarts_With($layout_def, $rename_columns = true)
    {
        $ids = array();

        $relation = BeanFactory::getBean('Relationships');
        $relation->retrieve_by_name($layout_def['link']);
        $seed = BeanFactory::getBean($relation->lhs_module, $layout_def['input_name0']);

        $link = new Link2($layout_def['link'], $seed);
        $sql = $link->getQuery();
        $result = $this->reporter->db->query($sql);
        while ($row = $this->reporter->db->fetchByAssoc($result))
        {
            $ids[] = $row['id'];
        }
        $layout_def['name'] = 'id';
        return $this->_get_column_select($layout_def) . " IN ('" . implode("', '", $ids) . "')";
    }

    /**
     * Method returns part of where in style table_alias.id IN (...) because we can't join of relation
     *
     * @param array $layout_def definition of a field
     * @param bool $rename_columns unused
     * @return string SQL where part
     */
    public function queryFilterone_of($layout_def, $rename_columns = true)
    {
        $ids = array();

        $relation = BeanFactory::getBean('Relationships');
        $relation->retrieve_by_name($layout_def['link']);

        $seed = BeanFactory::getBean($relation->lhs_module);

        foreach($layout_def['input_name0'] as $beanId)
        {
            $seed->retrieve($beanId);

            $link = new Link2($layout_def['link'], $seed);
            $sql = $link->getQuery();
            $result = $this->reporter->db->query($sql);
            while ($row = $this->reporter->db->fetchByAssoc($result))
            {
                $ids[] = $row['id'];
            }
        }
        $ids = array_unique($ids);
        $layout_def['name'] = 'id';
        return $this->_get_column_select($layout_def) . " IN ('" . implode("', '", $ids) . "')";
    }

	//for to_pdf/to_csv
	function displayListPlain($layout_def) {
	    $reporter = $this->layout_manager->getAttribute("reporter");
		$field_def = $reporter->all_fields[$layout_def['column_key']];
		$display = strtoupper($field_def['secondary_table'].'_name');
		//#31797  , we should get the table alias in a global registered array:selected_loaded_custom_links
		if(!empty($reporter->selected_loaded_custom_links) && !empty($reporter->selected_loaded_custom_links[$field_def['secondary_table']])){
			$display = strtoupper($reporter->selected_loaded_custom_links[$field_def['secondary_table']]['join_table_alias'].'_name');
		}
        elseif(isset($field_def['rep_rel_name']) && isset($reporter->selected_loaded_custom_links) && !empty($reporter->selected_loaded_custom_links[$field_def['secondary_table'].'_'.$field_def['rep_rel_name']]))
        {
            $display = strtoupper($reporter->selected_loaded_custom_links[$field_def['secondary_table'].'_'.$field_def['rep_rel_name']]['join_table_alias'].'_name');
        }
		elseif(!empty($reporter->selected_loaded_custom_links) && !empty($reporter->selected_loaded_custom_links[$field_def['secondary_table'].'_'.$field_def['name']])){
			$display = strtoupper($reporter->selected_loaded_custom_links[$field_def['secondary_table'].'_'.$field_def['name']]['join_table_alias'].'_name');
		}
		$cell = $layout_def['fields'][$display];
		return $cell;
	}

    function displayList($layout_def) {
        $reporter = $this->layout_manager->getAttribute("reporter");
        $field_def = $reporter->all_fields[$layout_def['column_key']];
        $display = strtoupper($field_def['secondary_table'].'_name');

        //#31797  , we should get the table alias in a global registered array:selected_loaded_custom_links
        if(!empty($reporter->selected_loaded_custom_links) && !empty($reporter->selected_loaded_custom_links[$field_def['secondary_table']])){
             $display = strtoupper($reporter->selected_loaded_custom_links[$field_def['secondary_table']]['join_table_alias'].'_name');
        }
        elseif(isset($field_def['rep_rel_name']) && isset($reporter->selected_loaded_custom_links) && !empty($reporter->selected_loaded_custom_links[$field_def['secondary_table'].'_'.$field_def['rep_rel_name']]))
        {
            $display = strtoupper($reporter->selected_loaded_custom_links[$field_def['secondary_table'].'_'.$field_def['rep_rel_name']]['join_table_alias'].'_name');
        }
        elseif(!empty($reporter->selected_loaded_custom_links) && !empty($reporter->selected_loaded_custom_links[$field_def['secondary_table'].'_'.$field_def['name']])){
            $display = strtoupper($reporter->selected_loaded_custom_links[$field_def['secondary_table'].'_'.$field_def['name']]['join_table_alias'].'_name');
        }
        $recordField = $this->getTruncatedColumnAlias(strtoupper($layout_def['table_alias']).'_'.strtoupper($layout_def['name']));

        $record = $layout_def['fields'][$recordField];
        $cell = "<a target='_blank' class=\"listViewTdLinkS1\" href=\"index.php?action=DetailView&module=".$field_def['ext2']."&record=$record\">";
        $cell .= $layout_def['fields'][$display];
        $cell .= "</a>";
        return $cell;
    }
}

?>
