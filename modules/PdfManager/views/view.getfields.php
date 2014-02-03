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



require_once 'modules/ExpressionEngine/formulaHelper.php';

class ViewGetFields extends SugarView
{
    public $vars = array("baseModule", "baseLink");

    public function __construct()
    {
        global $app_strings;
        parent::__construct();

        foreach ($this->vars as $var) {
            if (!isset($_REQUEST[$var])) {
                sugar_die($app_strings['ERR_MISSING_REQUIRED_FIELDS'] . $var);
            }
            $this->$var = $_REQUEST[$var];
        }
    }

    public function display()
    {
        $fieldsForSelectedModule = PdfManagerHelper::getFields($this->baseModule, true);
        $selectedField = $fieldsForSelectedModule;
        $fieldsForSubModule = array();

        if (!empty($this->baseLink) && strpos($this->baseLink, 'pdfManagerRelateLink_') === 0) {

            $selectedField = $this->baseLink;
            $linkName = substr($this->baseLink, strlen('pdfManagerRelateLink_'));
            $focus = BeanFactory::newBean($this->baseModule);
            $focus->id = create_guid();
            $linksForSelectedModule = PdfManagerHelper::getLinksForModule($this->baseModule);
            if (isset($linksForSelectedModule[$linkName]) && $focus->load_relationship($linkName)) {
                $fieldsForSubModule = PdfManagerHelper::getFields($focus->$linkName->getRelatedModuleName());
            }
        }

        $this->ss->assign('fieldsForSelectedModule', $fieldsForSelectedModule);
        $this->ss->assign('selectedField', $selectedField);
        $this->ss->assign('fieldsForSubModule', $fieldsForSubModule);

        $this->ss->display('modules/PdfManager/tpls/getFields.tpl');
    }
}
