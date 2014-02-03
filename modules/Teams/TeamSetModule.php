<?php


require_once('vendor/ytree/Tree.php');
require_once('vendor/ytree/Node.php');
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
/**

 */
class TeamSetModule extends SugarBean{
    /*
    * char(36) GUID
    */
    var $id;

    var $team_set_id;
    var $module_table_name;

    var $table_name = "team_sets_modules";
    var $object_name = "TeamSetModule";
    var $module_name = 'TeamSetModule';
    var $module_dir = 'Teams';
    var $disable_custom_fields = true;

    /**
    * Default constructor
    *
    */
    public function __construct(){
        parent::__construct();
        $this->disable_row_level_security =true;
    }

    public function save(){
        $sql = "SELECT id FROM $this->table_name WHERE team_set_id = '$this->team_set_id' AND module_table_name = '$this->module_table_name'";
        $result = $this->db->query($sql);
        $row = $this->db->fetchByAssoc($result);
        if (!$row){
            parent::save();
        }
    }
}
?>