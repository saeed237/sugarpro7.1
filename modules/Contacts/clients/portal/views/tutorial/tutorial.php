<?php
//FILE SUGARCRM flav=ent
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$viewdefs['Contacts']['portal']['view']['tutorial'] = array(
    'record' => array( //Record layout is used for the Portal profile
        'version' => 1,
        'intro' => 'LBL_PORTAL_TOUR_PROFILE_INTRO',
        'content' => array(
            array(
                'name' => '.btn-primary[name="edit_button"]',
                'text' => 'LBL_PORTAL_TOUR_PROFILE_EDIT',
                'full' => true,
            ),
            array(
                'name' => '.record-label[data-name="preferred_language"]',
                'text' => 'LBL_PORTAL_TOUR_PROFILE_LANGUAGE',
                'full' => true,
            ),
            array(
                'name' => 'li#userActions',
                'text' => 'LBL_PORTAL_TOUR_PROFILE_RETURN',
                'full' => true,
            ),
        )
    ),
);
