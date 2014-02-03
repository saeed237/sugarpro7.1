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


require_once('include/SearchForm/SearchForm.php');

class SearchFormReports extends SearchForm
{
    /**
     * @see SearchForm::setup()
     */
    function setup()
    {
        parent::setup();

        $this->xtpl->assign('LOADING_IMAGE',getStudioIcon('loading', 'loading', 16, 16));
        $this->xtpl->assign('HELP_IMAGE',SugarThemeRegistry::current()->getImageURL('help-dashlet.gif'));
        $this->xtpl->assign('CLOSE_IMAGE',SugarThemeRegistry::current()->getImageURL('close.gif'));
    }

    /**
     * @see SearchForm::displayHeader()
     */
    function displayHeader($view)
    {
        global $current_user;
        $GLOBALS['log']->debug('SearchForm.php->displayHeader()');
        $header_text = '';
        if(is_admin($current_user) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])){
            $header_text = "<a href='index.php?action=index&module=DynamicLayout&from_action=SearchForm&from_module=".$_REQUEST['module'] ."'>".SugarThemeRegistry::current()->getImage("EditLayout","border='0' align='bottom'",null,null,'.gif',$mod_strings['LBL_EDITLAYOUT'])."</a>";
        }

        echo "<form name='search_form' class='search_form'>" .
             "<input type='hidden' name='searchFormTab' value='{$view}'/>" .
             "<input type='hidden' name='module' value='{$_REQUEST['module']}'/>" .
             "<input type='hidden' name='action' value='{$_REQUEST['action']}'/>" .
             "<input type='hidden' name='query' value='true'/>";
    }

    /**
     * @see SearchForm::displayWithHeaders()
     */
    function displayWithHeaders($view, $basic_search_text = '', $advanced_search_text = '', $saved_views_text = '')
    {
        $GLOBALS['log']->debug('SearchForm.php->displayWithHeaders()');
        $this->displayHeader($view);
        echo "<div id='{$this->module}basic_searchSearchForm' class='edit view search basic' " . (($view == 'basic_search') ? '' : "style='display: none'") . ">" . $basic_search_text . "</div>";
        echo "<div id='{$this->module}advanced_searchSearchForm' class='edit view search advanced' " . (($view == 'advanced_search') ? '' : "style='display: none'") . ">" . $advanced_search_text . "</div>";
        echo '</form>';
        echo "
                <script>
                    function toggleInlineSearch(){
                        if (document.getElementById('inlineSavedSearch').style.display == 'none'){
                            document.getElementById('showSSDIV').value = 'yes'
                            document.getElementById('inlineSavedSearch').style.display = '';

                            document.getElementById('up_down_img').src='".SugarThemeRegistry::current()->getImageURL('basic_search.gif')."';
                            document.getElementById('up_down_img').setAttribute('alt','".translate('LBL_ALT_HIDE_OPTIONS')."');

                        }else{

                            document.getElementById('up_down_img').src='".SugarThemeRegistry::current()->getImageURL('advanced_search.gif')."';
                            document.getElementById('up_down_img').setAttribute('alt','".translate('LBL_ALT_SHOW_OPTIONS')."');
                            document.getElementById('showSSDIV').value = 'no';
                            document.getElementById('inlineSavedSearch').style.display = 'none';
                        }
                    }


                </script>
            ";
    }

    function displayAdvanced($header = true, $return = false, $listViewDefs='', $lv='')
    {
        global $app_strings;

        $SAVED_SEARCHES_OPTIONS = '';
        $savedSearch = BeanFactory::getBean('SavedSearch');
        $SAVED_SEARCHES_OPTIONS = $savedSearch->getSelect($this->module);
        $str = "";
        if(!empty($SAVED_SEARCHES_OPTIONS) && $this->showSavedSearchOptions){
            $str .= "   <span class='white-space'>
                        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<b>{$app_strings['LBL_SAVED_SEARCH_SHORTCUT']}</b>&nbsp;
                        {$SAVED_SEARCHES_OPTIONS}
                        <span id='go_btn_span' style='display:none'><input tabindex='2' title='go_select' id='go_select'  onclick='SUGAR.searchForm.clear_form(this.form); return false;' class='button' type='button' name='go_select' value=' {$app_strings['LBL_GO_BUTTON_LABEL']} '/></span>
                    </span>";
        }
        $str .= "
                <script>
                    function toggleInlineSearch(){
                        if (document.getElementById('inlineSavedSearch').style.display == 'none'){
                            document.getElementById('showSSDIV').value = 'yes'
                            document.getElementById('inlineSavedSearch').style.display = '';

                            document.getElementById('up_down_img').src='".SugarThemeRegistry::current()->getImageURL('basic_search.gif')."';
                            document.getElementById('up_down_img').setAttribute('alt','".translate('LBL_ALT_HIDE_OPTIONS')."');

                        }else{

                            document.getElementById('up_down_img').src='".SugarThemeRegistry::current()->getImageURL('advanced_search.gif')."';
                            document.getElementById('up_down_img').setAttribute('alt','".translate('LBL_ALT_SHOW_OPTIONS')."');
                            document.getElementById('showSSDIV').value = 'no';
                            document.getElementById('inlineSavedSearch').style.display = 'none';
                        }
                    }


                </script>
            ";
        $this->xtpl->assign('ADVANCED_BUTTONS',$str);
        $this->xtpl->assign('LBL_DELETE_CONFIRM',translate('LBL_DELETE_CONFIRM', 'SavedSearch'));
        return parent::displayAdvanced($header, $return, $listViewDefs, $lv);
    }

    public static function retrieveReportsSearchDefs()
     {
         $searchdefs = array();
         $searchFields = array();

         $defs = SugarAutoLoader::loadWithMetafiles('Reports', 'searchdefs');
         if($defs) {
             require $defs;
         }
         $searchFields = SugarAutoLoader::loadSearchFields('Reports');

         return array('searchdefs' => $searchdefs, 'searchFields' => $searchFields );
     }


}
