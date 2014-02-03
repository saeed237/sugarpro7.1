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


class CampaignLog extends SugarBean {

    var $table_name = 'campaign_log';
    var $object_name = 'CampaignLog';
    var $module_dir = 'CampaignLog';

    var $new_schema = true;

    var $campaign_id;
    var $target_tracker_key;
    var $target_id;
    var $target_type;
    var $activity_type;
    var $activity_date;
    var $related_id;
    var $related_type;
    var $deleted;
    var $list_id;
    var $hits;
    var $more_information;
    var $marketing_id;

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function CampaignLog()
    {
        self::__construct();
    }

    public function __construct() {
        global $sugar_config;
        parent::__construct();

        $this->disable_row_level_security=true;
        //$this->team_id = 1; // make the item globally accessible
    }

    function get_list_view_data(){
        global $locale;
        $temp_array = $this->get_list_view_array();
        //make sure that both items in array are set to some value, else return null
        if(!(isset($temp_array['TARGET_TYPE']) && $temp_array['TARGET_TYPE']!= '') || !(isset($temp_array['TARGET_ID']) && $temp_array['TARGET_ID']!= ''))
        {   //needed values to construct query are empty/null, so return null
            $GLOBALS['log']->debug("CampaignLog.php:get_list_view_data: temp_array['TARGET_TYPE'] and/or temp_array['TARGET_ID'] are empty, return null");
            $emptyArr = array();
            return $emptyArr;
        }

        $table = strtolower($temp_array['TARGET_TYPE']);

        if($temp_array['TARGET_TYPE']=='Accounts'){
            $query = "select name from $table where id = ".$this->db->quoted($temp_array['TARGET_ID']);
        }else{
            $query = "select first_name, last_name, ".$this->db->concat($table, array('first_name', 'last_name'))." name from $table" .
                " where id = ".$this->db->quoted($temp_array['TARGET_ID']);
        }
        $result=$this->db->query($query);
        $row=$this->db->fetchByAssoc($result);

        if ($row) {
            if($temp_array['TARGET_TYPE']=='Accounts'){
                $temp_array['RECIPIENT_NAME']=$row['name'];
            }else{
                $full_name = $locale->getLocaleFormattedName($row['first_name'], $row['last_name'], '');
                $temp_array['RECIPIENT_NAME']=$full_name;
            }
        }
        $temp_array['RECIPIENT_EMAIL']=$this->retrieve_email_address($temp_array['TARGET_ID']);

        $query = 'select name from email_marketing where id = \'' . $temp_array['MARKETING_ID'] . '\'';
        $result=$this->db->query($query);
        $row=$this->db->fetchByAssoc($result);

        if ($row)
        {
        	$temp_array['MARKETING_NAME'] = $row['name'];
        }

        return $temp_array;
    }

    function retrieve_email_address($trgt_id = ''){
        $return_str = '';
        if(!empty($trgt_id)){
            $qry  = " select eabr.primary_address, ea.email_address";
            $qry .= " from email_addresses ea ";
            $qry .= " Left Join email_addr_bean_rel eabr on eabr.email_address_id = ea.id ";
            $qry .= " where eabr.bean_id = '{$trgt_id}' ";
            $qry .= " and ea.deleted = 0 ";
            $qry .= " and eabr.deleted = 0" ;
            $qry .= " order by primary_address desc ";

            $result=$this->db->query($qry);
            $row=$this->db->fetchByAssoc($result);

            if (!empty($row['email_address'])){
                $return_str = $row['email_address'];
            }
        }
        return $return_str;
    }




    //this function is called statically by the campaign_log subpanel.
    function get_related_name($related_id, $related_type) {
        global $locale;
        $db= DBManagerFactory::getInstance();
        if ($related_type == 'Emails') {
            $query="SELECT name from emails where id='$related_id'";
            $result=$db->query($query);
            $row=$db->fetchByAssoc($result);
            if ($row != null) {
                return $row['name'];
            }
        }
        if ($related_type == 'Contacts') {
            $query="SELECT first_name, last_name from contacts where id='$related_id'";
            $result=$db->query($query);
            $row=$db->fetchByAssoc($result);
            if ($row != null) {
                return $full_name = $locale->getLocaleFormattedName($row['first_name'], $row['last_name']);
            }
        }
        if ($related_type == 'Leads') {
            $query="SELECT first_name, last_name from leads where id='$related_id'";
            $result=$db->query($query);
            $row=$db->fetchByAssoc($result);
            if ($row != null) {
                return $full_name = $locale->getLocaleFormattedName($row['first_name'], $row['last_name']);
            }
        }
        if ($related_type == 'Prospects') {
            $query="SELECT first_name, last_name from prospects where id='$related_id'";
            $result=$db->query($query);
            $row=$db->fetchByAssoc($result);
            if ($row != null) {
                return $full_name = $locale->getLocaleFormattedName($row['first_name'], $row['last_name']);
            }
        }
        if ($related_type == 'CampaignTrackers') {
            $query="SELECT tracker_url from campaign_trkrs where id='$related_id'";
            $result=$db->query($query);
            $row=$db->fetchByAssoc($result);
            if ($row != null) {
                return $row['tracker_url'] ;
            }
        }
        if ($related_type == 'Accounts') {
            $query="SELECT name from accounts where id='$related_id'";
            $result=$db->query($query);
            $row=$db->fetchByAssoc($result);
            if ($row != null) {
                return $row['name'];
            }
        }
		return $related_id.$related_type;
	}
}

?>
