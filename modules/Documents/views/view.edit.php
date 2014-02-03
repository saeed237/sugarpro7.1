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


class DocumentsViewEdit extends ViewEdit
{

    /**
     * @see SugarView::ViewEdit()
     */
     function DocumentsViewEdit(){
         parent::ViewEdit();
         $this->useForSubpanel = true;
     }

 	/**
	 * @see SugarView::display()
	 */
	public function display()
 	{
		global $app_list_strings, $mod_strings;

		$load_signed=false;
		if ((isset($_REQUEST['load_signed_id']) && !empty($_REQUEST['load_signed_id']))) {

			$load_signed=true;
			if (isset($_REQUEST['record'])) {
				$this->bean->related_doc_id=$_REQUEST['record'];
			}
			if (isset($_REQUEST['selected_revision_id'])) {
				$this->bean->related_doc_rev_id=$_REQUEST['selected_revision_id'];
			}

			$this->bean->id=null;
			$this->bean->document_name=null;
			$this->bean->filename=null;
			$this->bean->is_template=0;
		} //if

		if (!empty($this->bean->id) ||
            (empty($this->bean->id) && !empty($_REQUEST['record']) && !empty($_REQUEST['action']) && strtolower($_REQUEST['action'])=='quickedit')
        ) {
			$this->ss->assign("FILE_OR_HIDDEN", "hidden");
			if (!$this->ev->isDuplicate) {
				$this->ss->assign("DISABLED", "disabled");
			}
		} else {
			$this->bean->revision = 1;
		    $this->ss->assign("FILE_OR_HIDDEN", "file");
		}

		$popup_request_data = array(
			'call_back_function' => 'document_set_return',
			'form_name' => 'EditView',
			'field_to_name_array' => array(
				'id' => 'related_doc_id',
				'document_name' => 'related_document_name',
				),
			);
		$json = getJSONobj();
		$this->ss->assign('encoded_document_popup_request_data', $json->encode($popup_request_data));


		//get related document name.
		if (!empty($this->bean->related_doc_id)) {
			$this->ss->assign("RELATED_DOCUMENT_NAME",Document::get_document_name($this->bean->related_doc_id));
			$this->ss->assign("RELATED_DOCUMENT_ID",$this->bean->related_doc_id);
			if (!empty($this->bean->related_doc_rev_id)) {
				$this->ss->assign("RELATED_DOCUMENT_REVISION_OPTIONS", get_select_options_with_id(DocumentRevision::get_document_revisions($this->bean->related_doc_id), $this->bean->related_doc_rev_id));
			} else {
				$this->ss->assign("RELATED_DOCUMENT_REVISION_OPTIONS", get_select_options_with_id(DocumentRevision::get_document_revisions($this->bean->related_doc_id), ''));
			}
		} else {
			$this->ss->assign("RELATED_DOCUMENT_REVISION_DISABLED", "disabled");
		}


		//set parent information in the form.
		if (isset($_REQUEST['parent_id'])) {
			$this->ss->assign("PARENT_ID",$_REQUEST['parent_id']);
		} //if

		if (isset($_REQUEST['parent_name'])) {
			$this->ss->assign("PARENT_NAME", $_REQUEST['parent_name']);

			if (!empty($_REQUEST['parent_type'])) {
				switch (strtolower($_REQUEST['parent_type'])) {

					case "contracts" :
						$this->ss->assign("LBL_PARENT_NAME",$mod_strings['LBL_CONTRACT_NAME']);
						break;

					//todo remove leads case.
					case "leads" :
						$this->ss->assign("LBL_PARENT_NAME",$mod_strings['LBL_CONTRACT_NAME']);
						break;
				} //switch
			} //if
		} //if

		if (isset($_REQUEST['parent_type'])) {
			$this->ss->assign("PARENT_TYPE",$_REQUEST['parent_type']);
		}

		if ($load_signed) {
			$this->ss->assign("RELATED_DOCUMENT_REVISION_DISABLED", "disabled");
			$this->ss->assign("RELATED_DOCUMENT_BUTTON_AVAILABILITY", "hidden");
			$this->ss->assign("LOAD_SIGNED_ID",$_REQUEST['load_signed_id']);
		} else {
			$this->ss->assign("RELATED_DOCUMENT_BUTTON_AVAILABILITY", "button");
		} //if-else

 		parent::display();
 	}

	/**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
    	$params = array();
    	$params[] = $this->_getModuleTitleListParam($browserTitle);
    	if(!empty($this->bean->id)){
			$params[] = "<a href='index.php?module={$this->module}&action=DetailView&record={$this->bean->id}'>".$this->bean->document_name."</a>";
			$params[] = $GLOBALS['app_strings']['LBL_EDIT_BUTTON_LABEL'];
		}else{
			$params[] = $GLOBALS['app_strings']['LBL_CREATE_BUTTON_LABEL'];
		}

		return $params;
    }

}
