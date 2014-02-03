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

// defense
if(typeof(SUGAR) == 'undefined') {
	var SUGAR = {};
}

SUGAR.Administration = {
	/**
	 * calls modules/Administration/Async.php with JSON objects
	 */
	Async : {
	},

	/**
	 * Utility functions for RepairXSS screen
	 * @param HTMLSelectObject select dropdown
	 */
	RepairXSS : {
		toRepair : new Object, // assoc array of items to be cleaned
		currentRepairObject : "", // bean currently worked on
		currentRepairIds : new Array(), // array of ids for above bean
		repairedCount : 0,
		numberToFix: 25, // how many IDs to send at once from client

		/**
		 * Calculates how many rows to iterate through
		 */
		refreshEstimate : function(select) {
			this.toRepair = new Object();
			this.repairedCount = 0;

			var button = document.getElementById('repairXssButton');
			var selected = select.value;
			var totalDisplay = document.getElementById('repairXssDisplay');
			var counter = document.getElementById('repairXssCount');
			var repaired = document.getElementById('repairXssResults');
			var repairedCounter = document.getElementById('repairXssResultCount');

			if(selected != "0") {
				button.style.display = 'inline';
				repairedCounter.value = 0;
				AjaxObject.startRequest(callbackRepairXssRefreshEstimate, "&adminAction=refreshEstimate&bean=" + selected);
			} else {
				button.style.display = 'none';
				totalDisplay.style.display = 'none';
				repaired.style.display = 'none';
				counter.value = 0;
				repaired.value= 0;
			}
		},

		/**
		 * Takes selection and executes repair function
		 */
		executeRepair : function() {
			if(this.toRepair) {
				// if queue is empty load next
				if(this.currentRepairIds.length < 1) {
					if(!this.loadRepairQueue()) {
						alert(done);
						return; // we're done
					}
				}

				var beanIds = new Array();

				for(var i=0; i<this.numberToFix; i++) {
					if(this.currentRepairIds.length > 0) {
						beanIds.push(this.currentRepairIds.pop());
					}
				}

				var beanId = YAHOO.lang.JSON.stringify(beanIds);
				AjaxObject.startRequest(callbackRepairXssExecute, "&adminAction=repairXssExecute&bean=" + this.currentRepairObject + "&id=" + beanId);
			}
		},

		/**
		 * Loads the bean name and array of bean ids for repair
		 * @return bool False if load did not occur
		 */
		loadRepairQueue : function() {
			var loaded = false;

			this.currentRepairObject = '';
			this.currentRepairIds = new Array();

			for(var bean in this.toRepair) {
				if(this.toRepair[bean].length > 0) {
					this.currentRepairObject = bean;
					this.currentRepairIds = this.toRepair[bean];
					loaded = true;
				}
			}

			// 'unset' the IDs array so we don't iterate over it again
			this.toRepair[this.currentRepairObject] = new Array();

			return loaded;
		}
	}
}