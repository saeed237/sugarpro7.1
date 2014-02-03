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

* Description: Bug 40166. Need for return right join for campaign's target list relations.
* All Rights Reserved.
* Contributor(s): ______________________________________..
********************************************************************************/

require_once('data/Link2.php');

/**
 * @brief Bug #40166. Campaign Log Report will not display Contact/Account Names
 */
class ProspectLink extends Link2
{

    /**
     * This method changes join of any item to campaign through target list
     * if you want to use this join method you should add code below to your vardef.php
     * 'link_class' => 'ProspectLink',
     * 'link_file' => 'modules/Campaigns/ProspectLink.php'
     *
     * @see Link::getJoin method
     */
    public function getJoin($params, $return_array = false)
    {
        $join_type= ' INNER JOIN ';
        if (isset($params['join_type']))
        {
            $join_type = $params['join_type'];
        }
        $join = '';
        $bean_is_lhs=$this->_get_bean_position();

        if (
            $this->_relationship->relationship_type == 'one-to-many'
            && $bean_is_lhs
        )
        {
            $table_with_alias = $table = $this->_relationship->rhs_table;
            $key = $this->_relationship->rhs_key;
            $module = $this->_relationship->rhs_module;
            $other_table = (empty($params['left_join_table_alias']) ? $this->_relationship->lhs_table : $params['left_join_table_alias']);
            $other_key = $this->_relationship->lhs_key;
            $alias_prefix = $table;
            if (!empty($params['join_table_alias']))
            {
                $table_with_alias = $table. " ".$params['join_table_alias'];
                $table = $params['join_table_alias'];
                $alias_prefix = $params['join_table_alias'];
            }

            $join .= ' '.$join_type.' prospect_list_campaigns '.$alias_prefix.'_plc ON';
            $join .= ' '.$alias_prefix.'_plc.'.$key.' = '.$other_table.'.'.$other_key."\n";

            // join list targets
            $join .= ' '.$join_type.' prospect_lists_prospects '.$alias_prefix.'_plp ON';
            $join .= ' '.$alias_prefix.'_plp.prospect_list_id = '.$alias_prefix.'_plc.prospect_list_id AND';
            $join .= ' '.$alias_prefix.'_plp.related_type = '.$GLOBALS['db']->quoted($module)."\n";

            // join target
            $join .= ' '.$join_type.' '.$table_with_alias.' ON';
            $join .= ' '.$table.'.id = '.$alias_prefix.'_plp.related_id AND';
            $join .= ' '.$table.'.deleted=0'."\n";

            if ($return_array)
            {
                $ret_arr = array();
                $ret_arr['join'] = $join;
                $ret_arr['type'] = $this->_relationship->relationship_type;
                if ($bean_is_lhs)
                {
                    $ret_arr['rel_key'] = $this->_relationship->join_key_rhs;
                }
                else
                {
                    $ret_arr['rel_key'] = $this->_relationship->join_key_lhs;
                }
                return $ret_arr;
            }
            return $join;
        } else {
            return parent::getJoin($params, $return_array);
        }
    }
}
