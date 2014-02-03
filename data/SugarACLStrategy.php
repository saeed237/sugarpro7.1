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
 * Base class for ACL implementations
 * @api
 */
abstract class SugarACLStrategy
{
    /**
     * Check access
     * @param string $module
     * @param string $view
     * @param array $context
     * @return bool has access?
     */
    abstract public function checkAccess($module, $view, $context);

    /**
     * Get current user from context
     * @param array $context
     * @return User|null Current user
     */
    public function getCurrentUser($context)
    {
        if(isset($context['user'])) {
            return $context['user'];
        }
        return isset($GLOBALS['current_user'])?$GLOBALS['current_user']:null;
    }

    /**
     * Get current user ID from context
     * @param array $context
     * @return string|null Current user ID
     */
    public function getUserID($context)
    {
        if(isset($context['user'])) {
            return $context['user']->id;
        }
        if(isset($context['user_id'])) {
            return $context['user_id'];
        }
        if(isset($GLOBALS['current_user'])) {
            return $GLOBALS['current_user']->id;
        }
        return null;
    }

    /**
     * Check access for the list of fields
     * @param string $module
     * @param array $field_list key=>value list of fields
     * @param string $action Action to check
     * @param array $context
     * @return array[boolean] Access for each field, array() means all allowed
     */
    public function checkFieldList($module, $field_list, $action, $context)
    {
        $result = array();
        foreach($field_list as $key => $field) {
            $result[$key] = $this->checkAccess($module, "field", $context + array("field" => $field, "action" => $action));
        }
        return $result;
    }

    /**
     * Get access for the list of fields
     * @param string $module
     * @param array $field_list key=>value list of fields
     * @param array $context
     * @return array[int] Access for each field, array() means all allowed
     */
    public function getFieldListAccess($module, $field_list, $context)
    {
        $result = array();
        foreach($field_list as $key => $field) {
            if($this->checkAccess($module, "field", $context + array("field" => $field, "action" => "edit"))) {
                $result[$key] = SugarACL::ACL_READ_WRITE;
            } else if($this->checkAccess($module, "field", $context + array("field" => $field, "action" => "detail"))) {
                $result[$key] = SugarACL::ACL_READ_ONLY;
            } else {
                $result[$key] = SugarACL::ACL_NO_ACCESS;
            }
        }
        return $result;
    }

    /**
     * Get user access for the list of actions
     * @param string $module
     * @param array $access_list List of actions
     * @returns array - List of access levels. Access levels not returned are assumed to be "all allowed".
     */
    public function getUserAccess($module, $access_list, $context)
    {
        // default implementation, specific ACLs can override
        $access = $access_list;
        // check 'access' first - if it's false all others will be false
        if(isset($access_list['access'])) {
            if(!$this->checkAccess($module, 'access', $context)) {
        	    foreach($access_list as $action => $value) {
        		    $access[$action] = false;
        	    }
        		return $access;
            }
            // no need to check it second time
            unset($access_list['access']);
        }
        foreach($access_list as $action => $value) {
        	if(!$this->checkAccess($module, $action, $context)) {
        		$access[$action] = false;
        	}
        }
        return $access;
    }

    /**
     * Fix up the ACL actions into a sanitized subset
     * @param string $actionToCheck Which access you are checking, for example: 'ListView', 'edit', 'Save'
     * @returns string The canonical version of that string, for example:       'list',     'edit', 'edit'
     */
    public static function fixUpActionName($actionToCheck)
    {
        if ( empty($actionToCheck) ) {
            return $actionToCheck;
        }
        $input = strtolower($actionToCheck);
        switch ($input)
        {
            case 'index':
            case 'listview':
            case 'subpanel':
                $output = 'list';
                break;
            case 'save':
            case 'popupeditview':
            case 'editview':
            case 'create':
                $output = 'edit';
                break;
            case 'read':
            case 'access':
            case 'detail':
            case 'detailview':
                $output = 'view';
                break;
            default:
                $output = $input;
        }

        return $output;
    }
    
    /**
     * Helper function to determine if a user is attempting to perform a write operation
     * @param string $view A view name as passed in to checkAccess, will be sanitized using fixUpActionName
     * @param array $context The additional context information passed in to checkAccess
     * @return bool This is a write operation
     */
    public function isWriteOperation($view, $context)
    {
        // Let's make it a little easier on ourselves and fix up the actions nice and quickly
        $action = self::fixUpActionName($view);
        if ( $action == 'field' ) {
            $action = self::fixUpActionName($context['action']);
        }

        if ( $action == 'edit' || $action == 'delete' || $action == 'import' || $action == 'massupdate' ) {
            return true;
        } else {
            return false;
        }
    }
}