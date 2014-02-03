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

 * Description: This file is used to override the default Meta-data EditView behavior
 * to provide customization specific to the Calls module.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/MVC/View/views/view.wirelesssave.php');

class CallsViewWirelesssave extends ViewWirelesssave {

 	protected function post_save()
    {
        // Bug 22326 - Handle special case of saving calls to leads and contacts
        if ( $this->return_module == 'Leads' ) {
            $this->bean->load_relationship('leads');
            $this->bean->leads->add($this->return_id);
        }
        if ( $this->return_module == 'Contacts' ) {
            $this->bean->load_relationship('contacts');
            $this->bean->contacts->add($this->return_id);
        }
        
        parent::post_save();
 	}
}
?>
