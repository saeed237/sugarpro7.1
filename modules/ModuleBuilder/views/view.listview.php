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


require_once 'modules/ModuleBuilder/parsers/constants.php' ;
require_once ('include/SubPanel/SubPanel.php') ;

class ViewListView extends SugarView
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

    /*
     * Pseudo-constructor to enable subclasses to call a parent's constructor without knowing the parent in PHP4
     */
    function __construct()
    {
        $this->editModule = $_REQUEST [ 'view_module' ] ;
        $this->editLayout = $_REQUEST [ 'view' ] ;
        $this->subpanel = (! empty ( $_REQUEST [ 'subpanel' ] )) ? $_REQUEST [ 'subpanel' ] : false ;
        $this->subpanelLabel = (! empty ( $_REQUEST [ 'subpanelLabel' ] )) ? $_REQUEST [ 'subpanelLabel' ] : false ;

        $this->fromModuleBuilder = ! empty ( $_REQUEST [ 'view_package' ] ) ;
        if (! $this->fromModuleBuilder)
        {
            $moduleNames = array_change_key_case ( $GLOBALS['app_list_strings'] [ 'moduleList' ] ) ;
            $this->translatedEditModule = $moduleNames [ strtolower ( $this->editModule ) ] ;
        }
    }

    // DO NOT REMOVE - overrides parent ViewEdit preDisplay() which attempts to load a bean for a non-existent module
    function preDisplay ()
    {
    }

    function display ($preview = false)
    {

        $packageName = (! empty ( $_REQUEST [ 'view_package' ] )) ? $_REQUEST [ 'view_package' ] : null ;
        $subpanelName = (! empty ( $_REQUEST [ 'subpanel' ] )) ? $_REQUEST [ 'subpanel' ] : null ;
        require_once 'modules/ModuleBuilder/parsers/ParserFactory.php' ;
        $parser = ParserFactory::getParser (  $this->editLayout , $this->editModule , $packageName, $subpanelName ) ;
        $smarty = $this->constructSmarty ( $parser ) ;

        if ($preview)
        {
            echo $smarty->fetch ( "modules/ModuleBuilder/tpls/Preview/listView.tpl" ) ;
        } else
        {
            $ajax = $this->constructAjax () ;
            $ajax->addSection ( 'center', $this->translatedViewType, $smarty->fetch ( "modules/ModuleBuilder/tpls/listView.tpl" ) ) ;

            echo $ajax->getJavascript () ;
        }
    }

    function constructAjax ()
    {
        require_once ('modules/ModuleBuilder/MB/AjaxCompose.php') ;
        $ajax = new AjaxCompose ( ) ;

        $layoutLabel = 'LBL_LAYOUTS' ;
        $layoutView = 'layouts' ;

        if ( $this->editLayout == MB_WIRELESSLISTVIEW )
        {
        	$layoutLabel = 'LBL_WIRELESSLAYOUTS' ;
        	$layoutView = 'wirelesslayouts' ;
        }

        $labels = array (
        			MB_LISTVIEW => 'LBL_LISTVIEW' ,
        			MB_WIRELESSLISTVIEW => 'LBL_WIRELESSLISTVIEW' ,
        			) ;
        $translatedViewType = '' ;
		if ( isset ( $labels [ strtolower ( $this->editLayout ) ] ) )
			$translatedViewType = translate ( $labels [ strtolower( $this->editLayout ) ] , 'ModuleBuilder' ) ;
		$this->translatedViewType = $translatedViewType;

        if ($this->fromModuleBuilder)
        {
            $ajax->addCrumb ( translate ( 'LBL_MODULEBUILDER', 'ModuleBuilder' ), 'ModuleBuilder.main("mb")' ) ;
            $ajax->addCrumb ( $_REQUEST [ 'view_package' ], 'ModuleBuilder.getContent("module=ModuleBuilder&action=package&package=' . $_REQUEST [ 'view_package' ] . '")' ) ;
            $ajax->addCrumb ( $this->editModule, 'ModuleBuilder.getContent("module=ModuleBuilder&action=module&view_package=' . $_REQUEST [ 'view_package' ] . '&view_module=' . $_REQUEST [ 'view_module' ] . '")' ) ;
            if ($this->subpanel != "")
            {
                $ajax->addCrumb ( translate ( 'LBL_AVAILABLE_SUBPANELS', 'ModuleBuilder' ), '' ) ;
                if ($this->subpanelLabel)
                {
                    $subpanelLabel = $this->subpanelLabel;
                    // If the subpanel title has changed, use that for the label instead
                    if( !empty($_REQUEST['subpanel_title'] ) && $_REQUEST['subpanelLabel'] != $_REQUEST['subpanel_title'] )
                        $subpanelLabel = $_REQUEST['subpanel_title'];

                    $ajax->addCrumb( $subpanelLabel, '' );
                    $this->translatedViewType = $subpanelLabel . "&nbsp;" . translate("LBL_SUBPANEL", "ModuleBuilder");
                } else
                {
                    $ajax->addCrumb ( $this->subpanel, '' ) ;
                    $this->translatedViewType = translate("LBL_SUBPANEL", "ModuleBuilder");
                }
            } else
            {
                $ajax->addCrumb ( translate ( $layoutLabel, 'ModuleBuilder' ), 'ModuleBuilder.getContent("module=ModuleBuilder&MB=true&action=wizard&view_module=' . $_REQUEST [ 'view_module' ] . '&view_package=' . $_REQUEST [ 'view_package' ] . '")' ) ;
                $ajax->addCrumb ( $translatedViewType, '' ) ;
            }
        } else
        {
            $ajax->addCrumb ( translate ( 'LBL_STUDIO', 'ModuleBuilder' ), 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard")' ) ;
            $ajax->addCrumb ( $this->translatedEditModule, 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&view_module=' . $this->editModule . '")' ) ;

            if ($this->subpanel)
            {
                $ajax->addCrumb ( translate ( 'LBL_SUBPANELS', 'ModuleBuilder' ), 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&view=subpanels&view_module=' . $this->editModule . '")' ) ;
                if ($this->subpanelLabel)
                {
                    $subpanelLabel = $this->subpanelLabel;
                    // If the subpanel title has changed, use that for the label instead
                    if( !empty($_REQUEST['subpanel_title'] ) && $_REQUEST['subpanelLabel'] != $_REQUEST['subpanel_title'] )
                        $subpanelLabel = $_REQUEST['subpanel_title'];

                    $ajax->addCrumb( $subpanelLabel, '' );
                    $this->translatedViewType = $subpanelLabel . "&nbsp;" . translate("LBL_SUBPANEL", "ModuleBuilder");
                } else
                {
                    $ajax->addCrumb ( $this->subpanel, '' ) ;
                    $this->translatedViewType = translate("LBL_SUBPANEL", "ModuleBuilder");
                }
            } else
            {
                $ajax->addCrumb ( translate ( $layoutLabel, 'ModuleBuilder' ), 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&view='.$layoutView.'&view_module=' . $this->editModule . '")' ) ;
                $ajax->addCrumb ( $translatedViewType, '' ) ;
            }
        }
        return $ajax ;
    }

    function constructSmarty ($parser)
    {
        global $mod_strings;
        $smarty = new Sugar_Smarty ( ) ;
        $smarty->assign ( 'translate', true ) ;
        $smarty->assign ( 'language', $parser->getLanguage () ) ;

        $smarty->assign ( 'view', $this->editLayout ) ;
        $smarty->assign ( 'module', "ModuleBuilder" ) ;
        $smarty->assign ( 'field_defs', $parser->getFieldDefs () ) ;
        $smarty->assign ( 'action', 'listViewSave' ) ;
        $smarty->assign ( 'view_module', $this->editModule ) ;
        if (!empty ( $this->subpanel ) )
        {
            $smarty->assign ( 'subpanel', $this->subpanel ) ;
            $smarty->assign ( 'subpanelLabel', $this->subpanelLabel ) ;
            if (!$this->fromModuleBuilder) {
                $subList =  SubPanel::getModuleSubpanels ( $this->editModule);
                $subRef = $subList[strtolower($this->subpanel)];
                $subTitleKey = !empty($subRef) ? $subRef : "LBL_" . strtoupper($this->subpanel) . "_SUBPANEL_TITLE";
                $subTitle    = !empty($subRef) ? translate($subTitleKey, $this->editModule) : UCfirst($this->subpanel);
            	$smarty->assign ( 'subpanel_label', $subTitleKey ) ;
            	$smarty->assign ( 'subpanel_title', $subTitle ) ;
            }
        }
        $helpName = $this->subpanel ? 'subPanelEditor' : 'listViewEditor';
        $smarty->assign ( 'helpName', $helpName ) ;
        $smarty->assign ( 'helpDefault', 'modify' ) ;

        $smarty->assign ( 'title', $this->_constructTitle () ) ;
        $groups = array ( ) ;
        foreach ( $parser->columns as $column => $function )
        {
            // update this so that each field has a properties set
            // properties are name, value, title (optional)
            $groups [ $GLOBALS [ 'mod_strings' ] [ $column ] ] = $parser->$function () ; // call the parser functions to populate the list view columns, by default 'default', 'available' and 'hidden'
        }
        foreach ( $groups as $groupKey => $group )
        {
            foreach ( $group as $fieldKey => $field )
            {
                if (isset ( $field [ 'width' ] ))
                {
                    if (substr ( $field [ 'width' ], - 1, 1 ) == '%')
                    {

                        $groups [ $groupKey ] [ $fieldKey ] [ 'width' ] = substr ( $field [ 'width' ], 0, strlen ( $field [ 'width' ] ) - 1 ) ;
                    }
                }
            }
        }

        $smarty->assign ( 'groups', $groups ) ;
        $smarty->assign('from_mb', $this->fromModuleBuilder);

        global $image_path;
        $imageSave = SugarThemeRegistry::current()->getImage('studio_save','',null,null,'.gif',$mod_strings['LBL_BTN_SAVE']) ;

//        $imageHelp = SugarThemeRegistry::current()->getImage('help') ;


        $history = $parser->getHistory () ;

        $histaction = "ModuleBuilder.history.browse(\"{$this->editModule}\", \"{$this->editLayout}\")" ;
        if ($this->subpanel)
            $histaction = "ModuleBuilder.history.browse(\"{$this->editModule}\", \"{$this->editLayout}\", \"{$this->subpanel}\")" ;

        $restoreAction = "onclick='ModuleBuilder.history.revert(\"{$this->editModule}\", \"{$this->editLayout}\", \"{$history->getLast()}\", \"\")'";
        if ($this->subpanel)
            $restoreAction = "onclick='ModuleBuilder.history.revert(\"{$this->editModule}\", \"{$this->editLayout}\", \"{$history->getLast()}\", \"{$this->subpanel}\")'";

        $buttons = array ( ) ;
        $buttons [] = array ( 'id' =>'savebtn', 'name' => 'savebtn' , 'image' => $imageSave , 'text' => (! $this->fromModuleBuilder)?$GLOBALS [ 'mod_strings' ] [ 'LBL_BTN_SAVEPUBLISH' ]: $GLOBALS [ 'mod_strings' ] [ 'LBL_BTN_SAVE' ], 'actionScript' => "onclick='studiotabs.generateGroupForm(\"edittabs\");if (countListFields()==0) ModuleBuilder.layoutValidation.popup() ; else ModuleBuilder.handleSave(\"edittabs\" )'" ) ;
        $buttons [] = array ( 'id' => 'spacer' , 'width' => '50px' ) ;
        $buttons [] = array ( 'id' =>'historyBtn',       'name' => 'historyBtn' , 'text' => translate ( 'LBL_HISTORY' ) , 'actionScript' => "onclick='$histaction'" ) ;
        $buttons [] = array ( 'id' => 'historyDefault' , 'name' => 'historyDefault',  'text' => translate ( 'LBL_RESTORE_DEFAULT' ) , 'actionScript' => $restoreAction ) ;

        $smarty->assign ( 'buttons', $this->_buildImageButtons ( $buttons ) ) ;

        $editImage = SugarThemeRegistry::current()->getImage('edit_inline','',null,null,'.gif',$mod_strings['LBL_EDIT']) ;

        $smarty->assign ( 'editImage', $editImage ) ;
        $deleteImage = SugarThemeRegistry::current()->getImage('delete_inline','',null,null,'.gif',$mod_strings['LBL_MB_DELETE']) ;

        $smarty->assign ( 'deleteImage', $deleteImage ) ;
        $smarty->assign ( 'MOD', $GLOBALS [ 'mod_strings' ] ) ;

        if ($this->fromModuleBuilder)
        {
            $smarty->assign ( 'MB', true ) ;
            $smarty->assign ( 'view_package', $_REQUEST [ 'view_package' ] ) ;
            $mb = new ModuleBuilder ( ) ;
            $module = & $mb->getPackageModule ( $_REQUEST [ 'view_package' ], $this->editModule ) ;
            $smarty->assign('current_mod_strings', $module->getModStrings());
            if ($this->subpanel)
            {
                if (isset ( $_REQUEST [ 'local' ] ))
                {
                    $smarty->assign ( 'local', '1' ) ;
                }
                $smarty->assign ( "subpanel", $this->subpanel ) ;
            } else
            {
                $smarty->assign ( 'description', $GLOBALS [ 'mod_strings' ] [ 'LBL_LISTVIEW_DESCRIPTION' ] ) ;

            }

        } else
        {
            if ($this->subpanel)
            {
                $smarty->assign ( "subpanel", "$this->subpanel" ) ;
            } else
            {
                $smarty->assign ( 'description', $GLOBALS [ 'mod_strings' ] [ 'LBL_LISTVIEW_DESCRIPTION' ] ) ;
            }
        }

        return $smarty ;
    }

    function _constructTitle ()

    {

        global $app_list_strings ;

        if ($this->fromModuleBuilder)
        {
            $title = $this->editModule ;
            if ($this->subpanel != "")
            {
                $title .= ":$this->subpanel" ;
            }
        } else
        {
            $title = ($this->subpanel) ? ':' . $this->subpanel : $app_list_strings [ 'moduleList' ] [ $this->editModule ] ;
        }
        return $GLOBALS [ 'mod_strings' ] [ 'LBL_LISTVIEW_EDIT' ] . ':&nbsp;' . $title ;

    }

    function _buildImageButtons ($buttons , $horizontal = true)
    {
    	$text = '<table cellspacing=2><tr>' ;
        foreach ( $buttons as $button )
        {
            if (empty($button['id'])) {
            	$button['id'] = $button['name'];
            }
            if (! $horizontal)
            {
                $text .= '</tr><tr>' ;
            }
            if ($button['id'] == "spacer") {
                $text .= "<td style='width:{$button['width']}'> </td>";
                continue;
            }

            if (! empty ( $button [ 'plain' ] ))
            {
                $text .= <<<EOQ
	             <td><input name={$button['name']} id={$button['id']} class="button" type="button" valign='center' {$button['actionScript']}
EOQ;

            } else
            {
                $text .= <<<EOQ
	          <td><input name={$button['name']} id={$button['id']} class="button" type="button" valign='center' style='cursor:default'  {$button['actionScript']}
EOQ;
            }
            $text .= "value=\"{$button['text']}\"/></td>" ;
        }
        $text .= '</tr></table>' ;
        return $text ;
    }
}
