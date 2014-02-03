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


// Activity stream.
$activitystream = array(
    1,
    'activitystream',
    'modules/ActivityStream/Activities/ActivityQueueManager.php',
    'ActivityQueueManager',
    'eventDispatcher',
);
$hook_array['after_save'][] = $activitystream;
$hook_array['after_delete'][] = $activitystream;
$hook_array['after_undelete'][] = $activitystream;
$hook_array['after_relationship_add'][] = $activitystream;
$hook_array['after_relationship_delete'][] = $activitystream;
unset($activitystream);
