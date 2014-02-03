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





require_once ('modules/ModuleBuilder/views/view.listview.php') ;
require_once 'modules/ModuleBuilder/parsers/constants.php' ;

class ViewSearchView extends ViewListView
{
 	public function __construct()
 	{
 		parent::__construct();
 		if (!empty($_REQUEST['searchlayout'])) {
 			$this->editLayout = $_REQUEST['searchlayout'];
 		}
 	}
 	
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

 	// DO NOT REMOVE - overrides parent ViewEdit preDisplay() which attempts to load a bean for a non-existent module
 	function preDisplay()
 	{
 	}

 	function display(
 	    $preview = false
 	    )
 	{
 		$packageName = (isset ( $_REQUEST [ 'view_package' ] )) ? $_REQUEST [ 'view_package' ] : '' ;
 		require_once 'modules/ModuleBuilder/parsers/ParserFactory.php' ;
 		$parser = ParserFactory::getParser ( $this->editLayout , $this->editModule, $packageName ) ;

 		$smarty = parent::constructSmarty ( $parser ) ;
 		$smarty->assign ( 'action', 'searchViewSave' ) ;
 		$smarty->assign ( 'view', $this->editLayout ) ;
 		$smarty->assign ( 'helpName', 'searchViewEditor' ) ;
 		$smarty->assign ( 'helpDefault', 'modify' ) ;

 		if ($preview)
 		{
 			echo $smarty->fetch ( "modules/ModuleBuilder/tpls/Preview/listView.tpl" ) ;
 		} else
 		{
 			$ajax = $this->constructAjax () ;
 			$ajax->addSection ( 'center', translate ($this->title), $smarty->fetch ( "modules/ModuleBuilder/tpls/listView.tpl" ) ) ;
 			echo $ajax->getJavascript () ;
 		}
 	}

 	function constructAjax()
 	{
 		require_once ('modules/ModuleBuilder/MB/AjaxCompose.php') ;
 		$ajax = new AjaxCompose ( ) ;
 		switch ( $this->editLayout )
 		{
 			case MB_WIRELESSBASICSEARCH:
 			case MB_WIRELESSADVANCEDSEARCH:
 				$searchLabel = 'LBL_WIRELESSSEARCH' ;
 				break;
 			default:
                if(isModuleBWC($this->editModule)) {
                    $searchLabel = 'LBL_' . strtoupper($this->editLayout);
                } else {
                    $searchLabel = 'LBL_FILTER_SEARCH';
                }
                break;
 		}

        $layoutLabel = 'LBL_LAYOUTS' ;
        $layoutView = 'layouts' ;

        if ( in_array ( $this->editLayout , array ( MB_WIRELESSBASICSEARCH , MB_WIRELESSADVANCEDSEARCH ) ) )
        {
        	$layoutLabel = 'LBL_WIRELESSLAYOUTS' ;
        	$layoutView = 'wirelesslayouts' ;
        }

 		if ($this->fromModuleBuilder)
 		{
 			$ajax->addCrumb ( translate ( 'LBL_MODULEBUILDER', 'ModuleBuilder' ), 'ModuleBuilder.main("mb")' ) ;
 			$ajax->addCrumb ( $_REQUEST [ 'view_package' ], 'ModuleBuilder.getContent("module=ModuleBuilder&action=package&package=' . $_REQUEST [ 'view_package' ] . '")' ) ;
 			$ajax->addCrumb ( $this->editModule, 'ModuleBuilder.getContent("module=ModuleBuilder&action=module&view_package=' . $_REQUEST [ 'view_package' ] . "&view_module={$this->editModule}" . '")'  ) ;
 			$ajax->addCrumb ( translate ( $layoutLabel, 'ModuleBuilder' ), 'ModuleBuilder.getContent("module=ModuleBuilder&MB=true&action=wizard&view_module=' . $this->editModule. '&view_package=' . $_REQUEST['view_package'] . '")'  ) ;
 			if ( $layoutLabel == 'LBL_LAYOUTS' ) $ajax->addCrumb ( translate ( 'LBL_SEARCH_FORMS', 'ModuleBuilder' ), 'ModuleBuilder.getContent("module=ModuleBuilder&MB=true&action=wizard&view=search&view_module=' .$this->editModule . '&view_package=' . $_REQUEST [ 'view_package' ] . '")'  ) ;
 			$ajax->addCrumb ( translate ( $searchLabel, 'ModuleBuilder' ), '' ) ;
 		} else
 		{
 			$ajax->addCrumb ( translate ( 'LBL_STUDIO', 'ModuleBuilder' ), 'ModuleBuilder.main("studio")' ) ;
 			$ajax->addCrumb ( $this->translatedEditModule, 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&view_module=' . $this->editModule . '")'  ) ;
 			$ajax->addCrumb ( translate ( $layoutLabel, 'ModuleBuilder' ), 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&view='.$layoutView.'&view_module=' . $this->editModule . '")'  ) ;
 			if ( $layoutLabel == 'LBL_LAYOUTS' ) $ajax->addCrumb ( translate ( 'LBL_SEARCH_FORMS', 'ModuleBuilder' ), 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&view=search&view_module=' .$this->editModule . '")' ) ;
 			$ajax->addCrumb ( translate ( $searchLabel, 'ModuleBuilder' ), ''  ) ;
 		}
 		$this->title = $searchLabel;
 		return $ajax ;
 	}
}
