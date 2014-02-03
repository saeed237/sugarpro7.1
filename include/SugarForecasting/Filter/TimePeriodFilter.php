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


require_once('include/SugarForecasting/AbstractForecast.php');
class SugarForecasting_Filter_TimePeriodFilter extends SugarForecasting_AbstractForecast
{

    /**
     * Process to get an array of Timeperiods based on system configurations.  It will return the n number
     * of backward timeperiods + current set of timeperiod + n number of future timeperiods.
     *
     * @return array id/name of TimePeriods
     */
    public function process()
    {
        $admin = BeanFactory::getBean('Administration');
        $settings = $admin->getConfigForModule('Forecasts', 'base');
        $forward = $settings['timeperiod_shown_forward'];
        $backward = $settings['timeperiod_shown_backward'];
        $type = $settings['timeperiod_interval'];
        $leafType = $settings['timeperiod_leaf_interval'];
        $timedate = TimeDate::getInstance();

        $timePeriods = array();

        $current = TimePeriod::getCurrentTimePeriod($type);

        //If the current TimePeriod cannot be found for the type, just create one using the current date as a reference point
        if(empty($current)) {
            $current = TimePeriod::getByType($type);
            $current->setStartDate($timedate->getNow()->asDbDate());
        }

        $startDate = $timedate->fromDbDate($current->start_date);

        //Move back for the number of backward TimePeriod(s)
        while($backward-- > 0) {
            $startDate->modify($current->previous_date_modifier);
        }

        $endDate = $timedate->fromDbDate($current->end_date);

        //Increment for the number of forward TimePeriod(s)
        while($forward-- > 0) {
            $endDate->modify($current->next_date_modifier);
        }

        $db = DBManagerFactory::getInstance();
        $query = sprintf("SELECT id, name FROM timeperiods WHERE parent_id is not null AND deleted = 0 AND start_date >= %s AND start_date <= %s AND type != '' ORDER BY start_date ASC",
            $db->convert($db->quoted($startDate->asDbDate()), 'date'),
            $db->convert($db->quoted($endDate->asDbDate()), 'date')
        );

        $result = $db->query($query);
        if(!empty($result)) {
            while(($row = $db->fetchByAssoc($result))) {
               $timePeriods[$row['id']] = $row['name'];
            }
        }

        return $timePeriods;

    }

}