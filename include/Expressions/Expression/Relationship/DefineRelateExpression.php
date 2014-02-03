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

require_once('include/Expressions/Expression/Relationship/RelateExpression.php');

class DefineRelateExpression extends RelateExpression
{
	/**
	 * Returns the entire enumeration bare.
	 */
	function evaluate() {
		$fieldName = $this->getParameters()->evaluate();

        if (!isset($this->context))
        {
            //If we don't have a context provided, we have to guess. This can be a large performanc hit.
            $this->setContext();
        }

        if (empty($this->context->field_defs[$fieldName]))
            throw new Exception("Unable to find field {$fieldName}");

        if(!$this->context->load_relationship($fieldName))
            throw new Exception("Unable to load relationship $fieldName");

        if(empty($this->context->$fieldName))
            throw new Exception("Relationship $fieldName was not set");

        $rmodule = $this->context->$fieldName->getRelatedModuleName();

        //now we need a seed of the related module to load.
        $seed = $this->getBean($rmodule);

        return $this->context->$fieldName->getBeans($seed);
	}

    protected function setContext()
    {
        $module = $_REQUEST['module'];
        $id = $_REQUEST['record'];
        $focus = $this->getBean($module);
        $focus->retrieve($id);
        $this->context = $focus;
    }

    protected function getBean($module)
    {
        $bean = BeanFactory::getBean($module);
        if (empty($bean))
           throw new Exception("No bean for module $module");
        return $bean;
    }

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return "";
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "link";
	}

	/**
	 * All parameters have to be a string.
	 */
    static function getParameterTypes() {
		return array("string");
	}

	/**
	 * Returns the maximum number of parameters needed.
	 */
	static function getParamCount() {
		return 1;
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}

?>