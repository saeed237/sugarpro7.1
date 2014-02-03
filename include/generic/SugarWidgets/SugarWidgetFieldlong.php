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


/*********************************************************************************
 * This resolves SugarCRM Bug # 52929
 * http://www.sugarcrm.com/support/bugs.html#issue_52929
 *
 * Jeff Bickart
 * Twitter: @bickart
 * Email: jeff @ neposystems.com
 * Blog: http://sugarcrm-dev.blogspot.com
 ********************************************************************************/

class SugarWidgetFieldLong extends SugarWidgetFieldDecimal
{
	function SugarWidgetFieldLong(&$layout_manager) {
		parent::SugarWidgetFieldDecimal($layout_manager);
	}	
}

?>
