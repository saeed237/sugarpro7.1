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
(function(app){app.events.on("app:init",function(){app.plugins.register("GridBuilder",["view"],{getGridBuilder:function(params){function Row(options){this.initialize(options);}
_.extend(Row.prototype,{initialize:function(options){this.cells=[];this.span=0;this.maxSpan=options.maxSpan||12;this.maxCells=options.maxCells||1;},addCell:function(field,tabIndex){if(!_.isEmpty(tabIndex)){field.index=tabIndex;}
this.cells.push(field);this.span+=field.cellSpan;},hasMoreRoom:function(cellSpan){if(this.cells.length==this.maxCells||(this.span+cellSpan)>this.maxSpan){return false;}
return true;}});function GridBuilder(options){this.initialize(options);}
_.extend(GridBuilder.prototype,{initialize:function(options){options=options||{};options.fields=options.fields||{};this.grid=[];this.fields=app.utils.deepCopy(options.fields);this.maxRowSpan=12;this.maxColumns=options.columns||1;this.tabIndex=options.tabIndex||0;},build:function(){var grid=[];_.each(this.grid,function(row,index){grid[index]=[];_.each(row.cells,function(cell){grid[index].push(cell);},this);},this);this.grid=grid;return this._getGrid();},addRow:function(){var row=new Row({maxSpan:this.maxRowSpan,maxCells:this.maxColumns});this.grid.push(row);return row;},addField:function(field){var currentRow;if(this.grid.length<1){currentRow=this.addRow();}else{currentRow=this.grid[this.grid.length-1];}
if(!currentRow.hasMoreRoom(field.cellSpan)){currentRow=this.addRow();}
currentRow.addCell(field,++this.tabIndex);},_getGrid:function(){return{grid:this.grid,lastTabIndex:this.tabIndex};},_calculateFieldSpan:function(field){if(_.isUndefined(field.span)){field.span=Math.floor(this.maxRowSpan / this.maxColumns);}
if(field.span<1){field.span=1;}
if(field.span>this.maxRowSpan){field.span=this.maxRowSpan;}
field.cellSpan=field.span;}});var LabelsInlineGridBuilder=function(options){this.initialize(options);}
app.utils.extendFrom(LabelsInlineGridBuilder,GridBuilder,{build:function(){_.each(this.fields,function(field){this._calculateFieldSpan(field);if(_.isUndefined(field.labelSpan)){field.labelSpan=Math.floor(4 / this.maxColumns);}
if(field.labelSpan<1){field.labelSpan=1;}
if(_.isUndefined(field.dismiss_label)){field.dismiss_label=false;}
if(field.dismiss_label!==true){field.span-=field.labelSpan;if(field.span<1){field.span=1;}}
this.addField(field);},this);return GridBuilder.prototype.build.call(this);}});var LabelsOnTopGridBuilder=function(options){this.initialize(options);}
app.utils.extendFrom(LabelsOnTopGridBuilder,GridBuilder,{build:function(){_.each(this.fields,function(field){this._calculateFieldSpan(field);if(_.isUndefined(field.labelSpan)){field.labelSpan=field.span}
if(_.isUndefined(field.dismiss_label)){field.dismiss_label=false;}
this.addField(field);},this);return GridBuilder.prototype.build.call(this);}});var options={fields:params.fields,columns:params.columns,tabIndex:params.tabIndex};if(params.labelsOnTop===false&&params.labels){return new LabelsInlineGridBuilder(options);}else{return new LabelsOnTopGridBuilder(options);}}});});})(SUGAR.App);