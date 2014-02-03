<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

$listDefs = array(
    'panels' =>
    array(
        0 =>
        array(
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                array(
                    'name' => 'commit_stage',
                    'type' => 'enum',
                    'searchBarThreshold' => 7,
                    'label' => 'LBL_FORECAST',
                    'sortable' => false,
                    'default' => true,
                    'enabled' => true,
                    'click_to_edit' => true
                ),
                array(
                    'name' => 'parent_name',
                    'label' => 'LBL_NAME',
                    'link' => true,
                    'id' => 'parent_id',
                    'sortable' => true,
                    'default' => true,
                    'enabled' => true,
                    'type' => 'parent',
                    'readonly' => true
                ),
                array(
                    'name' => 'account_name'
                ),
                array(
                    'name' => 'date_closed',
                    'label' => 'LBL_DATE_CLOSED',
                    'sortable' => true,
                    'default' => true,
                    'enabled' => true,
                    'type' => 'date',
                    'view' => 'detail',
                    'click_to_edit' => true
                ),
                array(
                    'name' => 'sales_stage',
                    'label' => 'LBL_SALES_STAGE',
                    'type' => 'enum',
                    'options' => 'sales_stage_dom',
                    'searchBarThreshold' => 7,
                    'sortable' => false,
                    'default' => true,
                    'enabled' => true,
                    'click_to_edit' => true
                ),
                array(
                    'name' => 'probability',
                    'label' => 'LBL_OW_PROBABILITY',
                    'type' => 'int',
                    'default' => true,
                    'enabled' => true,
                    'maxValue' => 100,
                    'minValue' => 0,
                    'click_to_edit' => true,
                    'align' => 'right',
                    'width' => '7%'
                ),
                array(
                    'name' => 'likely_case',
                    'label' => 'LBL_LIKELY',
                    'type' => 'currency',
                    'default' => true,
                    'enabled' => true,
                    'convertToBase'=> true,
                    'showTransactionalAmount'=>true,
                    'align' => 'right',
                    'click_to_edit' => true,
                    'width' => '22%'
                ),
                array(
                    'name' => 'best_case',
                    'label' => 'LBL_BEST',
                    'type' => 'currency',
                    'default' => true,
                    'enabled' => true,
                    'convertToBase'=> true,
                    'showTransactionalAmount'=>true,
                    'align' => 'right',
                    'click_to_edit' => true,
                    'width' => '22%'
                )
            )
        )
    )
);


// TODO this has been commented out due to the setting being hidden in the Admin
// Note the above arrays need to be fixed as well.
/*
$admin = BeanFactory::getBean('Administration');
$config = $admin->getConfigForModule('Forecasts');
$viewdefs['ForecastWorksheets']['base']['view']['list'] = $viewdefArray[$config['forecast_by']];
*/
$viewdefs['ForecastWorksheets']['base']['view']['list'] = $listDefs;
