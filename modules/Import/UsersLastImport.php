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

 * Description: Bean class for the users_last_import table
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/


require_once('modules/Import/Forms.php');

class UsersLastImport extends SugarBean
{
    /**
     * Fields in the table
     */
    public $id;
    public $assigned_user_id;
    public $import_module;
    public $bean_type;
    public $bean_id;
    public $deleted;

    /**
     * Set the default settings from Sugarbean
     */
    public $module_dir = 'Import';
    public $table_name = "users_last_import";
    public $object_name = "UsersLastImport";
    var $disable_custom_fields = true;
    public $column_fields = array(
        "id",
        "assigned_user_id",
        "bean_type",
        "bean_id",
        "deleted"
        );
    public $new_schema = true;
    public $additional_column_fields = Array();

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->disable_row_level_security =true;
    }

    /**
     * Extends SugarBean::listviewACLHelper
     *
     * @return array
     */
    public function listviewACLHelper()
    {
        $array_assign = parent::listviewACLHelper();
        $is_owner = false;
        if ( !ACLController::moduleSupportsACL('Accounts')
                || ACLController::checkAccess('Accounts', 'view', $is_owner) ) {
            $array_assign['ACCOUNT'] = 'a';
        }
        else {
            $array_assign['ACCOUNT'] = 'span';
        }
        return $array_assign;
    }

    /**
     * Delete all the records for a particular user
     *
     * @param string $user_id user id of the user doing the import
     */
    public function mark_deleted_by_user_id($user_id)
    {
        $query = "DELETE FROM $this->table_name WHERE assigned_user_id = '$user_id'";
        $this->db->query($query,true,"Error marking last imported records deleted: ");
    }

    /**
     * Undo a single record
     *
     * @param string $id specific users_last_import id to undo
     */
    public function undoById($id)
    {
        global $current_user;

        $query1 = "SELECT bean_id, bean_type FROM users_last_import WHERE assigned_user_id = '$current_user->id'
                   AND id = '$id' AND deleted=0";

        $result1 = $this->db->query($query1);
        if ( !$result1 )
            return false;

        while ( $row1 = $this->db->fetchByAssoc($result1))
            $this->_deleteRecord($row1['bean_id'],$row1['bean_type']);

        return true;
    }

    /**
     * Undo an import
     *
     * @param string $module  module being imported into
     */
    public function undo($module)
    {
        global $current_user;

        $query1 = "SELECT bean_id, bean_type FROM users_last_import WHERE assigned_user_id = '$current_user->id'
                   AND import_module = '$module' AND deleted=0";

        $result1 = $this->db->query($query1);
        if ( !$result1 )
            return false;

        while ( $row1 = $this->db->fetchByAssoc($result1))
            $this->_deleteRecord($row1['bean_id'],$row1['bean_type']);

        return true;
    }

    /**
     * Deletes a record in a bean
     *
     * @param $bean_id
     * @param $module
     */
    protected function _deleteRecord($bean_id,$module)
    {
        static $focus;

        // load bean
        if ( !( $focus instanceof $module) ) {
            $focus = BeanFactory::newBeanByName($module);
        }

        $result = $this->db->query(
            "DELETE FROM {$focus->table_name}
                WHERE id = '{$bean_id}'"
            );
        if (!$result)
            return false;
        // Bug 26318: Remove all created e-mail addresses ( from jchi )
        $result2 = $this->db->query(
            "SELECT email_address_id
                FROM email_addr_bean_rel
                WHERE email_addr_bean_rel.bean_id='{$bean_id}'
                    AND email_addr_bean_rel.bean_module='{$focus->module_dir}'");
        $this->db->query(
            "DELETE FROM email_addr_bean_rel
                WHERE email_addr_bean_rel.bean_id='{$bean_id}'
                    AND email_addr_bean_rel.bean_module='{$focus->module_dir}'"
            );

        while ( $row2 = $this->db->fetchByAssoc($result2)) {
            if ( !$this->db->getOne(
                    "SELECT email_address_id
                        FROM email_addr_bean_rel
                        WHERE email_address_id = '{$row2['email_address_id']}'") )
                $this->db->query(
                    "DELETE FROM email_addresses
                        WHERE id = '{$row2['email_address_id']}'");
        }

        if ($focus->hasCustomFields())
            $this->db->query(
                "DELETE FROM {$focus->table_name}_cstm
                    WHERE id_c = '{$bean_id}'");
    }

    /**
     * Get a list of bean types created in the import
     *
     * @param string $module  module being imported into
     */
    public static function getBeansByImport($module)
    {
        global $current_user;

        $query1 = "SELECT DISTINCT bean_type FROM users_last_import WHERE assigned_user_id = '$current_user->id'
                   AND import_module = '$module' AND deleted=0";

        $result1 = $GLOBALS['db']->query($query1);
        if ( !$result1 )
            return array($module);

        $returnarray = array();
        while ( $row1 = $GLOBALS['db']->fetchByAssoc($result1))
            $returnarray[] = $row1['bean_type'];

        return $returnarray;
    }

}
?>
