<?php
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


global $app_strings;

$menuDef['sugarPerson'] = array(
    array('text' => 'LBL_ADD_TO_FAVORITES', 
          'action' => 'SUGAR.contextMenu.actions.addToFavorites'),
    array('text' => 'LBL_CREATE_NOTE', 
          'action' => 'SUGAR.contextMenu.actions.createNote',
          'module' => 'Notes',
          'aclAction' => 'edit'),
    array('text' => 'LBL_CREATE_TASK', 
          'action' => 'SUGAR.contextMenu.actions.createTask',
          'module' => 'Tasks',
          'aclAction' => 'edit'),
    array('text' => 'LBL_SCHEDULE_MEETING', 
          'action' => 'SUGAR.contextMenu.actions.scheduleMeeting',
          'module' => 'Meetings',
          'aclAction' => 'edit'),
    array('text' => 'LBL_SCHEDULE_CALL', 
          'action' => 'SUGAR.contextMenu.actions.scheduleCall',
          'module' => 'Calls',
          'aclAction' => 'edit'),
    );

?>