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

require_once('include/Expressions/Expression/Generic/GenericExpression.php');


class SugarFieldExpression extends GenericExpression
{
    /**
     * @var SugarBean
     */
    public $context;

    function __construct($varName){
        $this->varName = $varName;
    }
    /**
	 * Returns the entire enumeration bare.
	 */
	function evaluate() {
		if (empty($this->varName))
            return "";
        $fieldName = $this->varName;

        if (!isset($this->context))
        {
            //If we don't have a context provided, we have to guess. This can be a large performance hit.
            $this->setContext();
        }

        if (empty($this->context->field_defs[$fieldName]))
            throw new Exception("Unable to find field {$fieldName}");

        $def = $this->context->field_defs[$fieldName];
        $timedate = TimeDate::getInstance();
        switch($def['type']) {
            case 'link':
                return $this->getLinkField($fieldName);
            case 'datetime':
            case 'datetimecombo':
                if(empty($this->context->$fieldName)) {
                    return false;
                }
                // bug 57900 - we might have a user-formatted timedate here converted from SugarBean::retrieve()
                if($timedate->check_matching_format($this->context->$fieldName,$timedate->get_date_time_format())) {
                    $date = $timedate->fromUser($this->context->$fieldName);
                }
                else {
                    $date = $timedate->fromDb($this->context->$fieldName);
                }

                if(empty($date)) {
                    return false;
                }
                $timedate->tzUser($date);
                $date->def = $def;
                return $date;
            case 'date':
                if(empty($this->context->$fieldName)) {
                    return false;
                }
                $date = $timedate->fromDbDate($this->context->$fieldName);
                if(empty($date)) {
                    return false;
                }
                $date->def = $def;
                return $date;
            case 'time':
                if(empty($this->context->$fieldName)) {
                    return false;
                }
                return $timedate->fromUserTime($timedate->to_display_time($this->context->$fieldName));
            case 'bool':
                if (!empty($this->context->$fieldName))
                    return AbstractExpression::$TRUE;
                return AbstractExpression::$FALSE;
        }
        return $this->context->$fieldName;
	}

    protected function setContext()
    {
        if (empty($this->context) && !empty($_REQUEST['module']) && !empty($_REQUEST['record']))
        {
            $module = $_REQUEST['module'];
            $id = $_REQUEST['record'];
            $this->context = BeanFactory::getBean($module, $id);
        }
    }

    protected function getLinkField($fieldName)
    {
        if (empty($this->context->$fieldName) && !$this->context->load_relationship($fieldName))
            throw new Exception("Unable to load relationship $fieldName");

        if(empty($this->context->$fieldName))
            throw new Exception("Relationship $fieldName was not set");

        if (isset($this->context->$fieldName->beans))
            return $this->context->$fieldName->beans;

        $beans = $this->context->$fieldName->getBeans();

        return $beans;
    }



	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
		    var varName = this.getParameters().evaluate();
			return SUGAR.forms.AssignmentHandler.getValue(varName);
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return array("sugarField");
	}

	/**
	 * The first parameter is a number and the second is the list.
	 */
    static function getParameterTypes() {
		return array(AbstractExpression::$STRING_TYPE);
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
