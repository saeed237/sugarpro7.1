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
<link rel="stylesheet" type="text/css" href="include/javascript/yui-old/assets/container.css" />
<script type="text/javascript" src='{sugar_getjspath file="include/SugarFields/Fields/Collection/SugarFieldCollection.js"}'></script>
<div id='{{sugarvar key='name'}}_div' name='{{sugarvar key='name'}}_div'><img src="{sugar_getimagepath file='sqsWait.gif'}" alt="loading..." id="{{sugarvar key="name"}}_loading_img" style="display:none"></div>
<script type="text/javascript">
//{literal}
    var callback = {
        success:function(o){
            //{/literal}
            //collection['{{sugarvar key="name"}}'] = new SUGAR.collection('{{sugarvar key="name"}}', "{{sugarvar key='module'}}", '{{$displayParams.popupData}}');
            document.getElementById('{{sugarvar key="name"}}_loading_img').style.display="none";
            document.getElementById('{{sugarvar key="name"}}_div').innerHTML = o.responseText;
            SUGAR.util.evalScript(o.responseText);
            {* //TODO: Expression Engine removed from Tokyo so SUGAR.forms no longer exists.
			{{if !empty($required)}}
            SUGAR.forms.FormValidator.add('EditView', '{{sugarvar key="name"}}_field', 'isRequiredCollection(\${{sugarvar key="name"}}_field)', SUGAR.language.get('app_strings', 'ERROR_MISSING_COLLECTION_SELECTION'));
            {{/if}} *}
            //{literal}
        },
        failure:function(o){
            alert(SUGAR.language.get('app_strings','LBL_AJAX_FAILURE'));
        }
    }
    //{/literal}
    document.getElementById('{{sugarvar key="name"}}_loading_img').style.display="inline";
    postData = '&displayParams=' + '{{$displayParamsJSON}}' + '&vardef=' + '{{$vardefJSON}}' + '&module_dir=' + document.forms.EditView.module.value + '&bean_id=' + document.forms.EditView.record.value + '&action_type=editview';
    //{literal}
    YAHOO.util.Connect.asyncRequest('POST', 'index.php?action=viewsugarfieldcollection', callback, postData);
//{/literal}
</script>