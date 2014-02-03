<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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

?>
<script type="text/javascript" src="../include/javascript/sugar_3.js"></script>

<form name='test'>
<table>
<tr><td>*Name:</td><td><input type='text' name='name'></td></tr>
<tr><td>*Email:</td><td><input type='text' name='email'></td></tr>
<tr><td>Address:</td><td><input type='text' name='add'></td></tr>
<tr><td>Time:</td><td><input type='text' name='time'></td></tr>
<tr><td>Date:</td><td><input type='text' name='date'></td></tr>
<tr><td>Amount:</td><td>$<input type='text' name='amount'></td></tr>

</table>
<input type='button' name='test' value='Test' onclick="check_form('test');">
</form>
<script>
addToValidate('test','email', 'email', true, 'EMAIL');
addToValidate('test','name', '', true, 'NAME');
addToValidate('test','add', '', false, 'ADDRESS');
addToValidate('test','time', 'time', false, 'TIME');
addToValidate('test','date', 'date', true, 'DATE');
addToValidate('test','amount', 'numeric', false, 'AMOUNT');
</script>
