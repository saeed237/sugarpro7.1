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

/*********************************************************************************

 * Description:
 ********************************************************************************/




require_once('include/workflow/workflow_utils.php');
require_once('include/workflow/field_utils.php');
require_once('include/utils/expression_utils.php');


require_once('modules/Expressions/MetaArray.php');

// Expression is a general object for expressions, filters, and calculations
class Expression extends SugarBean {
	var $field_name_map;
	// Stored fields
	var $id;
	var $deleted;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $created_by;
	var $created_by_name;
	var $modified_by_name;

	//construction
	var $name;


	var $lhs_type;
	var $lhs_field;
	var $lhs_module;
	var $lhs_value;

	var $lhs_group_type;
	var $operator;
	var $rhs_group_type;

	var $rhs_type;
	var $rhs_field;
	var $rhs_module;
	var $rhs_value;

	var $parent_id;
	var $exp_type;
	var $exp_order;

	var $parent_exp_id;
	var $parent_exp_side;

	var $parent_type = "filter";

	var $ext1;
	var $ext2;
	var $ext3;

	var $return_prefix;

	//used for the selector popups
	var $show_field = false;			//show the block for selecting field
	var $seed_object;


	///for display text
	var $target_bean;
	var $display_array;



	var $selector_popup_fields = Array(
	"lhs_module"
	,"lhs_field"
	,"return_prefix"
	,"rhs_value"
	,"parent_type"
	,"operator"
	);


	var $table_name = "expressions";
	var $module_dir = "Expressions";
	var $object_name = "Expression";

	var $new_schema = true;

	var $column_fields = Array("id"
		,"name"
		,"date_entered"
		,"date_modified"
		,"modified_user_id"
		,"created_by"

		,"lhs_type"
		,"lhs_field"
		,"lhs_module"
		,"lhs_value"

		,"lhs_group_type"
		,"operator"
		,"rhs_group_type"

		,"rhs_type"
		,"rhs_field"
		,"rhs_module"
		,"rhs_value"

		,"parent_id"
		,"exp_type"
		,"exp_order"

		,"parent_exp_id"
		,"parent_exp_side"

		,"parent_type"

		,"ext1"
		,"ext2"
		,"ext3"
		);


	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array();

	// This is the list of fields that are in the lists.
	var $list_fields = array();
	// This is the list of fields that are required
	var $required_fields =  array();

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function Expression()
    {
        self::__construct();
    }

	public function __construct() {
		parent::__construct();

		$this->disable_row_level_security =true;

	}



	function get_summary_text()
	{
		return "$this->name";
	}




	/** Returns a list of the associated product_templates
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved.
	 * Contributor(s): ______________________________________..
	*/

    function create_export_query(&$order_by, &$where)
    {

    }



	function save_relationship_changes($is_update)
    {
    }


	function mark_relationships_deleted($id)
	{
	}

	function fill_in_additional_list_fields()
	{

	}

	function fill_in_additional_detail_fields()
	{

	}



	function get_list_view_data()
    {
	}


	function clear_deleted($id)
    {
	}





	function get_selector_array($type, $value, $dom_name, $text_only_array=false, $meta_filter_name="", $only_related_modules = false, $trigger_type="", $only_plural = false){
		global $app_list_strings;
		global $current_language;

		if($type=='assigned_user_id' || $type=='assigned_user_name'){

			$select_array = get_user_array(TRUE, "Active", "", true, null, ' AND is_group=0 ');
		}
		if($type=='team_list'){

			$select_array = get_team_array();
		}
		if($type=='role'){
			$select_array = get_bean_select_array(true, 'ACLRole','name');

		}
		if($type=='dom_array'){
			if(!empty($app_list_strings[$dom_name])){
				$select_array = $app_list_strings[$dom_name];
			}
				ksort($select_array);
		}

		if($type=='field'){
		    $temp_module = BeanFactory::getBean($dom_name);
		    if ( !is_object($temp_module) ) {
		        //var_dump($dom_name);
		        //display_stack_trace(true);
		        $GLOBALS['log']->fatal("get_selector_array: Unknown module: $dom_name");
		        return null;
		    }
		    if(isset($trigger_type) && !empty($trigger_type)){
		    	global $process_dictionary;
		    	include_once('modules/WorkFlowTriggerShells/MetaArray.php');
		    	if(array_key_exists("trigger_type_override", $process_dictionary['TriggersCreateStep1']['elements'][$trigger_type])){
		    		//we have found an override
		    		$meta_filter_name = $process_dictionary['TriggersCreateStep1']['elements'][$trigger_type]['trigger_type_override'];
		    	}
		    }
            $temp_module->call_vardef_handler($meta_filter_name);
            if($_GET['opener_id']=='rel_module')
            {
                $temp_select_array = $temp_module->vardef_handler->get_vardef_array(false, false, true, false);
                $select_array = getDuplicateRelationListWithTitle($temp_select_array, $temp_module->vardef_handler->module_object->field_defs, $temp_module->vardef_handler->module_object->module_dir);
            }
            else
            {
                $select_array = $temp_module->vardef_handler->get_vardef_array(true);
                $select_array = array_unique($select_array);
                asort($select_array);
            }

		//end if type is field
		}

		if($type=='module_list'){
			if($only_related_modules){
					global $beanList;
					$temp_module = BeanFactory::getBean($dom_name);
					$temp_module->call_vardef_handler("rel_filter");

					$select_array = $temp_module->vardef_handler->get_vardef_array(true, '', true, true);
			}
			else if($meta_filter_name == "singular"){
				$select_array = convert_module_to_singular(get_module_map(false));
			} else {
				$select_array = get_module_map();
			}

			unset($select_array["Forecasts"]);
			unset($select_array["Products"]);
			unset($select_array["Documents"]);
			asort($select_array);
		//end if type is module_list
		}

		if(!empty($select_array)){
			if($text_only_array==true){
				return $select_array;
			} else {
				return get_select_options_with_id($select_array, $value);
			}
		} else {
			return null;
		}
	//end get_selector_array
	}



	function build_field_filter($base_module, $target_field, $enum_multi=false){

			////Begin - New Code call to workflow_utils
		$temp_module = BeanFactory::getBean($base_module);
		//Build Selector Array
		$selector_array = array(
							'value' => $this->rhs_value,
							'operator' => $this->operator,
							'time' => $this->ext1,
							'field' => $target_field,
							'target_field' => $this->lhs_field,
							);

		$meta_array = array(
							'parent_type' => $this->parent_type,
							'enum_multi' => $enum_multi,
							);


		$output_array = get_field_output($temp_module, $selector_array, $meta_array);
		return $output_array;


	//end function build_field_filter
	}


///////////////////////////////////Display label functions///////////////


	function get_display_array_using_name($target_module=""){
	//use this if you don't have the module name.
	//you can either build using lhs_module or override with your own

		if($target_module==""){
			$target_bean = BeanFactory::getBean($this->lhs_module);
		} else {
			$target_bean = BeanFactory::getBean($target_module);
		}

		return $this->get_display_array($target_bean);

	//end function get_display_array_using_name
	}

	function get_display_array(& $target_bean){
	    global $app_strings;
		$this->target_bean = $target_bean;
		$this->display_array = array();

		//Grab label for lhs_field
		$this->display_array['lhs_field'] = translate_label_from_bean($target_bean, $this->lhs_field);


		//Grab label for operator
		$this->display_array['operator'] = $this->get_display_operator($this->operator);



		//check for enum multi
		if($this->operator=="in" || $this->operator=="not_in"){

			//foreach loop on the in values
			$selected_array = unencodeMultienum($this->rhs_value);
			$multi_text = "";
			$selected_count = count($selected_array);
			$the_counter = 1;
			foreach($selected_array as $key => $value){


				if($multi_text!=""){
					if($the_counter != $selected_count){
					$multi_text .=", ";
					} else {
						if($selected_count > 2){
							$multi_text	.= ", {$app_strings['LBL_LOWER_OR']} ";
						} else {
							$multi_text .= " {$app_strings['LBL_LOWER_OR']} ";
						}
					}
				//end if multi is not blank
				}

				$multi_text .= $this->get_display_rhs_value($value);
			++$the_counter;
			}

			$this->display_array['rhs_value'] = $multi_text;
		//end if enum multi
		} else {

			//Grab lable for rhs_value
			$this->display_array['rhs_value'] = $this->get_display_rhs_value($this->rhs_value);
		//end if not enum multi value
		}

		//if blank value then set to "NONE"
		//if($this->display_array['rhs_value']==""){
		//	$this->display_array['rhs_value'] = "none";
		//}

		return $this->display_array;

	//end function get_display_array
	}


	function get_display_rhs_value($rhs_value){

			if( $this->exp_type == "assigned_user_name" || $this->exp_type == "team_list"){

				$text_array = $this->get_selector_array($this->exp_type, $rhs_value, "", true);

				return $text_array[$rhs_value];

			//end if team or assigned_user
			}

			if($this->exp_type == "bool"){
	            global $app_list_strings;
				if($rhs_value=="bool_true"){
					return isset($app_list_strings['bselect_type_dom']['bool_true']) ? $app_list_strings['bselect_type_dom']['bool_true'] : 'Yes';
				}
				if($rhs_value=="bool_false"){
					return isset($app_list_strings['bselect_type_dom']['bool_false']) ? $app_list_strings['bselect_type_dom']['bool_false'] : 'No';
				}
				return "";
			//end if target_type is bool
			}
			//if enum and reaching here
			if($this->exp_type == "enum" || $this->exp_type == "multienum"){
				return translate_option_name_from_bean($this->target_bean, $this->lhs_field, $rhs_value);
			//end if enum
			}


				return $rhs_value;

	//end function get_display_rhs_value
	}



	function get_display_operator(){
		global $app_list_strings, $app_strings, $mod_strings;
		if($this->operator=="in"){
			$operator_text = $app_strings['LBL_OPERATOR_IN_TEXT'];
		} else if($this->operator=="not_in"){
			$operator_text = $app_strings['LBL_OPERATOR_NOT_IN_TEXT'];
		} else if(!empty($app_list_strings['dselect_type_dom'][$this->operator])) {
            $operator_text = $app_list_strings['dselect_type_dom'][$this->operator];
        }
        else {
			$operator_text = $this->operator;
		}

		return $operator_text;

	//end function get_display_operator
	}


	function handleSave($prefix, $parent_type, $exp_id=""){

		if($exp_id!=""){
			$this->retrieve($exp_id);
		}


		foreach($this->column_fields as $field){
			if(isset($_POST[$prefix."".$field])){
			$this->$field = $_POST[$prefix."".$field];
			}
		}

		if(!empty($_POST[$prefix.'time_int'])){
			$this->ext1 = $_POST[$prefix.'time_int'];
		}


		$this->parent_type = $parent_type;
		$this->save();

	//end function handleSave
	}

    /**
     * This function will determine whether the given input string is plural
     *
     * @param string to check
     *
     * @return true or false
     */
    function isPlural($text){
        $pattern = '/s$/i';
        preg_match($pattern, $text, $matches);
        return (count($matches) > 0);
    }

//end class Expression
}

?>
