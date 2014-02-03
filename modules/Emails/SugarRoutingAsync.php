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

require_once("include/SugarRouting/SugarRouting.php");

$ie = BeanFactory::getBean('InboundEmail');
$json = getJSONobj();
$rules = new SugarRouting($ie, $current_user);

switch($_REQUEST['routingAction']) {
	case "setRuleStatus":
		$rules->setRuleStatus($_REQUEST['rule_id'], $_REQUEST['status']);
	break;

	case "saveRule":
		$rules->save($_REQUEST);
	break;

	case "deleteRule":
		$rules->deleteRule($_REQUEST['rule_id']);
	break;

	/* returns metadata to construct actions */
	case "getActions":
		require_once("include/SugarDependentDropdown/SugarDependentDropdown.php");

		$sdd = new SugarDependentDropdown();
		$sdd->init("include/SugarDependentDropdown/metadata/dependentDropdown.php");
		$out = $json->encode($sdd->metadata, true);
		echo $out;
	break;

	/* returns metadata to construct a rule */
	case "getRule":
		$ret = '';
		if(isset($_REQUEST['rule_id']) && !empty($_REQUEST['rule_id']) && isset($_REQUEST['bean']) && !empty($_REQUEST['bean'])) {
		    $bean = BeanFactory::getBean($_REQUEST['bean']);
            if(!empty($bean)) {
				$rule = $rules->getRule($_REQUEST['rule_id'], $bean);

				$ret = array(
					'bean' => $_REQUEST['bean'],
					'rule' => $rule
				);
			}
		} else {
			$bean = BeanFactory::getBean('Empty');
			$rule = $rules->getRule('', $bean);

			$ret = array(
				'bean' => $_REQUEST['bean'],
				'rule' => $rule
			);
		}

		//_ppd($ret);

		$out = $json->encode($ret, true);
		echo $out;
	break;

	case "getStrings":
		$ret = $rules->getStrings();
		$out = $json->encode($ret, true);
		echo $out;
	break;


	default:
		echo "NOOP";
}