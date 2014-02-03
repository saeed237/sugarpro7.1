{*
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

*}
{{include file='include/Popups/tpls/header.tpl'}}
{{sugar_getscript file='include/javascript/popup_helper.js'}}
{{sugar_getscript file='include/javascript/yui/build/connection/connection.js'}}
{{sugar_getscript file='modules/ProductTemplates/Popup_picker.js'}}
{{$treeheader}}
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
    <tr><td>
        <table width="95%" border="0" cellspacing="0" cellpadding="0">
            <tr><td>
                <div id="productcatalog">{{$treeinstance}}</div>
            </td></tr>
        </table>
    </td></tr>
</table>