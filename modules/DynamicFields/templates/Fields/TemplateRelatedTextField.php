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


require_once('modules/DynamicFields/templates/Fields/TemplateField.php');
require_once 'modules/ModuleBuilder/parsers/parser.label.php';
require_once 'modules/ModuleBuilder/MB/ModuleBuilder.php';

class TemplateRelatedTextField extends TemplateText{
    var $type = 'relate';
    //ext1 is the name field
    //ext2 is the related module

    function get_html_edit(){
        $this->prepare();
        $name = $this->name .'_name';
        $value_name = strtoupper('{'.$name.'}');
        $id = $this->name ;
        $value_id = strtoupper('{'.$id .'}');
        return "<input type='text' name='$name' id='$name' size='".$this->size."' readonly value='$value_name'><input type='button' onclick='open_popup(\"{". strtoupper($this->name). "_MODULE}\", 600, 400,\" \", true, false, {ENCODED_". strtoupper($this->name). "_POPUP_REQUEST_DATA})' type='button'  class='button' value='{APP.LBL_SELECT_BUTTON_LABEL}' ><input type='hidden' name='$id' value='$value_id'>";
    }

    function get_html_detail(){
        $name = $this->name .'_name';
        $value_name = strtoupper('{'.$name.'}');
        $id = $this->name ;
        $value_id = strtoupper('{'.$id .'}');

        return "<a href='index.php?module=$this->ext2&action=DetailView&record={$value_id}'>{$value_name}</a>" ;
    }

    function get_html_list(){
        if(isset($this->bean)){
            $name = $this->bean->object_name . '.'. $this->ext1;
        }else{
            $name = $this->ext1;
        }
        return '{'. strtoupper($name) . '}';
    }

    function get_html_search(){
        $searchable=array();
        $def = $this->bean->field_name_map[$this->name];
        $searchable = array('team_id');
        if(!empty($def['id_name']) && in_array($def['id_name'], $searchable)){
            $name = $def['id_name'];
            return "<select size='3' name='{$name}[]' tabindex='1' multiple='multiple'>{".strtoupper($name). "_FILTER}</select>";
        }
        //return 'NOT AVAILABLE';
        return $this->get_html_edit();
    }

    function get_xtpl_search(){
        $searchable=array();
        $def = $this->bean->field_name_map[$this->name];
        $searchable = array('team_id');
        $returnXTPL = array();
        if(!empty($def['id_name']) && in_array($def['id_name'], $searchable)){
            $name = $def['id_name'];
            $team_list = '';
            foreach(get_team_array() as $id=>$team){
                $selected = '';

                if(!empty($_REQUEST[$name]) && is_array($_REQUEST[$name]) && in_array($id, $_REQUEST[$name])){
                    $selected = 'selected';
                }
                $team_list .= "<option  $selected value='$id'>$team</option>";
            }
            $returnXTPL[strtoupper($name). '_FILTER'] = $team_list;
        } else {
            $id = $this->name;
            $name = $this->name .'_name';
            $module = $this->ext2;
            $popup_request_data = array(
                                        'call_back_function' => 'set_return',
                                        'form_name' => 'search_form',
                                        'field_to_name_array' => array(
                                        'id' => $this->name,
                                        $this->ext1 => $name,
                                    ),
            );

            $json = getJSONobj();
            $encoded_popup_request_data = $json->encode($popup_request_data);
            $returnXTPL['ENCODED_'.strtoupper($id).'_POPUP_REQUEST_DATA'] = $encoded_popup_request_data;
            $returnXTPL[strtoupper($id).'_MODULE'] = $module;

            if(isset( $_REQUEST[$name])){
               $returnXTPL[strtoupper($name)] =  $_REQUEST[$name];
            }
            if(isset( $_REQUEST[$id])){
               $returnXTPL[strtoupper($id)] =  $_REQUEST[$id];
            }
        }
        return $returnXTPL;
    }


    function get_xtpl_edit(){
    global $beanList;

        $name = $this->name .'_name';
        $id = $this->name;
        $module = $this->ext2;
        $returnXTPL = array();
        $popup_request_data = array(
            'call_back_function' => 'set_return',
            'form_name' => 'EditView',
            'field_to_name_array' => array(
            'id' => $this->name,
            $this->ext1 => $name,
        ),
        );

        //$GLOBALS['log']->fatal($this->bean);

        $json = getJSONobj();
        $encoded_contact_popup_request_data = $json->encode($popup_request_data);
        $returnXTPL['ENCODED_'.strtoupper($id).'_POPUP_REQUEST_DATA'] = $encoded_contact_popup_request_data;
        $returnXTPL[strtoupper($id).'_MODULE'] = $module;

        if(isset($this->bean->$id)){
            if(!isset($this->bean->$name)){
                $mod_field = $this->ext1;
                $mod = BeanFactory::getBean($module, $this->bean->$id);
                if(isset($mod->$mod_field)){
                    $this->bean->$name = $mod->$mod_field;
                }
            }


            $returnXTPL[strtoupper($id)] = $this->bean->$id;
        }
        if(isset($this->bean->$name)){
            $returnXTPL[strtoupper($name)] = $this->bean->$name;
        }
        if(isset($this->bean->$id)) {
            $returnXTPL[strtoupper($id)] = $this->bean->$id;
        }


        return $returnXTPL;
    }

    function get_xtpl_detail(){
        return $this->get_xtpl_edit();
    }

    function get_related_info(){

    }

     function get_field_def(){
        $def = parent::get_field_def();
        $def['id_name'] = $this->ext3;
        $def['ext2'] = $this->ext2;
        $def['module'] = $def['ext2'];
        //Special case for documents, which use a document_name rather than name
        if ($def['module'] == "Documents") {
        	$def['rname'] = 'document_name';
        } else {
        	$def['rname'] = 'name';
        }
        $def['quicksearch'] = 'enabled';
        $def['studio'] = 'visible';
        $def['source'] = 'non-db';
        return $def;
    }


    
    /**
     * Delete field
     *
     * @param DynamicField $df
     */
    public function delete($df)
    {
        if ($df instanceof DynamicField) {
            $fieldId = $df->getFieldWidget($df->module, $this->id_name);
        } elseif ($df instanceof MBModule) {
            $fieldId = $df->getField($this->id_name);
        } else {
            $GLOBALS['log']->fatal('Unsupported DynamicField type');
        }

        $this->deleteIdLabel($fieldId, $df);
        $fieldId->delete($df);
        parent::delete($df);
    }
        
    /**
     * Delete label of id field
     * @param TemplateField $fieldId
     * @param $df
     */
    protected function deleteIdLabel(TemplateField $fieldId, $df)
    {
        if ($df instanceof DynamicField) {
            require_once 'modules/ModuleBuilder/parsers/parser.label.php';
            foreach (array_keys($GLOBALS['sugar_config']['languages']) AS $language) {
                foreach (ModuleBuilder::getModuleAliases($df->module) AS $module) {
                    $mod_strings = return_module_language($language, $module);
                    if (isset($mod_strings[$fieldId->vname])) {
                        ParserLabel::removeLabel($language, $fieldId->vname, $mod_strings[$fieldId->vname], $module);
                    }
                }
            }
    
        } elseif ($df instanceof MBModule) {
            foreach (array_keys($GLOBALS['sugar_config']['languages']) AS $language) {
                $df->deleteLabel($language, $fieldId->vname);
                $df->save();
            }
        }
    }


    function save($df){
        // create the new ID field associated with this relate field - this will hold the id of the related record
        // this field must have a unique name as the name is used when constructing quicksearches and when saving the field
        //Check if we have not saved this field so we don't create two ID fields.
        //Users should not be able to switch the module after having saved it once.
        if (!$df->fieldExists($this->name)) {
	    	$id = new TemplateId();
	        $id->len = 36;
            $id->label = strtoupper("LBL_{$this->name}_".BeanFactory::getBeanName($this->ext2)."_ID");
            $id->vname = $id->label;
            $this->saveIdLabel($id->label, $df);

	        $count = 0;
	        $basename = strtolower(get_singular_bean_name($this->ext2)).'_id' ;
	        $idName = $basename.'_c' ;

	        while ( $df->fieldExists($idName, 'id') )
	        {
	            $idName = $basename.++$count.'_c' ;
	        }
	        $id->name = $idName ;
			$id->reportable = false;
	        $id->save($df);

	        // record the id field's name, and save
	        $this->ext3 = $id->name;
            $this->id_name = $id->name;
        }

        parent::save($df);
    }

    /**
     * Save label for id field
     *
     * @param string $idLabelName
     * @param DynamicField $df
     */
    protected function saveIdLabel($idLabelName, $df)
    {
        if ($df instanceof DynamicField) {
            $module = $df->module;
        } elseif ($df instanceof MBModule) {
            $module = $df->name;
        }else{
            $GLOBALS['log']->fatal('Unsupported DynamicField type');
        }
        $viewPackage = isset($df->package)?$df->package:null;

        $idLabelValue = string_format(
            $GLOBALS['mod_strings']['LBL_RELATED_FIELD_ID_NAME_LABEL'],
            array($this->label_value, $GLOBALS['app_list_strings']['moduleListSingular'][$this->ext2])
        );

        $idFieldLabelArr = array(
            "label_{$idLabelName}" => $idLabelValue
        );

        foreach(ModuleBuilder::getModuleAliases($module) AS  $moduleName) {
            if ($df instanceof DynamicField) {
                $parser = new ParserLabel($moduleName, $viewPackage);
                $parser->handleSave($idFieldLabelArr, $GLOBALS['current_language']);
            } elseif ($df instanceof MBModule) {
                $df->setLabel($GLOBALS ['current_language'], $idLabelName, $idLabelValue);
                $df->save();
            }
        }

    }
    
    function get_db_add_alter_table($table){
    	return "";
    }

    function get_db_delete_alter_table($table) {
    	return "";
    }

    function get_db_modify_alter_table($table){
    	return "";
    }

}


?>
