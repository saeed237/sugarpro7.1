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
{if !empty($parentFieldArray.$col)}
{if !empty($vardef.calculated)}
<a href="javascript:SUGAR.image.lightbox('{$parentFieldArray.$col}')">
<img src='{$parentFieldArray.$col}' style='height: 64px;'>
{else}
<a href="javascript:SUGAR.image.lightbox('index.php?entryPoint=download&id={$parentFieldArray.$col}&type=SugarFieldImage&isTempFile=1')">
<img src='index.php?entryPoint=download&id={$parentFieldArray.$col}&type=SugarFieldImage&isTempFile=1'
    style='height: 64px;'>
{/if}

{/if}
