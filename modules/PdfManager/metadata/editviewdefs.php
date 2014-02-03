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



$viewdefs['PdfManager'] =
array (
  'EditView' =>
  array (
    'templateMeta' =>
    array (
        'form' => array(
                            'footerTpl' => 'modules/PdfManager/tpls/EditViewFooter.tpl',
                            'enctype'=>'multipart/form-data',
                            'hidden' => array(
                                '<input type="hidden" name="base_module_history" id="base_module_history" value="{$fields.base_module.value}">',
                            )
                        ),
      'maxColumns' => '2',
      'widths' =>
      array (
        0 =>
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 =>
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'includes' => array (
          array (
              'file' => 'modules/PdfManager/javascript/PdfManager.js',
          ),
      ),
      'useTabs' => false,
      'syncDetailEditViews' => false,
    ),
    'panels' =>
    array (
      'default' =>
      array (
        0 =>
        array (
          0 => 'name',
          1 =>
          array (
            'name' => 'team_name',
            'displayParams' =>
            array (
              'display' => true,
            ),
          ),
        ),
        1 =>
        array (
          0 => array(   'name' => 'description',
                        'displayParams' => array('rows' => 1)
                    ),
        ),
        2 =>
        array (
          0 =>
          array (
            'name' => 'base_module',
            'label' => 'LBL_BASE_MODULE',
            'popupHelp' => 'LBL_BASE_MODULE_POPUP_HELP',
            'displayParams' =>
            array (
                'field' => array (
                    'onChange' => 'SUGAR.PdfManager.loadFields(this.value, \'\');',
                ),
            ),
          ),
          1 =>
          array (
            'name' => 'published',
            'label' => 'LBL_PUBLISHED',
            'popupHelp' => 'LBL_PUBLISHED_POPUP_HELP',
          ),
        ),
        3 =>
        array (
          0 =>
          array (
            'name' => 'field',
            'label' => 'LBL_FIELD',
            'customCode' => '{include file="modules/PdfManager/tpls/getFields.tpl"}',
            'popupHelp' => 'LBL_FIELD_POPUP_HELP',
          ),
        ),
        4 =>
        array (
          0 =>
          array (
            'name' => 'body_html',
            'label' => 'LBL_BODY_HTML',
            'popupHelp' => 'LBL_BODY_HTML_POPUP_HELP',
          ),
        ),
      ),
      'lbl_editview_panel1' =>
      array (
        0 =>
        array (
          0 =>
          array (
            'name' => 'author',
            'label' => 'LBL_AUTHOR',
          ),
          1 =>
          array (
            'name' => 'title',
            'label' => 'LBL_TITLE',
          ),
        ),
        1 =>
        array (
          0 =>
          array (
            'name' => 'subject',
            'label' => 'LBL_SUBJECT',
          ),
          1 =>
          array (
            'name' => 'keywords',
            'label' => 'LBL_KEYWORDS',
            'popupHelp' => 'LBL_KEYWORDS_POPUP_HELP'
          ),
        ),
      ),
    ),
  ),
);
