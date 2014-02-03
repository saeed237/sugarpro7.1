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

class ViewFunctiondetail extends SugarView
{
	function ViewFunctionDetail(){
		$this->options['show_footer'] = false;
		$this->options['show_header'] = false;
 		parent::SugarView();

 	}

 	function display(){
 		global $app_strings, $current_user, $mod_strings, $theme, $beanList, $beanFiles;
 		if (!is_file($cachefile = sugar_cached('Expressions/functionmap.php'))) {
        	$GLOBALS['updateSilent'] = true;
            include ('include/Expressions/updatecache.php');
        }
 		include $cachefile;
 		require_once('include/JSON.php');
 		$desc = "";
 		if (!empty($_REQUEST['function']) && !empty($FUNCTION_MAP[$_REQUEST['function']])){
 			$func_def =  $FUNCTION_MAP[$_REQUEST['function']];
			require_once($func_def['src']);
			$class = new ReflectionClass($func_def['class']);
			$doc = $class->getDocComment();
			if (!empty($doc)) {
				//Remove the javadoc style comment *'s
				$desc = preg_replace("/((\/\*+)|(\*+\/)|(\n\s*\*)[^\/])/", "", $doc);
			} else if (isset($mod_strings['func_descriptions'][$_REQUEST['function']]))
			{
				$desc = $mod_strings['func_descriptions'][$_REQUEST['function']];
			}
			else
			{
				$seed = $func_def['class'];
				$count = call_user_func(array($seed, "getParamCount"));
				$type = call_user_func(array($seed, "getParameterTypes"));
				$desc = $_REQUEST['function'] . "(";
				if ($count == -1)
				{
					$desc .=  $type . ", ...";
				} else {
					for ($i = 0; $i < $count; $i++) {
						if ($i != 0) $desc .= ", ";
						if (is_array($type))
							$desc .=  $type[$i] . ($i+1);
						else
							$desc .=  $type . ($i+1);
					}
				}
				$desc .= ")";
			}
		}
		else {
			$desc = "function not found";
		}
		echo json_encode(array(
			"func" => empty($_REQUEST['function']) ? "" : $_REQUEST['function'],
			"desc" => $desc,
		));
 	}
}
?>