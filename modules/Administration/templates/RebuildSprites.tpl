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

<script type="text/javascript">
{literal}
var ajxProgress;
var showMSG = 'true';
//when called, this function will make ajax call to rebuild/repair js files
function callRebuildSprites() {

    //begin main function that will be called
    ajaxCall = function() {
        //create success function for callback
        success = function(data)
        {
            //turn off loading message
            ajaxStatus.hideStatus();
            var targetdiv=document.getElementById('msgDiv');
            $msg = data.responseText;
            $msg += '</br>' + SUGAR.language.get('Administration', 'LBL_REPAIR_JS_FILES_DONE_PROCESSING');
            targetdiv.innerHTML = $msg;
        }

        //set loading message and create url
        ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_PROCESSING_REQUEST'));
        postData = 'module=Administration&action=callRebuildSprites';

        //if this is a call already in progress, then just return
        if(typeof ajxProgress != 'undefined')
        {
           return;
        }

        //make asynchronous call to process js files
        var ajxProgress = YAHOO.util.Connect.asyncRequest('POST','index.php', {success: success, failure: success}, postData);
    };//end ajaxCall method

    window.setTimeout('ajaxCall()', 2000);
    return;

}
//call function, so it runs automatically
callRebuildSprites();
{/literal}
</script>