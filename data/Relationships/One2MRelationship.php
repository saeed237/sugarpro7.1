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
 * Represents a one to many relationship that is table based.
 * @api
 */
class One2MRelationship extends M2MRelationship
{

    public function __construct($def)
    {
        global $dictionary;

        $this->def = $def;
        $this->name = $def['name'];

        $this->selfReferencing = $def['lhs_module'] == $def['rhs_module'];
        $lhsModule = $def['lhs_module'];
        $rhsModule = $def['rhs_module'];

        if ($this->selfReferencing)
        {
            $links = VardefManager::getLinkFieldForRelationship(
                $lhsModule, BeanFactory::getObjectName($lhsModule), $this->name
            );
            if (empty($links))
            {
                $GLOBALS['log']->fatal("No Links found for relationship {$this->name}");
            }
            else {
                if (!isset($links[0]) && !isset($links['name'])) {
                    $GLOBALS['log']->fatal("Bad link found for relationship {$this->name}");
                }
                else if (!isset($links[1])&&isset($links['name'])) //Only one link for a self referencing relationship, this is very bad.
                {
                    $this->lhsLinkDef = $this->rhsLinkDef = $links;
                }
                else if (!empty($links[0]) && !empty($links[1]))
                {

                    if ((!empty($links[0]['side']) && $links[0]['side'] == "right")
                        || (!empty($links[0]['link_type']) && $links[0]['link_type'] == "one"))
                    {
                        //$links[0] is the RHS
                        $this->lhsLinkDef = $links[1];
                        $this->rhsLinkDef = $links[0];
                    } else
                    {
                        //$links[0] is the LHS
                        $this->lhsLinkDef = $links[0];
                        $this->rhsLinkDef = $links[1];
                    }
                }
            }
        } else
        {
            $this->lhsLinkDef = VardefManager::getLinkFieldForRelationship(
                $lhsModule, BeanFactory::getObjectName($lhsModule), $this->name
            );
            $this->rhsLinkDef = VardefManager::getLinkFieldForRelationship(
                $rhsModule, BeanFactory::getObjectName($rhsModule), $this->name
            );
            if (!isset($this->lhsLinkDef['name']) && isset($this->lhsLinkDef[0]))
            {
              $this->lhsLinkDef = $this->lhsLinkDef[0];
            }
            if (!isset($this->rhsLinkDef['name']) && isset($this->rhsLinkDef[0])) {
                $this->rhsLinkDef = $this->rhsLinkDef[0];
            }
        }
        $this->lhsLink = $this->lhsLinkDef['name'];
        $this->rhsLink = $this->rhsLinkDef['name'];
    }

    protected function linkIsLHS($link) {
        if ( $this->lhsLink != $this->rhsLink ) {
            return $link->getSide() == REL_LHS;
        } else {
            return ($link->getSide() == REL_LHS && !$this->selfReferencing)
                || ($link->getSide() == REL_RHS && $this->selfReferencing);
        }
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
			// Pre-load the RHS relationship, which is used later in the add() function and expects a Bean
			// and we also use it for clearing relationships in case of non self-referencing O2M relations
			// (should be preloaded because when using the relate_to field for updating/saving relationships,
			// only the bean id is loaded into $rhs->$rhsLinkName)
			$rhsLinkName = $this->rhsLink;
			$rhs->load_relationship($rhsLinkName);
        	
			// If it's a One2Many self-referencing relationship
        	// the positions of the default One (LHS) and Many (RHS) are swaped
        	// so we should clear the links from the many (left) side
        	if ($this->selfReferencing && ($this->rhsLink == $this->lhsLink) ) {
        		// Load right hand side relationship name
	            $linkName = $this->rhsLink;
	            // Load the relationship into the left hand side bean
	            $lhs->load_relationship($linkName);
	            
	            // Pick the loaded link
	            $link = $lhs->$linkName;
	            // Get many (LHS) side bean
	            $focus = $link->getFocus();
	            // Get relations
	        	$related = $link->getBeans();
	        	
        		// Clear the relations from many side bean
	        	foreach($related as $relBean) {
	        		$this->remove($focus, $relBean);
	        	}
            } else { // For non self-referencing, remove all the relationships from the many (RHS) side
            	$this->removeAll($rhs->$rhsLinkName);
            }
            
            // Add relationship
            parent::add($lhs, $rhs, $additionalFields);
        }
    }

    /**
     * Just overriding the function from M2M to prevent it from occuring
     * 
     * The logic for dealing with adding self-referencing one-to-many relations is in the add() method
     */
    protected function addSelfReferencing($lhs, $rhs, $additionalFields = array())
    {
        //No-op on One2M.
    }

    /**
     * Just overriding the function from M2M to prevent it from occuring
     */
    protected function removeSelfReferencing($lhs, $rhs, $additionalFields = array())
    {
        //No-op on One2M.
    }
}
