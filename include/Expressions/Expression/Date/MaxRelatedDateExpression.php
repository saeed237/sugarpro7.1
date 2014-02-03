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

require_once('include/Expressions/Expression/Date/DateExpression.php');
/**
 * <b>maxRelatedDate(Relate <i>link</i>, String <i>field</i>)</b><br>
 * Returns the highest value of <i>field</i> in records related by <i>link</i><br/>
 * ex: <i>maxRelatedDate($products, "date_closed_timestamp")</i> in Opportunities would return the <br/>
 * latest date_closed_timestamp of all related Revenue Line Items.
 */

class MaxRelatedDateExpression extends DateExpression
{
    
    /**
     * Returns the opreation name that this Expression should be
     * called by.
     */
    public static function getOperationName() {
        return array("maxRelatedDate");
    }
    
    public function evaluate() {
        $params = $this->getParameters();
        //This should be of relate type, which means an array of SugarBean objects
        $linkField = $params[0]->evaluate();
        $relfield = $params[1]->evaluate();
        $ret = 0;
        $isTimestamp = true;
        
        //if the field or relationship isn't defined, bail
        if (!is_array($linkField) || empty($linkField)) {
           return $ret; 
        }           
                        
        foreach ($linkField as $bean) {
            //set up our timestamp
            $timestamp = $bean->$relfield;
            if (isset($bean->$relfield)) {
                //if it isn't a timestamp, mark the flag as such and convert it for comparison
                if (!is_int($timestamp)) {
                    $isTimestamp = false;
                    $timestamp = strtotime($timestamp);
                }
                
                //compare
                if ( $ret < $timestamp) {
                    $ret = $timestamp;
                }
            }            
        }
        
        //if nothing was done, return an empty string
        if ($ret == 0 && $isTimestamp) {            
            return "";   
        }
        
        //return the timestamp if the field started off that way
        if ($isTimestamp) {
            return $ret;
        } 
        
        //convert the timestamp to a date and return
        $date = new DateTime();
        $date->setTimestamp($ret);
   
        return $date->format("Y-m-d");
    }
    
    //todo: javascript version here
    /**
     * Returns the JS Equivalent of the evaluate function.
     */
    public static function getJSEvaluate() 
    {
        return "";
    }
}
?>
