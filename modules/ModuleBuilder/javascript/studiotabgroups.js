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




if(typeof('console') == 'undefined'){
console = {
	log: function(message) {
	
	}
}
}

StudioTabGroup = function(){
	this.fields = {};
	this.lastEditTabGroupLabel = -1;
	this.widths = new Object;
};


StudioTabGroup.prototype.editTabGroupLabel = function (id, done){
	if(!done){
		if(this.lastEditTabGroupLabel != -1)editTabGroupLabel(this.lastEditTabGroupLabel, true);
		document.getElementById('tabname_'+id).style.display = 'none';
		document.getElementById('tablabel_'+id).style.display = '';
		document.getElementById('tabother_'+id).style.display = 'none';
		document.getElementById('tablabel_'+id).focus();
		this.lastEditTabGroupLabel = id;
		//Ext.dd.DragDropMgr.lock();
	}else{
		this.lastEditTabGroupLabel = -1;
		document.getElementById('tabname_'+id).innerHTML = escape(document.getElementById('tablabel_'+id).value);
		document.getElementById('tabname_'+id).style.display = '';
		document.getElementById('tablabel_'+id).style.display = 'none';
		document.getElementById('tabother_'+id).style.display = '';
		//Ext.dd.DragDropMgr.unlock();
	}
}

 StudioTabGroup.prototype.generateForm = function(formname){
		  	var form = document.getElementById(formname);
		  	for(j = 0; j < studiotabs.slotCount; j++){
				var ul = document.getElementById('ul' + j);
				items = ul.getElementsByTagName('li');
				for(i = 0; i < items.length; i++) {
				
				if(typeof(studiotabs.subtabModules[items[i].id]) != 'undefined'){
				
					var input = document.createElement('input');
					input.type='hidden'
					input.name= j + '_'+ i;
					input.value = studiotabs.tabLabelToValue[studiotabs.subtabModules[items[i].id]];
					form.appendChild(input);
				}
				}
		  }
		  };

 StudioTabGroup.prototype.generateGroupForm = function(formname){
		  	this.clearGroupForm(formname);
		  	var form = document.getElementById(formname);
		  	for(j = 0; j < studiotabs.slotCount; j++){
				var ul = document.getElementById('ul' + j);
				items = ul.getElementsByTagName('li');
				for(i = 0; i < items.length; i++) {
				if(typeof(studiotabs.subtabModules[items[i].id]) != 'undefined'){
					var input = document.createElement('input');
					input.type='hidden';
					input.name= 'group_'+ j + '[]';
					input.value = studiotabs.tabLabelToValue[studiotabs.subtabModules[items[i].id]];
					form.appendChild(input);
//					if(this.widths[items[i].id] != null) {
					var winput = document.createElement('input');
					winput.type='hidden';
					winput.name= input.value + 'width';
					winput.value = "width=" + document.getElementById(items[i].id+'width').innerHTML;
					form.appendChild(winput);
//					}
				}
				}
		  	}
		  };
		  
StudioTabGroup.prototype.clearGroupForm = function(formname){
		var form = document.getElementById(formname);
		for(j = 0; j < form.elements.length; j++){
			if (typeof(form.elements[j].name) != 'undefined' && String(form.elements[j].name).indexOf("group") > -1) {
				form.removeChild(form.elements[j]);
				j--;
			}
		}
};

StudioTabGroup.prototype.deleteTabGroup = function(id){
		if(document.getElementById('delete_' + id).value == 0){
			document.getElementById('ul' + id).style.display = 'none';
			document.getElementById('tabname_'+id).style.textDecoration = 'line-through'
			document.getElementById('delete_' + id).value = 1;
		}else{
			document.getElementById('ul' + id).style.display = '';
			document.getElementById('tabname_'+id).style.textDecoration = 'none'
			document.getElementById('delete_' + id).value = 0;
		}
	}	

StudioTabGroup.prototype.editField = function(elem, link) {
	if (this.widths[elem.id] != null) {
		ModuleBuilder.getContent(link + '&width=' + this.widths[elem.id]);
	}else{
		ModuleBuilder.getContent(link);
	}
}

StudioTabGroup.prototype.saveField = function(elemID, formname) {
	var elem = document.getElementById(elemID);
	var form = document.getElementById(formname);
	var inputs = form.getElementsByTagName("input");
	for (i = 0; i < inputs.length; i++) {
		if (inputs[i].name == "width") {
			this.widths[elemID] = inputs[i].value;
			var dispWidth = elem.getElementsByTagName("td")[3];
			dispWidth.innerHTML = "width:" + inputs[i].value;
		}
		if (inputs[i].name == "label") {
			var title = elem.getElementsByTagName("span")[0];
			title.innerHTML = inputs[i].value;
		}
	}
	ModuleBuilder.submitForm(formname);
	ajaxStatus.flashStatus('Field Saved', 1000);
}

StudioTabGroup.prototype.reset = function() {
	this.subtabCount = {};
	this.subtabModules = {};
	this.tabLabelToValue = {};
	this.widths = new Object;
}

var lastField = '';
			var lastRowCount = -1;
			var undoDeleteDropDown = function(transaction){
			    deleteDropDownValue(transaction['row'], document.getElementById(transaction['id']), false);
			}
			jstransaction.register('deleteDropDown', undoDeleteDropDown, undoDeleteDropDown);
			function deleteDropDownValue(rowCount, field, record){
			    if(record){
			        jstransaction.record('deleteDropDown',{'row':rowCount, 'id': field.id });
			    }
			    //We are deleting if the value is 0
			    if(field.value == '0'){
			        field.value = '1';
			        document.getElementById('slot' + rowCount + '_value').style.textDecoration = 'line-through';
			    }else{
			        field.value = '0';
			        document.getElementById('slot' + rowCount + '_value').style.textDecoration = 'none';
			    }
			    
			   
			}
var studiotabs = new StudioTabGroup();
studiotabs.subtabCount = {};
studiotabs.subtabModules = {};
studiotabs.tabLabelToValue = {};