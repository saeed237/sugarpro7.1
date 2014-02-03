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

<div align='center' style='background:lightgray'>
<h3 style='color:red'>Possible Cross Site Request Forgery (XSRF) Attack Detected</h3>
<h4>If you think this is a mistake please ask your administrator to add the following site to the acceptable referer list</h4>
<h3>{$host}</h3>
<h4><a href='javascript:void(0);' onclick='document.getElementById("directions").style.display="";'>Click here for directions to add this site to the acceptable referer list</a></h4>
</div>
<div id='directions' style='display:none'>
	<h3>Directions:</h3>
	<ol>
		<li>On your file system go to the root of your SugarCRM instance
		<li>Open the file config_override.php. If it does not exist, create it. (it should be at the same level as index.php and config.php)
		<li>Make sure the file starts with <pre>&lt;?php</pre> followed by a new line
		<li>Add the following line to your config_override.php file<br> <pre>$sugar_config['http_referer']['list'][] = '{$host}';</pre>
		<li>Save the file and it should work
	</ol>
	<h3>Attempted action ({$action}):</h3>
	If you feel this is a valid action that should be allowed from any referer, add the following to your config_override.php file
	<ul><li><pre>$sugar_config['http_referer']['actions'] =array( {$whiteListString} ); </pre></ul>
</div>
