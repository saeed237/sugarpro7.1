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
{if $view_module != 'KBDocuments'}
<input type='button' name='addrelbtn' value='{$mod_strings.LBL_BTN_ADD_RELATIONSHIP}'
	class='button' onclick='ModuleBuilder.moduleLoadRelationship2("");' style="margin-bottom:5px;">
{/if}
<div id='relGrid'></div>
{if $studio}{sugar_translate label='LBL_CUSTOM_RELATIONSHIPS' module='ModuleBuilder'}</h3>{/if}
<script>
{literal}
//Workaround for YUI bug 2527707: http://yuilibrary.com/projects/yui2/ticket/913efafad48ce433199f3e72e4847b18, should be removed when YUI 2.8+ is used
YAHOO.widget.DataTable.prototype.getColumn = function(column) {
    var oColumn = this._oColumnSet.getColumn(column);

    if(!oColumn) {
        // Validate TD element
        var elCell = column.nodeName.toLowerCase() != "th" ? this.getTdEl(column) : false;
        if(elCell) {
            oColumn = this._oColumnSet.getColumn(elCell.cellIndex);
        }
        // Validate TH element
        else {
            elCell = this.getThEl(column);
            if(elCell) {
                // Find by TH el ID
                var allColumns = this._oColumnSet.flat;
                for(var i=0, len=allColumns.length; i<len; i++) {
                    if(allColumns[i].getThEl().id === elCell.id) {
                        oColumn = allColumns[i];
                    } 
                }
            }
        }
    }
    if(!oColumn) {
        YAHOO.log("Could not get Column for column at " + column, "info", this.toString());
    }
    return oColumn;
};
{/literal}
var relationships = {ldelim}relationships:{$relationships}{rdelim};
var grid = new YAHOO.widget.ScrollingDataTable('relGrid',
	[
	    {ldelim}key:'name',       label: SUGAR.language.get('ModuleBuilder','LBL_REL_NAME'),        width: 200, sortable: true{rdelim},
	    {ldelim}key:'lhs_module', label: SUGAR.language.get('ModuleBuilder','LBL_LHS_MODULE'),      width: 120, sortable: true{rdelim},
	    {ldelim}key:'relationship_type', label: SUGAR.language.get('ModuleBuilder','LBL_REL_TYPE'), width: 120, sortable: true{rdelim},
	    {ldelim}key:'rhs_module', label: SUGAR.language.get('ModuleBuilder','LBL_RHS_MODULE'),      width: 120, sortable: true{rdelim}
	],{literal}
	new YAHOO.util.LocalDataSource(relationships, {
	    responseSchema: {
		   resultsList : "relationships",
		   fields : [{key : "name"}, {key: "lhs_module"}, {key: "relationship_type"}, {key: "rhs_module"}]
	    }
	}),
    {MSG_EMPTY: SUGAR.language.get('ModuleBuilder','LBL_NO_RELS'), height:"auto"}
);
grid.subscribe("rowMouseoverEvent", grid.onEventHighlightRow); 
grid.subscribe("rowMouseoutEvent", grid.onEventUnhighlightRow); 
grid.subscribe("rowClickEvent", function(args){
    var rel = this.getRecord(args.target).getData();
    var editTab = ModuleBuilder.findTabById("relEditor");
    if (editTab) ModuleBuilder.tabPanel.removeTab(editTab);
    var name = rel.name.indexOf("*") > -1 ? rel.name.substring(0, rel.name.length-1) : rel.name;
    ModuleBuilder.moduleLoadRelationship2(name);
});
grid.render();

{/literal}
ModuleBuilder.module = '{$view_module}';
ModuleBuilder.MBpackage = '{$view_package}';
ModuleBuilder.helpRegisterByID('relGrid');
{if $fromModuleBuilder}
ModuleBuilder.helpSetup('relationshipsHelp','default');
{else}
ModuleBuilder.helpSetup('studioWizard','relationshipsHelp');
{/if}
</script>