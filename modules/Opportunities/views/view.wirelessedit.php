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

 * Description: This file is used to override the default Meta-data EditView behavior
 * to provide customization specific to the Calls module.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/MVC/View/views/view.wirelessedit.php');

class OpportunitiesViewWirelessedit extends ViewWirelessedit 
{
 	public function display() 
 	{
		parent::display();
        
        global $app_list_strings;
		$json = getJSONobj();
		$prob_array = $json->encode($app_list_strings['sales_probability_dom']);
		$prePopProb = '';
		
		if(empty($this->bean->id)) 
		    $prePopProb = 'document.getElementsByName(\'sales_stage\')[0].onchange();';
        
		echo <<<EOQ
<script>
prob_array = $prob_array;
if(document.getElementsByName('sales_stage') != null) {
    document.getElementsByName('sales_stage')[0].onchange = function() {
        if(document.getElementsByName('probability') != null
                && typeof(document.getElementsByName('sales_stage')[0].value) != "undefined" 
                && prob_array[document.getElementsByName('sales_stage')[0].value]) {
            document.getElementsByName('probability')[0].value = prob_array[document.getElementsByName('sales_stage')[0].value];
        } 
    };
    $prePopProb
}
</script>
EOQ;
 	}
}
?>
