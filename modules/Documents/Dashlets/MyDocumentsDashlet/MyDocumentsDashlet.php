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


require_once('include/Dashlets/DashletGeneric.php');

class MyDocumentsDashlet extends DashletGeneric { 

	function MyDocumentsDashlet($id, $def = null)
	{
		global $current_user, $app_strings;
		require('modules/Documents/Dashlets/MyDocumentsDashlet/MyDocumentsDashlet.data.php');

        parent::DashletGeneric($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'Documents');

        $this->searchFields = $dashletData['MyDocumentsDashlet']['searchFields'];
        $this->columns = $dashletData['MyDocumentsDashlet']['columns'];

        $this->seedBean = BeanFactory::getBean('Documents');        
    }

    function displayOptions() {
        $this->processDisplayOptions();
        require_once('modules/Documents/Document.php');

        $types = getDocumentsExternalApiDropDown();
        $this->currentSearchFields['doc_type']['input'] = '<select size="3" multiple="true" name="doc_type[]">'
	                                              . get_select_options_with_id($types, (empty($this->filters['doc_type']) ? '' : $this->filters['doc_type']))
	                                              . '</select>';
        $this->configureSS->assign('searchFields', $this->currentSearchFields);
        return $this->configureSS->fetch($this->configureTpl);
    }
}

?>