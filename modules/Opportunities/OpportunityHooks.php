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

require_once('modules/Forecasts/AbstractForecastHooks.php');
class OpportunityHooks extends AbstractForecastHooks
{

    /**
     * This is a general hook that takes the Opportunity and saves it to the forecast worksheet record.
     *
     * @param Opportunity $bean             The bean we are working with
     * @param string $event                 Which event was fired
     * @param array $args                   Any additional Arguments
     * @return bool
     */
    public static function saveWorksheet(Opportunity $bean, $event, $args)
    {
        if (static::isForecastSetup()) {
            /* @var $worksheet ForecastWorksheet */
            $worksheet = BeanFactory::getBean('ForecastWorksheets');
            $worksheet->saveRelatedOpportunity($bean);
            return true;
        }

        return false;
    }

    /**
     * Mark all related RLI's on a given opportunity to be deleted
     *
     * @param Opportunity $bean
     * @param $event
     * @param $args
     */
    public static function deleteOpportunityRevenueLineItems(Opportunity $bean, $event, $args)
    {
        if (static::isForecastSetup()) {
            $rlis = $bean->get_linked_beans('revenuelineitems', 'RevenueLineItems');
            foreach ($rlis as $rli) {
                $rli->mark_deleted($rli->id);
            }
        }
    }

    /**
     * Set the Sales Status based on the associated RLI's sales_stage
     *
     * @param Opportunity $bean
     * @param string $event
     * @param array $args
     */
    public static function setSalesStatus(Opportunity $bean, $event, $args)
    {
        if (static::isForecastSetup()) {
            $closed_won = static::$settings['sales_stage_won'];
            $closed_lost = static::$settings['sales_stage_lost'];

            $won_rlis = count(
                $bean->get_linked_beans(
                    'revenuelineitems',
                    'RevenueLineItems',
                    array(),
                    0,
                    -1,
                    0,
                    'sales_stage in ("' . join('","', $closed_won) . '")'
                )
            );

            $lost_rlis = count(
                $bean->get_linked_beans(
                    'revenuelineitems',
                    'RevenueLineItems',
                    array(),
                    0,
                    -1,
                    0,
                    'sales_stage in ("' . join('","', $closed_lost) . '")'
                )
            );

            $total_rlis = count($bean->get_linked_beans('revenuelineitems', 'RevenueLineItems'));

            if ($total_rlis > ($won_rlis + $lost_rlis) || $total_rlis === 0) {
                // still in progress
                $bean->sales_status = Opportunity::STATUS_IN_PROGRESS;
            } else {
                // they are equal so if the total lost == total rlis then it's closed lost,
                // otherwise it's always closed won
                if ($lost_rlis == $total_rlis) {
                    $bean->sales_status = Opportunity::STATUS_CLOSED_LOST;
                } else {
                    $bean->sales_status = Opportunity::STATUS_CLOSED_WON;
                }
            }
        }
    }
}
