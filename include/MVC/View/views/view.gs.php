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


require_once('include/SugarWireless/SugarWirelessView.php');
require_once('include/DetailView/DetailView2.php');

class ViewGS extends SugarWirelessView
{
    private $searchFields;
    private $searchString;
    private $searchRegex;
    private $matchHitStart = "<span class='searchHighlight'>";
    private $matchHitEnd = "</span>";

    public function ViewGS()
    {
        $this->searchString = empty($_REQUEST['q']) ? null : $_REQUEST['q'];
        $this->searchRegex = '/' . $this->searchString . '/i';
        $this->options['show_title'] = false;
		$this->options['show_header'] = false;
		$this->options['show_footer'] = false;
		$this->options['show_javascript'] = false;
		$this->options['show_subpanels'] = false;
		$this->options['show_search'] = false;
		parent::SugarView();
    }


     private function _getGlobalSearchFields()
     {
         $results = array();
         foreach ( $this->bean->field_name_map as $fieldName => $entry)
         {
             if( isset($entry['unified_search']) && $entry['unified_search'] )
             {
                 if($fieldName == 'email_addresses' || $fieldName == 'emails')
                    $results[] = 'email1';
                 else
                    $results[] = $fieldName;
             }
         }
         return $results;
     }

     function preDisplay()
     {
        $this->searchFields = $this->_getGlobalSearchFields();

 	}

    /**
     * @see SugarView::display()
     */
    public function display()
    {
 		// no record, we should also provide a way out
 	    if (empty($this->bean->id)){
 	        sugar_die($GLOBALS['app_strings']['ERROR_NO_RECORD']);
 	    }

 	    // set up Smarty variables
		$this->ss->assign('BEAN_ID', $this->bean->id);
		$this->ss->assign('BEAN_NAME', $this->bean->name);
	   	$this->ss->assign('MODULE', $this->module);
	   	$this->ss->assign('MODULE_NAME', translate('LBL_MODULE_NAME',$this->module));

        //Get the fields to display
        $detailFields = $this->bean_details('WirelessDetailView');
	   	$this->ss->assign('DETAILS', $detailFields);

        //Of the fields to display, highlight text based on match
 	    $matchedFields = $this->setMatchedFields($detailFields);
		$this->ss->assign('fields', $matchedFields);

	   	$this->ss->assign('ENABLE_FORM', $this->checkEditPermissions());
	   	$this->ss->assign('LBL_GS_HELP', $GLOBALS['app_strings']['LBL_GS_HELP']);

	   	// display the detail view
        $this->ss->display(SugarAutoLoader::existingCustomOne('include/MVC/View/tpls/gsdetail.tpl'));
    }

    protected function setMatchedFields($fields)
    {
        if($this->searchString == null)
        {
            return $fields;
        }


        foreach ($fields as &$field)
        {
            if($field['value'] == '')
            {
                continue;
            }

            //Check if we have a search match and set the highlight flag
            $matchReplace = $this->matchHitStart . '${0}' . $this->matchHitEnd;

            if(isset($field['name']) && ($field['name'] == 'email1' || $field['name'] == 'email2'))
            {
                if(preg_match_all("/\<a.*?\>(.*?)\<\/a\>/is", $field['value'], $matches))
                {
                    $aValue = $matches[1][0];
                    $aReplacedValue = preg_replace($this->searchRegex, $matchReplace, $aValue);
                    $newLink = preg_replace("/\<a(.*?)\>(.*?)\<\/a\>/i", "<a\${1}>{$aReplacedValue}<a>", $field['value']);
                    $field['value'] = $newLink;
                }
            } else if(isset($field['type']) && $field['type'] == 'phone') {
                //Do a string replacement for phone fields since it may contain special characters
                $matchReplace = $this->matchHitStart . $this->searchString . $this->matchHitEnd;
                $field['value'] = str_replace($this->searchString, $matchReplace, $field['value']);
            } else {
                if (isset($field['type']) && $field['type'] == 'enum') //TODO: Handle enums since we are destroying the key.
                {
                    continue;
                }
                $field['value'] = preg_replace($this->searchRegex, $matchReplace, $field['value']);
            }
        }

        return $fields;
    }
   /**
	 * Public function that attains the bean detail and sets up an array for
	 * Smarty consumption.
	 */
 	public function bean_details($view)
	{

 	    require_once 'modules/ModuleBuilder/parsers/views/GridLayoutMetaDataParser.php' ;
        global $current_user;

		// traverse through the wirelessviewdefs metadata to get the fields and values
		$bean_details = array();

        	foreach($this->searchFields as $field)
            {
	            // handle empty assigned_user_name
                if(empty($this->bean->assigned_user_name)) {
				   if(!empty($this->bean->assigned_user_id)){
				       $this->bean->assigned_user_name = get_assigned_user_name($this->bean->assigned_user_id);
				   }else{
                       $this->bean->assigned_user_name = $GLOBALS['current_user']->user_name;
				   }
				}

	            // handle empty team_name
	            if(empty($this->bean->team_name)) {
				   if(!empty($this->bean->team_id)){
				       $this->bean->team_name = Team::getTeamName($this->bean->team_id);
				   }else{
				       $this->bean->team_name = $GLOBALS['current_user']->default_team_name;
				   }
				}

				$field_info = $this->setup_detail_field($field);

				if (is_array($field_info))
                {
                    $name = is_array($field) ? $field['name'] : $field;

                    //If we don't have ACL field access, don't display the value
                    if(!$this->bean->ACLFieldAccess($name))
                    {
                       $field_info['value'] = '';
                    }
					$bean_details[$name] = $field_info;
				}
        	}

        return $bean_details;
 	}
}
