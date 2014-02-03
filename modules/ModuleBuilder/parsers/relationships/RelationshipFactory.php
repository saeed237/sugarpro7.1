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


require_once 'modules/ModuleBuilder/parsers/constants.php' ;

class RelationshipFactory
{

    /*
     * Construct a new relationship of type as provided by the $definition
     * @param array $definition Complete definition of the relationship, as specified by AbstractRelationship::keys
     */
    static function newRelationship ($definition = array())
    {
        // handle the case where a relationship_type is not provided - set it to Many-To-Many as this was the usual type in ModuleBuilder
        if (! isset ( $definition [ 'relationship_type' ] ))
            $definition [ 'relationship_type' ] = MB_MANYTOMANY ;
            
    	if (!empty ($definition['for_activities']) && $definition['for_activities'] == true) {
        	require_once 'modules/ModuleBuilder/parsers/relationships/ActivitiesRelationship.php';
        	return new ActivitiesRelationship ($definition);
        }
        
        switch ( strtolower ( $definition [ 'relationship_type' ] ))
        {
            case strtolower ( MB_ONETOONE ) :
                require_once 'modules/ModuleBuilder/parsers/relationships/OneToOneRelationship.php' ;
                return new OneToOneRelationship ( $definition ) ;
            
            case strtolower ( MB_ONETOMANY ) :
                require_once 'modules/ModuleBuilder/parsers/relationships/OneToManyRelationship.php' ;
                return new OneToManyRelationship ( $definition ) ;
                
            case strtolower ( MB_MANYTOONE ) :
                require_once 'modules/ModuleBuilder/parsers/relationships/ManyToOneRelationship.php' ;
                return new ManyToOneRelationship ( $definition ) ;
            
            // default case is Many-To-Many as this was the only type ModuleBuilder could create and so much of the MB code assumes Many-To-Many
            default :
                $definition [ 'relationship_type' ] = MB_MANYTOMANY ;
                require_once 'modules/ModuleBuilder/parsers/relationships/ManyToManyRelationship.php' ;
                return new ManyToManyRelationship ( $definition ) ;
        }
    
    }
}
?>