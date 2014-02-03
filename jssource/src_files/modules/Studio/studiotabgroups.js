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



var subtabCount = [];
var subtabModules = [];
var tabLabelToValue = [];
StudioTabGroup = function(){
	this.lastEditTabGroupLabel = -1;
};


StudioTabGroup.prototype.editTabGroupLabel = function (id, done){
	if(!done){
		if(this.lastEditTabGroupLabel != -1)StudioTabGroup.prototype.editTabGroupLabel(this.lastEditTabGroupLabel, true);
		document.getElementById('tabname_'+id).style.display = 'none';
		document.getElementById('tablabel_'+id).style.display = '';
		document.getElementById('tabother_'+id).style.display = 'none';
		//#28274, I think this is a simple way when a element can't accept focus()
		try{
			document.getElementById('tablabel_'+id).focus();
		}
		catch(er){
			//TODO
		}
		this.lastEditTabGroupLabel = id;
		YAHOO.util.DragDropMgr.lock();
	}else{
		this.lastEditTabGroupLabel = -1;
		document.getElementById('tabname_'+id).innerHTML = escape(document.getElementById('tablabel_'+id).value);
		document.getElementById('tabname_'+id).style.display = '';
		document.getElementById('tablabel_'+id).style.display = 'none';
		document.getElementById('tabother_'+id).style.display = '';
		YAHOO.util.DragDropMgr.unlock();
	}
}

 StudioTabGroup.prototype.generateForm = function(formname){
  	var form = document.getElementById(formname);
  	for(var j = 0; j < slotCount; j++){
		var ul = document.getElementById('ul' + j);
		var items = ul.getElementsByTagName('li');
		for(var i = 0; i < items.length; i++) {
		    if(typeof(subtabModules[items[i].id]) != 'undefined'){
			
				var input = document.createElement('input');
				input.type='hidden';
				input.name= j + '_'+ i;
				input.value = tabLabelToValue[subtabModules[items[i].id]];
				form.appendChild(input);
			}
		}
    }
	//set the slotcount in the form.
	form.slot_count.value = slotCount;
};

 StudioTabGroup.prototype.generateGroupForm = function(formname){
		  	var form = document.getElementById(formname);
		  	for(j = 0; j < slotCount; j++){
				var ul = document.getElementById('ul' + j);
				items = ul.getElementsByTagName('li');
				for(i = 0; i < items.length; i++) {
				if(typeof(subtabModules[items[i].id]) != 'undefined'){
					var input = document.createElement('input');
					input.type='hidden'
					input.name= 'group_'+ j + '[]';
					input.value = tabLabelToValue[subtabModules[items[i].id]];
					form.appendChild(input);
				}
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