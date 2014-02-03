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


// Any YUI overrides can go in here

//Override for bugfixes 45438 & 45557
YAHOO.widget.Panel.prototype.configClose = function (type, args, obj) {
    var val = args[0],
        oClose = this.close,
        strings = this.cfg.getProperty("strings"),
        fc;

    if (val) {
        if (!oClose) {

            if (!this.m_oCloseIconTemplate) {
                this.m_oCloseIconTemplate = document.createElement("a");
                this.m_oCloseIconTemplate.className = "container-close";
                this.m_oCloseIconTemplate.href = "#";
            }

            oClose = this.m_oCloseIconTemplate.cloneNode(true);

            fc = this.innerElement.firstChild;

            if (fc) {
                if (fc.className == this.m_oCloseIconTemplate.className) {
                    this.innerElement.replaceChild(oClose, fc);
                } else {
                    this.innerElement.insertBefore(oClose, fc);
                }
            } else {
                this.innerElement.appendChild(oClose);
            }

            oClose.innerHTML = (strings && strings.close) ? strings.close : "&#160;";

            YAHOO.util.Event.on(oClose, "click", this._doClose, this, true);

            this.close = oClose;

        } else {
            oClose.style.display = "block";
        }

    } else {
        if (oClose) {
            oClose.style.display = "none";
        }
    }
}

// Override for bug45669
// The fix is moving the code into this file 'as is'
YAHOO.widget.Overlay.prototype.center = function() {
	var scrollX = document.documentElement.scrollLeft || document.body.scrollLeft;
	var scrollY = document.documentElement.scrollTop || document.body.scrollTop;

	var viewPortWidth = YAHOO.util.Dom.getClientWidth();
	var viewPortHeight = YAHOO.util.Dom.getClientHeight();

	var elementWidth = this.element.offsetWidth;
	var elementHeight = this.element.offsetHeight;

	var x = (viewPortWidth / 2) - (elementWidth / 2) + scrollX;
	var y = (viewPortHeight / 2) - (elementHeight / 2) + scrollY;

	this.element.style.left = parseInt(x, 10) + "px";
	this.element.style.top = parseInt(y, 10) + "px";
	this.syncPosition();

	this.cfg.refireEvent("iframe");
}

// Override for bug45837
YAHOO.SUGAR.DragDropTable.prototype._deleteTrEl = function(row) {
    var rowIndex;

    // Get page row index for the element
    if(!YAHOO.lang.isNumber(row)) {
        rowIndex = Dom.get(row).sectionRowIndex;
    }
    else {
        rowIndex = row;
    }
    if(YAHOO.lang.isNumber(rowIndex) && (rowIndex > -1) && (rowIndex < this._elTbody.rows.length)) {
        // Cannot use tbody.deleteRow due to IE6 instability
        //return this._elTbody.deleteRow(rowIndex);
        return this._elTbody.removeChild(this._elTbody.rows[row]);
    }
    else {
        return null;
    }
}