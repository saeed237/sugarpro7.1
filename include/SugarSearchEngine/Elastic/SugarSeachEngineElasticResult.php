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


require_once("include/SugarSearchEngine/SugarSearchEngineAbstractResult.php");
require_once("include/SugarSearchEngine/SugarSearchEngineHighlighter.php");

/**
 * Adapter class to Elastica Result
 */
class SugarSeachEngineElasticResult extends SugarSearchEngineAbstractResult
{
    /**
     * @var \Elastica_Result
     */
    private $elasticaResult;

    public function __construct(Elastica_Result $result)
    {
        $this->elasticaResult = $result;
        //No need to lazy load, will always want to load the bean to fill in the details
        $this->bean = BeanFactory::getBean($this->getModule(), $this->getId());
        if($this->bean === FALSE)
        {
            $GLOBALS['log']->fatal("Unable to load bean with id for FTS result set: {$this->getId()}");
        }
    }

    /**
     * Return the id of the
     *
     * @return string
     */
    public function getId()
    {
        return $this->elasticaResult->getId();
    }

    /**
     *
     * @return array
     */
    public function getModule()
    {
        return $this->elasticaResult->module;
    }


    /**
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->elasticaResult->getScore();
    }

    /**
     * This function returns an array of highlighted key-value pairs.
     * 
     * @param maxFields - the number of highlighted fields to return, 0 = all
     *
     * @return array of key value pairs
     */
    public function getHighlightedHitText($maxFields = 0)
    {
        $ret = array();

        $highlights = $this->elasticaResult->getHighlights();

        if (!empty($highlights) && is_array($highlights))
        {
            $highlighter = new SugarSearchEngineHighlighter();
            $highlighter->setModule($this->getModule());
            $ret = $highlighter->processHighlightText($highlights);
            if($maxFields > 0) {
                $ret = array_slice($ret, 0, $maxFields);
            }
        }

        return $ret;
    }
}