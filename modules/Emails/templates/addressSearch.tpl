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
<form id="searchForm" method="get" action="#">
    <table id="searchTable" border="0" cellpadding="0" cellspacing="0" width="670">
		<tr id="peopleTableSearchRow">
			<td scope="row" nowrap="NOWRAP">
			     <div id="rollover">
			     {$mod_strings.LBL_SEARCH_FOR}:
			         <a href="#" class="rollover"><img border="0" alt=$mod_strings.LBL_HELP src="index.php?entryPoint=getImage&amp;imageName=helpInline.png">
	                        <div><span class="rollover">{$mod_strings.LBL_ADDRESS_BOOK_SEARCH_HELP}</span></div>
	                 </a>

		      	<input id="input_searchField" name="input_searchField" type="text" value="">
		      	</div>
			    &nbsp;&nbsp; {$mod_strings.LBL_LIST_RELATED_TO}: &nbsp;
			    <select name="person" id="input_searchPerson">
			         {$listOfPersons}
			    </select>
			    &nbsp;
			    <a href="javascript:void(0);">
                    {sugar_getimage name="select" ext=".gif" alt=$mod_strings.LBL_EMAIL_SELECTOR_SELECT other_attributes='align="absmiddle" border="0" onclick="SUGAR.email2.addressBook.searchContacts();" '}
                </a>
                <a href="javascript:void(0);">
                    {sugar_getimage name="clear" ext=".gif" alt=$mod_strings.LBL_EMAIL_SELECTOR_CLEAR other_attributes='align="absmiddle" border="0" onclick="SUGAR.email2.addressBook.clearAddressBookSearch();" '}
                </a>
			</td>
        </tr>
        <tr id="peopleTableSearchRow">
            <td scope="row" nowrap="NOWRAP" colspan="2" id="relatedBeanColumn">
		      {$mod_strings.LBL_FILTER_BY_RELATED_BEAN}<span id="relatedBeanInfo"></span>
		   	  <input name="hasRelatedBean" id="hasRelatedBean" type="checkbox"/>
            </td>

        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr id="peopleTableSearchRow">
            <td id="searchSubmit" scope="row" nowrap="NOWRAP">
                <button onclick="SUGAR.email2.addressBook.insertContactToResultTable(null,'{sugar_translate label='LBL_EMAIL_ADDRESS_BOOK_ADD_TO'}')">
                    {sugar_translate label="LBL_ADD_TO_ADDR" module="Emails"} <b>{sugar_translate label="LBL_EMAIL_ADDRESS_BOOK_ADD_TO"}</b>
                </button>
                <button onclick="SUGAR.email2.addressBook.insertContactToResultTable(null,'{sugar_translate label='LBL_EMAIL_ADDRESS_BOOK_ADD_CC'}')">
                    {sugar_translate label="LBL_ADD_TO_ADDR" module="Emails"} <b>{sugar_translate label="LBL_EMAIL_ADDRESS_BOOK_ADD_CC"}</b>
                </button>
                <button onclick="SUGAR.email2.addressBook.insertContactToResultTable(null,'{sugar_translate label='LBL_EMAIL_ADDRESS_BOOK_ADD_BCC'}')">
                    {sugar_translate label="LBL_ADD_TO_ADDR" module="Emails"} <b>{sugar_translate label="LBL_EMAIL_ADDRESS_BOOK_ADD_BCC"}</b>
                </button>
            </td>
        </tr>

    </table>
</form>