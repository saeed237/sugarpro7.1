<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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
 * Bean duplicate check manager
 * @api
 */
class BeanDuplicateCheck
{
    /**
     * Strategy for performing dupe check for this bean
     * @var DuplicateCheckStrategy
     */
    protected $strategy = false;

    /**
     * @param SugarBean $bean
     * @param array $metadata
     */
    public function __construct($bean, $metadata)
    {
        $dupeCheckClass = $this->determineStrategy($metadata, $bean->module_name);
        $this->setStrategy($dupeCheckClass, $bean, $metadata);
    }

    /**
     * Ask the strategy for the possible duplicates
     *
     * @return array
     */
    public function findDuplicates()
    {
        if ($this->strategy) {
            return $this->strategy->findDuplicates();
        } else {
            return null;
        }
    }

    /**
     * Determine the name of the strategy to construct
     *
     * @param array  $metadata
     * @param string $moduleName
     * @return bool|string  false=Not a valid strategy; string=Class name of the strategy
     */
    protected function determineStrategy($metadata, $moduleName)
    {
        $dupeCheckClass = false;
        $metadataCount  = 0;

        foreach($metadata AS $metadataKey => $metadataRules) {
            if ($metadataKey != "enabled") { // Skip over the enabled Flag if it exists
                $metadataCount++;
                $dupeCheckClass = $metadataKey;
            }
        }

        if ($metadataCount === 0) {
            $GLOBALS["log"]->info("No DuplicateCheckStrategy exists for the {$moduleName} module");
        } elseif ($metadataCount !== 1) {
            //force only one strategy
            $GLOBALS["log"]->warn("More than one DuplicateCheckStrategy exists for the {$moduleName} module");
        } else {
            reset($metadata);
        }

        return $dupeCheckClass;
    }

    /**
     * Set the strategy to an instance of the strategy class, but only if it's valid
     *
     * @param bool|string $strategyName
     * @param SugarBean   $bean
     * @param array $metadata
     */
    protected function setStrategy($strategyName, $bean, $metadata)
    {
        if (!empty($strategyName)) {
            if (!class_exists($strategyName)) {
                $GLOBALS["log"]->warn("The DuplicateCheckStrategy named '{$strategyName}' does not exist");
            } else {
                $this->strategy = new $strategyName($bean, $metadata[$strategyName]);
            }
        }
    }

    /**
     * Return the selected strategy. This is specifically used for unit tests.
     *
     * @return bool|DuplicateCheckStrategy  false=No strategy; object=Instance of the strategy
     */
    public function getStrategy()
    {
        return $this->strategy;
    }
}
