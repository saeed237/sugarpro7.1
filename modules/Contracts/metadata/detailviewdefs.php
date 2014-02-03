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

$viewdefs['Contracts']['DetailView'] = array(
    'templateMeta' => array(
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30')
        ),
        'form' => array(
            'buttons' => array(
                'EDIT',
                'SHARE',
                'DUPLICATE',
                'DELETE'
            )
        ),
    ),
    'panels' => array(
        'lbl_contract_information' => array(
            array(
                array(
                    'name' => 'name',
                    'label' => 'LBL_CONTRACT_NAME',
                ),
                'status',
            ),
            array(
                'reference_code',
                'start_date',
            ),
            array(
                'account_name',
                'end_date',
            ),
            array(
                array(
                    'name' => 'opportunity_name',
                    'label' => 'LBL_OPPORTUNITY',
                ),
            ),
            array(
                array(
                    'name' => 'type',
                    'label' => 'LBL_CONTRACT_TYPE',
                ),
                array(
                    'name' => 'contract_term',
                    'customCode' => '{$fields.contract_term.value}&nbsp;{if !empty($fields.contract_term.value) }{$MOD.LBL_DAYS}{/if}',
                    'label' => 'LBL_CONTRACT_TERM',
                ),
            ),
            array(
                array(
                    'name' => 'total_contract_value',
                    'label' => '{$MOD.LBL_TOTAL_CONTRACT_VALUE} ({$fields.currency_name.value})',
                ),
                'company_signed_date',
            ),
            array(

                'expiration_notice',
                'customer_signed_date',
            ),
            array(
                'description',
            ),
        ),
        'LBL_PANEL_ASSIGNMENT' => array(
            array(
                array(
                    'name' => 'assigned_user_name',
                    'label' => 'LBL_ASSIGNED_TO',
                ),
                array(
                    'name' => 'date_modified',
                    'customCode' => '{$fields.date_modified.value}&nbsp;{$APP.LBL_BY}&nbsp;{$fields.modified_by_name.value}',
                    'label' => 'LBL_DATE_MODIFIED',
                ),
            ),
            array(
                'team_name',
                array(
                    'name' => 'date_entered',
                    'customCode' => '{$fields.date_entered.value}&nbsp;{$APP.LBL_BY}&nbsp;{$fields.created_by_name.value}',
                    'label' => 'LBL_DATE_ENTERED',
                ),
            ),
        )
    )
);
