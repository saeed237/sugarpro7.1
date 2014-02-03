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


class MeetingsController extends SugarController
{
    protected function action_editView()
    {
        $this->view = 'edit';
       
        require_once "modules/Calendar/CalendarUtils.php";
        $editAllRecurrences = isset($_REQUEST['edit_all_recurrences']) ? $_REQUEST['edit_all_recurrences'] : false;
        $this->view_object_map['repeatData'] = CalendarUtils::getRepeatData($this->bean, $editAllRecurrences);
        
        return true;
    }
    
    protected function action_editAllRecurrences()
    {
        if (!empty($this->bean->repeat_parent_id)) {
            $id = $this->bean->repeat_parent_id;
        } else {
            $id = $this->bean->id;
        }
        header("Location: index.php?module=Meetings&action=EditView&record={$id}&edit_all_recurrences=true");
    }
    
    protected function action_removeAllRecurrences()
    {
        if (!empty($this->bean->repeat_parent_id)) {
            $id = $this->bean->repeat_parent_id;
            $this->bean->retrieve($id);
        } else {
            $id = $this->bean->id;
        }
        
        if (!$this->bean->ACLAccess('Delete')) {
            ACLController::displayNoAccess(true);
            sugar_cleanup(true);
        }
        
        require_once "modules/Calendar/CalendarUtils.php";
        CalendarUtils::markRepeatDeleted($this->bean);
        $this->bean->mark_deleted($id);
        
        header("Location: index.php?module=Meetings");
    }
}
