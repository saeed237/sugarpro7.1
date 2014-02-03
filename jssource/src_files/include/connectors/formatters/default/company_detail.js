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


function CompanyDetailsDialog(div_id, text, x, y)
{
    this.div_id = div_id;
    this.text = text;
    this.width = 300;
    this.header = '';
    this.footer = '';
    this.x = x;
    this.y = y;
}

function header(header)
{
    this.header = header;
}

function footer(footer)
{
    this.footer = footer;
}

function display()
{
    if(typeof(dialog) != 'undefined')
        dialog.destroy();

    dialog = new YAHOO.widget.SimpleDialog(this.div_id,
        {
            width: this.width,
            visible: true,
            draggable: true,
            close: true,
            text: this.text,
            constraintoviewport: true,
            x: this.x,
            y: this.y
    });

    dialog.setHeader(this.header);
    dialog.setBody(this.text);
    dialog.setFooter(this.footer);
    dialog.render(document.body);
    dialog.show();
}

CompanyDetailsDialog.prototype.setHeader = header;
CompanyDetailsDialog.prototype.setFooter = footer;
CompanyDetailsDialog.prototype.display = display;
