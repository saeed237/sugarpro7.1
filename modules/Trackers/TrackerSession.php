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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
require_once('data/SugarBean.php');

class TrackerSession extends SugarBean {

    var $module_dir = 'Trackers';
    var $module_name = 'TrackerSessions';
    var $object_name = 'tracker_sessions';
    var $table_name = 'tracker_sessions';
    var $acltype = 'TrackerSession';
    var $acl_category = 'TrackerSessions';
    var $disable_custom_fields = true;

    public function __construct() {
        global $dictionary;
        if(isset($this->module_dir) && isset($this->object_name) && !isset($GLOBALS['dictionary'][$this->object_name])){
            require('metadata/tracker_sessionsMetaData.php');
        }
        parent::__construct();
        $this->disable_row_level_security = true;
    }

    function bean_implements($interface){
        switch($interface){
            case 'ACL': return true;
        }
        return false;
    }
}
?>
