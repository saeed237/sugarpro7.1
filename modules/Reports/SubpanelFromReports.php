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

require_once 'modules/Reports/Report.php';

class SubpanelFromReports extends Report {
	public function __construct($report) {
		parent::Report($report->content);
		if (isset($this->report_def['display_columns'])) {	
			if (!empty($this->report_def['display_columns'])) {
				foreach ($this->report_def['display_columns'] as $key => $column) {
					// If self column exists, return Report class
					if ($column['table_key'] == 'self') {
						return $this;
					}
				}
			} 
			$this->_appendNecessaryColumn();
		}
	} 
	
	/**
	 *  Because one self column needed to generate primaryid for subpanel list
	 */
	private function _appendNecessaryColumn() {
		array_push($this->report_def['display_columns'], array (
			'label' => 'Name',
			'name' => 'name',
			'table_key' => 'self'
		));
	}
}