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

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
require_once('modules/UpgradeWizard/SugarMerge/EditViewMerge.php');
/**
 * This class extends the EditViewMerge - since the meta data is relatively the same the only thing that needs to be changed is the parameter for viewdefs
 *
 */
class DetailViewMerge extends EditViewMerge{
	/**
	 * Enter the name of the parameter used in the $varName for example in editviewdefs and detailviewdefs it is 'EditView' and 'DetailView' respectively - $viewdefs['EditView']
	 *
	 * @var STRING
	 */
	protected $viewDefs = 'DetailView';
		/**
	 * Determines if getFields should analyze panels to determine if it is a MultiPanel
	 *
	 * @var BOOLEAN
	 */
	protected $scanForMultiPanel = true;	/**
	 * Parses out the fields for each files meta data and then calls on mergeFields and setPanels
	 *
	 */
	protected function mergeMetaData(){
		$this->originalFields = $this->getFields($this->originalData[$this->module][$this->viewDefs][$this->panelName]);
		$this->originalPanelIds = $this->getPanelIds($this->originalData[$this->module][$this->viewDefs][$this->panelName]);
		$this->customFields = $this->getFields($this->customData[$this->module][$this->viewDefs][$this->panelName]);

		//Special handling to rename certain variables for DetailViews
		$rename_fields = array();
		foreach($this->customFields as $field_id=>$field){
		    //Check to see if we need to rename the field for special cases
			if(!empty($this->fieldConversionMapping[$this->module][$field_id])) {
			   $rename_fields[$field_id] = $this->fieldConversionMapping[$this->module][$field['data']['name']];
			   $this->customFields[$field_id]['data']['name'] = $this->fieldConversionMapping[$this->module][$field['data']['name']];
			}				
		}

		foreach($rename_fields as $original_index=>$new_index) {
			$this->customFields[$new_index] = $this->customFields[$original_index];
			unset($this->customFields[$original_index]);
		}
		
		$this->customPanelIds = $this->getPanelIds($this->customData[$this->module][$this->viewDefs][$this->panelName]);		
		$this->newFields = $this->getFields($this->newData[$this->module][$this->viewDefs][$this->panelName]);
		//echo var_export($this->newFields, true);
		$this->newPanelIds = $this->getPanelIds($this->newData[$this->module][$this->viewDefs][$this->panelName]);
		$this->mergeFields();
		$this->mergeTemplateMeta();
		$this->setPanels();
	}
		
}
?>