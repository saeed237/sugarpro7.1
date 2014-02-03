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


function get_body (&$ss , $vardef)
{

    $modules = array ( ) ;

    require_once 'modules/ModuleBuilder/parsers/relationships/DeployedRelationships.php' ;
    $relatableModules = array_keys ( DeployedRelationships::findRelatableModules () ) ;

    foreach ( $relatableModules as $module )
    {
        $modules [ $module ] = translate ( 'LBL_MODULE_NAME', $module ) ;
    }

    $modules = SugarACL::filterModuleList($modules);
    unset ( $modules [ "" ] ) ;
    unset ( $modules [ 'Activities' ] ) ; // cannot relate to Activities as only Activities' submodules have records; use a Flex Relate instead!

    // tyoung bug 18631 - reduce potential confusion when creating a relate custom field for Products - actually points to the Product Catalog, so label it that way in the drop down list
    if (isset ( $modules [ 'ProductTemplates' ] ) && $modules [ 'ProductTemplates' ] == 'Product')
    {
        $modules [ 'ProductTemplates' ] = translate ( 'LBL_MODULE_NAME', 'ProductTemplates' ) ;
    }

    // C.L. - Merge from studio_rel_user branch
    $modules['Users'] = translate('LBL_MODULE_NAME', 'Users');
    asort($modules);

    $ss->assign ( 'modules', $modules ) ;

    return $ss->fetch ( 'modules/DynamicFields/templates/Fields/Forms/relate.tpl' ) ;
}
?>
