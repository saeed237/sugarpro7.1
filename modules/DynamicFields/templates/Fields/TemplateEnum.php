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


require_once('include/utils/array_utils.php');
class TemplateEnum extends TemplateText{
    var $max_size = 100;
    var $len = 100;
    var $type='enum';
    var $ext1 = '';
    var $default_value = '';
    var $dependency ; // any dependency information
    var $supports_unified_search = true;

    function __construct ()
    {
    	// ensure that the field dependency information is read in from any _REQUEST
    	$this->localVardefMap = array (
    		'trigger' => 'trigger',
    		'action' => 'action' ,
            'visibility_grid' => 'visibility_grid',
        ) ;
    	$this->vardef_map = array_merge ( $this->vardef_map , $this->localVardefMap ) ;
    }

    function populateFromPost ()
    {
    	parent::populateFromPost();
        if (!empty($this->visibility_grid) && is_string($this->visibility_grid))
        {
            $this->visibility_grid = json_decode(html_entity_decode($this->visibility_grid), true);
        }
    	// now convert trigger,action pairs into a dependency array representation
    	// we expect the dependencies in the following format:
    	// trigger = [ trigger for action 1 , trigger for action 2 , ... , trigger for action n ]
    	// action = [ action 1 , action 2 , ... , action n ]

    	// check first if we have the component parts of a dependency
    	$dependencyPresent = true ;
    	foreach ( $this->localVardefMap as $def )
    	{
    		$dependencyPresent &= isset ( $this->$def ) ;
    	}

    	if ( $dependencyPresent )
    	{
    		$dependencies = array () ;

    		if ( is_array ( $this->trigger ) && is_array ( $this->action ) )
    		{
				for ( $i = 0 ; $i < count ( $this->action ) ; $i++ )
				{
					$dependencies [ $this->trigger [ $i ] ] = $this->action [ $i ] ;
				}
				$this->dependency = $dependencies ;
    		}
    		else
    		{
    			if ( ! is_array ( $this->trigger ) && ! is_array ( $this->action ) )
    				$this->dependency = array ( $this->trigger => $this->action ) ;
    		}
    		// tidy up
    		unset ( $this->trigger ) ;
    		unset ( $this->action ) ;
    	}
    }
	function get_xtpl_edit(){
		$name = $this->name;
		$value = '';
		if(isset($this->bean->$name)){
			$value = $this->bean->$name;
		}else{
			if(empty($this->bean->id)){
				$value= $this->default_value;
			}
		}
		if(!empty($this->help)){
		    $returnXTPL[strtoupper($this->name . '_help')] = translate($this->help, $this->bean->module_dir);
		}

		global $app_list_strings;
		$returnXTPL = array();
		$returnXTPL[strtoupper($this->name)] = $value;
		if(empty($this->ext1)){
			$this->ext1 = $this->options;
		}
		$returnXTPL[strtoupper('options_'.$this->name)] = get_select_options_with_id($app_list_strings[$this->ext1], $value);

		return $returnXTPL;


	}

	function get_xtpl_search(){
		$searchFor = '';
		if(!empty($_REQUEST[$this->name])){
			$searchFor = $_REQUEST[$this->name];
		}
		global $app_list_strings;
		$returnXTPL = array();
		$returnXTPL[strtoupper($this->name)] = $searchFor;
		if(empty($this->ext1)){
			$this->ext1 = $this->options;
		}
		$returnXTPL[strtoupper('options_'.$this->name)] = get_select_options_with_id(add_blank_option($app_list_strings[$this->ext1]), $searchFor);
		return $returnXTPL;

	}

	function get_field_def(){
		$def = parent::get_field_def();
		$def['options'] = !empty($this->options) ? $this->options : $this->ext1;
		$def['default'] = !empty($this->default) ? $this->default : $this->default_value;
		$def['len'] = $this->max_size;
		$def['studio'] = 'visible';
		// this class may be extended, so only do the unserialize for genuine TemplateEnums
		if (get_class( $this ) == 'TemplateEnum' && empty($def['dependency']) )
			$def['dependency'] = isset($this->ext4)? unserialize(html_entity_decode($this->ext4)) : null ;
        if (!empty($this->visibility_grid))
            $def['visibility_grid'] = $this->visibility_grid;

		return $def;
	}

	function get_xtpl_detail(){
		$name = $this->name;

		// awu: custom fields are not being displayed on the detail view because $this->ext1 is always empty, adding this to get the options
		if(empty($this->ext1)){
			if(!empty($this->options))
				$this->ext1 = $this->options;
		}

		if(isset($this->bean->$name)){
			$key = $this->bean->$name;
			global $app_list_strings;
			if(preg_match('/&amp;/s', $key)) {
			   $key = str_replace('&amp;', '&', $key);
			}
			if(isset($app_list_strings[$this->ext1])){
                if(isset($app_list_strings[$this->ext1][$key])) {
                    return $app_list_strings[$this->ext1][$key];
                }

				if(isset($app_list_strings[$this->ext1][$this->bean->$name])){
					return $app_list_strings[$this->ext1][$this->bean->$name];
				}
			}
		}
		return '';
	}

	function save($df){
		if (!empty($this->default_value) && is_array($this->default_value)) {
			$this->default_value = $this->default_value[0];
		}
		if (!empty($this->default) && is_array($this->default)) {
			$this->default = $this->default[0];
		}
        if (!empty($this->visibility_grid) && is_string($this->visibility_grid))
        {
            $this->visibility_grid = json_decode($this->visibility_grid, true);
        }
		parent::save($df);
	}

    /**
     * @param DynamicField $df
     */
    function delete($df){
        //If a dropdown uses the field that is being delted as a parent dropdown, we need to remove that dependency
        $seed = BeanFactory::getBean($df->getModuleName());
        if ($seed)
        {
            $fields = $seed->field_defs;
            foreach($fields as $field => $def)
            {
                if (!empty($def['visibility_grid']['trigger']) && $def['visibility_grid']['trigger'] == $this->name)
                {
                    $field = get_widget ( $def [ 'type' ] ) ;
                    unset($def['visibility_grid']);
                    $field->populateFromRow($def);
                    if(isset($def['source']) && $def['source'] == "custom_fields")
                        $field->save ( $df );
                    else
                    {
                        //Out of the box field that we need to use a StandardField rather than DynamicFIeld object to save
                        require_once ('modules/ModuleBuilder/parsers/StandardField.php') ;
                        $sf = new StandardField ( $df->getModuleName() ) ;
                        $sf->setup ( $seed ) ;
                        $field->module = $seed;
                        $field->save ( $sf ) ;
                    }
                }
            }
        }

        parent::delete($df);
    }
}


?>
