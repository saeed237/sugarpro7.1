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


require_once 'clients/base/api/ModuleApi.php';
require_once 'modules/Audit/Audit.php';

class AuditApi extends ModuleApi
{
    public function registerApiRest()
    {
        return array(
            'view_change_log' => array(
                'reqType' => 'GET',
                'path' => array('<module>','?', 'audit'),
                'pathVars' => array('module','record','audit'),
                'method' => 'viewChangeLog',
                'shortHelp' => 'View change log in record view',
                'longHelp' => 'include/api/help/audit_get_help.html',
            ),
        );
    }

    public function viewChangeLog($api, $args)
    {
        global $focus, $current_user;

        $this->requireArgs($args,array('module', 'record'));

        $focus = BeanFactory::getBean($args['module'], $args['record']);

        if (!$focus->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('no access to the bean');
        }

        $auditBean = BeanFactory::newBean('Audit');

        return array(
            'next_offset' => -1,
            'records' => $auditBean->getAuditLog($focus),
        );
    }
}
