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



require_once 'modules/PdfManager/PdfManagerHelper.php';

class PdfManager extends Basic
{
    public $new_schema = true;
    public $module_dir = 'PdfManager';
    public $object_name = 'PdfManager';
    public $table_name = 'pdfmanager';
    public $importable = false;
    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $description;
    public $deleted;
    public $created_by_link;
    public $modified_user_link;
    public $team_id;
    public $team_set_id;
    public $team_count;
    public $team_name;
    public $team_link;
    public $team_count_link;
    public $teams;
    public $assigned_user_id;
    public $assigned_user_name;
    public $assigned_user_link;
    public $base_module;
    public $published;
    public $field;
    public $body_html;
    public $template_name;
    public $title;
    public $subject;
    public $keywords;

    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL': return true;
        }

        return false;
    }

    public function get_list_view_data() 
    {
        $the_array = parent::get_list_view_data();
        $the_array['BASE_MODULE'] = PdfManagerHelper::getModuleName($this->base_module);

        return  $the_array;
    }
}
