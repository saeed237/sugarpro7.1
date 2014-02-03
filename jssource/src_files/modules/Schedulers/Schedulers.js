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



function checkFormPre(formId) {
	validateCronInterval(formId);
	var noError = check_form(formId);

	if(noError) {
		return true;
	} else {
		toggleAdv('true');
		return false;
	}
}

function validateCronInterval(formId) {
	var fieldIsValid = function(value, min, max) {
		var inRange = function(value, min, max) {
			return (value >= min && value <= max);
		}
		//Check for *
		if (value == "*") {
			return true;
		}
		//Check for interval syntax
		var result = /^\*\/(\d+)$/.exec(value);
		if (result && result[0] && inRange(result[1], min, max)) {
			return true;
		}
		//Check for ranges/lists
		var sets = value.split(',');
		var valid = true;
		for (var i = 0; i < sets.length; i++) {
			result = /^(\d+)(-(\d+))?$/.exec(sets[i])
			if (!result || !result[0] || !inRange(result[1], min, max) || (result[3] && !inRange(result[3], min, max))) {
				return false;
			}
		}
		return true;
	}
	var cronFields = {
		mins: 		  {min:0, max:59},
		hours: 		  {min:0, max:23},
		day_of_month: {min:1, max:31},
		months:		  {min:1, max:12},
		day_of_week:  {min:0, max:7}
	}
	var valid = true;
	for (field in cronFields) {
		removeFromValidate(formId, field);
		if (document[formId][field] && !fieldIsValid(document[formId][field].value, cronFields[field].min, cronFields[field].max)) {
			valid = false;
			addToValidate(formId, field, 'error', true, "{$MOD.ERR_CRON_SYNTAX}");
		} else {
			addToValidate(formId, field, 'verified', true, "{$MOD.ERR_CRON_SYNTAX}");
		}
	}
	return valid;
}

function toggleAdv(onlyAdv) {
	var thisForm = document.getElementById("EditView");
	var crontab = document.getElementById("crontab");
	var simple = document.getElementById("simple");
	var adv = document.getElementById("advTable");
	var use = document.getElementById("use_adv");

	if(crontab.style.display == "none" || onlyAdv == 'true') { // show advanced
		crontab.style.display = "";
		adv.style.display = "";
		simple.style.display = "none";
		use.value = "true";
	} else {
		crontab.style.display = "none";
		adv.style.display = "none";
		simple.style.display = "";
		use.value = "false";
	}

	for(i=0; i<thisForm.elements.length; i++) {
		if(thisForm.elements[i].disabled) {
			thisForm.elements[i].disabled = false;
		}
	}
}

function allDays() {
	var toggle = document.getElementById("all");
	var m = document.getElementById("mon");
	var t = document.getElementById("tue");
	var w = document.getElementById("wed");
	var h = document.getElementById("thu");
	var f = document.getElementById("fri");
	var s = document.getElementById("sat");
	var u = document.getElementById("sun");

	if(toggle.checked) {
		m.checked = true;
		t.checked = true;
		w.checked = true;
		h.checked = true;
		f.checked = true;
		s.checked = true;
		u.checked = true;
	} else {
		m.checked = false;
		t.checked = false;
		w.checked = false;
		h.checked = false;
		f.checked = false;
		s.checked = false;
		u.checked = false;
	}

}

function updateVisibility()
{
	if($('#adv_interval').is(':checked')) {
		$('#job_interval_advanced').parent().parent().show();
		$('#job_interval_basic').parent().parent().hide();
		$('#LBL_ADV_OPTIONS').show();
	} else {
		$('#job_interval_advanced').parent().parent().hide();
		$('#job_interval_basic').parent().parent().show();
		$('#LBL_ADV_OPTIONS').hide();
	}
}

function initScheduler(){
	if(typeof(adv_interval) != "undefined" && adv_interval){
		$('#adv_interval').prop("checked", true);
	}
}

$('#EditView_tabs').ready(function() {
	initScheduler();
	updateVisibility();
});
$('#adv_interval').ready(function() {$('#adv_interval').click(updateVisibility); });