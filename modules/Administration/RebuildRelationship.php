<?php
if (! defined ( 'sugarEntry' ) || ! sugarEntry)
    die ( 'Not A Valid Entry Point' ) ;
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

include ('include/modules.php') ;



global $db, $mod_strings ;
$log = & $GLOBALS [ 'log' ] ;

$query = "DELETE FROM relationships" ;
$db->query ( $query ) ;

//clear cache before proceeding..
VardefManager::clearVardef () ;

// loop through all of the modules and create entries in the Relationships table (the relationships metadata) for every standard relationship, that is, relationships defined in the /modules/<module>/vardefs.php
// SugarBean::createRelationshipMeta just takes the relationship definition in a file and inserts it as is into the Relationships table
// It does not override or recreate existing relationships
foreach ( $GLOBALS['beanFiles'] as $bean => $file )
{
    if (strlen ( $file ) > 0 && file_exists ( $file ))
    {
        if (! class_exists ( $bean ))
        {
            require ($file) ;
        }
        $focus = BeanFactory::newBeanByName($bean);
        if ( $focus instanceOf SugarBean ) {
            // Add defensive coding around required args for relationship meta
            $objName = $focus->getObjectName();
            $tblName = $focus->table_name;
            if (empty($tblName) || empty($objName)) {
                $GLOBALS['log']->info("Either the object name or the table name for bean " . get_class($focus) . " is empty. Object Name is: $objName. Table name is $tblName.");
                continue;
            }
            
            $empty = array() ;
            if (empty ( $_REQUEST [ 'silent' ] ))
                echo $mod_strings [ 'LBL_REBUILD_REL_PROC_META' ] . $tblName . "..." ;
            SugarBean::createRelationshipMeta($objName, $db, $tblName, $empty, $focus->module_dir ) ;
            if (empty ( $_REQUEST [ 'silent' ] ))
                echo $mod_strings [ 'LBL_DONE' ] . '<br>' ;
        }
    }
}

// do the same for custom relationships (true in the last parameter to SugarBean::createRelationshipMeta) - that is, relationships defined in the custom/modules/<modulename>/Ext/vardefs/ area
foreach ( $GLOBALS['beanFiles'] as $bean => $file )
{
	//skip this file if it does not exist
	if(!file_exists($file)) continue;

	if (! class_exists ( $bean ))
    {
        require ($file) ;
    }
    $focus = BeanFactory::newBeanByName($bean);
    if ( $focus instanceOf SugarBean ) {
        $objName = $focus->getObjectName();
        $tblName = $focus->table_name;
        if (empty($tblName) || empty($objName)) {
            $GLOBALS['log']->info("Custom Relationships: Either the object name or the table name for bean " . get_class($focus) . " is empty. Object Name is: $objName. Table name is $tblName.");
            continue;
        }
        
        $empty = array() ;
        if (empty ( $_REQUEST [ 'silent' ] ))
            echo $mod_strings [ 'LBL_REBUILD_REL_PROC_C_META' ] . $tblName . "..." ;
        SugarBean::createRelationshipMeta($objName, $db, $tblName, $empty, $focus->module_dir, true ) ;
        if (empty ( $_REQUEST [ 'silent' ] ))
            echo $mod_strings [ 'LBL_DONE' ] . '<br>' ;
    }
}

// finally, whip through the list of relationships defined in TableDictionary.php, that is all the relationships in the metadata directory, and install those
    $dictionary = array ( ) ;
    require ('modules/TableDictionary.php') ;
    //for module installer incase we already loaded the table dictionary
    if (file_exists ( 'custom/application/Ext/TableDictionary/tabledictionary.ext.php' ))
    {
        include ('custom/application/Ext/TableDictionary/tabledictionary.ext.php') ;
    }
    $rel_dictionary = $dictionary ;
    foreach ( $rel_dictionary as $rel_name => $rel_data )
    {
        $table = isset($rel_data [ 'table' ]) ? $rel_data [ 'table' ] : "" ;

        if (empty ( $_REQUEST [ 'silent' ] ))
            echo $mod_strings [ 'LBL_REBUILD_REL_PROC_C_META' ] . $rel_name . "..." ;
        SugarBean::createRelationshipMeta ( $rel_name, $db, $table, $rel_dictionary, '' ) ;
        if (empty ( $_REQUEST [ 'silent' ] ))
            echo $mod_strings [ 'LBL_DONE' ] . '<br>' ;
    }

//clean relationship cache..will be rebuilt upon first access.
if (empty ( $_REQUEST [ 'silent' ] ))
    echo $mod_strings [ 'LBL_REBUILD_REL_DEL_CACHE' ] ;
Relationship::delete_cache () ;

//////////////////////////////////////////////////////////////////////////////
// Remove the "Rebuild Relationships" red text message on admin logins


if (empty ( $_REQUEST [ 'silent' ] ))
    echo $mod_strings [ 'LBL_REBUILD_REL_UPD_WARNING' ] ;

// clear the database row if it exists (just to be sure)
$query = "DELETE FROM versions WHERE name='Rebuild Relationships'" ;
$log->info ( $query ) ;
$db->query ( $query ) ;

// insert a new database row to show the rebuild relationships is done
$id = create_guid () ;
$gmdate = gmdate('Y-m-d H:i:s');
$date_entered = db_convert ( "'$gmdate'", 'datetime' ) ;
$query = 'INSERT INTO versions (id, deleted, date_entered, date_modified, modified_user_id, created_by, name, file_version, db_version) ' . "VALUES ('$id', '0', $date_entered, $date_entered, '1', '1', 'Rebuild Relationships', '4.0.0', '4.0.0')" ;
$log->info ( $query ) ;
$db->query ( $query ) ;

$rel = BeanFactory::getBean('Relationships');
Relationship::delete_cache();
$rel->build_relationship_cache();

// unset the session variable so it is not picked up in DisplayWarnings.php
if (isset ( $_SESSION [ 'rebuild_relationships' ] ))
{
    unset ( $_SESSION [ 'rebuild_relationships' ] ) ;
}

if (empty ( $_REQUEST [ 'silent' ] ))
    echo $mod_strings [ 'LBL_DONE' ] ;
?>
