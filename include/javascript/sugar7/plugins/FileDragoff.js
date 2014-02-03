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
(function(app){app.events.on("app:init",function(){app.plugins.register('FileDragoff',['view'],{events:{'dragstart .dragoff':'saveAttachment'},saveAttachment:function(event){if(event.dataTransfer&&event.dataTransfer.constructor==Clipboard&&event.dataTransfer.setData('DownloadURL','http://www.sugarcrm.com')){var el=$(event.currentTarget),mime,name,file;while(el!==this.$el&&!el.data("url")){el=el.parent();}
mime=el.data("mime");name=el.data("filename");file=el.data("url");event.dataTransfer.setData("DownloadURL",mime+":"+name+":"+file);}}});});})(SUGAR.App);