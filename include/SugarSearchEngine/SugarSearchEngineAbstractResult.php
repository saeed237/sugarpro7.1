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


require_once("include/SugarSearchEngine/Interface.php");

/**
 * Abstract class to represent a result entry.
 * @api
 */
abstract class SugarSearchEngineAbstractResult implements SugarSearchEngineResult
{

    /**
     * @var SugarBean
     */
    protected $bean;

    public function getModuleName()
    {
        $moduleName = $this->getModule();
        if( isset($GLOBALS['app_list_strings']['moduleList'][$moduleName]) )
            return $GLOBALS['app_list_strings']['moduleList'][$moduleName];
        else
            return $moduleName;
    }

    public function getSummaryText()
    {
        if($this->bean !== FALSE)
            return $this->bean->get_summary_text();
    }

    public function __toString()
    {
        return __CLASS__ . " " . $this->getModule() . ": " . $this->getSummaryText() . " " . $this->getId();
    }


    /**
     *
     * @return integer
     */
    public function getScore()
    {
        return 0;
    }

}


