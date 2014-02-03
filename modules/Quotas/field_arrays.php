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

/*********************************************************************************

 * Description:  Contains field arrays that are used for caching
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
$fields_array['Quota'] = array ('column_fields' => Array("id"
		,"user_id"
		,"timeperiod_id"
		,"quota_type"
		,"amount"
		,"amount_base_currency"
		,"currency_id"
        ,"committed"
		,"date_entered"
		,"date_modified"
		,"modified_user_id"
		,"created_by"
		),
        'list_fields' =>  Array('id'),
    'required_fields' =>  array("user_id"=>1, "amount"=>2, "currency_id"=>3),
);
?>