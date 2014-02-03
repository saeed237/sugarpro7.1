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
<table class='edit view small' width="100%" border="0" cellspacing="1" cellpadding="0" >		
	<tr valign="top">
		<td width="35%">
			<table  border="0" cellspacing="2" cellpadding="0" >	
				<tr valign='top'>
					<td><img src="{$IMG}icon_ConnectorConfig.gif" name="connectorConfig" onclick="document.location.href='index.php?module=Connectors&action=ModifyProperties';"
						onMouseOver="document.connectorConfig.src='{$IMG}icon_ConnectorConfigOver.gif'"
						onMouseOut="document.connectorConfig.src='{$IMG}icon_ConnectorConfig.gif'"></td>
					<td>&nbsp;&nbsp;</td>
					<td><b>{$mod.LBL_MODIFY_PROPERTIES_TITLE}</b><br/>
						{$mod.LBL_MODIFY_PROPERTIES_DESC}
					</td>
				</tr>
				<tr>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr valign='top'>
					<td><img src="{$IMG}icon_ConnectorEnable.gif" name="enableImage" onclick="document.location.href='index.php?module=Connectors&action=ModifyDisplay';"
						onMouseOver="document.enableImage.src='{$IMG}icon_ConnectorEnableOver.gif'"
						onMouseOut="document.enableImage.src='{$IMG}icon_ConnectorEnable.gif'"></td>
					<td>&nbsp;&nbsp;</td>
					<td><b>{$mod.LBL_MODIFY_DISPLAY_TITLE}</b><br/>
						{$mod.LBL_MODIFY_DISPLAY_DESC}
					</td>
				</tr>			
			</table>
		</td>
		<td width="10%">&nbsp;</td>
		<td width="35%">
			<table  border="0" cellspacing="2" cellpadding="0">	   
				<tr valign='top'>
					<td><img src="{$IMG}icon_ConnectorMap.gif" name="connectorMapImg" onclick="document.location.href='index.php?module=Connectors&action=ModifyMapping';"
						onMouseOver="document.connectorMapImg.src='{$IMG}icon_ConnectorMapOver.gif'"
						onMouseOut="document.connectorMapImg.src='{$IMG}icon_ConnectorMap.gif'"></td>
					<td>&nbsp;&nbsp;</td>
					<td><b>{$mod.LBL_MODIFY_MAPPING_TITLE}</b><br/>
						{$mod.LBL_MODIFY_MAPPING_DESC}
					</td>
				</tr>

				<tr>
					<td colspan=2>&nbsp;</td>
				</tr>


				<tr valign='top'>
					<td>
					    <img src="{$IMG}icon_ConnectorSearchFields.gif" name="connectorSearchImg" onclick="document.location.href='index.php?module=Connectors&action=ModifySearch';"
						onMouseOver="document.connectorSearchImg.src='{$IMG}icon_ConnectorSearchFieldsOver.gif'"
						onMouseOut="document.connectorSearchImg.src='{$IMG}icon_ConnectorSearchFields.gif'">
				    </td>
					<td>&nbsp;&nbsp;</td>
					<td>
					    {* BEGIN SUGARCRM flav=pro ONLY *}
					    <b>{$mod.LBL_MODIFY_SEARCH_TITLE}</b><br/>
						{$mod.LBL_MODIFY_SEARCH_DESC}
						{* END SUGARCRM flav=pro ONLY *}
					</td>	
				</tr>

			</table>
		</td>				
		<td width="20%">&nbsp;</td>
	</tr>
</table>