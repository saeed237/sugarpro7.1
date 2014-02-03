<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

require_once('clients/base/api/ModuleApi.php');

class CasesApi extends ModuleApi
{
    public function registerApiRest()
    {
        return array(
            'create' => array(
                'reqType'   => 'POST',
                'path'      => array('Cases'),
                'pathVars'  => array('module'),
                'method'    => 'createRecord',
                'shortHelp' => 'This method creates a new Case record with option to add Contact and Account relationships',
                'longHelp'  => 'modules/Cases/api/help/CasesApi.html',
            ),
        );
    }

    /**
     * Create the case record and optionally perform post-save actions for Portal
     */

    public function createRecord($api, $args)
    {
        //create the case using the ModuleApi

        $contact = null;
        if (isset($_SESSION['type']) && $_SESSION['type'] == 'support_portal') {
            $contact = BeanFactory::getBean('Contacts', $_SESSION['contact_id'], array('strict_retrieve' => true));

            if (!empty($contact)) {
                $args['assigned_user_id'] = $contact->assigned_user_id;
                $args['account_id']       = $contact->account_id;
                $args['team_id']     = $contact->fetched_row['team_id'];
                $args['team_set_id'] = $contact->fetched_row['team_set_id'];
            }
        }

        $data = parent::createRecord($api, $args);

        $caseId = null;
        if (isset($data['id']) && !empty($data['id'])) {
            $caseId = $data['id'];
        } else {
            //case not created, can't do post-processes - bail out
            return $data;
        }

        if (!empty($caseId) && !empty($contact)) {
            $case = BeanFactory::getBean('Cases', $caseId);
            $case->load_relationship('contacts');
            $case->contacts->add($contact->id);
        }

        return $data;
    }
}
