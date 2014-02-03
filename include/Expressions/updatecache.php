<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
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


/**
 * Traverses the Arithmetic directory and builds the cache of
 * function to object mappings.
 */
$GLOBALS['ignore_files'] = array(
						'AbstractExpression.php',
						'EnumExpression.php',
						'NumericExpression.php',
						'StringExpression.php',
						'TimeExpression.php',
						'DateExpression.php',
						'BooleanExpression.php',
						'FalseExpression.php',
						'GenericExpression.php',
                        'RelateExpression.php',
						'AbstractAction.php',
						'ActionFactory.php',
                        'DefineRelateExpression.php'
					);


function recursiveParse($dir, $silent = false)
{
	//Check if the directory exists
	if ( !is_dir($dir) )	return;
	$directory = opendir($dir);
	if ( !$directory )	return;

	// First get a list of all the files in this directory.
	$entries = array();
	while( $entry = readdir($directory) )
	{
		$entries[] = $entry;
	}
	closedir($directory);

	if ($silent === false) {
		echo "<ul>";
	}

	$contents = "";
	$js_contents = "";

	foreach ( $entries as $entry ) {
		// skip current and parent
		if ( $entry == '.' || $entry == '..' )	continue;

		// parse the sub-directories
		if ( !is_file($entry) ) {
			$cont = recursiveParse($dir . "/" . $entry, $silent);
			$contents 	 .= $cont["function_map"];
			$js_contents .= $cont["javascript"];
		}

		// Check for extensions.
		if ( ! preg_match('/^[0-9a-zA-Z-_]+Expression.php$/', $entry) )	continue;

		// ignore files
		if ( in_array($entry."", $GLOBALS['ignore_files']) ) {
			if (!$silent) echo "<i>Ignoring $entry</i><br>";
			continue;
		}

		// now require this Expression file
		require_once($dir . "/" . $entry);
		$entry = str_replace(".php", "", $entry);
		$js_code     = call_user_func(array($entry, "getJSEvaluate"));
		$param_count = call_user_func(array($entry, "getParamCount"));
		$op_name     = call_user_func(array($entry, "getOperationName"));
		$types 		 = call_user_func(array($entry, "getParameterTypes"));

		if ( empty($op_name) )	{
			if ($silent === false) {
				echo "<i>EMPTY OPERATION NAME $entry</i><br>";
			}
			continue;
		}
		if (!is_array($op_name))
		  $op_name = array($op_name);

		$parent_class = get_parent_class($entry);
		$parent_types = call_user_func(array($parent_class, "getParameterTypes"));

        //This is a workaround for out-of-order filesystem loading.  On some systems, things that extend base
        //expressions load before what they extend have loaded.
        if ($js_code !== false) {

		$js_contents .= <<<EOQ
/**
 * Construct a new $entry.
 */
SUGAR.expressions.$entry = function(params, context) {
	this.context = context;
	this.init(params);
}
SUGAR.util.extend(SUGAR.expressions.$entry, SUGAR.expressions.$parent_class, {
    className: "$entry",
	evaluate: function() {
$js_code
	}

EOQ;

		if ( $param_count != -1 ) {

$js_contents .= <<<EOQ
	,getParamCount: function() {
		return $param_count;
	}

EOQ;
		}

		if ( is_array($types) ) {

$js_contents .= <<<EOQ
	,getParameterTypes: function() {
		return [
EOQ;

		$types_code = "";
		foreach ( $types as $type )	$types_code .= "'$type',";
		$js_contents .= substr($types_code, 0, strlen($types_code)-1);
		$js_contents .= "];\n";


$js_contents.= <<<EOQ
	}

EOQ;

		}

		if ( !is_array($types) && $parent_types != $types ) {
			if ($silent === false) {
				echo "type mismatch<br>";
			}
$js_contents .= <<<EOQ
	,getParameterTypes: function() {
		return '$types';
	}

EOQ;
		}


$js_contents .= "});\n\n";
}
		foreach ($op_name as $alias)
		{
	        //echo the entry
			if ($silent === false)
			{
				echo "<li>($alias) $entry<br>";
			}

			$contents .= <<<EOQ
			'$alias' => array(
						'class'	=>	'$entry',
						'src'	=>	'$dir/$entry.php',
			),\n
EOQ;
		}
	}
	if ($silent === false)
	{
		echo "</ul>";
	}

	return array("function_map" => $contents, "javascript"=>$js_contents);
}

$silent = isset($GLOBALS['updateSilent']) ? $GLOBALS['updateSilent'] : false;
// the new contents of the functionmap.php file
$contents = recursiveParse("include/Expressions/Expression", $silent);

if (is_dir("custom/include/Expressions/Expression")) {
    $customContents = recursiveParse("custom/include/Expressions/Expression", $silent);
    $contents["function_map"] .= $customContents["function_map"];
	$contents["javascript"]   .= $customContents["javascript"];
}

//Parse Actions into the cached javascript.
require_once("include/Expressions/Actions/ActionFactory.php");
$contents["javascript"] .= ActionFactory::buildActionCache($silent);


$new_contents = "<?php\n\$FUNCTION_MAP = array(\n";
$new_contents .= $contents["function_map"];
$new_contents .= ");\n";
$new_contents .= "?>";


create_cache_directory("Expressions/functionmap.php");

$fmap = sugar_cached("Expressions/functionmap.php");
// now write the new contents to functionmap.php
$fh = fopen($fmap, 'w');
fwrite($fh, $new_contents);
fclose($fh);


// write the functions cache file
$cache_contents = $contents["javascript"];

require_once $fmap;

$cache_contents .= <<<EOQ
/**
 * The function to object map that is used by the Parser
 * to parse expressions into objects.
 */
SUGAR.FunctionMap = {

EOQ;
if ( isset($FUNCTION_MAP) && is_array($FUNCTION_MAP) ) {
    foreach ( $FUNCTION_MAP as $key=>$value ) {
        $entry = $FUNCTION_MAP[$key]['class'];
        $cache_contents .= "\t'$key'\t:\tSUGAR.expressions.$entry,";
    }
}
$cache_contents = substr($cache_contents, 0, -1);
$cache_contents .= "};\n";


$cache_contents .= <<<EOQ
/**
 * The function to object map that is used by the Parser
 * to parse expressions into objects.
 */
SUGAR.NumericConstants = {

EOQ;
if ( isset(Parser::$NUMERIC_CONSTANTS) && is_array(Parser::$NUMERIC_CONSTANTS) ) {
    foreach ( Parser::$NUMERIC_CONSTANTS as $key=>$value ) {
        $cache_contents .= "\t'$key'\t:\t$value,";
    }
}
$cache_contents = substr($cache_contents, 0, -1);
$cache_contents .= "};\n";

create_cache_directory("Expressions/functions_cache_debug.js");
file_put_contents(sugar_cached("Expressions/functions_cache_debug.js"), $cache_contents);


require_once("jssource/minify_utils.php");
$minifyUtils = new SugarMinifyUtils();
$minifyUtils->CompressFiles(sugar_cached('Expressions/functions_cache_debug.js'), sugar_cached('Expressions/functions_cache.js'));
if (!$silent) echo "complete.";
?>
