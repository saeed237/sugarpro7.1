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
(function(app){app.events.on("app:init",function(){app.plugins.register('DisableDelete',["field"],{onAttach:function(component,plugin){this.on("render",this.removeDelete,this);},removeDelete:function(){var sales_stage_won=null,sales_stage_lost=null,closed_RLI_count=0,message=null,status=null,button=null;if(_.contains(["list:deleterow:fire","button:delete_button:click"],this.def.event)){if(app.metadata.getModule("Forecasts","config").is_setup==1){sales_stage_won=app.metadata.getModule("Forecasts","config").sales_stage_won;sales_stage_lost=app.metadata.getModule("Forecasts","config").sales_stage_lost;if(_.isEmpty(status)){status=this.model.get("sales_stage");}
if(closed_RLI_count>0){message=app.lang.get("NOTICE_NO_DELETE_CLOSED_RLIS","Opportunities");}
if(_.contains(sales_stage_won,status)||_.contains(sales_stage_lost,status)){message=app.lang.getAppString("NOTICE_NO_DELETE_CLOSED");}
if(!_.isEmpty(message)){button=this.getFieldElement();button.addClass("disabled");button.attr("data-event","");button.tooltip({title:message});}}}
return message;}})})})(SUGAR.App);