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



$subpanel_layout = array(
    'top_buttons' => array(
        array('widget_class' => 'SubPanelTopCreateButton'),
        array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'PdfManager'),
    ),

    'where' => '',

    'list_fields' => array(
        'name'=>array(
             'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
             'width' => '45%',
        ),
        'date_modified'=>array(
             'vname' => 'LBL_DATE_MODIFIED',
             'width' => '45%',
        ),
        'edit_button'=>array(
            'widget_class' => 'SubPanelEditButton',
             'module' => 'PdfManager',
             'width' => '4%',
        ),
        'remove_button'=>array(
            'widget_class' => 'SubPanelRemoveButton',
             'module' => 'PdfManager',
            'width' => '5%',
        ),
    ),
);
