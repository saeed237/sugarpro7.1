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

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');
class SugarFieldCollection extends SugarFieldBase {
	var $tpl_path;

	function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
		$nolink = array('Users');
		if(in_array($vardef['module'], $nolink)){
			$displayParams['nolink']=true;
		}else{
			$displayParams['nolink']=false;
		}
		$json = getJSONobj();
        $displayParamsJSON = $json->encode($displayParams);
        $vardefJSON = $json->encode($vardef);
        $this->ss->assign('displayParamsJSON', '{literal}'.$displayParamsJSON.'{/literal}');
        $this->ss->assign('vardefJSON', '{literal}'.$vardefJSON.'{/literal}');
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        if(empty($this->tpl_path)){
        	$this->tpl_path = $this->findTemplate('DetailView');
        }
        return $this->fetch($this->tpl_path);
    }

    function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex, $searchView = false) {
        if($searchView){
        	$form_name = 'search_form';
        }else{
    		$form_name = 'EditView';
        }
        $json = getJSONobj();
        $displayParamsJSON = $json->encode($displayParams);
        $vardefJSON = $json->encode($vardef);
        $this->ss->assign('required', !empty($vardef['required']));
        $this->ss->assign('displayParamsJSON', '{literal}'.$displayParamsJSON.'{/literal}');
        $this->ss->assign('vardefJSON', '{literal}'.$vardefJSON.'{/literal}');

        $keys = $this->getAccessKey($vardef,'COLLECTION',$vardef['module']);
        $displayParams['accessKeySelect'] = $keys['accessKeySelect'];
        $displayParams['accessKeySelectLabel'] = $keys['accessKeySelectLabel'];
        $displayParams['accessKeySelectTitle'] = $keys['accessKeySelectTitle'];
        $displayParams['accessKeyClear'] = $keys['accessKeyClear'];
        $displayParams['accessKeyClearLabel'] = $keys['accessKeyClearLabel'];
        $displayParams['accessKeyClearTitle'] = $keys['accessKeyClearTitle'];

        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
	    if(!$searchView) {
	    	if(empty($this->tpl_path)){
        		$this->tpl_path = $this->findTemplate('EditView');
        	}
	    	return $this->fetch($this->tpl_path);
	    }
    }

	function getSearchViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
		$this->getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex, true);
    }
     /**
     * This should be called when the bean is saved. The bean itself will be passed by reference
     * @param SugarBean bean - the bean performing the save
     * @param array params - an array of paramester relevant to the save, most likely will be $_REQUEST
     */
	public function save(&$bean, $params, $field, $properties, $prefix = ''){
        if(isset($_POST["primary_" . $field . "_collection"])){
            $save = false;
            $value_name = $field . "_values";
            $link_field = array();
            // populate $link_field from POST
            foreach($_POST as $name=>$value){
                if(strpos($name, $field . "_collection_") !== false){
                    $num = substr($name, -1);
                    if(is_numeric($num)){
                        settype($num, 'int');
                        if(strpos($name, $field . "_collection_extra_") !== false){
                            $extra_field = substr($name, $field . "_collection_extra_" . $num);
                            $link_field[$num]['extra_field'][$extra_field]=$value;
                        }else if ($name == $field . "_collection_" . $num){
                            $link_field[$num]['name']=$value;
                        }else if ($name == "id_" . $field . "_collection_" . $num){
                            $link_field[$num]['id']=$value;
                        }
                    }
                }
            }
            // Set Primary
            if(isset($_POST["primary_" . $field . "_collection"])){
                $primary = $_POST["primary_" . $field . "_collection"];
                settype($primary, 'int');
                $link_field[$primary]['primary']=true;
            }
            // Create or update record and take care of the extra_field
            require_once('data/Link.php');
       	 	$class = load_link_class($bean->field_defs[$field]);

            $link_obj = new $class($bean->field_defs[$field]['relationship'], $bean, $bean->field_defs[$field]);
            $module = $link_obj->getRelatedModuleName();
            foreach($link_field as $k=>$v){
                $save = false;
                $update_fields = array();
                $obj = BeanFactory::getBean($module);
                if(!isset($link_field[$k]['name']) || empty($link_field[$k]['name'])){
                    // There is no name so it is an empty record -> ignore it!
                    unset($link_field[$k]);
                    break;
                }
                if(!isset($link_field[$k]['id']) || empty($link_field[$k]['id']) || (isset($_POST[$field . "_new_on_update"]) && $_POST[$field . "_new_on_update"] === 'true')){
                    // Create a new record
                    if(isset($_POST[$field . "_allow_new"]) && ($_POST[$field . "_allow_new"] === 'false' || $_POST[$field . "_allow_new"] === false)){
                        // Not allow to create a new record so remove from $link_field
                        unset($link_field[$k]);
                        break;
                    }
                    if(!isset($link_field[$k]['id']) || empty($link_field[$k]['id'])){
                        // There is no ID so it is a new record
                        $save = true;
                        $obj->name=$link_field[$k]['name'];
                    }else{
                        // We duplicate an existing record because new_on_update is set
                        $obj->retrieve($link_field[$k]['id']);
                        $obj->id='';
                        $obj->name = $obj->name . '_DUP';
                    }
                }else{
                    // id exist so retrieve the data
                    $obj->retrieve($link_field[$k]['id']);
                }
                // Update the extra field for the new or the existing record
                if(isset($v['extra_field']) && is_array($v['extra_field'])){
                    // Retrieve the changed fields
                    if(isset($_POST["update_fields_{$field}_collection"]) && !empty($_POST["update_fields_{$field}_collection"])){
                        $JSON = getJSONobj();
                        $update_fields = $JSON->decode(html_entity_decode($_POST["update_fields_{$field}_collection"]));
                    }
                    // Update the changed fields
                    foreach($update_fields as $kk=>$vv){
                        if(!isset($_POST[$field . "_allow_update"]) || ($_POST[$field . "_allow_update"] !== 'false' && $_POST[$field . "_allow_update"] !== false)){
                            //allow to update the extra_field in the record
                            if(isset($v['extra_field'][$kk]) && $vv == true){
                                $extra_field_name = str_replace("_".$field."_collection_extra_".$k,"",$kk);
                                if($obj->$extra_field_name != $v['extra_field'][$kk]){
                                    $save = true;
                                    $obj->$extra_field_name=$v['extra_field'][$kk];
                                }
                            }
                        }
                    }
                }
                // Save the new or updated record
                if($save){
                    if(!$obj->ACLAccess('save')){
                        ACLController::displayNoAccess(true);
                        sugar_cleanup(true);
                    }
                    $obj->save();
                    $link_field[$k]['id']=$obj->id;
                }
            }
            // Save new relationship or delete deleted relationship
            if(!empty($link_field)){
                if($bean->load_relationship($field)){
                    $oldvalues = $bean->$field->get(true);
                    $role_field = $bean->$field->_get_link_table_role_field($bean->$field->_relationship_name);
                    foreach($link_field as $new_v){
                        if(!empty($new_v['id'])){
                            if(!empty($role_field)){
                                if(isset($new_v['primary']) && $new_v['primary']){
                                    $bean->$field->add($new_v['id'], array($role_field=>'primary'));
                                }else{
                                    $bean->$field->add($new_v['id'], array($role_field=>'NULL'));
                                }
                            }else{
                                $bean->$field->add($new_v['id'], array());
                            }
                        }
                    }
                    foreach($oldvalues as $old_v){
                        $match = false;
                        foreach($link_field as $new_v){
                            if($new_v['id'] == $old_v['id']){
                                $match = true;
                            }
                        }
                        if(!$match){
                            $bean->$field->delete($bean->id, $old_v['id']);
                        }
                    }
                }
            }
        }
    }

}
?>