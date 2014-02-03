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


/**
 * Represents 1-1 relationship
 * @api
 */
class One2OneRelationship extends M2MRelationship
{

    public function __construct($def)
    {
        parent::__construct($def);
    }
    /**
     * @param  $lhs SugarBean left side bean to add to the relationship.
     * @param  $rhs SugarBean right side bean to add to the relationship.
     * @param  $additionalFields key=>value pairs of fields to save on the relationship
     * @return boolean true if successful
     */
    public function add($lhs, $rhs, $additionalFields = array())
    {
        $dataToInsert = $this->getRowToInsert($lhs, $rhs, $additionalFields);
        //If the current data matches the existing data, don't do anything
        if (!$this->checkExisting($dataToInsert))
        {
            $lhsLinkName = $this->lhsLink;
            $rhsLinkName = $this->rhsLink;
            //In a one to one, any existing links from both sides must be removed first.
            //one2Many will take care of the right side, so we'll do the left.
            $lhs->load_relationship($lhsLinkName);
            $this->removeAll($lhs->$lhsLinkName);
            $rhs->load_relationship($rhsLinkName);
            $this->removeAll($rhs->$rhsLinkName);

            return parent::add($lhs, $rhs, $additionalFields);
        }

        // data matched what was there so return false, since nothing happened
        return false;
    }


}
