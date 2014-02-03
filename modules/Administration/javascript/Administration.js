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
if(typeof(SUGAR)=='undefined'){var SUGAR={};}
SUGAR.Administration={Async:{},RepairXSS:{toRepair:new Object,currentRepairObject:"",currentRepairIds:new Array(),repairedCount:0,numberToFix:25,refreshEstimate:function(select){this.toRepair=new Object();this.repairedCount=0;var button=document.getElementById('repairXssButton');var selected=select.value;var totalDisplay=document.getElementById('repairXssDisplay');var counter=document.getElementById('repairXssCount');var repaired=document.getElementById('repairXssResults');var repairedCounter=document.getElementById('repairXssResultCount');if(selected!="0"){button.style.display='inline';repairedCounter.value=0;AjaxObject.startRequest(callbackRepairXssRefreshEstimate,"&adminAction=refreshEstimate&bean="+selected);}else{button.style.display='none';totalDisplay.style.display='none';repaired.style.display='none';counter.value=0;repaired.value=0;}},executeRepair:function(){if(this.toRepair){if(this.currentRepairIds.length<1){if(!this.loadRepairQueue()){alert(done);return;}}
var beanIds=new Array();for(var i=0;i<this.numberToFix;i++){if(this.currentRepairIds.length>0){beanIds.push(this.currentRepairIds.pop());}}
var beanId=YAHOO.lang.JSON.stringify(beanIds);AjaxObject.startRequest(callbackRepairXssExecute,"&adminAction=repairXssExecute&bean="+this.currentRepairObject+"&id="+beanId);}},loadRepairQueue:function(){var loaded=false;this.currentRepairObject='';this.currentRepairIds=new Array();for(var bean in this.toRepair){if(this.toRepair[bean].length>0){this.currentRepairObject=bean;this.currentRepairIds=this.toRepair[bean];loaded=true;}}
this.toRepair[this.currentRepairObject]=new Array();return loaded;}}}