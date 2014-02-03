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
({plugins:['EllipsisInline'],initialize:function(options){var serverInfo=app.metadata.getServerInfo();this.skypeEnabled=serverInfo.system_skypeout_on?true:false;app.view.Field.prototype.initialize.call(this,options);},format:function(value){if((this.action==='list'||this.action==='detail'||this.action==='record')&&this.isSkypeFormatted(value)&&this.skypeEnabled){this.skypeValue=this.skypeFormat(value);}
return value;},isSkypeFormatted:function(value){if(_.isString(value)){return value.substr(0,1)==='+'||value.substr(0,2)==='00'||value.substr(0,3)==='011';}else{return false;}},skypeFormat:function(value){if(_.isString(value)){var number=value.replace(/[^\d\(\)\.\-\/ ]/g,'');if(null!==number.match(/[\-]/g)&&number.match(/[\-]/g).length>=2){number=number.replace(/[^\d\-]/g,'').replace(/(\d+)\-(\d+)\-([\d\-]+)/g,function($0,$1,$2,$3){return[$1,$2,$3.replace(/\D/g,'')].join('-');});}else if(null!==number.match(/[\.]/g)&&number.match(/[\.]/g).length>=2){number=number.replace(/[^\d\.]/g,'').replace(/(\d+)\.(\d+)\.([\d\.]+)/g,function($0,$1,$2,$3){return[$1,$2,$3.replace(/\D/g,'')].join('.');});}else if(null!==number.match(/\(\D*\d+\D*\)/g)){number=number.replace(/[^\d\(\)]+/g,'').replace(/(\d+)\((\d+)\)([0-9\(\)]+)/g,function($0,$1,$2,$3){return $1+'('+$2+')'+$3.replace(/\D/g,'');})}else if(null!==number.match(/[\/]/g)&&number.match(/[\/]/g).length>=2){number=number.replace(/[^\d\/]/g,'').replace(/(\d+)\/(\d+)\/([\d\/]+)/g,function($0,$1,$2,$3){return[$1,$2,$3.replace(/\D/g,'')].join('/');});}else if(null!==number.match(/\S+\s+\S+\s+[\S\s]+/g)){number=number.replace(/(\S+)\s+(\S+)\s+([\S\s]+)/g,function($0,$1,$2,$3){return _.map([$1,$2,$3],function(s){return s.replace(/\D/g,'');}).join(' ');})}else{number=number.replace(/\D/g,'');}
if(value.substr(0,1)==='+'||(number.substr(0,2)!=='00'&&number.substr(0,3)!=='011')){number='+'+number;}
return number;}else if(_.isNumber(value)){if(value.substr(0,2)!=='00'&&value.substr(0,3)!=='011'){value='+'+value;}}
return value;}})