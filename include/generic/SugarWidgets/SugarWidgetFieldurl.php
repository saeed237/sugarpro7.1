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


class SugarWidgetFieldURL extends SugarWidgetFieldVarchar
{
 	/* Display item as link
     * @param array $layout_def definition of field which we want to display as link
     * @return string html code
     */
    function displayList($layout_def) 
    {
        $urlValue = trim($this->_get_list_value($layout_def));
        return '<a target="_blank" href="' . $urlValue . '">' . $urlValue . "</a>";
    }
    
}
