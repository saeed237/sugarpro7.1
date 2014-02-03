 <?php
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

require_once ('modules/ModuleBuilder/MB/AjaxCompose.php') ;
require_once ('modules/ModuleBuilder/MB/ModuleBuilder.php') ;
require_once ('modules/ModuleBuilder/views/view.relationship.php') ;
require_once ('modules/ModuleBuilder/Module/StudioModule.php') ;
require_once ('modules/ModuleBuilder/Module/StudioBrowser.php') ;

class ViewRelationships extends SugarView
{
    /**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;
	    
    	return array(
    	   translate('LBL_MODULE_NAME','Administration'),
    	   ModuleBuilderController::getModuleTitle(),
    	   );
    }

    function display()
    {
        $moduleName = ! empty ( $_REQUEST [ 'view_module' ] ) ? $_REQUEST [ 'view_module' ] : $_REQUEST [ 'edit_module' ] ;
        $smarty = new Sugar_Smarty ( ) ;
        // set the mod_strings as we can be called after doing a Repair and the mod_strings are set to Administration
        $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], 'ModuleBuilder');
        $smarty->assign ( 'mod_strings', $GLOBALS [ 'mod_strings' ] ) ;
        $smarty->assign ( 'view_module', $moduleName ) ;

        $ajax = new AjaxCompose ( ) ;
        $json = getJSONobj () ;
		$this->fromModuleBuilder = !empty ( $_REQUEST [ 'MB' ] ) || (!empty($_REQUEST['view_package']) && $_REQUEST['view_package'] != 'studio') ;
        $smarty->assign('fromModuleBuilder', $this->fromModuleBuilder);
        if (!$this->fromModuleBuilder)
        {
            $smarty->assign ( 'view_package', '' ) ;

            $relationships = new DeployedRelationships ( $moduleName ) ;
            $ajaxRelationships = $this->getAjaxRelationships( $relationships ) ;
            $smarty->assign ( 'relationships', $json->encode ( $ajaxRelationships ) ) ;
            $smarty->assign ( 'empty', (sizeof ( $ajaxRelationships ) == 0) ) ;
            $smarty->assign ( 'studio', true ) ;

            //crumb
            global $app_list_strings ;
            $moduleNames = array_change_key_case ( $app_list_strings [ 'moduleList' ] ) ;
            $translatedModule = $moduleNames [ strtolower ( $moduleName ) ] ;
            $ajax->addCrumb ( translate('LBL_STUDIO'), 'ModuleBuilder.main("studio")' ) ;
            $ajax->addCrumb ( $translatedModule, 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&view_module=' . $moduleName . '")' ) ;
            $ajax->addCrumb ( translate('LBL_RELATIONSHIPS'), '' ) ;
            $ajax->addSection ( 'center', $moduleName . ' ' . translate('LBL_RELATIONSHIPS'), $this->fetchTemplate($smarty, 'modules/ModuleBuilder/tpls/studioRelationships.tpl'));

        } else
        {
            $smarty->assign ( 'view_package', $_REQUEST [ 'view_package' ] ) ;

            $mb = new ModuleBuilder ( ) ;
            $module = & $mb->getPackageModule ( $_REQUEST [ 'view_package' ], $_REQUEST [ 'view_module' ] ) ;
            $package = $mb->packages [ $_REQUEST [ 'view_package' ] ] ;
			$package->loadModuleTitles();
            $relationships = new UndeployedRelationships ( $module->getModuleDir () ) ;
            $ajaxRelationships = $this->getAjaxRelationships( $relationships ) ;
            $smarty->assign ( 'relationships', $json->encode ( $ajaxRelationships ) ) ;
            $smarty->assign ( 'empty', (sizeof ( $ajaxRelationships ) == 0) ) ;

            $module->help [ 'default' ] = (empty ( $_REQUEST [ 'view_module' ] )) ? 'create' : 'modify' ;
            $module->help [ 'group' ] = 'module' ;

            $ajax->addCrumb ( translate('LBL_MODULEBUILDER'), 'ModuleBuilder.main("mb")' ) ;
            $ajax->addCrumb ( $package->name, 'ModuleBuilder.getContent("module=ModuleBuilder&action=package&package=' . $package->name . '")' ) ;
            $ajax->addCrumb ( $moduleName, 'ModuleBuilder.getContent("module=ModuleBuilder&action=module&view_package=' . $package->name . '&view_module=' . $moduleName . '")' ) ;
            $ajax->addCrumb ( translate('LBL_RELATIONSHIPS'), '' ) ;
            $ajax->addSection ( 'center', $moduleName . ' ' . translate('LBL_RELATIONSHIPS'), $this->fetchTemplate($smarty, 'modules/ModuleBuilder/tpls/studioRelationships.tpl'));
        }
        echo $ajax->getJavascript () ;
    }

    /*
     * Encode the relationships for this module for display in the Ext grid layout
     */
    function getAjaxRelationships ( $relationships )
    {
        $ajaxrels = array ( ) ;
        foreach ( $relationships->getRelationshipList () as $relationshipName )
        {
            $rel = $relationships->get ( $relationshipName )->getDefinition () ;
            $rel [ 'lhs_module' ] = translate( $rel [ 'lhs_module' ] ) ;
            $rel [ 'rhs_module' ] = translate( $rel [ 'rhs_module' ] ) ;
            
            //#28668  , translate the relationship type before render it .
            switch($rel['relationship_type']){
            	case 'one-to-one':
            	$rel['relationship_type']  = translate ( 'LBL_ONETOONE' );
            	break;
            	case 'one-to-many':
            	$rel['relationship_type']  = translate ( 'LBL_ONETOMANY' );
            	break;
            	case 'many-to-one':
            	$rel['relationship_type']  = translate ( 'LBL_MANYTOONE' );
            	break;
            	case 'many-to-many':
            	$rel['relationship_type']  = translate ( 'LBL_MANYTOMANY' );
            	break;
            	default: $rel['relationship_type']  = '';
            }
            $rel [ 'name' ] = $relationshipName ;
            if ($rel [ 'is_custom' ] && isset($rel [ 'from_studio' ]) && $rel [ 'from_studio' ]) {
            	$rel [ 'name' ] = $relationshipName . "*";
            }
            $ajaxrels [] = $rel ;
        }
        return $ajaxrels ;
    }

    /**
     * fetchTemplate
     * This function overrides fetchTemplate from SugarView.
     *
     * @param FieldViewer $mixed the Sugar_Smarty instance
     * @param string $template the file to fetch
     * @return string contents from calling the fetch method on the Sugar_Smarty instance
     */
    protected function fetchTemplate($smarty, $template)
    {
        return $smarty->fetch($this->getCustomFilePathIfExists($template));
    }
}