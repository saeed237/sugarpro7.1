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




if( !isset( $install_script ) || !$install_script ){
    die($mod_strings['ERR_NO_DIRECT_SCRIPT']);
}
// $mod_strings come from calling page.

$langDropDown = get_select_options_with_id($supportedLanguages, $current_language);

///////////////////////////////////////////////////////////////////////////////
////	START OUTPUT

$langHeader = get_language_header();
$out = <<<EOQ
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html {$langHeader}>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Style-Type" content="text/css">
   <title>{$mod_strings['LBL_WIZARD_TITLE']} {$mod_strings['LBL_TITLE_WELCOME']} {$setup_sugar_version} {$mod_strings['LBL_WELCOME_SETUP_WIZARD']}</title>
   <link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
   <link rel="stylesheet" href="install/install.css" type="text/css">
</head>

<body onload="javascript:document.getElementById('button_next2').focus();">
	<form action="install.php" method="post" name="form" id="form">
  <table cellspacing="0" cellpadding="0" border="0" align="center" class="shell">
  <tr><td colspan="2" id="help"><a href="{$help_url}" target='_blank'>{$mod_strings['LBL_HELP']} </a></td></tr>
    <tr>
			<th width="500">
		<p>
		<img src="{$sugar_md}" alt="SugarCRM" border="0">
		</p>
		{$mod_strings['LBL_TITLE_WELCOME']} {$setup_sugar_version} {$mod_strings['LBL_WELCOME_SETUP_WIZARD']}</th>

      <th width="200" height="30" style="text-align: right;"><a href="http://www.sugarcrm.com" target=
          "_blank"><IMG src="include/images/sugarcrm_login.png" alt="SugarCRM" border="0"></a>
      </th>
    </tr>
   <tr>
      <td colspan="2"  id="ready_image"><IMG src="include/images/install_themes.jpg" width="698" height="247" alt="Sugar Themes" border="0"></td>
    </tr>
                <td>
			    {$mod_strings['LBL_WELCOME_CHOOSE_LANGUAGE']}: <select name="language" onchange='this.form.submit()';>{$langDropDown}</select>
                </td>
                <td>
			    &nbsp;
                </td>
    </tr>

    <tr>
			<td align="right" colspan="2">
        <hr>
        <table cellspacing="0" cellpadding="0" border="0" class="stdTable">
          <tr>
                <td>
						    <input type="hidden" name="current_step" value="{$next_step}">
						</td>
					    <td>
					        <input class="button" type="submit" name="goto" value="{$mod_strings['LBL_NEXT']}" id="button_next2" />
			            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
	</form>
    <script>
        function showtime(div){

            if(document.getElementById(div).style.display == ''){
                document.getElementById(div).style.display = 'none';
                document.getElementById('adv_'+div).style.display = '';
                document.getElementById('basic_'+div).style.display = 'none';
            }else{
                document.getElementById(div).style.display = '';
                document.getElementById('adv_'+div).style.display = 'none';
                document.getElementById('basic_'+div).style.display = '';
            }

        }
    </script>
</body>
</html>
EOQ;
if (version_compare(phpversion(),'5.2.0') < 0) {
	if(empty($mod_strings['LBL_MINIMUM_PHP_VERSION'])){
		$mod_strings['LBL_MINIMUM_PHP_VERSION'] = 'Minimum Php version required is 5.2.1.';
	}

$php_verison_warning =<<<eoq
	    <table width="100%" cellpadding="0" cellpadding="0" border="0" class="Welcome">
			<tr>
		      <td colspan="2"  align="center" id="ready_image"><IMG src="include/images/install_themes.jpg" width="698" height="190" alt="Sugar Themes" border="0"></td>
		    </tr>
			<th colspan="2" align="center">
				<h1><span class='error'><b>{$mod_strings['LBL_MINIMUM_PHP_VERSION']}</b></span></h1>
			</th>
			<tr>
		      <td colspan="2" align="center" id="ready_image"><IMG src="include/images/install_themes.jpg" width="698" height="190" alt="Sugar Themes" border="0"></td>
		    </tr>
	</table>
eoq;
	$out = $php_verison_warning;
}
echo $out;
?>
