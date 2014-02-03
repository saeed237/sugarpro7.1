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


require_once 'modules/ModuleBuilder/parsers/relationships/AbstractRelationship.php' ;

/*
 * Class to manage the metadata for a One-To-Many Relationship
 * The One-To-Many relationships created by this class are a combination of a subpanel and a custom relate field
 * The LHS (One) module will receive a new subpanel for the RHS module. The subpanel gets its data ('get_subpanel_data') from a link field that references a new Relationship
 * The RHS (Many) module will receive a new relate field to point back to the LHS
 * 
 * OOB modules implement One-To-Many relationships as:
 * 
 * On the LHS (One) side:
 * A Relationship of type one-to-many in the rhs modules vardefs.php
 * A link field in the same vardefs.php with 'relationship'= the relationship name and 'source'='non-db'
 * A subpanel which gets its data (get_subpanel_data) from the link field
 * 
 * On the RHS (Many) side:
 * A Relate field in the vardefs, formatted as in this example, which references a link field:
 * 'name' => 'account_name',
 * 'rname' => 'name',
 * 'id_name' => 'account_id',
 * 'vname' => 'LBL_ACCOUNT_NAME',
 * 'join_name'=>'accounts',
 * 'type' => 'relate',
 * 'link' => 'accounts',
 * 'table' => 'accounts',
 * 'module' => 'Accounts',
 * 'source' => 'non-db'
 * A link field which references the shared Relationship
 */

class OneToManyRelationship extends AbstractRelationship
{

    /*
     * Constructor
     * @param array $definition Parameters passed in as array defined in parent::$definitionKeys
     * The lhs_module value is for the One side; the rhs_module value is for the Many
     */
    function __construct ($definition)
    {
        parent::__construct ( $definition ) ;
    }

    /*
     * BUILD methods called during the build
     */
    
    /*
     * Construct subpanel definitions
     * The format is that of TO_MODULE => relationship, FROM_MODULE, FROM_MODULES_SUBPANEL, mimicking the format in the layoutdefs.php
     * @return array    An array of subpanel definitions, keyed by the module
     */
    function buildSubpanelDefinitions ()
    {        
        if ($this->relationship_only)
            return array () ;
        
        $source = "";

        return array( 
        	$this->lhs_module => $this->getSubpanelDefinition ( 
        		$this->relationship_name, $this->rhs_module, $this->rhs_subpanel , $this->getRightModuleSystemLabel()
        	) 
        );
    }

    function buildWirelessSubpanelDefinitions ()
    {
        if ($this->relationship_only)
            return array () ;

        $source = "";

        return array(
        	$this->lhs_module => $this->getWirelessSubpanelDefinition (
        		$this->relationship_name, $this->rhs_module, $this->rhs_subpanel , $this->getRightModuleSystemLabel() , $source
        	)
        );
    }

    /*
     * @return array    An array of field definitions, ready for the vardefs, keyed by module
     */
	function buildVardefs ( )
    {
        $leftLink = $this->getLinkFieldDefinition ( 
            $this->rhs_module, 
            $this->relationship_name, 
            false,
            'LBL_' . strtoupper ( $this->relationship_name . '_FROM_' . $this->getLeftModuleSystemLabel() ) . '_TITLE',
            $this->relationship_only ? false : $this->getIDName( $this->lhs_module )
        );

        $rightLink = $this->getLinkFieldDefinition (
            $this->lhs_module,
            $this->relationship_name,
            true,
            'LBL_' . strtoupper ( $this->relationship_name . '_FROM_' . $this->getRightModuleSystemLabel()  ) . '_TITLE'
        );

        if (! $this->relationship_only) {
            $relateNameField = $this->getRelateFieldDefinition ( 
                $this->lhs_module, 
                $this->relationship_name,
                $this->getLeftModuleSystemLabel()
            );
            $relateIdField = $this->getLink2FieldDefinition (
                $this->lhs_module,
                $this->relationship_name,
                true,
                'LBL_' . strtoupper ( $this->relationship_name . '_FROM_' . $this->getRightModuleSystemLabel()  ) . '_TITLE'
            );
            
        }

        $rightLink['link-type'] = 'one';
        $rightLink['side'] = 'right';
        $leftLink['link-type'] = 'many';
        $leftLink['side'] = 'left';

        //$rightLink['id_name'] = $this->getJoinKeyRHS();
        
        if ( $this->rhs_module == $this->lhs_module ) {
            $rightLink['name'] = $rightLink['name'].'_right';
            $leftLink['id_name'] = $this->getJoinKeyRHS();
        }

        if ( !$this->relationship_only ) {
            $relateNameField['id_name'] = $rightLink['id_name'];
            $relateIdField['id_name'] = $rightLink['id_name'];
            $relateNameField['link'] = $rightLink['name'];
            $relateIdField['link'] = $rightLink['name'];
        }

        $vardefs = array ( ) ;
        
        $vardefs [ $this->lhs_module ] [] = $leftLink;
        $vardefs [ $this->rhs_module ] [] = $rightLink;

        if (! $this->relationship_only) {
            $vardefs [ $this->rhs_module ] [] = $relateNameField;
            $vardefs [ $this->rhs_module ] [] = $relateIdField;
        }
        /*
        if ($this->rhs_module != $this->lhs_module )
        {
        	$vardefs [ $this->lhs_module ] [] = 
        }
        else
        {
            $rightLink = $this->getLinkFieldDefinition ( $this->rhs_module, $this->relationship_name, true,
                'LBL_' . strtoupper ( $this->relationship_name . '_FROM_' . $this->getRightModuleSystemLabel()  ) . '_TITLE');
        }

        if (! $this->relationship_only)
        {
            $relateField = 
            $link2Field = 

            if ( $this->rhs_module == $this->lhs_module ) {
                // We need to fix up the links to use the alternate link
                $relateField['link'] .= '_right';
                $link2Field['link'] .= '_right';
                $link2Field['side'] = 'right';
                
                $relateField['id_name'] = $this->getJoinKeyRHS();
                $link2Field['id_name'] = $this->getJoinKeyRHS();
                $link2Field['name'] = $this->getJoinKeyRHS();
            } else {
                unset($link2Field['id_name']);
            }

        }
        */
        return $vardefs ;
    }
    
    /*
     * Define what fields to add to which modules layouts
     * @return array    An array of module => fieldname
     */
    function buildFieldsToLayouts ()
    {
        if ($this->relationship_only)
            return array () ;
 
        return array( $this->rhs_module =>$this->getValidDBName($this->relationship_name . "_name")); // this must match the name of the relate field from buildVardefs
    }
       
    /*
     * @return array    An array of relationship metadata definitions
     */
    function buildRelationshipMetaData ()
    {
        return array( $this->lhs_module => $this->getRelationshipMetaData ( MB_ONETOMANY ) ) ;
    }

    public function buildSidecarSubpanelDefinitions()
    {
        return $this->buildSubpanelDefinitions();
    }

    public function buildSidecarMobileSubpanelDefinitions()
    {
        return $this->buildWirelessSubpanelDefinitions();
    }

}
?>