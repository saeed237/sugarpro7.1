<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

/**
 * @param Opportunity $focus        The Current Opportunity we are working with
 */
function perform_save($focus)
{
    global $app_list_strings, $timedate, $current_language;
    $app_list_strings = return_app_list_strings_language($current_language);

    /* @var $admin Administration */
    $admin = BeanFactory::getBean('Administration');
    $settings = $admin->getConfigForModule('Forecasts');
    //Determine the default commit_stage based on the probability
    if ($settings['is_setup'] && empty($focus->commit_stage) && $focus->probability !== '') {
        //Retrieve Forecasts_category_ranges and json decode as an associative array
        $forecast_ranges = isset($settings['forecast_ranges']) ? $settings['forecast_ranges'] : '';
        $category_ranges = isset($settings[$forecast_ranges . '_ranges']) ?
            (array)$settings[$forecast_ranges . '_ranges'] : array();
        foreach ($category_ranges as $key => $entry) {
            if ($focus->probability >= $entry['min'] && $focus->probability <= $entry['max']) {
                $focus->commit_stage = $key;
                break;
            }
        }
    }

    // if any of the case fields are NULL or an empty string set it to the amount from the main opportunity
    if (is_null($focus->best_case) || strval($focus->best_case) === "") {
        $focus->best_case = $focus->amount;
    }

    if (is_null($focus->worst_case) || strval($focus->worst_case) === "") {
        $focus->worst_case = $focus->amount;
    }

    // if sales stage was set to Closed Won set best and worst cases to amount
    if (isset($settings['is_setup']) && $settings['is_setup'] == 1) {
        $wonStages = $settings['sales_stage_won'];
        if (!empty($focus->sales_stage) && in_array($focus->sales_stage, $wonStages)) {
            $focus->best_case = $focus->amount;
            $focus->worst_case = $focus->amount;
        }
    }

    // Bug49495: amount may be a calculated field
    $focus->updateCalculatedFields();

    //Store the base currency value
    if (isset($focus->amount) && !number_empty($focus->amount)) {
        $focus->amount_usdollar = SugarCurrency::convertWithRate($focus->amount, $focus->base_rate);
    }

    if ($settings['is_setup']) {
        if (empty($focus->id)) {
            $focus->id = create_guid();
            $focus->new_with_id = true;
        }
        //We create a related product entry for any new opportunity so that we may forecast on products
        // create an empty product module
        /* @var $rli RevenueLineItem */
        $rli = BeanFactory::getBean('RevenueLineItems');
        
        //We still need to update the associated product with changes
        if ($focus->new_with_id == false) {
            $rli->retrieve_by_string_fields(array('opportunity_id' => $focus->id));
        }
        
        //If $rli is set then we need to copy values into it from the opportunity
        if (isset($rli)) {
            $rli->name = $focus->name;
            $rli->best_case = $focus->best_case;
            $rli->likely_case = $focus->amount;
            $rli->worst_case = $focus->worst_case;
            $rli->cost_price = $focus->amount;
            $rli->quantity = 1;
            $rli->currency_id = $focus->currency_id;
            $rli->base_rate = $focus->base_rate;
            $rli->probability = $focus->probability;
            $rli->date_closed = $focus->date_closed;
            $rli->date_closed_timestamp = $focus->date_closed_timestamp;
            $rli->assigned_user_id = $focus->assigned_user_id;
            $rli->opportunity_id = $focus->id;
            $rli->account_id = $focus->account_id;
            $rli->commit_stage = $focus->commit_stage;
            $rli->sales_stage = $focus->sales_stage;
            $rli->deleted = $focus->deleted;
            $rli->save();
        }
    }
}
