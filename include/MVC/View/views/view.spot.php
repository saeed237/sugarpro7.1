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


require_once('include/MVC/View/views/view.ajax.php');
require_once('modules/Home/UnifiedSearchAdvanced.php');
require_once('include/SugarSearchEngine/SugarSearchEngineFactory.php');


class ViewSpot extends ViewAjax
{
    /**
     * Constructor
     *
     * @see SugarView::SugarView()
     */
    public function ViewSpot() {
        $this->options['show_header'] = true;
        parent::SugarView();
    }

    /**
     * @see SugarView::display()
     */
    public function display()
    {

		$offset = -1;
        $modules = array();

		if(!empty($_REQUEST['zoom']) )
        {
			$modules = array($_REQUEST['zoom']);
			if(isset($_REQUEST['offset'])){
				$offset = $_REQUEST['offset'];
			}
		}

        $limit = ( !empty($GLOBALS['sugar_config']['max_spotresults_initial']) ? $GLOBALS['sugar_config']['max_spotresults_initial'] : 5 );
        if($offset !== -1)
        {
            $limit = ( !empty($GLOBALS['sugar_config']['max_spotresults_more']) ? $GLOBALS['sugar_config']['max_spotresults_more'] : 20 );
        }

        $options = array('current_module' => $this->module, 'modules' => $modules);

        $searchEngine = SugarSearchEngineFactory::getInstance('', array(), true);

        $trimmed_query = trim($_REQUEST['q']);
        $rs = $searchEngine->search($trimmed_query, $offset, $limit, $options);
        $formattedResults = $this->formatSearchResultsToDisplay($rs, $offset,$trimmed_query);

        $query_encoded = urlencode($trimmed_query);
        $displayMoreForModule = $formattedResults['displayMoreForModule'];
        $displayResults = $formattedResults['displayResults'];

        $ss = new Sugar_Smarty();
        $ss->assign('displayResults', $displayResults);
        $ss->assign('displayMoreForModule', $displayMoreForModule);
        $ss->assign('appStrings', $GLOBALS['app_strings']);
        $ss->assign('appListStrings', $GLOBALS['app_list_strings']);
        $ss->assign('queryEncoded', $query_encoded);
        $ss->assign('test', "#bwc/index.php?module=Home&action=UnifiedSearch&search_form=false&advanced=false&query_string=".$query_encoded);

        echo $ss->fetch(SugarAutoLoader::existingCustomOne('include/SearchForm/tpls/SugarSpot.tpl'));
    }


    protected function formatSearchResultsToDisplay($results, $offset, $trimmedQuery)
    {
        $displayResults = array();
        $displayMoreForModule = array();
        //$actions=0;
        foreach($results as $m=>$data)
        {
            if(empty($data['data']))
            {
                continue;
            }

            $countRemaining = $data['pageData']['offsets']['total'] - count($data['data']);
            if($offset > 0)
            {
                $countRemaining -= $offset;
            }

            if($countRemaining > 0)
            {
                $displayMoreForModule[$m] = array('query'=>$trimmedQuery,
                    'offset'=>++$data['pageData']['offsets']['next'],
                    'countRemaining'=>$countRemaining);
            }

            foreach($data['data'] as $row)
            {
                $name = '';

                //Determine a name to use
                if(!empty($row['NAME']))
                {
                    $name = $row['NAME'];
                }
                else if(!empty($row['DOCUMENT_NAME']))
                {
                    $name = $row['DOCUMENT_NAME'];
                }
                else
                {
                    $foundName = '';
                    foreach($row as $k=>$v)
                    {
                        if(strpos($k, 'NAME') !== false)
                        {
                            if(!empty($row[$k]))
                            {
                                $name = $v;
                                break;
                            }
                            else if(empty($foundName))
                            {
                                $foundName = $v;
                            }
                        }
                    }

                    if(empty($name))
                    {
                        $name = $foundName;
                    }
                }

                $displayResults[$m][$row['ID']] = $name;
            }
        }

        return array('displayResults' => $displayResults, 'displayMoreForModule' => $displayMoreForModule);
    }
}

