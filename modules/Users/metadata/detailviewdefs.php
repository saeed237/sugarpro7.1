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
            array('full_name','user_name'),
            array('status',
                  array(
                      'name'=>'UserType',
                      'customCode'=>'{$USER_TYPE_READONLY}',
                  ),
            ),
            array('picture'),
        ),
        'LBL_EMPLOYEE_INFORMATION' => array(
            array('employee_status','show_on_employees'),
            array('title','phone_work'),
            array('department','phone_mobile'),
            array('reports_to_name','phone_other'),
            array('','phone_fax'),
            array('','phone_home'),
            array('messenger_type','messenger_id'),
            array('address_street','address_city'),
            array('address_state','address_postalcode'),
            array('address_country'),
            array('description'),
        ),
    ),
);
