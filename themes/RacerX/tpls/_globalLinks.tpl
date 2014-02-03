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
<div class="dcmenuDivider" id="globalLinksDivider"></div>
<div id="globalLinksModule">
    <ul class="clickMenu" id="globalLinks">
        <li>
            <ul class="subnav iefixed">
                {foreach from=$GCLS item=GCL name=gcl key=gcl_key}
    			    <li><a id="{$gcl_key}_link" href="{$GCL.URL}" {if $smarty.foreach.gcl.last}class="last"{/if}{if !empty($GCL.ONCLICK)} onclick="{$GCL.ONCLICK}"{/if}>{$GCL.LABEL}</a></li>

	                {foreach from=$GCL.SUBMENU item=GCL_SUBMENU name=gcl_submenu key=gcl_submenu_key}
	                    <a id="{$gcl_submenu_key}_link" href="{$GCL_SUBMENU.URL}"{if !empty($GCL_SUBMENU.ONCLICK)} onclick="{$GCL_SUBMENU.ONCLICK}"{/if}>{$GCL_SUBMENU.LABEL}</a>
	                {/foreach}
                {/foreach}

                <li><a id="logout_link" href='{$LOGOUT_LINK}' class='utilsLink'>{$LOGOUT_LABEL}</a> </li>
            </ul>
            <span> 
        	    <div id="dcmenuUserIcon" {$NOTIFCLASS}>
				  {$NOTIFICON}
				</div>
            	<a id="welcome_link" href='javascript: void(0);'>{$CURRENT_USER}</a>
            	
            </span>
        </li>
    </ul>
</div>

{if $NOTIFCODE != ""}
	<div class="dcmenuDivider" id="notifDivider"></div>
	<div id="dcmenuSugarCube" {$NOTIFCLASS} {if $ISADMIN}onclick="DCMenu.notificationsList();" title="{$APP.LBL_PENDING_NOTIFICATIONS}"{/if}>
	  {$NOTIFCODE}
	</div>
{else}
<div id="dcmenuSugarCubeEmpty"></div>
{/if}