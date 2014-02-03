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

$viewdefs['Employees']['QuickCreate'] = array(
    'templateMeta' => array('maxColumns' => '2', 
                            'widths' => array(
                                array('label' => '10', 'field' => '30'), 
                                array('label' => '10', 'field' => '30')
                            ),
                            'form' => array(
                                'headerTpl'=>'modules/Users/tpls/EditViewHeader.tpl',
                                'footerTpl'=>'modules/Users/tpls/EditViewFooter.tpl',
                            ),
                      ),
    'panels' => array (
        'LBL_EMPLOYEE_INFORMATION' => array(
            array(
                array(
                      'name'=>'employee_status',
                      'customCode'=>'{if $EDIT_REPORTS_TO || $IS_ADMIN}@@FIELD@@{else}{$EMPLOYEE_STATUS_READONLY}{/if}',
                ),
                array(
                      'name'=>'title',
                      'customCode'=>'{if  $EDIT_REPORTS_TO || $IS_ADMIN}@@FIELD@@{else}{$TITLE_READONLY}{/if}',
                ),
            ),
            array(
                'first_name',
                array(
                    'name'=>'last_name',
                    'displayParams' => array('required'=>true),
                ),
            ),
            array(
                array(
                    'name'=>'department',
                    'customCode'=>'{if  $EDIT_REPORTS_TO || $IS_ADMIN}@@FIELD@@{else}{$DEPT_READONLY}{/if}',
                ),
                'phone_work'
            ),
            array(
                array(
                    'name'=>'reports_to_name',
                    'customCode'=>'{if  $EDIT_REPORTS_TO || $IS_ADMIN}@@FIELD@@{else}{$REPORTS_TO_READONLY}{/if}',
                ),
                array(
                    'name'=>'email1',
                    'displayParams' => array('required'=>false),
                ),
            ),
        ),
    ),
);
