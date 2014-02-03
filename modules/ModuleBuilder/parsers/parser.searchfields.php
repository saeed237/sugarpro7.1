<?php
if (! defined ( 'sugarEntry' ) || ! sugarEntry)
    die ( 'Not A Valid Entry Point' ) ;
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

require_once ('modules/ModuleBuilder/parsers/ModuleBuilderParser.php') ;
require_once ('modules/ModuleBuilder/MB/MBPackage.php');

class ParserSearchFields extends ModuleBuilderParser
{

	var $searchFields;
	var $packageKey; 
	
    function ParserSearchFields ($moduleName, $packageName='')
    {
        $this->moduleName = $moduleName;
        if (!empty($packageName))
        {
            $this->packageName = $packageName;
            $mbPackage = new MBPackage($this->packageName);
            $this->packageKey = $mbPackage->key;
        }
        
        $this->searchFields = $this->getSearchFields();
    }
    
    function addSearchField($name, $searchField)
    {
    	if(empty($name) || empty($searchField) || !is_array($searchField))
    	{
    		return;
    	}
    	
    	$key = isset($this->packageKey) ? $this->packageKey . '_' . $this->moduleName : $this->moduleName;
        $this->searchFields[$key][$name] = $searchField;
    }
    
    function removeSearchField($name) 
    {

    	$key = isset($this->packageKey) ? $this->packageKey . '_' . $this->moduleName : $this->moduleName;

    	if(isset($this->searchFields[$key][$name]))
    	{
    		unset($this->searchFields[$key][$name]);
    	}
    }
    
    function getSearchFields()
    {
    	$searchFields = array();
        if (!empty($this->packageName) && file_exists("custom/modulebuilder/packages/{$this->packageName}/modules/{$this->moduleName}/metadata/SearchFields.php")) //we are in Module builder
        {
			include("custom/modulebuilder/packages/{$this->packageName}/modules/{$this->moduleName}/metadata/SearchFields.php");      	        	
        } else if(file_exists("custom/modules/{$this->moduleName}/metadata/SearchFields.php")) {
			include("custom/modules/{$this->moduleName}/metadata/SearchFields.php");      	        	
        } else if(file_exists("modules/{$this->moduleName}/metadata/SearchFields.php")) {
			include("modules/{$this->moduleName}/metadata/SearchFields.php");      	        	        	
        }
        
        return $searchFields;
    }
    
    function saveSearchFields ($searchFields)
    {
        if (!empty($this->packageName)) //we are in Module builder
        {
			$header = file_get_contents('modules/ModuleBuilder/MB/header.php');
            if(!file_exists("custom/modulebuilder/packages/{$this->packageName}/modules/{$this->moduleName}/metadata/SearchFields.php"))
            {
               mkdir_recursive("custom/modulebuilder/packages/{$this->packageName}/modules/{$this->moduleName}/metadata");
            }
			write_array_to_file("searchFields['{$this->packageKey}_{$this->moduleName}']", $searchFields["{$this->packageKey}_{$this->moduleName}"], "custom/modulebuilder/packages/{$this->packageName}/modules/{$this->moduleName}/metadata/SearchFields.php", 'w', $header);                	        	
        } else {
			$header = file_get_contents('modules/ModuleBuilder/MB/header.php');
            if(!file_exists("custom/modules/{$this->moduleName}/metadata/SearchFields.php"))
            {
               mkdir_recursive("custom/modules/{$this->moduleName}/metadata");
            }			
			write_array_to_file("searchFields['{$this->moduleName}']", $searchFields[$this->moduleName], "custom/modules/{$this->moduleName}/metadata/SearchFields.php", 'w', $header);                	        	
        }
        $this->searchFields = $searchFields;
    }
    


}

?>
