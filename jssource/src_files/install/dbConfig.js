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



function togglePasswordRetypeRequired() {
   var theForm = document.forms[0];
   var elem = document.getElementById('password_retype_required');

   if( theForm.setup_db_create_sugarsales_user.checked ){
      elem.style.display = '';
      // theForm.setup_db_sugarsales_user.focus();
      theForm.setup_db_username_is_privileged.checked = "";
      theForm.setup_db_username_is_privileged.disabled = "disabled";
      toggleUsernameIsPrivileged();
   }
   else {
      elem.style.display = 'none';
      theForm.setup_db_username_is_privileged.disabled = "";
   }
}

function toggleDropTables(){
   var theForm = document.forms[0];

   if( theForm.setup_db_create_database.checked ){
      theForm.setup_db_drop_tables.checked = '';
      theForm.setup_db_drop_tables.disabled = "disabled";
   }
   else {
      theForm.setup_db_drop_tables.disabled = '';
   }
}

function toggleUsernameIsPrivileged(){
   var theForm = document.forms[0];
   var elem = document.getElementById('privileged_user_info');

   if( theForm.setup_db_username_is_privileged.checked ){
      elem.style.display = 'none';
   }
   else {
      elem.style.display = '';
   }
}
