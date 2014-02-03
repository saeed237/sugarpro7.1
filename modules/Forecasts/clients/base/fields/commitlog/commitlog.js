/*
     * By installing or using this file, you are confirming on behalf of the entity
     * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
     * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
     * http://www.sugarcrm.com/master-subscription-agreement
     *
     * If Company is not bound by the MSA, then by installing or using this file
     * you are agreeing unconditionally that Company will be bound by the MSA and
     * certifying that you have authority to bind Company accordingly.
     *
     * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
     */
({commitLog:[],previousDateEntered:'',initialize:function(options){app.view.Field.prototype.initialize.call(this,options);this.on('show',function(){if(!this.disposed){this.render();}},this);},bindDataChange:function(){this.collection.on('reset',function(){this.hide();this.buildCommitLog();},this);this.context.on('forecast:commit_log:trigger',function(){if(!this.isVisible()){this.show();}else{this.hide();}},this);},buildCommitLog:function(){this.commitLog=[];if(_.isEmpty(this.collection.models)){return;}
var previousModel=_.first(this.collection.models);var dateEntered=new Date(Date.parse(previousModel.get('date_modified')));if(dateEntered=='Invalid Date'){dateEntered=previousModel.get('date_modified');}
this.previousDateEntered=app.date.format(dateEntered,app.user.getPreference('datepref')+' '+app.user.getPreference('timepref'));var loopPreviousModel='';var models=_.clone(this.collection.models).reverse();_.each(models,function(model){this.commitLog.push(app.utils.createHistoryLog(loopPreviousModel,model));loopPreviousModel=model;},this);this.commitLog.reverse();}})