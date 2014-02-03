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


require_once('modules/Campaigns/utils.php');
require_once('clients/base/api/ModuleApi.php');

class LeadsApi extends ModuleApi {
    public function registerApiRest() {
        return array(
            'create' => array(
                'reqType' => 'POST',
                'path' => array('Leads'),
                'pathVars' => array('module'),
                'method' => 'createRecord',
                'shortHelp' => 'This method creates a new Lead record with option to add Target & Email relationships',
                'longHelp' => 'modules/Leads/api/help/LeadsApi.html',
            ),
        );
    }

    /**
     * Create the lead record and optionally perform post-save actions for Convert Target & Lead from Email cases
     */
    public function createRecord($api, $args) {
        //create the lead using the ModuleApi
        $data = parent::createRecord($api, $args);

        $leadId = null;
        if (isset($data['id']) && !empty($data['id'])) {
            $leadId = $data['id'];
        } else {
            //lead not created, can't do post-processes - bail out
            return $data;
        }

        //handle Convert Target/Prospect use case
        if (isset($args['prospect_id']) && !empty($args['prospect_id'])) {
            $campaignId = (isset($data['campaign_id'])) ? $data['campaign_id'] : null;
            $this->convertProspect($args['prospect_id'], $leadId, $campaignId);
        }

        //handle Create Lead from Email use case
        if (isset($args['inbound_email_id']) && !empty($args['inbound_email_id'])) {
            $this->linkLeadToEmail($args['inbound_email_id'], $leadId);
        }

        return $data;
    }

    /**
     * Convert Target/Prospect to a Lead by linking the lead to the prospect
     * and creating a campaign log entry if newly created Lead is related to a campaign.
     * TODO: This logic is brought over from LeadFormBase->handleSave() - need refactoring to use Link2?
     *
     * @param $prospectId
     * @param $leadId
     * @param null $campaignId
     */
    protected function convertProspect($prospectId, $leadId, $campaignId = null) {
        $prospect = new Prospect();
        $prospect->retrieve($prospectId);
        $prospect->lead_id = $leadId;
        // Set to keep email in target
        $prospect->in_workflow = true;
        $prospect->save();

        if (!empty($campaignId)) {
            $lead = new Lead();
            $lead->id = $leadId;
            campaign_log_lead_or_contact_entry($campaignId, $prospect, $lead, 'lead');
        }
    }

    /**
     * Link the Lead to the Email from which the lead was created
     * Also set the assigned user to current user and mark email as read.
     * TODO: This logic is brought over from LeadFormBase->handleSave() - need refactoring to use Link2?
     *
     * @param $emailId
     * @param $leadId
     */
    protected function linkLeadToEmail($emailId, $leadId) {
        global $current_user;

        $email = new Email();
        $email->retrieve($emailId);
        $email->parent_type = 'Leads';
        $email->parent_id = $leadId;
        $email->assigned_user_id = $current_user->id;
        $email->status = 'read';
        $email->save();

        $email->load_relationship('leads');
        $email->leads->add($leadId);
    }

    protected function getAccountBean($api, $args, $record)
    {
        // Load up the relationship
        if (!$record->load_relationship('accounts')) {
            throw new SugarApiExceptionNotFound('Could not find a relationship name accounts');
        }

        // Figure out what is on the other side of this relationship, check permissions
        $linkModuleName = $record->accounts->getRelatedModuleName();
        $linkSeed = BeanFactory::newBean($linkModuleName);
        if (!$linkSeed->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$linkModuleName);
        }

        $accounts = $record->accounts->query(array());
        foreach ($accounts['rows'] as $accountId => $value) {
            $account = BeanFactory::getBean('Accounts', $accountId);
            if (empty($account)) {
                throw new SugarApiExceptionNotFound('Could not find parent record '.$accountId.' in module Accounts');
            }
            if (!$account->ACLAccess('view')) {
                throw new SugarApiExceptionNotAuthorized('No access to view records for module: Accounts');
            }

            // Only one account, so we can return inside the loop.
            return $account;
        }
    }

    protected function getAccountRelationship($api, $args, $account, $relationship, $limit = 5, $query = array())
    {
        // Load up the relationship
        if (!$account->load_relationship($relationship)) {
            // The relationship did not load, I'm guessing it doesn't exist
            throw new SugarApiExceptionNotFound('Could not find a relationship name ' . $relationship);
        }
        // Figure out what is on the other side of this relationship, check permissions
        $linkModuleName = $account->$relationship->getRelatedModuleName();
        $linkSeed = BeanFactory::newBean($linkModuleName);
        if (!$linkSeed->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$linkModuleName);
        }

        $relationshipData = $account->$relationship->query($query);
        $rowCount = 1;

        $data = array();
        foreach ($relationshipData['rows'] as $id => $value) {
            $rowCount++;
            $bean = BeanFactory::getBean(ucfirst($relationship), $id);
            $data[] = $this->formatBean($api, $args, $bean);
            if (!is_null($limit) && $rowCount == $limit) {
                // We have hit our limit.
                break;
            }
        }
        return $data;
    }

}
