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


class Call extends SugarBean {
	var $field_name_map;
	// Stored fields
	var $id;
	var $json_id;
	var $date_entered;
	var $date_modified;
	var $assigned_user_id;
	var $modified_user_id;
	var $team_id;
	var $description;
	var $name;
	var $status;
	var $date_start;
	var $time_start;
	var $duration_hours;
	var $duration_minutes;
	var $date_end;
	var $parent_type;
	var $parent_type_options;
	var $parent_id;
	var $contact_id;
	var $user_id;
	var $lead_id;
	var $direction;
	var $reminder_time;
	var $reminder_time_options;
	var $reminder_checked;
	var $email_reminder_time;
	var $email_reminder_checked;
	var $email_reminder_sent;
	var $required;
	var $accept_status;
	var $created_by;
	var $created_by_name;
	var $modified_by_name;
	var $parent_name;
	var $contact_name;
	var $contact_phone;
	var $contact_email;
	var $account_id;
	var $opportunity_id;
	var $case_id;
	var $assigned_user_name;
	var $note_id;
    var $outlook_id;
	var $team_name;
	var $update_vcal = true;
	var $contacts_arr = array();
	var $users_arr = array();
	var $leads_arr = array();
	var $default_call_name_values = array('Assemble catalogs', 'Make travel arrangements', 'Send a letter', 'Send contract', 'Send fax', 'Send a follow-up letter', 'Send literature', 'Send proposal', 'Send quote');
	var $minutes_value_default = 15;
	var $minutes_values = array('0'=>'00','15'=>'15','30'=>'30','45'=>'45');
	var $table_name = "calls";
	var $rel_users_table = "calls_users";
	var $rel_contacts_table = "calls_contacts";
    var $rel_leads_table = "calls_leads";
	var $module_dir = 'Calls';
	var $object_name = "Call";
	var $new_schema = true;
	var $importable = true;
	var $recurring_source;

	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = array('assigned_user_name', 'assigned_user_id', 'contact_id', 'user_id', 'contact_name');
	var $relationship_fields = array(	'account_id'		=> 'accounts',
										'opportunity_id'	=> 'opportunities',
										'contact_id'		=> 'contacts',
										'case_id'			=> 'cases',
										'user_id'			=> 'users',
										'assigned_user_id'	=> 'users',
										'note_id'			=> 'notes',
                                        'lead_id'			=> 'leads',
								);

	public $send_invites = false;

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function Call()
    {
        self::__construct();
    }

	public function __construct() {
		parent::__construct();
		global $app_list_strings;

       	$this->setupCustomFields('Calls');

		foreach ($this->field_defs as $field) {
			if(empty($field['name'])) {
		        continue;
		    }
		    $this->field_name_map[$field['name']] = $field;
		}

		global $current_user;
		if(!empty($current_user)) {
			$this->team_id = $current_user->default_team;	//default_team is a team id
			$this->team_set_id = $current_user->team_set_id; //bug 41334 : team_set_id needs to be updated with current_user's team_set_id
		} else {
			$this->team_id = 1; // make the item globally accessible
		}



         if(!empty($GLOBALS['app_list_strings']['duration_intervals']))
        	$this->minutes_values = $GLOBALS['app_list_strings']['duration_intervals'];
	}

    // save date_end by calculating user input
    // this is for calendar
	function save($check_notify = FALSE) {
		global $timedate,$current_user;

	    if(isset($this->date_start) && (isset($this->duration_hours) || isset($this->duration_minutes)))
        {
            // Set the duration hours and minutes to 0 if one of them isn't set but the other one is.
            $this->duration_hours = empty($this->duration_hours) ? 0 : $this->duration_hours;
            $this->duration_minutes = empty($this->duration_minutes) ? 0 : $this->duration_minutes;
    	    $td = $timedate->fromDb($this->date_start);
    	    if($td)
    	    {
	        	$this->date_end = $td->modify("+{$this->duration_hours} hours {$this->duration_minutes} mins")->asDb();
    	    }
        }

        $check_notify = $this->send_invites;

		if($this->send_invites == false) {
			$old_assigned_user_id = '';
			if(!empty($this->id)) {
				$old_record = BeanFactory::getBean('Calls', $this->id);
				$old_assigned_user_id = $old_record->assigned_user_id;
			}
			if((!isset($GLOBALS['installing']) || $GLOBALS['installing'] != true) && (empty($this->id) && isset($this->assigned_user_id) && !empty($this->assigned_user_id) && $GLOBALS['current_user']->id != $this->assigned_user_id) || (isset($old_assigned_user_id) && !empty($old_assigned_user_id) && isset($this->assigned_user_id) && !empty($this->assigned_user_id) && $old_assigned_user_id != $this->assigned_user_id) ){
				$this->special_notification = true;
				if(!static::inOperation('saving_related')) {
					$check_notify = true;
				}
                if(isset($_REQUEST['assigned_user_name'])) {
                    $this->new_assigned_user_name = $_REQUEST['assigned_user_name'];
                }
			}
		}
        if (empty($this->status) ) {
            $this->status = $this->getDefaultStatus();
        }

		// prevent a mass mailing for recurring meetings created in Calendar module
		if (empty($this->id) && !empty($_REQUEST['module']) && $_REQUEST['module'] == "Calendar" && !empty($_REQUEST['repeat_type']) && !empty($this->repeat_parent_id)) {
			$check_notify = false;
		}
		/*nsingh 7/3/08  commenting out as bug #20814 is invalid
		if($current_user->getPreference('reminder_time')!= -1 &&  isset($_POST['reminder_checked']) && isset($_POST['reminder_time']) && $_POST['reminder_checked']==0  && $_POST['reminder_time']==-1){
			$this->reminder_checked = '1';
			$this->reminder_time = $current_user->getPreference('reminder_time');
		}*/

        $return_id = parent::save($check_notify);
        // Previously this was handled in both the CallFormBase and the AfterImportSave function, so now it just happens every time you save a record.
        if ($this->parent_type == 'Contacts') {
            if (is_array($this->contacts_arr) && !in_array($this->parent_id, $this->contacts_arr)) {
                $this->contacts_arr[] = $this->parent_id;
            }
            $this->load_relationship('contacts');
            if (!$this->contacts->relationship_exists('contacts', array('id' => $this->parent_id))) {
                $this->contacts->add($this->parent_id);
            }
        } elseif ($this->parent_type == 'Leads') {
            if (is_array($this->leads_arr) && !in_array($this->parent_id, $this->leads_arr)) {
                $this->leads_arr[] = $this->parent_id;
            }
            $this->load_relationship('leads');
            if (!$this->leads->relationship_exists('leads', array('id' => $this->parent_id))) {
                $this->leads->add($this->parent_id);
            }
        }

        if (!empty($this->contact_id)) {
            if (is_array($this->contacts_arr) && !in_array($this->contact_id, $this->contacts_arr)) {
                $this->contacts_arr[] = $this->contact_id;
            }
            $this->load_relationship('contacts');
            if (!$this->contacts->relationship_exists('contacts', array('id' => $this->contact_id))) {
                $this->contacts->add($this->contact_id);
            }
        }

        $this->setUserInvitees($this->users_arr);

        vCal::cache_sugar_vcal(BeanFactory::getBean('Users', $this->assigned_user_id));


		if($this->update_vcal && $this->assigned_user_id != $GLOBALS['current_user']->id) {
			vCal::cache_sugar_vcal($current_user);
		}

        // CCL - Comment out call to set $current_user as invitee
        // set organizer to auto-accept
        // if there isn't a fetched row its new
        if ($this->assigned_user_id == $GLOBALS['current_user']->id && empty($this->fetched_row)) {
            $this->set_accept_status($GLOBALS['current_user'], 'accept');
        }

        return $return_id;
	}

	/** Returns a list of the associated contacts
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	*/
	function get_contacts()
	{
		// First, get the list of IDs.
		$query = "SELECT contact_id as id from calls_contacts where call_id='$this->id' AND deleted=0";

		return $this->build_related_list($query, BeanFactory::getBean('Contacts'));
	}


	function get_summary_text()
	{
		return "$this->name";
	}

	function create_list_query($order_by, $where, $show_deleted=0)
	{
        $custom_join = $this->getCustomJoin();
                $query = "SELECT ";
		$query .= "
			calls.*,";
			if ( preg_match("/calls_users\.user_id/",$where))
			{
				$query .= "calls_users.required,
				calls_users.accept_status,";
			}

			$query .= "
			users.user_name as assigned_user_name";
			$query .= ", teams.name AS team_name";
        $query .= $custom_join['select'];

			// this line will help generate a GMT-metric to compare to a locale's timezone

			if ( preg_match("/contacts/",$where)){
				$query .= ", contacts.first_name, contacts.last_name";
				$query .= ", contacts.assigned_user_id contact_name_owner";
			}
			$query .= " FROM calls ";

		// We need to confirm that the user is a member of the team of the item.
		$this->add_team_security_where_clause($query);
			if ( preg_match("/contacts/",$where)){
				$query .=	"LEFT JOIN calls_contacts
	                    ON calls.id=calls_contacts.call_id
	                    LEFT JOIN contacts
	                    ON calls_contacts.contact_id=contacts.id ";
			}
			if ( preg_match('/calls_users\.user_id/',$where))
			{
		$query .= "LEFT JOIN calls_users
			ON calls.id=calls_users.call_id and calls_users.deleted=0 ";
			}
			$query .= " LEFT JOIN teams ON calls.team_id=teams.id";
			$query .= "
			LEFT JOIN users
			ON calls.assigned_user_id=users.id ";
        $query .= $custom_join['join'];
			$where_auto = '1=1';
       		 if($show_deleted == 0){
            	$where_auto = " $this->table_name.deleted=0  ";
			}else if($show_deleted == 1){
				$where_auto = " $this->table_name.deleted=1 ";
			}

			//$where_auto .= " GROUP BY calls.id";

		if($where != "")
			$query .= "where $where AND ".$where_auto;
		else
			$query .= "where ".$where_auto;

        $order_by = $this->process_order_by($order_by);
        if (empty($order_by)) {
            $order_by = 'calls.name';
        }
        $query .= ' ORDER BY ' . $order_by;

		return $query;
	}

        function create_export_query(&$order_by, &$where, $relate_link_join='')
        {
            $custom_join = $this->getCustomJoin(true, true, $where);
            $custom_join['join'] .= $relate_link_join;
			$contact_required = stristr($where, "contacts");
            if($contact_required)
            {
                    $query = "SELECT calls.*, contacts.first_name, contacts.last_name, users.user_name as assigned_user_name ";
                    $query .= ", teams.name AS team_name";
                    $query .= $custom_join['select'];
                    $query .= " FROM contacts, calls, calls_contacts ";
                    $where_auto = "calls_contacts.contact_id = contacts.id AND calls_contacts.call_id = calls.id AND calls.deleted=0 AND contacts.deleted=0";
            }
            else
            {
                    $query = 'SELECT calls.*, users.user_name as assigned_user_name ';
                    $query .= ", teams.name AS team_name";
                    $query .= $custom_join['select'];
                    $query .= ' FROM calls ';
                    $where_auto = "calls.deleted=0";
            }

				// We need to confirm that the user is a member of the team of the item.
				$this->add_team_security_where_clause($query);

				$query .= getTeamSetNameJoin('calls');
			$query .= "  LEFT JOIN users ON calls.assigned_user_id=users.id ";

            $query .= $custom_join['join'];

			if($where != "")
                    $query .= "where $where AND ".$where_auto;
            else
                    $query .= "where ".$where_auto;

        $order_by = $this->process_order_by($order_by);
        if (empty($order_by)) {
            $order_by = 'calls.name';
        }
        $query .= ' ORDER BY ' . $order_by;

            return $query;
        }





	function fill_in_additional_detail_fields()
	{
		global $locale;
		parent::fill_in_additional_detail_fields();
		if (!empty($this->contact_id)) {
			$query  = "SELECT first_name, last_name FROM contacts ";
			$query .= "WHERE id='$this->contact_id' AND deleted=0";
			$result = $this->db->limitQuery($query,0,1,true," Error filling in additional detail fields: ");

			// Get the contact name.
			$row = $this->db->fetchByAssoc($result);
			$GLOBALS['log']->info("additional call fields $query");
			if($row != null)
			{
				$this->contact_name = $locale->getLocaleFormattedName($row['first_name'], $row['last_name'], '', '');
				$GLOBALS['log']->debug("Call($this->id): contact_name = $this->contact_name");
				$GLOBALS['log']->debug("Call($this->id): contact_id = $this->contact_id");
			}
		}
		if (!isset($this->duration_minutes)) {
			$this->duration_minutes = $this->minutes_value_default;
		}

        global $timedate;
        //setting default date and time
		if (is_null($this->date_start)) {
			$this->date_start = $timedate->now();
		}

		if (is_null($this->duration_hours))
			$this->duration_hours = "0";
		if (is_null($this->duration_minutes))
			$this->duration_minutes = "1";

		$this->fill_in_additional_parent_fields();

		global $app_list_strings;
		if (empty($this->reminder_time)) {
			$this->reminder_time = -1;
		}

		if ( empty($this->id) ) {
		    $reminder_t = $GLOBALS['current_user']->getPreference('reminder_time');
		    if ( isset($reminder_t) )
		        $this->reminder_time = $reminder_t;
		}
		$this->reminder_checked = $this->reminder_time == -1 ? false : true;

		if (empty($this->email_reminder_time)) {
			$this->email_reminder_time = -1;
		}
		if(empty($this->id)){
			$reminder_t = $GLOBALS['current_user']->getPreference('email_reminder_time');
			if(isset($reminder_t))
		    		$this->email_reminder_time = $reminder_t;
		}
		$this->email_reminder_checked = $this->email_reminder_time == -1 ? false : true;

		if (isset ($_REQUEST['parent_type']) && (!isset($_REQUEST['action']) || $_REQUEST['action'] != 'SubpanelEdits')) {
			$this->parent_type = $_REQUEST['parent_type'];
		} elseif (is_null($this->parent_type)) {
			$this->parent_type = $app_list_strings['record_type_default_key'];
		}
	}


	function get_list_view_data(){
		$call_fields = $this->get_list_view_array();
		global $app_list_strings, $focus, $action, $currentModule;
		if (isset($focus->id)) $id = $focus->id;
		else $id = '';
		if (isset($this->parent_type) && $this->parent_type != null)
		{
			$call_fields['PARENT_MODULE'] = $this->parent_type;
		}
		if ($this->status == "Planned") {
			//cn: added this if() to deal with sequential Closes in Meetings.  this is a hack to a hack (formbase.php->handleRedirect)
			if(empty($action))
			    $action = "index";

            $setCompleteUrl = "<a id='{$this->id}' onclick='SUGAR.util.closeActivityPanel.show(\"{$this->module_dir}\",\"{$this->id}\",\"Held\",\"listview\",\"1\");'>";
			if ($this->ACLAccess('edit')) {
                $call_fields['SET_COMPLETE'] = $setCompleteUrl . SugarThemeRegistry::current()->getImage("close_inline"," border='0'",null,null,'.gif',translate('LBL_CLOSEINLINE'))."</a>";
            } else {
                $call_fields['SET_COMPLETE'] = '';
            }
		}
		global $timedate;
		$today = $timedate->nowDb();
		$nextday = $timedate->asDbDate($timedate->getNow()->modify("+1 day"));
		$mergeTime = $call_fields['DATE_START']; //$timedate->merge_date_time($call_fields['DATE_START'], $call_fields['TIME_START']);
		$date_db = $timedate->to_db($mergeTime);
		if( $date_db	< $today){
			$call_fields['DATE_START']= "<font class='overdueTask'>".$call_fields['DATE_START']."</font>";
		}else if($date_db < $nextday){
			$call_fields['DATE_START'] = "<font class='todaysTask'>".$call_fields['DATE_START']."</font>";
		}else{
			$call_fields['DATE_START'] = "<font class='futureTask'>".$call_fields['DATE_START']."</font>";
		}
		$this->fill_in_additional_detail_fields();

		//make sure we grab the localized version of the contact name, if a contact is provided
		if (!empty($this->contact_id)) {
           // Bug# 46125 - make first name, last name, salutation and title of Contacts respect field level ACLs
            $contact_temp = BeanFactory::getBean("Contacts", $this->contact_id);
            if(!empty($contact_temp)) {
                $contact_temp->_create_proper_name_field();
                $this->contact_name = $contact_temp->full_name;
            }
		}

        $call_fields['CONTACT_ID'] = $this->contact_id;
        $call_fields['CONTACT_NAME'] = $this->contact_name;
		$call_fields['PARENT_NAME'] = $this->parent_name;
        $call_fields['REMINDER_CHECKED'] = $this->reminder_time==-1 ? false : true;
	    $call_fields['EMAIL_REMINDER_CHECKED'] = $this->email_reminder_time==-1 ? false : true;

		return $call_fields;
	}

	function set_notification_body($xtpl, $call) {
		global $sugar_config;
		global $app_list_strings;
		global $current_user;
		global $app_list_strings;
		global $timedate;

        // rrs: bug 42684 - passing a contact breaks this call
		$notifyUser =($call->current_notify_user->object_name == 'User') ? $call->current_notify_user : $current_user;


		// Assumes $call dates are in user format
		$calldate = $timedate->fromDb($call->date_start);
		$xOffset = $timedate->asUser($calldate, $notifyUser).' '.$timedate->userTimezoneSuffix($calldate, $notifyUser);

		if ( strtolower(get_class($call->current_notify_user)) == 'contact' ) {
			$xtpl->assign("ACCEPT_URL", $sugar_config['site_url'].
				  '/index.php?entryPoint=acceptDecline&module=Calls&contact_id='.$call->current_notify_user->id.'&record='.$call->id);
		} elseif ( strtolower(get_class($call->current_notify_user)) == 'lead' ) {
			$xtpl->assign("ACCEPT_URL", $sugar_config['site_url'].
				  '/index.php?entryPoint=acceptDecline&module=Calls&lead_id='.$call->current_notify_user->id.'&record='.$call->id);
		} else {
			$xtpl->assign("ACCEPT_URL", $sugar_config['site_url'].
				  '/index.php?entryPoint=acceptDecline&module=Calls&user_id='.$call->current_notify_user->id.'&record='.$call->id);
		}

		$xtpl->assign("CALL_TO", $call->current_notify_user->new_assigned_user_name);
		$xtpl->assign("CALL_SUBJECT", $call->name);
		$xtpl->assign("CALL_STARTDATE", $xOffset);
		$xtpl->assign("CALL_HOURS", $call->duration_hours);
		$xtpl->assign("CALL_MINUTES", $call->duration_minutes);
		$xtpl->assign("CALL_STATUS", ((isset($call->status))?$app_list_strings['call_status_dom'][$call->status] : ""));
		$xtpl->assign("CALL_DESCRIPTION", $call->description);

		return $xtpl;
	}


	function get_call_users() {
		// First, get the list of IDs.
		$query = "SELECT calls_users.required, calls_users.accept_status, calls_users.user_id from calls_users where calls_users.call_id='$this->id' AND calls_users.deleted=0";
		$GLOBALS['log']->debug("Finding linked records $this->object_name: ".$query);
		$result = $this->db->query($query, true);
		$list = Array();

		while($row = $this->db->fetchByAssoc($result)) {
			$record = BeanFactory::retrieveBean('Users', $row['user_id']);
			if(empty($record)) continue;
			$record->required = $row['required'];
			$record->accept_status = $row['accept_status'];
			$list[] = $record;
		}
		return $list;
	}


  function get_invite_calls($user)
  {
    // First, get the list of IDs.
    $query = "SELECT calls_users.required, calls_users.accept_status, calls_users.call_id from calls_users where calls_users.user_id='$user->id' AND ( calls_users.accept_status IS NULL OR  calls_users.accept_status='none') AND calls_users.deleted=0";
    $GLOBALS['log']->debug("Finding linked records $this->object_name: ".$query);

    $result = $this->db->query($query, true);

    $list = Array();

    while($row = $this->db->fetchByAssoc($result))
    {
        $record = BeanFactory::retrieveBean($this->module_dir, $row['call_id']);
        if(empty($record)) continue;
        $record->required = $row['required'];
        $record->accept_status = $row['accept_status'];
        $list[] = $record;
    }
    return $list;

  }


  function set_accept_status($user,$status)
  {
    if ( $user->object_name == 'User')
    {
      $relate_values = array('user_id'=>$user->id,'call_id'=>$this->id);
      $data_values = array('accept_status'=>$status);
      $this->set_relationship($this->rel_users_table, $relate_values, true, true,$data_values);
      global $current_user;

      if ( $this->update_vcal )
      {
        vCal::cache_sugar_vcal($user);
      }
    }
    else if ( $user->object_name == 'Contact')
    {
      $relate_values = array('contact_id'=>$user->id,'call_id'=>$this->id);
      $data_values = array('accept_status'=>$status);
      $this->set_relationship($this->rel_contacts_table, $relate_values, true, true,$data_values);
    }
    else if ( $user->object_name == 'Lead')
    {
      $relate_values = array('lead_id'=>$user->id,'call_id'=>$this->id);
      $data_values = array('accept_status'=>$status);
      $this->set_relationship($this->rel_leads_table, $relate_values, true, true,$data_values);
    }
  }



	function get_notification_recipients() {
		if($this->special_notification) {
			return parent::get_notification_recipients();
		}

//		$GLOBALS['log']->debug('Call.php->get_notification_recipients():'.print_r($this,true));
		$list = array();
        if(!is_array($this->contacts_arr)) {
			$this->contacts_arr =	array();
		}

		if(!is_array($this->users_arr)) {
			$this->users_arr =	array();
		}

        if(!is_array($this->leads_arr)) {
			$this->leads_arr =	array();
		}

		foreach($this->users_arr as $user_id) {
			$notify_user = BeanFactory::getBean('Users', $user_id);
			if(!empty($notify_user->id)) {
				$notify_user->new_assigned_user_name = $notify_user->full_name;
				$GLOBALS['log']->info("Notifications: recipient is $notify_user->new_assigned_user_name");
				$list[$notify_user->id] = $notify_user;
			}
		}

		foreach($this->contacts_arr as $contact_id) {
			$notify_user = BeanFactory::getBean('Contacts', $contact_id);
			if(!empty($notify_user->id) && !empty($notify_user->email1)) {
				$notify_user->new_assigned_user_name = $notify_user->full_name;
				$GLOBALS['log']->info("Notifications: recipient is $notify_user->new_assigned_user_name");
				$list[$notify_user->id] = $notify_user;
			}
		}

        foreach($this->leads_arr as $lead_id) {
			$notify_user = BeanFactory::getBean('Leads', $lead_id);
			if(!empty($notify_user->id)) {
				$notify_user->new_assigned_user_name = $notify_user->full_name;
				$GLOBALS['log']->info("Notifications: recipient is $notify_user->new_assigned_user_name");
				$list[$notify_user->id] = $notify_user;
			}
		}
//		$GLOBALS['log']->debug('Call.php->get_notification_recipients():'.print_r($list,true));
		return $list;
	}

    function bean_implements($interface){
		switch($interface){
			case 'ACL':return true;
		}
		return false;
	}

	function listviewACLHelper(){
		$array_assign = parent::listviewACLHelper();
		$is_owner = false;
		if(!empty($this->parent_name)){

			if(!empty($this->parent_name_owner)){
				global $current_user;
				$is_owner = $current_user->id == $this->parent_name_owner;
			}
		}
			if(!ACLController::moduleSupportsACL($this->parent_type) || ACLController::checkAccess($this->parent_type, 'view', $is_owner)){
				$array_assign['PARENT'] = 'a';
			}else{
				$array_assign['PARENT'] = 'span';
			}
		$is_owner = false;
		if(!empty($this->contact_name)){

			if(!empty($this->contact_name_owner)){
				global $current_user;
				$is_owner = $current_user->id == $this->contact_name_owner;
			}
		}
			if( ACLController::checkAccess('Contacts', 'view', $is_owner)){
				$array_assign['CONTACT'] = 'a';
			}else{
				$array_assign['CONTACT'] = 'span';
			}

		return $array_assign;
	}

	function save_relationship_changes($is_update) {
		$exclude = array();
		if(empty($this->in_workflow))
        {
            if(empty($this->in_import))
            {
                //if the global soap_server_object variable is not empty (as in from a soap/OPI call), then process the assigned_user_id relationship, otherwise
                //add assigned_user_id to exclude list and let the logic from MeetingFormBase determine whether assigned user id gets added to the relationship
                if(!empty($GLOBALS['soap_server_object']))
                {
           		    $exclude = array('lead_id', 'contact_id', 'user_id');
           	    }
                else
                {
	                $exclude = array('lead_id', 'contact_id', 'user_id', 'assigned_user_id');
           	    }
            }
            else
            {
                $exclude = array('user_id');
            }


        }
		parent::save_relationship_changes($is_update, $exclude);
	}

    public function getDefaultStatus()
    {
         $def = $this->field_defs['status'];
         if (isset($def['default'])) {
             return $def['default'];
         } else {
            $app = return_app_list_strings_language($GLOBALS['current_language']);
            if (isset($def['options']) && isset($app[$def['options']])) {
                $keys = array_keys($app[$def['options']]);
                return $keys[0];
            }
        }
        return '';
    }

    public function mark_deleted($id)
    {
        require_once("modules/Calendar/CalendarUtils.php");
        CalendarUtils::correctRecurrences($this, $id);

        parent::mark_deleted($id);
    }

    /**
     * Stores contact invitees
     *
     * @patam array $userInvitees Array of contact invitees ids
     * @patam array $existingUsers
     */
    public function setContactInvitees($contactInvitees, $existingContacts = array())
    {
        $this->contacts_arr = $contactInvitees;

        $deleteContacts = array();
        $this->load_relationship('contacts');
        $q = 'SELECT mu.contact_id, mu.accept_status FROM calls_contacts mu WHERE mu.call_id = \''.$this->id.'\'';
        $r = $this->db->query($q);
        $acceptStatusContacts = array();
        while ($a = $this->db->fetchByAssoc($r)) {
              if(!in_array($a['contact_id'], $contactInvitees)) {
                   $deleteContacts[$a['contact_id']] = $a['contact_id'];
              } else {
                   $acceptStatusContacts[$a['contact_id']] = $a['accept_status'];
              }
        }

        if (count($deleteContacts) > 0) {
            $sql = '';
            foreach ($deleteContacts as $u) {
                $sql .= ",'" . $u . "'";
            }
            $sql = substr($sql, 1);
            $sql = "UPDATE calls_contacts SET deleted = 1 WHERE contact_id IN ($sql) AND call_id = '". $this->id . "'";
            $this->db->query($sql);
        }

        foreach ($contactInvitees as $contactId) {
            if (empty($contactId) || isset($existingContacts[$contactId]) || isset($deleteContacts[$contactId])) {
                continue;
            }
            if (!isset($acceptStatusContacts[$contactId])) {
                $this->contacts->add($contactId);
            } else {
                // update query to preserve accept_status
                $qU  = 'UPDATE calls_contacts SET deleted = 0, accept_status = \''.$acceptStatusContacts[$contactId].'\' ';
                $qU .= 'WHERE call_id = \''.$this->id.'\' ';
                $qU .= 'AND contact_id = \''.$contactId.'\'';
                $this->db->query($qU);
            }
        }
    }

    /**
     * Stores user invitees
     *
     * @patam array $userInvitees Array of user invitees ids
     * @patam array $existingUsers
     */
    public function setUserInvitees($userInvitees, $existingUsers = array())
    {
    	// if both are empty, don't do anything.  From the App these will always be set [they are set to at least current-user].
    	// For the api, these sometimes will not be set [linking related records]
    	if(empty($userInvitees) && empty($existingUsers)) {
    		return true;
    	}
        $this->users_arr = $userInvitees;

        $deleteUsers = array();
        $this->load_relationship('users');
        // Get all users for the call
        $q = 'SELECT mu.user_id, mu.accept_status FROM calls_users mu WHERE mu.call_id = \''.$this->id.'\'';
        $r = $this->db->query($q);
        $acceptStatusUsers = array();
        while ($a = $this->db->fetchByAssoc($r)) {
              if (!in_array($a['user_id'], $userInvitees)) {
                   $deleteUsers[$a['user_id']] = $a['user_id'];
              } else {
                 $acceptStatusUsers[$a['user_id']] = $a['accept_status'];
              }
        }

        if (count($deleteUsers) > 0) {
            $sql = '';
            foreach ($deleteUsers as $u) {
                   $sql .= ",'" . $u . "'";
            }
            $sql = substr($sql, 1);
            $sql = "UPDATE calls_users SET deleted = 1 WHERE user_id IN ($sql) AND call_id = '". $this->id . "'";
            $this->db->query($sql);
        }

        foreach ($userInvitees as $userId) {
            if (empty($userId) || isset($existingUsers[$userId]) || isset($deleteUsers[$userId])) {
                continue;
            }
            if (!isset($acceptStatusUsers[$userId])) {
                $this->users->add($userId);
            } else {
                // update query to preserve accept_status
                $qU  = 'UPDATE calls_users SET deleted = 0, accept_status = \''.$acceptStatusUsers[$userId].'\' ';
                $qU .= 'WHERE call_id = \''.$this->id.'\' ';
                $qU .= 'AND user_id = \''.$userId.'\'';
                $this->db->query($qU);
            }
        }
    }

    /**
     * Stores lead invitees
     *
     * @patam array $userInvitees Array of lead invitees ids
     * @patam array $existingUsers
     */
    public function setLeadInvitees($leadInvitees, $existingLeads = array())
    {
        $this->leads_arr = $leadInvitees;

        $deleteLeads = array();
        $this->load_relationship('leads');
        $q = 'SELECT mu.lead_id, mu.accept_status FROM calls_leads mu WHERE mu.call_id = \''.$this->id.'\'';
        $r = $this->db->query($q);
        $acceptStatusLeads = array();
        while($a = $this->db->fetchByAssoc($r)) {
              if(!in_array($a['lead_id'], $leadInvitees)) {
                   $deleteLeads[$a['lead_id']] = $a['lead_id'];
              }    else {
                   $acceptStatusLeads[$a['lead_id']] = $a['accept_status'];
              }
        }

        if (count($deleteLeads) > 0) {
            $sql = '';
            foreach($deleteLeads as $u) {
                    $sql .= ",'" . $u . "'";
            }
            $sql = substr($sql, 1);
            $sql = "UPDATE calls_leads SET deleted = 1 WHERE lead_id IN ($sql) AND call_id = '". $this->id . "'";
            $this->db->query($sql);
        }

        foreach ($leadInvitees as $leadId) {
            if(empty($leadId) || isset($existingLeads[$leadId]) || isset($deleteLeads[$leadId])) {
                continue;
            }
            if(!isset($acceptStatusLeads[$leadId])) {
                $this->leads->add($leadId);
            } else {
                // update query to preserve accept_status
                $qU  = 'UPDATE calls_leads SET deleted = 0, accept_status = \''.$acceptStatusLeads[$leadId].'\' ';
                $qU .= 'WHERE call_id = \''.$this->id.'\' ';
                $qU .= 'AND lead_id = \''.$leadId.'\'';
                $this->db->query($qU);
            }
        }
    }
}
