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
<script>
	function addToDescription(form, name, value){
			form.description.value += '--' + name + "=" + value+ "--"
	}
</script>
<form name='leadcap' action='../index.php?entryPoint=leadCapture' method='post'>
	<input type='hidden' name='lead_source' value='Web Site'>
	<input type='hidden' name='user' value='cheeto'>
	<input type='hidden' name='description' value=''>
	<input type='hidden' name='redirect' value='http://localhost/sugarcrm/examples/FormValidationTest.php'>
	<div align='center'>
	Please fill out this form so we can better server your game playing and food eating needs. It will redirect you to the form validation test.
	<table border=1><tr><td><table>
	<tr><td>First Name:</td><td><input type='text' name='first_name'></td></tr>
	<tr><td>Last Name:</td><td><input type='text' name='last_name'></td></tr>
	<tr><td>Company Name:</td><td><input type='text' name='account_name'></td></tr>
	<tr><td>Title:</td><td><input type='text' name='title'></td></tr>
	<tr><td>Favorite Game:</td><td><select name='game'>
		<option value='monopoly'> Monopoly</option>
		<option value='uno'> UNO</option>
		<option value='sorry'> Sorry</option>
		<option value='Checkers'> Checkers</option>
	</select></td></tr>
	<tr><td>Favorite Food:</td><td><select name='food'>
		<option value='pizza'> Pizza</option>
		<option value='hamburger'> Hamburger</option>
		<option value='candy'> Candy </option>
		<option value='icecream'> Ice Cream</option>
	</select></td></tr>

	<tr><td></td><td><input type='Submit' name='submit' value='Submit' onclick='addToDescription(document.leadcap,"Favorite Food", document.leadcap.food.options[document.leadcap.food.selectedIndex].text);addToDescription(document.leadcap,"Favorite Game", document.leadcap.game.options[document.leadcap.game.selectedIndex].text);' ></td></tr></table></table>
</form>