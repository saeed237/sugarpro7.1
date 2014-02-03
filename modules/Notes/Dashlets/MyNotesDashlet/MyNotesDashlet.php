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


require_once('include/Dashlets/DashletGeneric.php');


class MyNotesDashlet extends DashletGeneric { 
    function MyNotesDashlet($id, $def = null) {
        global $current_user, $app_strings, $dashletData;
		require('modules/Notes/Dashlets/MyNotesDashlet/MyNotesDashlet.data.php');
        
        parent::DashletGeneric($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_MY_NOTES_DASHLETNAME', 'Notes');
         
        $this->searchFields = $dashletData['MyNotesDashlet']['searchFields'];
        $this->columns = $dashletData['MyNotesDashlet']['columns'];
        
        $this->seedBean = BeanFactory::getBean('Notes');        
    }    
}
?>
