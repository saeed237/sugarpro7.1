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
 * Portal visibility class replaces the team security restrictions for portal users
 * For non-portal users this class will not modify the query in any way.
 */
class SupportPortalVisibility extends SugarVisibility
{
    protected $wherePart = '';
    protected static $accountIds;

    /**
     * Pull the list of account id's for a particular contact, we can't cache this because
     * there are requirements about the account id's changing fairly often for a contact.
     */
    public function getAccountIds() 
    {
        if ( ! isset($this->accountIds) ) {
            $db = DBManagerFactory::getInstance();

            if ( !empty($_SESSION['contact_id']) ) {
                // Using a raw query here, if we attempt to load in a bean and relationships
                // we end up back here again trying to load the same data.
                $ret = $db->query("SELECT accounts_contacts.account_id FROM accounts_contacts INNER JOIN accounts ON accounts_contacts.account_id = accounts.id WHERE accounts_contacts.contact_id = '".$db->quote($_SESSION['contact_id'])."' AND accounts_contacts.deleted = 0 AND accounts.deleted = 0");
                $this->accountIds = array();
                while ( $row = $db->fetchByAssoc($ret) ) {
                    $this->accountIds[] = $row['account_id'];
                }
            } else {
                $this->accountIds = array();
            }
        }
        return $this->accountIds;
    }

    /**
     * This function is here so we can put all the rules in one local section and just have it return the part of the query for that particular type
     * @param $query string The query string (probably shouldn't need to modify it here, but just in case)
     * @param $queryType string Either 'from' or 'where' to match the two types we understand right now.
     * @return string What to append to the query
     */
    protected function addVisibilityPortal($query, $queryType) 
    {
        if ( empty($_SESSION['type']) || $_SESSION['type'] != 'support_portal' ) {
            $GLOBALS['log']->error("Not a portal user, but running through the portal visibility class.");
            return;
        }
        if ($this->bean->disable_row_level_security) {
            $GLOBALS['log']->debug("No portal security applied to module (row-level security disabled): ".$this->bean->module_dir);
            return;
        }


        $table_alias = $this->getOption('table_alias');
        if(empty($table_alias)) {
            $table_alias = $this->bean->table_name;
        }

        $accountIds = $this->getAccountIds();

        if ( !empty($accountIds) ) {
            $accountIn = "('".implode("','",$accountIds)."')";
        } else {
            // No accounts
            // According to the SQL specification this should never return any records
            $accountIn = "(NULL)";
        }
        // $_SESSION['contact_id']
        // $accountIds

        $queryPart = '';

        // The Portal Rules Of Visibility:
        switch ($this->bean->module_dir) {
            case 'Contacts':
                // Contacts: Any contact related to the account list
                // Special case, if there are no accounts in the list, at least allow them access to their own contact
                if ( count($accountIds) == 0 && !empty($_SESSION['contact_id']) ) {
                    if ( $queryType == 'where' ) {
                        $queryPart = " $table_alias.id = '".$_SESSION['contact_id']."' ";
                    }
                } else {
                    if ( $queryType == 'from' ) {
                        $this->bean->load_relationship('accounts');
                        $queryPart = $this->bean->accounts->getJoin(array('join_table_alias'=>'accounts_pv'))." AND accounts_pv.id IN $accountIn ";
                    }
                }
                break;
            case 'Accounts':
                // Accounts: Any account in the account list
                if ( $queryType == 'where' ) {
                    $queryPart = " $table_alias.id IN $accountIn ";
                }
                break;
            case 'Bugs':
                // Bugs: Any bug that has the portal_viewable flag set to true
                if ( $queryType == 'where' ) {
                }

                break;
            case 'KBDocuments':
                // KBDocuments: Any KBDocument where is_external_article = 1 AND ( exp_date is empty or > today ) AND status_id = Published
                if ( $queryType == 'where' ) { 
                    $queryPart = " {$table_alias}.is_external_article = 1 "
                        ."AND ( {$table_alias}.exp_date IS NULL OR {$table_alias}.exp_date > " . $GLOBALS['db']->now() . " ) "
                        ."AND ( {$table_alias}.active_date = " . $GLOBALS['db']->emptyValue('date') . " OR {$table_alias}.active_date < " . $GLOBALS['db']->now() . " ) "
                        ."AND {$table_alias}.status_id = 'Published' ";
                }

                break;
            case 'Notes':
                // Notes: Notes that are connected to a Case or a Bug that is connected to one of our Accounts and has the portal_flag set to true
                if ( $queryType == 'from' ) {
                    if ( !empty($accountIds) ) {
                        // Only add in this join if the user can see bugs related to cases
                        $this->bean->load_relationship('cases');
                        
                        $caseBean = BeanFactory::newBean('Cases');
                        $caseBean->load_relationship('accounts');
                        
                        $queryPart = $this->bean->cases->getJoin(array('join_table_alias'=>'cases_pv','join_type'=>' LEFT JOIN '));
                        $queryPart .= " ".$caseBean->accounts->getJoin(array('join_table_alias'=>'accounts_cases_pv','right_join_table_alias'=>'cases_pv','join_type' => ' LEFT JOIN '))." AND accounts_cases_pv.id IN $accountIn ";
                    }
                    $this->bean->load_relationship('bugs');
                    
                    $bugBean = BeanFactory::newBean('Bugs');

                    $queryPart .= " ".$this->bean->bugs->getJoin(array('join_table_alias'=>'bugs_pv','join_type'=>' LEFT JOIN '));

                } else if ( $queryType == 'where' ) {
                    if ( !empty($accountIds) ) {
                        $queryPart = " {$table_alias}.portal_flag = 1 AND ( bugs_pv.id IS NOT NULL OR accounts_cases_pv.id IS NOT NULL ) ";
                    } else {
                        $queryPart = " {$table_alias}.portal_flag = 1 AND bugs_pv.id IS NOT NULL ";
                    }
                }
                break;
            case 'Cases':
                // Cases: Any case that has the portal_viewable flag set to true and is related to the account list
            default:
                // Other: Same as cases, if there is no portal_viewable (or portal_viewable_c) field, it is not portal accessible
                $additionalPart = '';
                if ( $this->bean->module_dir == 'Cases' ) {
                    $portalEnabled = true;
                    $linkName = 'accounts';
                } else {
                    $portalEnabled = false;
                    // TODO: Currently custom modules are not supported in portal, but if they were, 
                    // it'd look a little something like this:
                    /*
                    // We have to find a portal_viewable field before this module will be viewable in the portal
                    if ( isset($this->bean->field_defs['portal_viewable']) ) {
                        $wherePart = " $table_alias.portal_viewable = 1 ";
                        $portalEnabled = true;
                    } else if ( isset($this->bean->field_defs['portal_viewable_c']) ) {
                        // Custom portal_viewable field... the table name is a bit of a mystery.
                        $wherePart = " {$table_alias}_cstm.portal_viewable_c = 1 ";
                        $portalEnabled = true;
                    }
                    if ( $portalEnabled && $queryType == 'from' ) {
                        // This is expensive, we need to find the link to the Accounts module that this random module uses
                        if ( isset($this->bean->field_defs['accounts']) ) {
                            $linkName = 'accounts';
                        } else {
                            // Couldn't find a link by that name
                            $portalEnabled = false;
                        }
                    }
                    */
                }
                
                if ( $portalEnabled ) {
                    if ( $queryType == 'from' ) {
                        $this->bean->load_relationship($linkName);
                        $queryPart = $this->bean->$linkName->getJoin(array('right_join_table_alias'=>$table_alias, 'join_table_alias'=>$linkName.'_pv'))." AND {$linkName}_pv.id IN $accountIn ";
                    } else if ( $queryType == 'where' ) {
                        $queryPart = $wherePart;
                    }
                } else {
                    // This module is not a default portal module, nor can I figure out how the portal visibility for this module works, so I am here to make sure they don't see anything.
                    if ( $queryType == 'where' ) {
                        $queryPart = ' 1=0 ';
                    }
                    
                }
                break;
        }
        
        return $queryPart;
    }

    public function addVisibilityFrom(&$query)
    {
        $query .= $this->addVisibilityPortal($query,'from');
        return;
    }

    public function addVisibilityWhere(&$query)
    {
        $queryPart = $this->addVisibilityPortal($query,'where');
        if ( !empty($query) && !empty($queryPart) ) {
            $query .= " AND ".$queryPart;
        } else if (!empty($queryPart)) {
            $query .= $queryPart;
        }
        return;
    }

    /**
     * Add Visibility to a SugarQuery Object
     * @param SugarQuery $sugarQuery
     * @param array $options
     * @return object|SugarQuery
     */
    public function addVisibilityFromQuery(SugarQuery $sugarQuery, $options = array())
    {
        $query = '';
        $join = $this->addVisibilityPortal($query, 'from');
        if(!empty($join)) {
            $sugarQuery->joinRaw($join);
        }
        return $sugarQuery;
    } 

    /**
     * Add Visibility to a SugarQuery Object
     * @param SugarQuery $sugarQuery
     * @param array $options
     * @return object|SugarQuery
     */
    public function addVisibilityWhereQuery(SugarQuery $sugarQuery, $options = array())
    {
        $where = $this->addVisibilityPortal('', 'where');
        if(!empty($where)) {
            $sugarQuery->whereRaw($where);
        }
        return $sugarQuery;
    }
}