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

require_once 'modules/ModuleBuilder/Module/StudioModuleFactory.php' ;

function cmp($a,$b)
{
	return strcasecmp($a,$b);
}

class StudioBrowser{
	var $modules = array();
	
	function loadModules(){
	    global $current_user;
		$access = $current_user->getDeveloperModules();
	    $d = dir('modules');
		while($e = $d->read()){
			if(substr($e, 0, 1) == '.' || !is_dir('modules/' . $e))continue;
			if(file_exists('modules/' . $e . '/metadata/studio.php') && isset($GLOBALS [ 'beanList' ][$e]) && (in_array($e, $access) || $current_user->isAdmin())) // installed modules must also exist in the beanList
			{
				$this->modules[$e] =  StudioModuleFactory::getStudioModule( $e ) ;
			}
		}
	}
	
    function loadRelatableModules(){
        $d = dir('modules');
        while($e = $d->read()){
        	if( ( (isset($_REQUEST['view_module'])) && ($_REQUEST['view_module'] == 'Project') )
                && ($e=='ProjectTask') && (isset($_REQUEST['id'])) && $_REQUEST['id']=='relEditor' && $_REQUEST['relationship_name'] == '') continue; //46141 - disabling creating custom relationship between Projects and ProjectTasks in studio
        	if(substr($e, 0, 1) == '.' || !is_dir('modules/' . $e))continue;
            if(file_exists('modules/' . $e . '/metadata/studio.php') && isset($GLOBALS [ 'beanList' ][$e])) // installed modules must also exist in the beanList
            {
                $this->modules[$e] = StudioModuleFactory::getStudioModule( $e ) ;
            }
        }
    }
		
	function getNodes(){
		$this->loadModules();
	    $nodes = array();
		foreach($this->modules as $module){
			$nodes[$module->name] = $module->getNodes();
		}
		uksort($nodes,'cmp'); // bug 15103 - order is important - this array is later looped over by foreach to generate the module list
		return $nodes;
	}

	
	
	
	
}
?>