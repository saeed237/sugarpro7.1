{*
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

*}
<input type="hidden" name="wl_datetime" value="true" />
<input type="hidden" name="field_name" value="{$vardef.name}" />
{html_select_date prefix="wl_date_" time=$date_start month_format="%m" end_year="+5" field_order=$field_order}<br />
{html_select_time prefix="wl_time_" time=$time_start use_24_hours=$use_meridian display_seconds=false minute_interval="15"}