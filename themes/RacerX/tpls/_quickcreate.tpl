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

<div id="quickCreate">
<ul class="clickMenu" id="quickCreateUL">
    <li>
        <ul class="subnav iefixed showLess" id="quickCreateULSubnav">
            {foreach from=$DCACTIONS item=action name=quickCreate}
                <li {if $smarty.foreach.quickCreate.index > 4}class="moreOverflow"{/if}><a href="javascript: if ( DCMenu.menu ) DCMenu.menu('{$action.module}','{$action.createRecordTitle}', true);" id="{$action.module}_quickcreate">{$action.createRecordTitle}</a></li>

            {/foreach}

            {if count($DCACTIONS) > 4}
                <li class="moduleMenuOverFlowMore"><a href="javascript: SUGAR.themes.toggleQuickCreateOverFlow('quickCreateULSubnav','more');">{$APP.LBL_SHOW_MORE} <div class="showMoreArrow"></div></a></li>
                <li class="moduleMenuOverFlowLess"><a href="javascript: SUGAR.themes.toggleQuickCreateOverFlow('quickCreateULSubnav','less');">{$APP.LBL_SHOW_LESS} <div class="showLessArrow"></div></a></li>
            {/if}
        </ul>
    </li>
</ul>
</div>
