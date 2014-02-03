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


require_once('include/MVC/View/views/view.detail.php');

class CasesViewDetail extends ViewDetail {

    public function preDisplay()
    {
        parent::preDisplay();
        if(ACLController::checkAccess('KBDocuments', 'edit', true))
        {
            array_push($this->dv->defs['templateMeta']['form']['buttons'], array(
                    'customCode'=>'<input title="{$MOD.LBL_CREATE_KB_DOCUMENT}" accessKey="M" class="button" onclick="this.form.return_module.value=\'Cases\'; this.form.return_action.value=\'DetailView\';this.form.action.value=\'EditView\';this.form.module.value=\'KBDocuments\';" type="submit" name="button" value="{$MOD.LBL_CREATE_KB_DOCUMENT}">',
                    'sugar_html' => array(
                        'type' => 'submit',
                        'value' => '{$MOD.LBL_CREATE_KB_DOCUMENT}',
                        'htmlOptions' => array(
                            'title' => '{$MOD.LBL_CREATE_KB_DOCUMENT}',
                            'accessKey' => 'M',
                            'class' => 'button',
                            'onclick' => 'this.form.return_module.value=\'Cases\'; this.form.return_action.value=\'DetailView\';this.form.action.value=\'EditView\';this.form.module.value=\'KBDocuments\';',
                            'name' => 'button',
                        ),
                    ),
                )
            );
        }
        $this->dv->th->deleteTemplate($this->dv->module, $this->dv->view);
    }
}

?>