<?php
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

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldText extends SugarFieldBase {

	function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
		$displayParams['nl2br'] = true;
		$displayParams['htmlescape'] = true;
		$displayParams['url2html'] = true;
		return parent::getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex);
    }
	function getWirelessEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
		$displayParams['nl2br'] = true;
		$displayParams['url2html'] = true;
		return parent::getWirelessEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex);
    }
    function getClassicEditView($field_id='description', $value='', $prefix='', $rich_text=false, $maxlength='', $tabindex=1, $cols=80, $rows=4) {

        $this->ss->assign('prefix', $prefix);
        $this->ss->assign('field_id', $field_id);
        $this->ss->assign('value', $value);
        $this->ss->assign('tabindex', $tabindex);

        $displayParams = array();
        $displayParams['textonly'] = $rich_text ? false : true;
        $displayParams['maxlength'] = $maxlength;
        $displayParams['rows'] = $rows;
        $displayParams['cols'] = $cols;


        $this->ss->assign('displayParams', $displayParams);
		if(isset($GLOBALS['current_user'])) {
			$height = $GLOBALS['current_user']->getPreference('text_editor_height');
			$width = $GLOBALS['current_user']->getPreference('text_editor_width');
			$height = isset($height) ? $height : '300px';
	        $width = isset($width) ? $width : '95%';
			$this->ss->assign('RICH_TEXT_EDITOR_HEIGHT', $height);
			$this->ss->assign('RICH_TEXT_EDITOR_WIDTH', $width);
		} else {
			$this->ss->assign('RICH_TEXT_EDITOR_HEIGHT', '100px');
			$this->ss->assign('RICH_TEXT_EDITOR_WIDTH', '95%');
		}

		return $this->ss->fetch($this->findTemplate('ClassicEditView'));
    }
}
?>
