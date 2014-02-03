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

global $soapclient, $soap_server;
if($sync_module_index == -1){
	$current_step = 0;
	$module_steps = 4;
	global $timedate;
		echo '<table width="100%" class="edit view"><tr><td width="50%" valign="top">';
		echo  get_form_header(translate('LBL_SYNC_SETUP','Sync') ,'',false);
		display_progress_bar('sync_setup', $current_step , $module_steps);
		echo '<br>';


		echo '<div id="records_progress_div" style="display:inline">';
		display_flow_bar('file_update', .5);



		echo '</div></td><td><div id = "current_substatus">&nbsp;<div><br><input type="button" name="stop_sync_btn" id="stop_sync_btn" class="button" value="Stop Sync" onclick="window.close();"></td></tr></table>';
		echo '<table width="100%"><tr><td colspan="2" id="current_msg"  valign="top"><div id="show_conflict_div">&nbsp;<div></td></tr></table>';
		echo '<div id="current_status">&nbsp;</div>';
}
if($sync_module_index == -1)add_to_msg("Logging Into Server...");
	$result = $soapclient->call('login',array('user_auth'=>sync_get_user_auth_data(), 'application_name'=>'MobileClient'));

	if(!has_error($result)){
		$session = $result['id'];
		$_SESSION['sync_session'] = $session;
                //ensure that this system has not been disabled
                global $sugar_config;
                global $sugar_flavor;
                global $sugar_version;

                $soapclient->setHeaders('sugar_version='.$sugar_version);
                $result = $soapclient->call('get_system_status', array('session'=>$session, 'unique_key'=>$sugar_config['unique_key']));

				if(!has_error($result) && $result['id'] == 0){
                    $result = $soapclient->call('get_sugar_flavor', array());

                    if(!has_error($result) && $result == $sugar_flavor){
				        if($sync_module_index == -1){
					       add_to_msg('Updating Files -<b>Please Wait</b>- <br><br>');
					       $current_step++;
					       update_progress_bar('sync_setup', $current_step , $module_steps);

					       if(isset($_REQUEST['new_sync']) ){

					       // run the file sync
	    			        require_once( "include/utils/disc_client_utils.php" );
	    			        $from_sync_client = true;

                            //before we do a file sync we need to install any necessary upgrades
                            $upgrade_applied = get_required_upgrades($soapclient, $session);

	   				        $results = disc_client_get_zip( $soapclient, $session, true, 0, $upgrade_applied);
	   				        $_REQUEST['do_action']='execute';
	   				        $_REQUEST['repair_silent'] = true;
                             $current_user->is_admin = 1;
                                                        echo "<div id='rrresult'></div>
                                <script>
                                var xmlhttp=false;
                                /*@cc_on @*/
                                /*@if (@_jscript_version >= 5)
                                // JScript gives us Conditional compilation, we can cope with old IE versions.
                                // and security blocked creation of the objects.
                                 try {
                                  xmlhttp = new ActiveXObject(\"Msxml2.XMLHTTP\");
                                 } catch (e) {
                                  try {
                                   xmlhttp = new ActiveXObject(\"Microsoft.XMLHTTP\");
                                  } catch (E) {
                                   xmlhttp = false;
                                  }
                                 }
                                @end @*/
                                if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
                                    try {
                                        xmlhttp = new XMLHttpRequest();
                                    } catch (e) {
                                        xmlhttp = false;
                                    }
                                }
                                if (!xmlhttp && window.createRequest) {
                                    try {
                                        xmlhttp = window.createRequest();
                                    } catch (e) {
                                        xmlhttp = false;
                                    }
                                }
                                xmlhttp.onreadystatechange = function() {
                                            if(xmlhttp.readyState == 4) {
                                              document.getElementById('rrresult').innerHTML = xmlhttp.responseText;
                                            }
                                          }
                                xmlhttp.open('GET', 'index.php?module=Sync&action=OfflineClientRepair', true);
                                xmlhttp.send(null);
                                </script>";
                            //rebuild

                            echo "<div id='rrresult'></div>
                                <script>
                                var xmlhttp=false;
                                /*@cc_on @*/
                                /*@if (@_jscript_version >= 5)
                                // JScript gives us Conditional compilation, we can cope with old IE versions.
                                // and security blocked creation of the objects.
                                 try {
                                  xmlhttp = new ActiveXObject(\"Msxml2.XMLHTTP\");
                                 } catch (e) {
                                  try {
                                   xmlhttp = new ActiveXObject(\"Microsoft.XMLHTTP\");
                                  } catch (E) {
                                   xmlhttp = false;
                                  }
                                 }
                                @end @*/
                                if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
                                    try {
                                        xmlhttp = new XMLHttpRequest();
                                    } catch (e) {
                                        xmlhttp = false;
                                    }
                                }
                                if (!xmlhttp && window.createRequest) {
                                    try {
                                        xmlhttp = window.createRequest();
                                    } catch (e) {
                                        xmlhttp = false;
                                    }
                                }
                                xmlhttp.onreadystatechange = function() {
                                            if(xmlhttp.readyState == 4) {
                                              document.getElementById('rrresult').innerHTML = xmlhttp.responseText;
                                            }
                                          }
                                xmlhttp.open('GET', 'index.php?module=Administration&action=RebuildRelationship&to_pdf=true', true);
                                xmlhttp.send(null);
                                </script>";


                                require_once('ModuleInstall/ModuleInstaller.php');
                                $mi = new ModuleInstaller();
                                $mi->rebuild_all(true);
								$current_user->is_admin = 0;

                                $db = &DBManagerFactory::getInstance();
                                $query = "DELETE FROM versions WHERE name='Rebuild Extensions'";
                                $db->query($query);

                                // insert a new database row to show the rebuild extensions is done
                                $id = create_guid();
                                $gmdate = TimeDate::getInstance()->nowDb();
                                $date_entered = db_convert("'$gmdate'", 'datetime');
                                $query = 'INSERT INTO versions (id, deleted, date_entered, date_modified, modified_user_id, created_by, name, file_version, db_version) '
                                    . "VALUES ('$id', '0', $date_entered, $date_entered, '1', '1', 'Rebuild Extensions', '4.0.0', '4.0.0')";
                                $db->query($query);

	   				            $current_step++;
					            update_progress_bar('sync_setup', $current_step , $module_steps);

					            add_to_msg('Done updating files<br>');
	   				            add_to_msg('Updating User Information<br>');
	   				            $current_step++;
					            update_progress_bar('sync_setup', $current_step , $module_steps);
					            sync_users($soapclient, $session, $_REQUEST['clean_sync']);
	   				            $current_step++;
					            update_progress_bar('sync_setup', $current_step , $module_steps);
	   				            add_to_msg('Done Updating User Information<br>');
					       }//end new sync
					       destroy_flow_bar('file_update');
					       echo '<script>document.location.href = "index.php?&action=Popup&module=Sync&sync_module_index=0&new_sync=true&clean_sync='. $_REQUEST['clean_sync'] . '&global_accept_server='. $_REQUEST['global_accept_server'] . '";</script>';
					       die();
				        }
                }else{
                        add_to_msg('Server and Client must both be running the same flavor of Sugar.');
                    }
                }else{
                    add_to_msg('Your Offline Client instance has been disabled by your administrator');
                }

	}else{
		add_to_msg('Failed to Login<br>');
	}


?>
