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


$dashletStrings['TrackerDashlet'] = array('LBL_TITLE'            => 'Tracker Reports',
                                          'LBL_DESCRIPTION'      => 'A dashlet to run queries against Tracker data',
                                          'LBL_SAVING'           => 'Running Query ...',
                                          'LBL_SAVED'            => 'Query Complete',
                                          'LBL_CLEAR'            => 'Clear',
                                          'LBL_CLEAR_TOOLTIP'    => 'Clears the date field value',
                                          'LBL_CONFIGURE_TITLE'  => 'Title',
                                          'LBL_CONFIGURE_HEIGHT' => 'Height (1 - 300)',
										  'LBL_SELECT_QUERY'     => 'Select Query...',
										  'LBL_FILTER'              => 'Filter',
										  'LBL_FILTER_TOOLTIP'      => 'Filters by the value in the date field',
										  'LBL_SINCE'            => 'Since: ',
										  'LBL_CHOOSE_DATE_TOOLTIP' => 'For select reports, you can provide a date filter.' .
										                               '  The date value entered will replace the default date value for the report.' .
										                               '  For example, in the "My Activity (This Week)" report, the' .
										                               ' value will be used to display all records after the filter date' .
										                               ' instead of the default time period of one week.',
);