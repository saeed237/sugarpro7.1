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


interface HistoryInterface
{

    /*
     * Get the most recent item in the history
     * @return Id of the first item
     */
    function getFirst () ;

    /*
     * Get the next oldest item in the history
     * @return Id of the next item
     */
    function getNext () ;

    /*
     * Get the nth item in the history (where the zeroeth record is the most recent)
     * @return Id of the nth item
     */
    function getNth ($n) ;

    /*
     * Restore the historical layout identified by timestamp
     * @return Timestamp if successful, null if failure (if the file could not be copied for some reason)
     */
    function restoreByTimestamp ($timestamp) ;

    /*
     * Undo the restore - revert back to the layout before the restore
     */
    function undoRestore () ;

    /*
     * Add an item to the history
     * @return String   An timestamp for this newly added item
     */
    function append ($path) ;
}