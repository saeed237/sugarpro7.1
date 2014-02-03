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

require_once('modules/DynamicFields/templates/Fields/TemplateEnum.php');

require_once('modules/DynamicFields/templates/Fields/TemplateId.php');
require_once('modules/DynamicFields/templates/Fields/TemplateParentType.php');
class TemplateParent extends TemplateEnum{
    var $max_size = 25;
    var $type='parent';
    
    function get_field_def(){
        $def = parent::get_field_def();
        $def['type_name'] = 'parent_type';
        $def['id_name'] = 'parent_id';
        $def['parent_type'] = 'record_type_display';
        $def['source'] = 'non-db';
        $def['studio'] = 'visible';
        return $def;    
    }
    
    function delete($df){
        parent::delete($df);
        //currency id
        $parent_type = new TemplateText();
        $parent_type->name = 'parent_type';
        $parent_type->delete($df);  
        
        $parent_id = new TemplateId();
        $parent_id->name = 'parent_id';
        $parent_id->delete($df);
    }
    
    function save($df){
        $this->ext1 = 'parent_type_display';
        $this->name = 'parent_name';
        $this->default_value = '';
        parent::save($df); // always save because we may have updates
        
        //save parent_type
        $parent_type = new TemplateParentType();
        $parent_type->name = 'parent_type';
        $parent_type->vname = 'LBL_PARENT_TYPE';
        $parent_type->label = $parent_type->vname;
        $parent_type->len = 255;
        $parent_type->importable = $this->importable;
        $parent_type->save($df);
            
        //save parent_name
        $parent_id = new TemplateId();
        $parent_id->name = 'parent_id';
        $parent_id->vname = 'LBL_PARENT_ID';
        $parent_id->label = $parent_id->vname;
        $parent_id->len = 36;
        $parent_id->importable = $this->importable;
        $parent_id->save($df);
    }
    
    function get_db_add_alter_table($table){
        return '';
    }
    /**
     * mysql requires the datatype caluse in the alter statment.it will be no-op anyway.
     */ 
    function get_db_modify_alter_table($table){
        return '';
    }
    
    
}


?>
