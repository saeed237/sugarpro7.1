<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */


/**
 * Highlighter
 * @api
 */
class SugarSearchEngineHighlighter
{
    protected $_module;

    public static $preTag = '<strong>';
    public static $postTag = '</strong>';
    public static $fragmentSize = 20;
    public static $fragmentNumber = 2;

    public function __construct()
    {
    }

    /**
     * Setter for module name.
     *
     * @param $module
     */
    public function setModule($module)
    {
        $this->_module = $module;
    }

    public function processHighlightText(array $resultArray)
    {
        $ret = array();
        foreach ($resultArray as $field => $fragments) {
            $ret[$field] = array('text' => '', 'module' => $this->_module, 'label' => $this->getLabel($field));
            $first = true;
            foreach ($fragments as $fragment) {
                if (!$first) {
                    $ret[$field]['text'] .= '...' . $fragment;
                } else {
                    $ret[$field]['text'] = $fragment;
                }
                $first = false;
            }
        }

        return $ret;
    }

    public function getLabel($field)
    {
        if (empty($this->_module)) {
            return $field;
        } else {
            $tmpBean = BeanFactory::getBean($this->_module);
            $field_defs = $tmpBean->field_defs;
            $field_def = isset($field_defs[$field]) ? $field_defs[$field] : false;
            if ($field_def === false || (!isset($field_def['vname']) && !isset($field_def['label']))) {
                return $field;
            }

            return (isset($field_def['label'])) ? $field_def['label'] : $field_def['vname'];
        }
    }
}
