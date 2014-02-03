<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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


require_once('modules/TimePeriods/TimePeriodInterface.php');
/**
 * Implements the fiscal quarter representation of a time period where the monthly
 * leaves are split by the longest month occurring at the end of the quarter
 * @api
 */
class Quarter445TimePeriod extends TimePeriod implements TimePeriodInterface {

    /**
     * constructor override
     *
     * @param null $start_date date string to set the start date of the quarter time period
     */
    public function __construct($start_date = null) {
        parent::__construct();
        //set defaults
        $this->type = 'Quarter445';
        $this->is_fiscal = true;
        $this->date_modifier = '13 week';
    }

    /**
     * build leaves for the timeperiod by creating the specified types of timeperiods
     *
     * @param string $timePeriodType ignored for now as current requirements only allow monthly for quarters.  Left in place in case it is used in the future for weeks/fortnights/etc
     * @return mixed
     */
    public function buildLeaves($timePeriodType) {
        if($this->hasLeaves()) {
            throw new Exception("This TimePeriod already has leaves");
        }

        $this->load_relationship('related_timeperiods');

        //1st month
        $leafPeriod = BeanFactory::newBean('MonthTimePeriods');
        $leafPeriod->is_fiscal = true;
        $leafPeriod->setStartDate($this->start_date, 4);
        $leafPeriod->save();
        $this->related_timeperiods->add($leafPeriod->id);
        $leafPeriod->save();

        //create second month leaf
        $leafPeriod = $leafPeriod->createNextTimePeriod(4);
        $this->related_timeperiods->add($leafPeriod->id);
        $leafPeriod->save();

        //create third month leaf, this one gets the extra week
        $leafPeriod = $leafPeriod->createNextTimePeriod(5);
        $this->related_timeperiods->add($leafPeriod->id);
        $leafPeriod->save();

        $this->save();

    }
}