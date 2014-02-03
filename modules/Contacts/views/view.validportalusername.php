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
 * ContactsViewValidPortalUsername.php
 * 
 * This class overrides SugarView and provides an implementation for the ValidPortalUsername
 * method used for checking whether or not an existing portal user_name has already been assigned.
 * We take advantage of the MVC framework to provide this action which is invoked from
 * a javascript AJAX request.
 * 
 * @author Collin Lee
 * */
 
require_once('include/MVC/View/SugarView.php');

class ContactsViewValidPortalUsername extends SugarView 
{
 	/**
     * @see SugarView::process()
     */
    public function process() 
 	{
		$this->display();
 	}

 	/**
     * @see SugarView::display()
     */
    public function display()
    {
        if (!empty($_REQUEST['portal_name'])) {
            $portalUsername = $this->bean->db->quote($_REQUEST['portal_name']);
            $result = $this->bean->db->query("Select count(id) as total from contacts where portal_name = '$portalUsername' and deleted='0'");
            $total = 0;
            while($row = $this->bean->db->fetchByAssoc($result))
                $total = $row['total'];
            echo $total;
        }
        else
           echo '0';
 	}	
}