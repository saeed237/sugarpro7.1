<?php
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

class LeadConvert
{
    const STATUS_CONVERTED = 'Converted';
    protected $fileName = "modules/Leads/clients/base/layouts/convert-main/convert-main.php";
    protected $modules;
    protected $lead;
    protected $contact;
    protected $defs;

    public function __construct($leadId)
    {
        $this->initialize($leadId);
    }

    public function initialize($leadId)
    {
        $this->defs = $this->getVarDefs();

        if (empty($this->defs)) {
            throw new Exception('Could not retrieve lead convert metadata.');
        }

        $this->lead = BeanFactory::getBean('Leads', $leadId, array('strict_retrieve' => true));

        if (empty($this->lead)) {
            $errorMessage = string_format('Could not find record: {0} in module: Leads', $leadId);
            throw new Exception($errorMessage);
        }
    }

    /**
     * Returns the list of available modules that can be used during the lead convert process.
     * @return array modules
     */
    public function getAvailableModules()
    {
        $modules = array();
        foreach ($this->defs as $moduleDef) {
            $modules[] = $moduleDef['module'];
        }
        return $modules;
    }

    /**
     * Converts the Lead to a Contact and associates other modules to both lead and contact.
     * @param $modules Array of SugarBeans
     * @return array modules
     */
    public function convertLead($modules)
    {
        $this->modules = $modules;
        if (isset($this->modules['Contacts'])) {
            $this->contact = $this->modules['Contacts'];
        }

        foreach ($this->defs as $moduleDef) {
            $moduleName = $moduleDef['module'];
            if (!isset($this->modules[$moduleName])) {
                continue;
            }

            if ($moduleName != "Contacts" && $this->contact !=null && $this->contact instanceof Contact) {
                $this->setRelationshipsForModulesToContacts($moduleDef);
            }

            if ($this->modules[$moduleName]->object_name == 'Opportunity' && empty($this->modules[$moduleName]->account_id)) {
                $this->updateOpportunityWithAccountInformation($moduleDef);
            }
            $this->setAssignedForModulesToLeads($moduleDef);
            $this->setRelationshipForModulesToLeads($moduleDef);

            $this->modules[$moduleName]->save();
        }

        if($this->contact != null && $this->contact instanceof Contact) {
            $this->contact->save();
            $this->addLogForContactInCampaign();
        }

        $this->lead->status = LeadConvert::STATUS_CONVERTED;
        $this->lead->converted = 1;
        $this->lead->in_workflow = true;
        $this->lead->save();

        return $this->modules;
    }

    /**
     * Update the opportunity with account id and name
     *
     * @param $moduleDef
     */
    public function updateOpportunityWithAccountInformation($moduleDef) {
        $moduleName = $moduleDef['module'];
        if (isset($this->modules['Accounts'])) {
            $this->modules[$moduleName]->account_id = $this->modules['Accounts']->id;
            $this->modules[$moduleName]->account_name = $this->modules['Accounts']->name;
        }
    }
    /**
     * Sets the relationships for modules to the Contacts module
     * @return null
     */
    public function setRelationshipsForModulesToContacts($moduleDef)
    {
        $moduleName = $moduleDef['module'];
        $contactRel = "";
        $relate = "";

        if (isset($moduleDef['contactRelateField']) && !empty($moduleDef['contactRelateField'])) {
            $relate = $moduleDef['contactRelateField'];
            $fieldDef = $this->contact->field_defs[$relate];
            if (!empty($fieldDef['id_name'])) {
                $this->contact->$fieldDef['id_name'] = $this->modules[$moduleName]->id;
                if ($fieldDef['id_name'] != $relate) {
                    $rname = isset($fieldDef['rname']) ? $fieldDef['rname'] : "";
                    if (!empty($rname) && isset($this->modules[$moduleName]->$rname))
                        $this->contact->$relate = $this->modules[$moduleName]->$rname;
                    else
                        $this->contact->$relate = $this->modules[$moduleName]->name;
                }
            }
        }
        else {
            $contactRel = $this->findRelationship($this->contact, $this->modules[$moduleName]);
            if (!empty($contactRel)) {
                $this->contact->load_relationship($contactRel);
                $relObject = $this->contact->$contactRel->getRelationshipObject();
                if ($relObject->relationship_type == "one-to-many" && $this->contact->$contactRel->_get_bean_position()) {
                    $id_field = $relObject->rhs_key;
                    $this->modules[$moduleName]->$id_field = $this->contact->id;
                } else {
                    $this->contact->$contactRel->add($this->modules[$moduleName]);
                }
            }
        }
    }

    /**
     * Sets the assigned team and user based on the leads module
     * @return null
     */
    protected function setAssignedForModulesToLeads($moduleDef)
    {
        $moduleName = $moduleDef['module'];
        if (!empty($this->lead)) {
            if (empty($this->modules[$moduleName]->team_name)) {
                $this->modules[$moduleName]->team_id = $this->lead->team_id;
                $this->modules[$moduleName]->team_set_id = $this->lead->team_set_id;
            }
            if (empty($this->modules[$moduleName]->assigned_user_id)) {
                $this->modules[$moduleName]->assigned_user_id = $this->lead->assigned_user_id;
            }
        }
    }

    /**
     * Sets the relationships for modules to the Lead module
     * @return null
     */
    public function setRelationshipForModulesToLeads($moduleDef)
    {
        $moduleName = $moduleDef['module'];
        if (!empty($this->lead)) {
            $leadsRel = $this->findRelationship($this->modules[$moduleName], $this->lead);
            if (!empty($leadsRel)) {
                $this->modules[$moduleName]->load_relationship($leadsRel);
                $relObject = $this->modules[$moduleName]->$leadsRel->getRelationshipObject();

                if ($relObject->relationship_type == "one-to-many" && $this->modules[$moduleName]->$leadsRel->_get_bean_position()) {
                    $id_field = $relObject->rhs_key;
                    $this->lead->$id_field = $this->modules[$moduleName]->id;
                }
                else {
                    $this->modules[$moduleName]->$leadsRel->add($this->lead->id);
                }
            }
        }
    }

    /**
     * If campaign id exists then there should be an entry in campaign_log table for the newly created contact: bug 44522
     * @return null
     */
    public function addLogForContactInCampaign()
    {
        if (isset($this->lead->campaign_id) && $this->lead->campaign_id != null && isset($this->contact)) {
            $this->addCampaignLog($this->lead->campaign_id, $this->lead, $this->contact, 'contact');
        }
    }

    protected function addCampaignLog($campaignId, $lead, $contact, $moduleName)
    {
        return campaign_log_lead_or_contact_entry($campaignId, $lead, $contact, $moduleName);
    }

    /**
     * Loads the var def for the convert lead
     * @return null
     */
    protected function getVarDefs()
    {
        $viewdefs = array();
        $metaDataFile = SugarAutoLoader::existingCustomOne($this->fileName);
        require_once($metaDataFile);
        return $viewdefs['Leads']['base']['layout']['convert-main']['modules'];
    }

    /**
     * Finds the relationship between two modules and returns the relationship key
     * @return string
     */
    public function findRelationship($from, $to)
    {
        $dictionary = $this->getMetaTableDictionary();

        foreach ($from->field_defs as $field => $def) {
            if (isset($def['type']) && $def['type'] == "link" && isset($def['relationship'])) {
                $rel_name = $def['relationship'];
                $rel_def = "";
                if (isset($dictionary[$from->object_name]['relationships']) && isset($dictionary[$from->object_name]['relationships'][$rel_name])) {
                    $rel_def = $dictionary[$from->object_name]['relationships'][$rel_name];
                }
                else if (isset($dictionary[$to->object_name]['relationships']) && isset($dictionary[$to->object_name]['relationships'][$rel_name])) {
                    $rel_def = $dictionary[$to->object_name]['relationships'][$rel_name];
                }
                else if (isset($dictionary[$rel_name]) && isset($dictionary[$rel_name]['relationships'])
                    && isset($dictionary[$rel_name]['relationships'][$rel_name])
                ) {
                    $rel_def = $dictionary[$rel_name]['relationships'][$rel_name];
                }
                if (!empty($rel_def)) {
                    if ($rel_def['lhs_module'] == $from->module_dir && $rel_def['rhs_module'] == $to->module_dir) {
                        return $field;
                    }
                    else if ($rel_def['rhs_module'] == $from->module_dir && $rel_def['lhs_module'] == $to->module_dir) {
                        return $field;
                    }
                }
            }
        }
        return false;
    }

    public function getMetaTableDictionary()
    {
        global $dictionary;
        require_once("modules/TableDictionary.php");
        return $dictionary;
    }

    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    public function getContact()
    {
        return $this->contact;
    }

    public function setLead($lead)
    {
        $this->lead = $lead;
    }

    public function getLead()
    {
        return $this->lead;
    }

    public function setModules($modules)
    {
        $this->modules = $modules;
    }

    public function getModules()
    {
        return $this->modules;
    }
}
