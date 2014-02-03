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
require_once ('modules/ModuleBuilder/parsers/views/History.php') ;
require_once ('modules/ModuleBuilder/parsers/ParserFactory.php') ;

class ViewHistory extends SugarView
{
    var $pageSize = 10 ;

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

	function display ()
    {
        $this->layout = strtolower ( $_REQUEST [ 'view' ] ) ;
        
        $subpanelName = null ;
        if ((strtolower ( $this->layout ) == 'listview') && (!empty ( $_REQUEST [ 'subpanel' ] )))
        {
            $subpanelName = $_REQUEST [ 'subpanel' ] ;
            
        }
        
        $packageName = (isset ( $_REQUEST [ 'view_package' ] ) && (strtolower ( $_REQUEST [ 'view_package' ] ) != 'studio')) ? $_REQUEST [ 'view_package' ] : null ;
        $this->module = $_REQUEST [ 'view_module' ] ;
        
        $this->parser = ParserFactory::getParser ( $this->layout, $this->module, $packageName, $subpanelName ) ;
        $this->history = $this->parser->getHistory () ;
        $action = ! empty ( $_REQUEST [ 'histAction' ] ) ? $_REQUEST [ 'histAction' ] : 'browse' ;
        $GLOBALS['log']->debug( get_class($this)."->display(): performing History action {$action}" ) ;
        $this->$action () ;
    }

    function browse ()
    {
        $smarty = new Sugar_Smarty ( ) ;
        global $mod_strings ;
        $smarty->assign ( 'mod_strings', $mod_strings ) ;
        $smarty->assign ( 'view_module', $this->module ) ;
        $smarty->assign ( 'view', $this->layout ) ;
        
        if (! empty ( $_REQUEST [ 'subpanel' ] ))
        {
            $smarty->assign ( 'subpanel', $_REQUEST [ 'subpanel' ] ) ;
        }
        $stamps = array ( ) ;
        global $timedate ;
        $userFormat = $timedate->get_date_time_format () ;
        $page = ! empty ( $_REQUEST [ 'page' ] ) ? $_REQUEST [ 'page' ] : 0 ;
        $count = $this->history->getCount();
        $ts = $this->history->getNth ( $page * $this->pageSize ) ;
        $snapshots = array ( ) ;
        for ( $i = 0 ; $i <= $this->pageSize && $ts > 0 ; $i ++ )
        {
            $dbDate = $timedate->fromTimestamp($ts)->asDb();
            $displayTS = $timedate->to_display_date_time ( $dbDate ) ;
            if ($page * $this->pageSize + $i + 1 == $count)
                $displayTS = translate("LBL_MB_DEFAULT_LAYOUT");
            $snapshots [ $ts ] = $displayTS ;
            $ts = $this->history->getNext () ;
        }
        if (count ( $snapshots ) > $this->pageSize)
        {
            $smarty->assign ( 'nextPage', true ) ;
        }
        $snapshots = array_slice ( $snapshots, 0, $this->pageSize, true ) ;
        $smarty->assign ( 'currentPage', $page ) ;
        $smarty->assign ( 'snapshots', $snapshots ) ;
        
        $html = $smarty->fetch ( 'modules/ModuleBuilder/tpls/history.tpl' ) ;
        echo $html ;
    }

    function preview ()
    {
        global $mod_strings ;
        if (! isset ( $_REQUEST [ 'sid' ] ))
        {
            die ( 'SID Required' ) ;
        }
        $sid = $_REQUEST [ 'sid' ] ;
        $subpanel = '';
        if (! empty ( $_REQUEST [ 'subpanel' ] ))
        {
            $subpanel = ',"' . $_REQUEST [ 'subpanel' ] . '"' ;
        }
        echo "<input type='button' name='close$sid' value='". translate ( 'LBL_BTN_CLOSE' )."' " . 
                "class='button' onclick='ModuleBuilder.tabPanel.removeTab(ModuleBuilder.tabPanel.get(\"activeTab\"));' style='margin:5px;'>" . 
             "<input type='button' name='restore$sid' value='" . translate ( 'LBL_MB_RESTORE' ) . "' " .  
                "class='button' onclick='ModuleBuilder.history.revert(\"$this->module\",\"{$this->layout}\",\"$sid\"$subpanel);' style='margin:5px;'>" ;
        $this->history->restoreByTimestamp ( $sid ) ;
        $view ;
        if ($this->layout == 'listview')
        {
            require_once ("modules/ModuleBuilder/views/view.listview.php") ;
            $view = new ViewListView ( ) ;
        } else if ($this->layout == 'basic_search' || $this->layout == 'advanced_search')
        {
            require_once ("modules/ModuleBuilder/views/view.searchview.php") ;
            $view = new ViewSearchView ( ) ;
        } else if ($this->layout == 'dashlet' || $this->layout == 'dashletsearch')
        {
        	require_once ("modules/ModuleBuilder/views/view.dashlet.php") ;
        	$view = new ViewDashlet ( ) ;
        }  else if ($this->layout == 'popuplist' || $this->layout == 'popupsearch')
        {
        	require_once ("modules/ModuleBuilder/views/view.popupview.php") ;
        	$view = new ViewPopupview ( ) ;
        } else
        {
            require_once ("modules/ModuleBuilder/views/view.layoutview.php") ;
            $view = new ViewLayoutView ( ) ;
        }
        
        $view->display ( true ) ;
        $this->history->undoRestore () ;
    }

    function restore ()
    {
        if (! isset ( $_REQUEST [ 'sid' ] ))
        {
            die ( 'SID Required' ) ;
        }
        $sid = $_REQUEST [ 'sid' ] ;
        $this->history->restoreByTimestamp ( $sid ) ;
    }

	/**
 	 * Restores a layout to its current customized state. 
 	 * Called when leaving a restored layout without saving.
 	 */
    function unrestore() 
    {
    	$this->history->undoRestore () ;
    }
}
