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

require_once('data/SugarACLStrategy.php');

class SugarACLOAuthKeys extends SugarACLStrategy
{
    public $create_only_fields = array(
            'c_key' => true,
            'oauth_type' => true,
        );

    /**
     * Check access a current user has on Users and Employees
     * @param string $module
     * @param string $view
     * @param array $context
     * @return bool|void
     */
    public function checkAccess($module, $view, $context) {
        if ( $view == 'team_security' ) {
            // Let the other modules decide
            return true;
        }
        // Let's make it a little easier on ourselves and fix up the actions nice and quickly
        $view = SugarACLStrategy::fixUpActionName($view);
        if ( $view == 'field' ) {
            $context['action'] = SugarACLStrategy::fixUpActionName($context['action']);
        }

        // Other fields can only be edited when you create a record.
        if ( (!empty($context['bean']) && !empty($context['bean']->id)) && $view == 'field' && $context['action'] == 'edit' && isset($this->create_only_fields[$context['field']]) ) {
            return false;
        }

        // We can create without further restrictions
        if( (empty($context['bean']) || empty($context['bean']->id) || $context['bean']->new_with_id == true) && $view == 'edit' || ( $view == 'field' && $context['action'] == 'edit') ) {
            return true;
        }

        // Some c_keys are special, they can't edit them, but if they really want to delete them we will allow it
        if ( isset($context['bean']) && is_a($context['bean'],'SugarBean') ) {
            if( $view == 'edit' || ( isset($context['action']) && $context['action'] == 'edit' ) ) {
                if ( $context['bean']->c_key == 'sugar' || $context['bean']->c_key == 'support_portal' ) {
                    return false;
                }
            }
        }

        return true;
    }
}
