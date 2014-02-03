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

/**
 * OpportunitiesSeedData.php
 *
 * This is a class used for creating OpportunitiesSeedData.  We moved this code out from install/populateSeedData.php so
 * that we may better control and test creating default Opportunities.
 *
 */

class OpportunitiesSeedData {

    static private $_ranges;
    /**
     * populateSeedData
     *
     * This is a static function to create Opportunities.
     *
     * @static
     * @param $records Integer value indicating the number of Opportunities to create
     * @param $app_list_strings Array of application language strings
     * @param $accounts Array of Account instances to randomly build data against
     * @param $timeperiods Array of Timeperiods to create timeperiod seed data off of
     * @param $users Array of User instances to randomly build data against
     * @return array Array of Opportunities created
     */
    public static function populateSeedData($records, $app_list_strings, $accounts
        , $users
    )
    {
        if(empty($accounts) || empty($app_list_strings) || (!is_int($records) || $records < 1)
           || empty($users)

        )
        {
            return array();
        }

        $opp_ids = array();
        $timedate = TimeDate::getInstance();

        // get the additional currencies from the table
        /* @var $currency Currency */
        $currency = SugarCurrency::getCurrencyByISO('EUR');

        // load up the product template_ids
        $pt_ids = array();
        $sql = 'SELECT id, list_price, cost_price, discount_price FROM product_templates where deleted = 0';
        /* @var $db DBManager */
        $db = DBManagerFactory::getInstance();
        $results = $db->query($sql);
        while ($row = $db->fetchByAssoc($results)) {
            $pt_ids[$row['id']] = $row;
        }

        $pc_ids = array();
        $sql = 'SELECT id FROM product_categories where deleted = 0';
        $results = $db->query($sql);
        while ($row = $db->fetchByAssoc($results)) {
            $pc_ids[] = $row['id'];
        }

        while ($records-- > 0) {
            $key = array_rand($accounts);
            $account = $accounts[$key];

            /* @var $opp Opportunity */
            $opp = BeanFactory::getBean('Opportunities');

            //Create new opportunities
            $opp->team_id = $account->team_id;
            $opp->team_set_id = $account->team_set_id;

            $opp->assigned_user_id = $account->assigned_user_id;
            $opp->assigned_user_name = $account->assigned_user_name;

            // figure out which one to use
            $seed = rand(1, 15);
            if ($seed%2 == 0) {
                $currency_id = $currency->id;
                $base_rate = $currency->conversion_rate;
            } else {
                // use the base rate
                $currency_id = '-99';
                $base_rate = '1.0';
            }

            $opp->name = $account->name;
            $opp->lead_source = array_rand($app_list_strings['lead_source_dom']);
            $opp->sales_stage = array_rand($app_list_strings['sales_stage_dom']);
            $opp->sales_status = 'New';

            // If the deal is already done, make the date closed occur in the past.
            $opp->date_closed = ($opp->sales_stage == Opportunity::STAGE_CLOSED_WON || $opp->sales_stage == Opportunity::STAGE_CLOSED_WON)
                ? self::createPastDate()
                : self::createDate();
            $opp->date_closed_timestamp = $timedate->fromDbDate($opp->date_closed)->getTimestamp();
            $opp->opportunity_type = array_rand($app_list_strings['opportunity_type_dom']);
            $amount = rand(1000, 7500);
            $opp->amount = $amount;
            $opp->probability = $app_list_strings['sales_probability_dom'][$opp->sales_stage];

            //Setup forecast seed data
            $opp->best_case = $opp->amount;
            $opp->worst_case = $opp->amount;
            $opp->commit_stage = $opp->probability >= 70 ? 'include' : 'exclude';

            $opp->id = create_guid();
            $opp->new_with_id = true;
            // set the acccount on the opps, just for saving to the worksheet table
            $opp->account_id = $account->id;
            $opp->account_name = $account->name;

            // we need to save the opp before we create the rlis
            //$opp->save();

            $rlis_to_create = 1;
            $rlis_created = 0;

            $opp_best_case = 0;
            $opp_worst_case = 0;
            $opp_amount = 0;
            $opp_units = 0;
            $opp->total_revenue_line_items = $rlis_to_create;
            $opp->closed_revenue_line_items = 0;
    
            // stop obsessive saving
            SugarBean::enterOperation('saving_related');
            BeanFactory::registerBean('Opportunities', $opp);

            while($rlis_created < $rlis_to_create) {
                $amount = $opp->amount;
                $rand_best_worst = rand(100, 500);

                $doPT = false;

                $cost_price = $amount/2;
                $list_price = $amount;
                $discount_price = $amount;


                if ($rlis_created%2 === 0) {
                    $doPT = true;
                    $pt_id = array_rand($pt_ids);
                    $pt = $pt_ids[$pt_id];

                    $cost_price = $pt['cost_price'];
                    $list_price = $pt['list_price'];
                    $discount_price = $pt['discount_price'];
                    $amount = $discount_price;
                    $rand_best_worst = rand(100, $cost_price);
                }


                /* @var $rli RevenueLineItem */
                $rli = BeanFactory::getBean('RevenueLineItems');

                $rli->team_id = $opp->team_id;
                $rli->team_set_id = $opp->team_set_id;
                $rli->name = $opp->name;
                $rli->best_case = $amount+$rand_best_worst;
                $rli->likely_case = $amount;
                $rli->worst_case = $amount-$rand_best_worst;
                $rli->list_price = $list_price;
                $rli->discount_price = $discount_price;
                $rli->cost_price = $cost_price;
                $rli->quantity = rand(1, 100);
                $rli->currency_id = $currency_id;
                $rli->base_rate = $base_rate;
                $rli->sales_stage = $opp->sales_stage;
                $rli->probability = $opp->probability;
                $rli->date_closed = $opp->date_closed;
                $rli->date_closed_timestamp = $opp->date_closed_timestamp;
                $rli->assigned_user_id = $opp->assigned_user_id;
                $rli->opportunity_id = $opp->id;
                $rli->account_id = $account->id;
                $rli->commit_stage = $opp->commit_stage;
                $rli->lead_source = array_rand($app_list_strings['lead_source_dom']);
                // if this is an even number, assign a product template
                if ($doPT) {
                    $rli->product_template_id = $pt_id;
                    $rli->discount_amount = rand(100, $rli->cost_price);
                    $rli->discount_rate_percent = (($rli->discount_amount/$rli->discount_price)*100);
                } else {
                    $rli->discount_amount = 0;
                    $rli->discount_rate_percent = 0;
                    // if this is not an even number, assign a product category only
                    $rli->category_id = $pc_ids[array_rand($pc_ids, 1)];
                }
                $rli->total_amount = (($rli->discount_price-$rli->discount_amount)*$rli->quantity);
                $rli->save();

                $opp_units += $rli->quantity;
                $opp_amount += $amount;
                $opp_best_case += $amount+$rand_best_worst;
                $opp_worst_case += $amount-$rand_best_worst;

                $rlis_created++;
            }
            SugarBean::leaveOperation('saving_related');

            $opp->amount = $opp_amount;
            $opp->best_case = $opp_best_case;
            $opp->worst_case = $opp_worst_case;
            $opp->name .= ' - ' . $opp_units . ' Units';



            // save the opp again
            $opp->save();

            // save a draft worksheet for the new forecasts stuff
            /* @var $worksheet ForecastWorksheet */
            $worksheet = BeanFactory::getBean('ForecastWorksheets');
            $worksheet->saveRelatedOpportunity($opp);

            // Create a linking table entry to assign an account to the opportunity.
            $opp->set_relationship('accounts_opportunities', array('opportunity_id'=>$opp->id ,'account_id'=> $account->id), false);
            $opp_ids[] = $opp->id;
        }

        return $opp_ids;
    }

    /**
     * @static creates range of probability for the months
     * @param int $total_months - total count of months
     * @return mixed
     */
    private static function getRanges($total_months = 12)
    {
        if (self::$_ranges === null) {
            self::$_ranges = array();
            for ($i = $total_months; $i >= 0; $i--) {
                // define priority for month,
                self::$_ranges[$total_months-$i] = ( $total_months-$i > 6 )
                    ? self::$_ranges[$total_months-$i] = pow(6, 2) + $i
                    :  self::$_ranges[$total_months-$i] = pow($i, 2) + 1;
                // increase probability for current quarters
                self::$_ranges[$total_months-$i] = $total_months-$i == 0 ? self::$_ranges[$total_months-$i]*2.5 : self::$_ranges[$total_months-$i];
                self::$_ranges[$total_months-$i] = $total_months-$i == 1 ? self::$_ranges[$total_months-$i]*2 : self::$_ranges[$total_months-$i];
                self::$_ranges[$total_months-$i] = $total_months-$i == 2 ? self::$_ranges[$total_months-$i]*1.5 : self::$_ranges[$total_months-$i];
            }
        }
        return self::$_ranges;
    }

    /**
     * @static return month delta as random value using range of probability, 0 - current month, 1 next/previos month...
     * @param int $total_months - total count of months
     * @return int
     */
    public static function getMonthDeltaFromRange($total_months = 12)
    {
        $ranges = self::getRanges($total_months);
        asort($ranges, SORT_NUMERIC);
        $x = mt_rand(1, array_sum($ranges));
        foreach ($ranges as $key => $y) {
            $x -= $y;
            if ($x <= 0) {
                break;
            }
        }
        return $key;
    }

    /**
     * @static generates date
     * @param null $monthDelta - offset from current date in months to create date, 0 - current month, 1 - next month
     * @return string
     */
    public static function createDate($monthDelta = null)
    {
        global $timedate;
        $monthDelta = $monthDelta === null ? self::getMonthDeltaFromRange() : $monthDelta;

        $now = $timedate->getNow(true);
        $now->modify("+$monthDelta month");
        // random day from now to end of month
        $now->setTime(0, 0, 0);
        $day = mt_rand($now->day, $now->days_in_month);
        return $timedate->asDbDate($now->get_day_begin($day));
    }

    /**
     * @static generate past date
     * @param null $monthDelta - offset from current date in months to create past date, 0 - current month, 1 - previous month
     * @return string
     */
    public static function createPastDate($monthDelta = null)
    {
        global $timedate;
        $monthDelta = $monthDelta === null ? self::getMonthDeltaFromRange() : $monthDelta;

        $now = $timedate->getNow(true);
        $now->modify("-$monthDelta month");

        if ($monthDelta == 0 && $now->day == 1) {
            $now->modify("-1 day");
            $day = $now->day;
        } else {
            // random day from start of month to now
            $tmpDay = ($now->day-1 != 0) ? $now->day-1 : 1;
            $day =  mt_rand(1, $tmpDay);
        }
        $now->setTime(0, 0, 0); // always default it to midnight
        return $timedate->asDbDate($now->get_day_begin($day));
    }
}
