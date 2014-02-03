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

require_once("include/Expressions/Trigger.php");
require_once("include/Expressions/Dependency.php");
require_once("include/Expressions/Expression/Parser/Parser.php");
require_once("include/Expressions/Expression/AbstractExpression.php");

/**
 * Base action class
 * @api
 */
abstract class AbstractAction {
	protected $targetField = array();
    protected $params = array();

	/**
	 * Actions are expressions which modify data or layouts.
	 *
	 * @param Array $params A set of parameters to use in this action.
	 * @return AbstractAction
	 */
	function AbstractAction($params) {
		$this->params = $params;
		if (is_array($params) && isset($params['target'])) {
			$this->targetField = $params['target'];
		} else {
			$this->targetField = $params;
		}
	}

	/**
	 * Returns the javascript class equavalent to this php class
	 *
	 * @return string javascript.
	 */
	abstract static function getJavascriptClass() ;

	/**
	 * Returns the javascript code to create a new action of this type
	 * and execute the action.
	 *
	 * @return string javascript.
	 */
	abstract function getJavascriptFire();

	/**
	 * Applies the Action to the target.
	 *
	 * @param SugarBeam $target
	 */
	abstract function fire(&$target);

	/**
	 * Returns the definition of this action in array format.
	 *
	 */
	function getDefinition() {
		return array(
			"action" => $this->getActionName(),
	        "params" => $this->params,
	    );
	}

	abstract static function getActionName();

}

function handleExpressionError($errno, $errstr, $errfile, $errline, array $errcontext)
{
    $GLOBALS['log']->fatal("Error evaluating expression: {$errstr}\nLine {$errline} of file {$errfile}");
}