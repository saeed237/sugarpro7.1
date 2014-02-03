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
<div style='padding:5px;'>
    <button class="button" onclick="SUGAR.email2.addressBook.selectContactsDialogue();" id="selectContacts">{sugar_translate label="LBL_ADD_ENTRIES"}</button>
</div>
<div id="contactsFilterDiv" class="addressbookSearch">
<span> {$app_strings.LBL_EMAIL_ADDRESS_BOOK_FILTER}:&nbsp;<input size="10" type="text" class='input' id="contactsFilter" onkeyup="SUGAR.email2.addressBook.filter(this);">
	       <button class="button" onclick="SUGAR.email2.addressBook.clear();"> 
	       {$app_strings.LBL_CLEAR_BUTTON_LABEL} </button>
</span>
</div>
<div id="contacts"></div>
<div class="addressbookSearch">
<span >
    {$app_strings.LBL_EMAIL_ADDRESS_BOOK_ADD_LIST}:&nbsp;<input size="10" class="input" type="text" id="addListField" name="addListField" align="absmiddle">
</span>
 <button class="button" align="absmiddle" onclick="SUGAR.email2.addressBook.addMailingList();" style="padding-bottom: 2px">
        {$app_strings.LBL_EMAIL_ADDRESS_BOOK_ADD} </button>
</div>
<div id="lists"></div>
<div id="contactsMenu"></div>
<div id="listsMenu"></div>

