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


require_once('include/MVC/View/views/view.detail.php');

class DocumentsViewDetail extends ViewDetail 
{
 	/**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
    	$params = array();
    	$params[] = $this->_getModuleTitleListParam($browserTitle);
    	$params[] = $this->bean->document_name;
    	
		return $params;
    }

    public function display()
 	{
	//check to see if the file field is empty.  This should not occur and would only happen when an error has ocurred during upload, or from db manipulation of record.
         if(empty($this->bean->filename)){
	    //print error to screen
            $this->errors[] = $GLOBALS['mod_strings']['ERR_MISSING_FILE'];
            $this->displayErrors();
         }


        parent::display();
    }
    
}
