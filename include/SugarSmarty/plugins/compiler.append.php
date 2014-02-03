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

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
function smarty_compiler_append($tag_attrs, &$compiler)
{
    $_params = $compiler->_parse_attrs($tag_attrs);

    if (!isset($_params['var'])) {
        $compiler->_syntax_error("assign: missing 'var' parameter", E_USER_WARNING);
        return;
    }

    if (!isset($_params['value'])) {
        $compiler->_syntax_error("assign: missing 'value' parameter", E_USER_WARNING);
        return;
    }

    return "\$this->append({$_params['var']}, {$_params['value']});";
}
