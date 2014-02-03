{* <!--
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

-->


*}


<div class="dashletPanelMenu wizard">
<div class="bd">

		<div class="screen">
		
{foreach  from=$ADMIN_GROUP_HEADER key=j item=val1}
   
   {if isset($GROUP_HEADER[$j][1])}
   <p>{$GROUP_HEADER[$j][0]}{$GROUP_HEADER[$j][1]}
   <table class="other view">
   
   {else}
   <p>{$GROUP_HEADER[$j][0]}{$GROUP_HEADER[$j][2]}
   <table class="other view">
   {/if}
      
    {assign var='i' value=0}
    {foreach  from=$VALUES_3_TAB[$j] key=link_idx item=admin_option}
    {if isset($COLNUM[$j][$i])}
    <tr>
         

            <td width="20%" scope="row">{$ITEM_HEADER_IMAGE[$j][$i]}&nbsp;<a id='{$ID_TAB[$j][$i]}' href='{$ITEM_URL[$j][$i]}' class="tabDetailViewDL2Link">{$ITEM_HEADER_LABEL[$j][$i]}</a></td>
            <td width="30%">{$ITEM_DESCRIPTION[$j][$i]}</td>  
              
            {assign var='i' value=$i+1}
            {if $COLNUM[$j][$i] == '0'}
                    <td width="20%" scope="row">{$ITEM_HEADER_IMAGE[$j][$i]}&nbsp;<a id='{$ID_TAB[$j][$i]}' href='{$ITEM_URL[$j][$i]}' class="tabDetailViewDL2Link">{$ITEM_HEADER_LABEL[$j][$i]}</a></td>
                    <td width="30%">{$ITEM_DESCRIPTION[$j][$i]}</td>
            {else}
            <td width="20%" scope="row">&nbsp;</td>
            <td width="30%">&nbsp;</td>
            {/if}
   </tr>
   {/if}
   {assign var='i' value=$i+1}
   {/foreach}
           
</table>
<p/>
{/foreach}

</div>
</div>

</div>

	
