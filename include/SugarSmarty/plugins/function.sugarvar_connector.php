<?php

/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r51719 - 2009-10-22 10:18:00 -0700 (Thu, 22 Oct 2009) - mitani - Converted to Build 3  tags and updated the build system 

r51634 - 2009-10-19 13:32:22 -0700 (Mon, 19 Oct 2009) - mitani - Windex is the branch for Sugar Sales 1.0 development

r50375 - 2009-08-24 18:07:43 -0700 (Mon, 24 Aug 2009) - dwong - branch kobe2 from tokyo r50372

r42807 - 2008-12-29 11:16:59 -0800 (Mon, 29 Dec 2008) - dwong - Branch from trunk/sugarcrm r42806 to branches/tokyo/sugarcrm

r42645 - 2008-12-18 13:41:08 -0800 (Thu, 18 Dec 2008) - awu - merging maint_5_2_0 rev41336:HEAD to trunk

r42562 - 2008-12-15 17:54:57 -0800 (Mon, 15 Dec 2008) - dwong - create branches/maint_5_2_0 from branches/milan r42559

r42508 - 2008-12-11 14:59:33 -0800 (Thu, 11 Dec 2008) - Collin Lee - Updated license information  and emoved Wrapper components (we decided to not have these components awhile back).

r41851 - 2008-11-17 17:57:10 -0800 (Mon, 17 Nov 2008) - roger - bug: 26286.

r41724 - 2008-11-13 08:55:42 -0800 (Thu, 13 Nov 2008) - Collin Lee - Made changes to rename DataSource module and components to Connectors.


*/


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


function smarty_function_sugarvar_connector($params, &$smarty) {
      
      $displayParams = $smarty->get_template_vars('displayParams');
      if(!isset($displayParams['module'])) {
         $smarty->trigger_error("sugarvar_connector: missing 'module' parameter");
         $GLOBALS['log']->error("sugarvar_connector: missing 'module' parameter");
         return;     	
      }
      
      require_once('include/connectors/utils/ConnectorUtils.php');
      echo ConnectorUtils::getConnectorButtonScript($displayParams, $smarty);
}
?>