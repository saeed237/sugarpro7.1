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
<style>
div.playArea {ldelim}
    text-align:left; 
    overflow: hidden; 
    background-color: black; 
    background-image: url('modules/Home/Dashlets/InvadersDashlet/sprites/bg.png'); 
    width: 400px; 
    height:300px;
    position: relative;
    overflow: hidden;
{rdelim}
</style>
<div align="center">
<div class="playArea">
    <img id="player" style="position: absolute; top:270px; left:134px"
        src="modules/Home/Dashlets/InvadersDashlet/sprites/player.png" width="32px" height="32px"/>
    <img id="shot"   style="position: absolute; top:245px; display: none"
        src="modules/Home/Dashlets/InvadersDashlet/sprites/cube.png" width="16px" height="16px"/>
    
    <div id="aliens" style="position: absolute; left:0px; width:172px;">
		<table cellpadding="0" cellspacing="2"><tbody>
		<tr>
			<td id="a00" width="32" height="14">&nbsp;</td>
			<td id="a10" width="32" height="14">&nbsp;</td>
			<td id="a20" width="32" height="14">&nbsp;</td>
			<td id="a30" width="32" height="14">&nbsp;</td>
			<td id="a40" width="32" height="14">&nbsp;</td>
		</tr>
		<tr>
			<td id="a01" width="32" height="14">&nbsp;</td>
			<td id="a11" width="32" height="14">&nbsp;</td>
			<td id="a21" width="32" height="14">&nbsp;</td>
			<td id="a31" width="32" height="14">&nbsp;</td>
			<td id="a41" width="32" height="14">&nbsp;</td>
		</tr>
		<tr>
			<td id="a02" width="32" height="14">&nbsp;</td>
			<td id="a12" width="32" height="14">&nbsp;</td>
			<td id="a22" width="32" height="14">&nbsp;</td>
			<td id="a32" width="32" height="14">&nbsp;</td>
			<td id="a42" width="32" height="14">&nbsp;</td>
		</tr>
		<tr>
			<td id="a03" width="32" height="14">&nbsp;</td>
			<td id="a13" width="32" height="14">&nbsp;</td>
			<td id="a23" width="32" height="14">&nbsp;</td>
			<td id="a33" width="32" height="14">&nbsp;</td>
			<td id="a43" width="32" height="14">&nbsp;</td>
		</tr>
		</tbody></table>
	</div>
	<div align="center" id="startScreen" style="position: relative; top: 150px;" onclick="InvadersGame.reset()">
		<a href="javascript:void(0);" class="otherTabLink" style="text-decoration:none;">
		    <h1 style="color: #FFF;" id="messageText">{$dashletStrings.LBL_START}</h1>
		</a>
	</div>
</div>
</div>
