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



function submitbutton()
{
   var form = document.mosForm;
   var r = new RegExp("[^0-9A-Za-z]", "i");

   if (form.email1.value != "")
   {
      var myString = form.email1.value;
      var pattern = /(\W)|(_)/g;
      var adate = new Date();
      var ms = adate.getMilliseconds();
      var sec = adate.getSeconds();
      var mins = adate.getMinutes();
      ms = ms.toString();
      sec = sec.toString();
      mins = mins.toString();
      newdate = ms + sec + mins;
   
      var newString = myString.replace(pattern,"");
      newString = newString + newdate;
      //form.username.value = newString;
      //form.password.value = newString;
      //form.password2.value = newString;
   }

   // do field validation
   if (form.name.value == "")
   {
      form.name.focus();
      alert( "Please provide your name" );
      return false;
   }
   else if (form.email1.value == "")
   {
      form.email1.focus();
      alert( "Please provide your email address" );
      return false;
   }
   else
   {
      form.submit();
   }

   document.appform.submit();
   window.focus();
}
