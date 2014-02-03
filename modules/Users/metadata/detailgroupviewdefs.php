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

$viewdefs['Users']['DetailView'] = array(
    'templateMeta' => array('maxColumns' => '2', 
                            'widths' => array(
                                array('label' => '10', 'field' => '30'), 
                                array('label' => '10', 'field' => '30')
                            ),
                            'form' => array(
                                'headerTpl'=>'modules/Users/tpls/DetailViewHeader.tpl',
                                'footerTpl'=>'modules/Users/tpls/DetailViewFooter.tpl',
                            ),
                      ),
    'panels' => array (
        'LBL_USER_INFORMATION' => array (
            array('user_name',
                  array('name' => 'last_name',
                        'label' => 'LBL_LIST_NAME',
                  ),
            ),
            array('status',
                  '',
            ),
            array(array(
                      'name'=>'UserType',
                      'customCode'=>'{$USER_TYPE_READONLY}',
                  ),
            ),
        ),
    ),
);
