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
({initialize:function(options){app.view.View.prototype.initialize.call(this,options);this.results=[];this.guid=_.uniqueId("leaderboard");this.loadData();},_render:function(){var self=this;$("#"+this.guid+" svg").css("width",$("#"+this.guid).width());$("#"+this.guid+" svg").css("min-height","300px");},loadData:function(){var self=this,url=app.api.buildURL('CustomReport/OpportunityLeaderboard');app.api.call('GET',url,null,{success:function(o){self.results={properties:{title:'Opportunity Leaderboard'},data:[]};for(i=0;i<o.length;i++){self.results.data.push({key:o[i]['user_name'],value:parseInt(o[i]['amount'],10)});}
app.view.View.prototype._render.call(self);nv.addGraph(function(){var chart=nv.models.pieChart().x(function(d){return d.label;}).y(function(d){return d.value;});d3.select("#"+self.guid+" svg").datum(self.results).transition().duration(1200).call(chart);return chart;});}});}})