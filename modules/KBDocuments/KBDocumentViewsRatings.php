<?php
if(!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
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



class KBDocumentViewsRating extends SugarBean {

    var $id;
    var $kbdocument_id;
    var $views_number;
    var $ratings_number;
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $team_id;


    var $table_name = "kbdocuments_views_ratings";
    var $object_name = "KBDocumentViewsRating";
    var $module_name = 'KBDocumentsViewsRating';
    var $disable_custom_fields = true;
    var $user_preferences;

    var $encodeFields = Array ();

    var $new_schema = true;
    var $module_dir = 'KBDocuments';

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function KBDocumentViewsRatings()
    {
        self::__construct();
    }

    public function __construct() {
        parent::__construct();
        $this->setupCustomFields('KBDocumentViewsRating'); //parameter is module name
        $this->disable_row_level_security = false;
    }

    function save($check_notify = false) {
        return parent::save($check_notify);
    }

    function retrieve($id, $encode = false) {
        $ret = parent::retrieve($id, $encode);
        return $ret;
    }

    function is_authenticated() {
        return $this->authenticated;
    }

    function fill_in_additional_list_fields() {
        $this->fill_in_additional_detail_fields();
    }

    function mark_relationships_deleted($id) {
        //do nothing, this call is here to avoid default delete processing since
        //delete.php handles deletion of document revisions.
    }

    function bean_implements($interface) {
        switch ($interface) {
            case 'ACL' :
                return true;
        }
        return false;
    }
}
?>