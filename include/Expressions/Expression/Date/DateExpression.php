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

require_once('include/Expressions/Expression/AbstractExpression.php');
require_once('include/TimeDate.php');
abstract class DateExpression extends AbstractExpression
{
	/**
	 * All parameters have to be a string.
	 */
    static function getParameterTypes() {
		return AbstractExpression::$DATE_TYPE;
	}

    /**
     * @static
     * @param string $date String to be parsed
     *
     * @return DateTime|boolean the DateTime object representing the string passed in
     *                          or false if the string is empty
     * @throws Exception        if the string could not be converted to a valid date
     */
    public static function parse($date)
    {
        if ($date instanceof DateTime)
            return $date;

        if (empty($date)) {
            return false;
        }

        //String dates must be in User format.
        if (is_string($date)) {
            $timedate = TimeDate::getInstance();
            if (static::hastime($date)) {
                // have time
                $resdate = $timedate->fromUser($date);
            } else {
                // just date, no time
                $resdate = $timedate->fromUserDate($date);
            }
            if (!$resdate) {
                throw new Exception("attempt to convert invalid value to date: $date");
            }
            return $resdate;
        }
        throw new Exception("attempt to convert invalid value to date: $date");
    }

    /**
     * Do we have a time param with the date param
     *
     * @param $date
     * @return bool
     */
    public static function hasTime($date)
    {
        $timedate = TimeDate::getInstance();
        $split = $timedate->split_date_time($date);

        return !empty($split[1]);
    }

    /**
     * @static  
     * @param DateTime $date
     * @return DateTime $date rounded to the nearest 15 minute interval.
     */
    public static function roundTime($date)
    {
        if (!($date instanceof DateTime))
            return false;

        $min = $date->format("i");
        $offset = 0;
        if ($min < 16){
            $offset = 15 - $min;
        } else if ($min < 31)
        {
            $offset = 30 - $min;
        }
        else if ($min < 46)
        {
            $offset = 45 - $min;
        }
        else if ($min < 46)
        {
            $offset = 60 - $min;
        }
        if($offset != 0) {
            $date->modify("+$offset minutes");
        }

        return $date;
    }
}
?>
