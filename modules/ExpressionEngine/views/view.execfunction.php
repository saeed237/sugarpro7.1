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

require_once('include/MVC/View/views/view.ajax.php');
require_once('include/Expressions/Expression/Parser/Parser.php');
require_once("data/BeanFactory.php");
class ViewExecFunction extends ViewAjax
{
    var $vars = array("tmodule", "id", "params", "function");

    public function __construct()
    {
        parent::ViewAjax();
        foreach($this->vars as $var)
        {
            if (empty($_REQUEST[$var]))
                sugar_die("Required paramter $var not set in ViewRelFields");
            $this->$var = $_REQUEST[$var];
        }

    }

 	function display() {
        //First load the primary bean
        $focus = BeanFactory::getBean($this->tmodule, $this->id);

        $params = implode(",", json_decode(html_entity_decode($this->params)));
        $result = Parser::evaluate("{$this->function}($params)", $focus)->evaluate();
        //If the target field isn't a date, convert it to a user formated string
        if ($result instanceof DateTime)
        {
            global $timedate;
            if (isset($result->isDate) && $result->isDate)
                $result = $timedate->asUserDate($result);
            else
                $result = $timedate->asUser($result);
        }
        echo json_encode($result);
    }
}