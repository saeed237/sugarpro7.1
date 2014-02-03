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
 ********************************************************************************/

require_once('include/MVC/View/views/view.list.php');

class ViewNewsLetterList extends ViewList 
{    
    function processSearchForm()
    {
        // we have a query
        if(!empty($_SERVER['HTTP_REFERER']) && preg_match('/action=EditView/', $_SERVER['HTTP_REFERER'])) { // from EditView cancel
            $this->searchForm->populateFromArray($this->storeQuery->query);
        }
        else {
            $this->searchForm->populateFromRequest();
        }   
        $where_clauses = $this->searchForm->generateSearchWhere(true, $this->seed->module_dir);
        $where_clauses[] = "campaigns.campaign_type in ('NewsLetter')";
        if (count($where_clauses) > 0 )$this->where = '('. implode(' ) AND ( ', $where_clauses) . ')';
        $GLOBALS['log']->info("List View Where Clause: $this->where");


        echo $this->searchForm->display($this->headers);
    }
    
    /**
	 * @see SugarView::preDisplay()
	 */
	public function preDisplay() 
	{
        global $mod_strings;
        $mod_strings['LBL_MODULE_TITLE'] = $mod_strings['LBL_NEWSLETTER_TITLE'];
        $mod_strings['LBL_LIST_FORM_TITLE'] = $mod_strings['LBL_NEWSLETTER_LIST_FORM_TITLE'];
        parent::preDisplay();

    }        
}