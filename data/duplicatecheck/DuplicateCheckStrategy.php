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
 * Base class for duplicate check strategy implementations
 * @abstract
 * @api
 */
abstract class DuplicateCheckStrategy
{
    /**
     * Parent bean
     * @var SugarBean
     */
    protected $bean;

    /**
     * @param SugarBean $bean
     * @param array $metadata
     */
    public function __construct($bean, $metadata)
    {
        $this->bean = $bean;
        $this->setMetadata($metadata);
    }

    /**
     * Parse the provided metadata into appropriate protected properties
     *
     * @abstract
     * @access protected
     */
    abstract protected function setMetadata($metadata);

    /**
     * Finds possible duplicate records for a given set of field data.
     *
     * @abstract
     * @access public
     */
    abstract public function findDuplicates();
}