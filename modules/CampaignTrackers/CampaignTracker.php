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

/*********************************************************************************

 * Description: The primary Function of this file is to manage all the data
 * used by other files in this nodule. It should extend the SugarBean which implements
 * all the basic database operations. Any custom behaviors can be implemented here by
 * implementing functions available in the SugarBean.
 ********************************************************************************/






class CampaignTracker extends SugarBean {
    /* Foreach instance of the bean you will need to access the fields in the table.
    * So define a variable for each one of them, the variable name should be same as the field name
    * Use this module's vardef file as a reference to create these variables.
    */
    var $id;
    var $date_entered;
    var $created_by;
    var $date_modified;
    var $modified_by;
    var $deleted;
    var $tracker_key;
    var $tracker_url;
    var $tracker_name;
    var $campaign_id;
    var $campaign_name;
    var $message_url;
    var $is_optout;

    /* End field definitions*/

    /* variable $table_name is used by SugarBean and methods in this file to constructs queries
    * set this variables value to the table associated with this bean.
    */
    var $table_name = 'campaign_trkrs';

    /*This  variable overrides the object_name variable in SugarBean, wher it has a value of null.*/
    var $object_name = 'CampaignTracker';

    /**/
    var $module_dir = 'CampaignTrackers';

    /* This is a legacy variable, set its value to true for new modules*/
    var $new_schema = true;

    /* $column_fields holds a list of columns that exist in this bean's table. This list is referenced
    * when fetching or saving data for the bean. As you modify a table you need to keep this up to date.
    */
    var $column_fields = Array(
            'id'
            ,'tracker_key'
            ,'tracker_url'
            ,'tracker_name'
            ,'campaign_id'
    );

    // This is used to retrieve related fields from form posts.
    var $additional_column_fields = Array('campaign_id');
    var $relationship_fields = Array('campaing_id'=>'campaign');

    var $required_fields =  array('tracker_name'=>1,'tracker_url'=>1);

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function CampaignTracker()
    {
        self::__construct();
    }

    /*This bean's constructor*/
    public function __construct() {
        parent::__construct();
        $this->disable_row_level_security=true;
    }

    function save() {
        //make sure that the url has a scheme, if not then add http:// scheme
        if ($this->is_optout!=1 ){
            $url = strtolower(trim($this->tracker_url));
            if(!preg_match('/^(http|https|ftp):\/\//i', $url)){
                $this->tracker_url = 'http://'.$url;
            }
        }

        parent::save();
    }

    /* This method should return the summary text which is used to build the bread crumb navigation*/
    /* Generally from this method you would return value of a field that is required and is of type string*/
    function get_summary_text()
    {
        return "$this->tracker_name";
    }


    /* This method is used to generate query for the list form. The base implementation of this method
    * uses the table_name and list_field variable to generate the basic query and then  adds the custom field
    * join and team filter. If you are implementing this function do not forget to consider the additional conditions.
    */

    function fill_in_additional_detail_fields() {
        global $sugar_config;

        //setup campaign name.
        $query = "SELECT name from campaigns where id = '$this->campaign_id'";
        $result =$this->db->query($query,true," Error filling in additional detail fields: ");

        // Get the id and the name.
        $row = $this->db->fetchByAssoc($result);
        if($row != null) {
            $this->campaign_name=$row['name'];
        }

        if (!class_exists('Administration')) {

        }
        $admin = Administration::getSettings('massemailer'); //retrieve all admin settings.
        if (isset($admin->settings['massemailer_tracking_entities_location_type']) and $admin->settings['massemailer_tracking_entities_location_type']=='2'  and isset($admin->settings['massemailer_tracking_entities_location']) ) {
            $this->message_url=$admin->settings['massemailer_tracking_entities_location'];
        } else {
            $this->message_url=$sugar_config['site_url'];
        }
        if ($this->is_optout == 1) {
            $this->message_url .= '/index.php?entryPoint=removeme&identifier={MESSAGE_ID}';
        } else {
            $this->message_url .= '/index.php?entryPoint=campaign_trackerv2&track=' . $this->id;
        }
    }
}
?>
