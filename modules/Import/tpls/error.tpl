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
<script type="text/javascript" src="{sugar_getjspath file='include/javascript/sugar_grp_yui_widgets.js'}"></script>
<script>

    //set the variables
    var modalBod = "{$MESSAGE}";
    var cnfgtitle = '{$MOD.LBL_ERROR}';
    var startOverLBL = '{$MOD.LBL_TRY_AGAIN}';
    var cancelLBL = '{$MOD.LBL_CANCEL}';
    var actionVAR = '{$ACTION}';
    var importModuleVAR = '{$IMPORT_MODULE}';
    var sourceVAR = '{$SOURCE}';
    var showCancelVAR = '{$SHOWCANCEL}';
    {if !empty($CANCELLABEL)}
        cancelLBL = '{$CANCELLABEL}';
    {/if}

{literal}
    //function called when 'start over' button is pressed
    var chooseToStartOver = function() {
        //hide the modal and redirect window to previous step
        this.hide();
        document.location.href='index.php?module=Import&action='+actionVAR+'&import_module='+importModuleVAR+'&source='+sourceVAR;
        //SUGAR.importWizard.renderDialog(importModuleVAR,actionVAR,sourceVAR);
    };
    var chooseToCancel = function() {
        //do nothing, just hide the modal
        this.hide();
    };

    //define the buttons to be used in modal popup
    var importButtons = '';
    if(showCancelVAR){
        importButtons = [{ text: startOverLBL, handler: chooseToStartOver, isDefault:true },{ text:cancelLBL, handler: chooseToCancel}];
    }else{
        importButtons = [{ text: startOverLBL, handler: chooseToStartOver, isDefault:true }];
    }

    //define import error modal window
    ImportErrorBox = new YAHOO.widget.SimpleDialog('importMsgWindow', {
        type : 'alert',
        modal: true,
        width: '350px',
        id: 'importMsgWindow',
        close: true,
        visible: true,
        fixedcenter: true,
        constraintoviewport: true,
        draggable: true,
        buttons: importButtons
    });
{/literal}
    //display the window
    ImportErrorBox.setHeader(cnfgtitle);
    ImportErrorBox.setBody(modalBod);
    ImportErrorBox.render(document.body);
    ImportErrorBox.show();

</script>