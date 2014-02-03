<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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


// Opportunity is used to store customer information.
class Opportunity extends SugarBean
{
    const STAGE_CLOSED_WON = 'Closed Won';
    const STAGE_CLOSED_LOST = 'Closed Lost';

    const STATUS_NEW = 'New';
    const STATUS_IN_PROGRESS = 'In Progress';
    const STATUS_CLOSED_WON = 'Closed Won';
    const STATUS_CLOSED_LOST = 'Closed Lost';

    public $field_name_map;
    // Stored fields
    public $id;
    public $lead_source;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $assigned_user_id;
    public $created_by;
    public $created_by_name;
    public $modified_by_name;
    public $description;
    public $name;
    public $opportunity_type;
    public $amount;
    public $amount_usdollar;
    public $currency_id;
    public $base_rate;
    public $date_closed;
    public $date_closed_timestamp;
    public $next_step;
    public $sales_stage;
    public $sales_status;
    public $probability;
    public $campaign_id;
    public $team_name;
    public $team_id;
    public $quote_id;

    // These are related
    public $account_name;
    public $account_id;
    public $contact_id;
    public $task_id;
    public $note_id;
    public $meeting_id;
    public $call_id;
    public $email_id;
    public $assigned_user_name;

    public $table_name = "opportunities";
    public $rel_account_table = "accounts_opportunities";
    public $rel_contact_table = "opportunities_contacts";
    public $module_dir = "Opportunities";
    public $rel_quote_table = "quotes_opportunities";
    public $best_case;
    public $worst_case;
    public $timeperiod_id;
    public $commit_stage;

    public $importable = true;
    public $object_name = "Opportunity";

    // This is used to retrieve related fields from form posts.
    public $additional_column_fields = Array(
        'assigned_user_name',
        'assigned_user_id',
        'account_name',
        'account_id',
        'contact_id',
        'task_id',
        'note_id',
        'meeting_id',
        'call_id',
        'email_id'
    ,
        'quote_id'
    );

    public $relationship_fields = Array(
        'task_id' => 'tasks',
        'note_id' => 'notes',
        'account_id' => 'accounts',
        'meeting_id' => 'meetings',
        'call_id' => 'calls',
        'email_id' => 'emails',
        'project_id' => 'project',
        // Bug 38529 & 40938
        'currency_id' => 'currencies',
        'quote_id' => 'quotes',
    );

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function Opportunity()
    {
        self::__construct();
    }


    public function __construct()
    {
        parent::__construct();
        global $sugar_config;

        if (empty($sugar_config['require_accounts'])) {
            unset($this->required_fields['account_name']);
        }
        global $current_user;
        if (!empty($current_user)) {
            $this->team_id = $current_user->default_team; //default_team is a team id
        } else {
            $this->team_id = 1; // make the item globally accessible
        }
    }


    public $new_schema = true;


    public function get_summary_text()
    {
        return "$this->name";
    }


    public function create_list_query($order_by, $where, $show_deleted = 0)
    {

        $custom_join = $this->custom_fields->getJOIN();
        $query = "SELECT ";

        $query .= "
                            accounts.id as account_id,
                            accounts.name as account_name,
                            accounts.assigned_user_id account_id_owner,
                            users.user_name as assigned_user_name ";
        $query .= ",teams.name AS team_name ";
        if ($custom_join) {
            $query .= $custom_join['select'];
        }
        $query .= " ,opportunities.*
                            FROM opportunities ";

        // We need to confirm that the user is a member of the team of the item.
        $this->add_team_security_where_clause($query);
        $query .= "LEFT JOIN users
                            ON opportunities.assigned_user_id=users.id ";
        $query .= getTeamSetNameJoin('opportunities');

        $query .= " LEFT JOIN timeperiods
                        ON timeperiods.start_date_timestamp <= opportunities.date_closed_timestamp
                        AND timeperiods.end_date_timestamp >= opportunities.date_closed_timestamp ";

        $query .= "LEFT JOIN $this->rel_account_table
                            ON opportunities.id=$this->rel_account_table.opportunity_id
                            LEFT JOIN accounts
                            ON $this->rel_account_table.account_id=accounts.id ";
        if ($custom_join) {
            $query .= $custom_join['join'];
        }
        $where_auto = '1=1';
        if ($show_deleted == 0) {
            $where_auto = "
			($this->rel_account_table.deleted is null OR $this->rel_account_table.deleted=0)
			AND (accounts.deleted is null OR accounts.deleted=0)
			AND opportunities.deleted=0";
        } else {
            if ($show_deleted == 1) {
                $where_auto = " opportunities.deleted=1";
            }
        }

        if ($where != "") {
            $query .= "where ($where) AND " . $where_auto;
        } else {
            $query .= "where " . $where_auto;
        }

        if ($order_by != "") {
            $query .= " ORDER BY $order_by";
        } else {
            $query .= " ORDER BY opportunities.name";
        }

        return $query;
    }


    public function create_export_query(&$order_by, &$where, $relate_link_join = '')
    {
        $custom_join = $this->custom_fields->getJOIN(true, true, $where);
        if ($custom_join) {
            $custom_join['join'] .= $relate_link_join;
        }
        $query = "SELECT
                                opportunities.*,
                                accounts.name as account_name,
                                users.user_name as assigned_user_name ";
        $query .= ", teams.name AS team_name ";
        if ($custom_join) {
            $query .= $custom_join['select'];
        }
        $query .= " FROM opportunities ";
        // We need to confirm that the user is a member of the team of the item.
        $this->add_team_security_where_clause($query);
        $query .= "LEFT JOIN users
                                ON opportunities.assigned_user_id=users.id";
        $query .= " LEFT JOIN teams ON opportunities.team_id=teams.id";
        $query .= " LEFT JOIN $this->rel_account_table
                                ON opportunities.id=$this->rel_account_table.opportunity_id
                                LEFT JOIN accounts
                                ON $this->rel_account_table.account_id=accounts.id ";
        if ($custom_join) {
            $query .= $custom_join['join'];
        }
        $where_auto = "
			($this->rel_account_table.deleted is null OR $this->rel_account_table.deleted=0)
			AND (accounts.deleted is null OR accounts.deleted=0)
			AND opportunities.deleted=0";

        if ($where != "") {
            $query .= "where $where AND " . $where_auto;
        } else {
            $query .= "where " . $where_auto;
        }

        if ($order_by != "") {
            $query .= " ORDER BY opportunities.$order_by";
        } else {
            $query .= " ORDER BY opportunities.name";
        }
        return $query;
    }


    public function fill_in_additional_list_fields()
    {
        if ($this->force_load_details == true) {
            $this->fill_in_additional_detail_fields();
        }
    }


    public function fill_in_additional_detail_fields()
    {
        parent::fill_in_additional_detail_fields();

        if (!empty($this->currency_id)) {
            $currency = BeanFactory::getBean('Currencies', $this->currency_id);
            if ($currency->id != $this->currency_id || $currency->deleted == 1) {
                $this->amount = $this->amount_usdollar;
                $this->currency_id = $currency->id;
            }
        }
        //get campaign name
        if (!empty($this->campaign_id)) {
            $camp = BeanFactory::getBean('Campaigns', $this->campaign_id);
            $this->campaign_name = $camp->name;
        }
        $this->account_name = '';
        $this->account_id = '';
        if (!empty($this->id)) {
            $ret_values = Opportunity::get_account_detail($this->id);
            if (!empty($ret_values)) {
                $this->account_name = $ret_values['name'];
                $this->account_id = $ret_values['id'];
                $this->account_id_owner = $ret_values['assigned_user_id'];
            }
        }
    }


    /** Returns a list of the associated contacts
     * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
     * All Rights Reserved..
     * Contributor(s): ______________________________________..
     */
    public function get_contacts()
    {
        $this->load_relationship('contacts');
        $query_array = $this->contacts->getQuery(true);

        //update the select clause in the retruned query.
        $query_array['select'] = "SELECT contacts.id, contacts.first_name, contacts.last_name, contacts.title, contacts.email1, contacts.phone_work, opportunities_contacts.contact_role as opportunity_role, opportunities_contacts.id as opportunity_rel_id ";

        $query = '';
        foreach ($query_array as $qstring) {
            $query .= ' ' . $qstring;
        }
        $temp = Array(
            'id',
            'first_name',
            'last_name',
            'title',
            'email1',
            'phone_work',
            'opportunity_role',
            'opportunity_rel_id'
        );
        return $this->build_related_list2($query, BeanFactory::getBean('Contacts'), $temp);
    }


    public function update_currency_id($fromid, $toid)
    {
        $idequals = '';

        $currency = BeanFactory::getBean('Currencies', $toid);
        foreach ($fromid as $f) {
            if (!empty($idequals)) {
                $idequals .= ' or ';
            }
            $idequals .= "currency_id='$f'";
        }

		if ( !empty($idequals) ) {
			$query  = "select amount, id from opportunities where (" . $idequals . ") and deleted=0 and opportunities.sales_stage <> '".self::STAGE_CLOSED_WON."' AND opportunities.sales_stage <> '".self::STAGE_CLOSED_LOST."';";
			$result = $this->db->query($query);

            while ($row = $this->db->fetchByAssoc($result)) {
                $query = sprintf(
                    "update opportunities set currency_id='%s',
                                        amount_usdollar='%s',
                                        base_rate='%s'
                                        where id='%s';",
                    $currency->id,
                    SugarCurrency::convertAmountToBase($row['amount'], $currency->id),
                    $currency->conversion_rate,
                    $row['id']
                );
                $this->db->query($query);
            }
        }
    }


    public function get_list_view_data()
    {
        global $locale, $current_language, $current_user, $mod_strings, $app_list_strings, $sugar_config;
        $app_strings = return_application_language($current_language);
        $params = array();

        $temp_array = $this->get_list_view_array();
        $temp_array['SALES_STAGE'] = empty($temp_array['SALES_STAGE']) ? '' : $temp_array['SALES_STAGE'];
        $temp_array["ENCODED_NAME"] = $this->name;
        return $temp_array;
    }


    public function get_currency_symbol()
    {
        if (isset($this->currency_id)) {
            $cur_qry = "select * from currencies where id ='" . $this->currency_id . "'";
            $cur_res = $this->db->query($cur_qry);
            if (!empty($cur_res)) {
                $cur_row = $this->db->fetchByAssoc($cur_res);
                if (isset($cur_row['symbol'])) {
                    return $cur_row['symbol'];
                }
            }
        }
        return '';
    }

    /**
     * To check whether currency_id field is changed during save.
     * @return bool true if currency_id is changed, false otherwise
     */
    protected function isCurrencyIdChanged() {
        // if both are defined, compare
        if (isset($this->currency_id) && isset($this->fetched_row['currency_id'])) {
            if ($this->currency_id != $this->fetched_row['currency_id']) {
                return true;
            }
        }
        // one is not defined, the other one is not empty, means changed
        if (!isset($this->currency_id) && !empty($this->fetched_row['currency_id'])) {
            return true;
        }
        if (!isset($this->fetched_row['currency_id']) && !empty($this->currency_id)) {
            return true;
        }

        return false;
    }

    /**
    builds a generic search based on the query string using or
    do not include any $this-> because this is called on without having the class instantiated
     */
    public function build_generic_where_clause($the_query_string)
    {
        $where_clauses = Array();
        $the_query_string = $GLOBALS['db']->quote($the_query_string);
        array_push($where_clauses, "opportunities.name like '$the_query_string%'");
        array_push($where_clauses, "accounts.name like '$the_query_string%'");

        $the_where = "";
        foreach ($where_clauses as $clause) {
            if ($the_where != "") {
                $the_where .= " or ";
            }
            $the_where .= $clause;
        }

        return $the_where;
    }

    public function save($check_notify = false)
    {
        // Bug 32581 - Make sure the currency_id is set to something
        global $current_user, $app_list_strings;

        if (empty($this->currency_id)) {
            // use user preferences for currency
            $currency = SugarCurrency::getUserLocaleCurrency();
            $this->currency_id = $currency->id;
            $this->base_rate = $currency->conversion_rate;
        }

        // if stage is not closed won/lost, update base_rate with currency rate
        if (!in_array($this->sales_stage, $this->getClosedStages()) || !isset($this->base_rate) || $this->isCurrencyIdChanged()) {
            $currency = SugarCurrency::getCurrencyByID($this->currency_id);
            $this->base_rate = $currency->conversion_rate;
        }

        // backward compatibility, set usdollar amount with base_rate
        if (isset($this->amount) && !empty($this->amount)) {
            $this->amount_usdollar = SugarCurrency::convertWithRate($this->amount, $this->base_rate);
        }

        //if probablity isn't set, set it based on the sales stage
        if (!isset($this->probability) && !empty($this->sales_stage)) {
            $prob_arr = $app_list_strings['sales_probability_dom'];
            if (isset($prob_arr[$this->sales_stage])) {
                $this->probability = $prob_arr[$this->sales_stage];
            }
        }


        SugarAutoLoader::requireWithCustom('modules/Opportunities/SaveOverload.php');
        perform_save($this);

        return parent::save($check_notify);
    }

    public function save_relationship_changes($is_update)
    {
        //if account_id was replaced unlink the previous account_id.
        //this rel_fields_before_value is populated by sugarbean during the retrieve call.
        if (!empty($this->account_id) and !empty($this->rel_fields_before_value['account_id']) and
            (trim($this->account_id) != trim($this->rel_fields_before_value['account_id']))
        ) {
            //unlink the old record.
            $this->load_relationship('accounts');
            $this->accounts->delete($this->id, $this->rel_fields_before_value['account_id']);
            //propagate change down to products
            $this->load_relationship('products');
            foreach ($this->products->getBeans() as $product) {
                $product->account_id = $this->account_id;
                $product->save();
            }
        }
        // Bug 38529 & 40938 - exclude currency_id
        parent::save_relationship_changes($is_update, array('currency_id'));

        if (!empty($this->contact_id)) {
            $this->set_opportunity_contact_relationship($this->contact_id);
        }
    }


    public function set_opportunity_contact_relationship($contact_id)
    {
        global $app_list_strings;
        $default = $app_list_strings['opportunity_relationship_type_default_key'];
        $this->load_relationship('contacts');
        $this->contacts->add($contact_id, array('contact_role' => $default));
    }


    public function set_notification_body($xtpl, $oppty)
    {
        global $app_list_strings;

        $xtpl->assign("OPPORTUNITY_NAME", $oppty->name);
        $xtpl->assign("OPPORTUNITY_AMOUNT", $oppty->amount);
        $xtpl->assign("OPPORTUNITY_CLOSEDATE", $oppty->date_closed);

        $oppStage = '';
        if(isset($oppty->sales_stage) && !empty($oppty->sales_stage)) {
            $oppStage = $app_list_strings['sales_stage_dom'][$oppty->sales_stage];
        }
        $xtpl->assign("OPPORTUNITY_STAGE", $oppStage);

        $xtpl->assign("OPPORTUNITY_DESCRIPTION", $oppty->description);

        return $xtpl;
    }


    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }
        return false;
    }


    public function listviewACLHelper()
    {
        $array_assign = parent::listviewACLHelper();
        $is_owner = false;
        if (!empty($this->account_id)) {

            if (!empty($this->account_id_owner)) {
                global $current_user;
                $is_owner = $current_user->id == $this->account_id_owner;
            }
        }
        if (!ACLController::moduleSupportsACL('Accounts') ||
            ACLController::checkAccess('Accounts', 'view', $is_owner)) {
            $array_assign['ACCOUNT'] = 'a';
        } else {
            $array_assign['ACCOUNT'] = 'span';
        }

        return $array_assign;
    }


    /**
     * Static helper function for getting releated account info.
     */
    public function get_account_detail($opp_id)
    {
        $ret_array = array();
        $db = DBManagerFactory::getInstance();
        $query = "SELECT acc.id, acc.name, acc.assigned_user_id "
            . "FROM accounts acc, accounts_opportunities a_o "
            . "WHERE acc.id=a_o.account_id"
            . " AND a_o.opportunity_id='$opp_id'"
            . " AND a_o.deleted=0"
            . " AND acc.deleted=0";
        $result = $db->query($query, true, "Error filling in opportunity account details: ");
        $row = $db->fetchByAssoc($result);
        if ($row != null) {
            $ret_array['name'] = $row['name'];
            $ret_array['id'] = $row['id'];
            $ret_array['assigned_user_id'] = $row['assigned_user_id'];
        }
        return $ret_array;
    }

    /**
     * getClosedStages
     *
     * Return an array of closed stage names from the admin bean.
     *
     * @access public
     * @return array array of closed stage values
     */
    public function getClosedStages()
    {
        // TODO: move closed stages to a global setting.
        // For now, get them from forecasting.
        static $stages;
        if (!isset($stages)) {
            $admin = BeanFactory::getBean('Administration');
            $settings = $admin->getConfigForModule('Forecasts');

            // get all possible closed stages
            $stages = array_merge(
                isset($settings['sales_stage_won']) ? (array)$settings['sales_stage_won'] : array(),
                isset($settings['sales_stage_lost']) ? (array)$settings['sales_stage_lost'] : array()
            );
        }
        return $stages;
    }

}


function getTimePeriodsDropDown()
{
    return TimePeriod::get_timeperiods_dom();
}
