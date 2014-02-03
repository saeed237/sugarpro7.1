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

require_once('include/connectors/formatters/default/formatter.php');

class ext_rest_linkedin_formatter extends default_formatter {

public function getDetailViewFormat() {
   $mapping = $this->getSourceMapping();
   $mapping_name = !empty($mapping['beans'][$this->_module]['name']) ? $mapping['beans'][$this->_module]['name'] : '';
   if(!empty($mapping_name)) {
	   $this->_ss->assign('mapping_name', $mapping_name);
	   return $this->fetchSmarty();
   }

   $GLOBALS['log']->error($GLOBALS['app_strings']['ERR_MISSING_MAPPING_ENTRY_FORM_MODULE']);
   return '';
}

public function getIconFilePath() {
   return 'modules/Connectors/connectors/formatters/ext/rest/linkedin/tpls/linkedin.gif';
}

}
?>
