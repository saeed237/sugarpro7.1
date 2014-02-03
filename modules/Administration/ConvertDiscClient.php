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

set_time_limit(3600);
ini_set('default_socket_timeout', 360);
function ConvertDiscClient(){

    global $sugar_config;
    global $app_strings;
    global $app_list_strings;
    global $mod_strings;

    $xtpl=new XTemplate ('modules/Administration/ConvertDiscClient.html');
    $xtpl->assign("MOD", $mod_strings);
    $xtpl->assign("APP", $app_strings);

    echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_MODULE_NAME'],$mod_strings['LBL_UPGRADE_CONVERT_DISC_CLIENT_TITLE']), false);

    require_once('vendor/nusoap//nusoap.php');

    $errors = array();

    $server_url = "http://";
    $user_name  = "";
    $admin_name  = "";
    $password   = "";

    // run options are: convert, sync
    // default behavior of this page
    $run = "convert";
    if( isset( $_REQUEST['run'] ) ){
        $run = $_REQUEST['run'];
    }

    if( $run == "convert" ){
        if( isset($_REQUEST['server_url']) ){
            $server_url = $_REQUEST['server_url'];
            if( $server_url == "" ){
                $errors[] = $mod_strings['LBL_CONVERT_DISC_CLIENT_SERVER_URL_EMPTY_ERROR'];
            }
        }
    }
    else if( $run == "sync" ){
        $server_url = $sugar_config['sync_site_url'];
    }

    if( isset($_REQUEST['user_name']) ){
        $user_name = $_REQUEST['user_name'];
        if( $user_name == "" ){
            $errors[] = $mod_strings['LBL_CONVERT_DISC_CLIENT_USER_NAME_EMPTY_ERROR'];
        }
    }
    if( isset($_REQUEST['password']) ){
        if( $_REQUEST['password'] == "" ){
            $errors[] = $mod_strings['LBL_CONVERT_DISC_CLIENT_PASSWORD_EMPTY_ERROR'];
        }
    }
     if( isset($_REQUEST['admin_name']) ){
     	$admin_name = $_REQUEST['admin_name'];
        if( $_REQUEST['admin_name'] == "" ){
            $errors[] = $mod_strings['LBL_CONVERT_DISC_CLIENT_ADMIN_NAME_EMPTY'];
        }
    }

    if( $run == "convert" ){
        if( !is_writable( "config.php" ) ){
            $errors[] = $mod_strings['LBL_CONVERT_DISC_CLIENT_CONFIG_WRITABLE_ERROR'];
        }
    }

    if( isset( $_REQUEST['submitted'] ) && sizeof( $errors ) == 0 ){
          if(empty($server_url) || $server_url == 'http://'){
        	 $errors[] = $mod_strings['LBL_CONVERT_DISC_CLIENT_SERVER_URL_REQUIRED'];
        }else{

        $soapclient = new nusoapclient( "$server_url/soap.php" );
        $soapclient->response_timeout = 360;
		if($soapclient->call('is_loopback', array())){
			$errors[] = $mod_strings['LBL_CONVERT_DISC_CLIENT_SERVER_CLIENT_IP_ERROR'];
		}
		if(!$soapclient->call('offline_client_available', array())){
			$errors[] = $mod_strings['LBL_CONVERT_DISC_CLIENT_NO_LICENSE'];
		}
        $result = $soapclient->call( 'login', array('user_auth'=>array('user_name'=>$admin_name,'password'=>md5($_REQUEST['password']), 'version'=>'.01'), 'application_name'=>'Disconnected Client Setup'));
        if( $soapclient->error_str ){
            $errors[] = $mod_strings['LBL_CONVERT_DISC_CLIENT_LOGIN_FAILED_ERROR'] . $soapclient->error_str;
        }

        if( $result['error']['number'] != 0 ){
        	 $errors[] = $mod_strings['LBL_CONVERT_DISC_CLIENT_LOGIN_FAILED_ERROR'] . $result['error']['name'] . ' ' . $result['error']['description'];
        }

        $session = $result['id'];
        if(empty($errors)){
            $data = array($user_name);
        	$result = $soapclient->call( 'sudo_user', array('session'=>$session, 'user_name'=>$user_name));
         if( $soapclient->error_str ){
            $errors[] = string_format($mod_strings['LBL_CONVERT_DISC_CLIENT_SWITCH_TO_USER_ERROR'], $data) . $soapclient->error_str;
        }

        if(isset($result['error']) &&  $result['error']['number'] != 0 ){
        	 $errors[] = string_format($mod_strings['LBL_CONVERT_DISC_CLIENT_SWITCH_TO_USER_ERROR'], $data) . $result['error']['name'] . ' ' . $result['error']['description'];

        }
        }
          }
		 $errorString = "";
		 if(!empty($errors)){
	   		 foreach( $errors as $error ){
	      		 $errorString .= $error . "<br>" ;
	  		  }
		 }
  		  echo '<font color="red"> ' . $errorString . '</font>';

        if( $session  && empty($errors)){
            if( $run == "convert" ){
                // register this client/user with server

                // update local config.php file
                $sugar_config['disc_client']    = true;
                $sugar_config['sync_site_url']  = $server_url;

               	//attempt to obtain the system_id from the server
        		$result = $soapclient->call('get_unique_system_id', array('session'=>$session, 'unique_key'=>$sugar_config['unique_key']));
         		if( $soapclient->error_str ){
            		$errors[] = $mod_strings['LBL_CONVERT_DISC_CLIENT_UNIQUE_SYSTEM_ID_ERROR'] . $soapclient->error_str;
        		}
        		else{

					$admin = BeanFactory::getBean('Administration');
					$system_id = $result['id'];
					if(!isset($system_id)){
						$system_id = 1;
					}
					$admin->saveSetting('system', 'system_id', $system_id);
        		}
            }

            // run the file sync
            require_once( "include/utils/disc_client_utils.php" );
            disc_client_file_sync( $soapclient, $session, true );

            // data sync triggers

            require_once("modules/Sync/SyncHelper.php");
            sync_users($soapclient, $session, true);
             ksort( $sugar_config );
			echo $mod_strings['LBL_CONVERT_DISC_CLIENT_UPDATE_LOCAL_INFO'];
             if( !write_array_to_file( "sugar_config", $sugar_config, "config.php" ) ){
                   $xtpl->assign("COMPLETED_MESSAGE", $mod_strings['LBL_CONVERT_DISC_CLIENT_CONFIG_WRITABLE_AGAIN_ERROR'] );
                   $xtpl->parse("main.complete");
                   return;
                }
			 	echo $mod_strings['LBL_CONVERT_DISC_CLIENT_DONE_LOGOUT'] . '<script> function logout_countdown(left){document.getElementById("seconds_left").innerHTML = left; if(left == 0){document.location.href = "index.php?module=Users&action=Logout";}else{left--; setTimeout("logout_countdown("+ left+")", 1000)}};setTimeout("logout_countdown(10)", 1000)</script>';
            // done with soap calls
            $result = $soapclient->call( 'logout', array('session'=>$session) );

            $xtpl->assign("COMPLETED_MESSAGE", $mod_strings['LBL_CONVERT_DISC_CLIENT_SYNC_COMPLETE'] );
            $xtpl->parse("main.complete");

            return;
        }
    }

    $errorString = "";
    foreach( $errors as $error ){
       $errorString .= $error . "<br>" ;
    }

    if(!empty($errorString)){
         $xtpl->assign("COMPLETED_MESSAGE", $errorString);
         $xtpl->parse("main.complete");
    }

    if( ($run == "convert") && isset($sugar_config['disc_client']) && $sugar_config['disc_client'] == true ){
        $xtpl->parse("main.existing");
    }
    else{
        if( $run == "convert" ){

            $xtpl->assign("SERVER_URL",$server_url);
        }
            $xtpl->assign("USER_NAME", $user_name);
             $xtpl->assign("ADMIN_NAME", $admin_name);
            $xtpl->assign("SUBMITTTED", "true");
            $xtpl->assign("RUN", $run);

        if( $run == "convert" ){
            $xtpl->assign("SUBMIT_MESSAGE", $mod_strings['LBL_CONVERT_DISC_CLIENT_SUBMIT']);
        }
        else if( $run == "sync" ){
            $xtpl->assign("SUBMIT_MESSAGE", $mod_strings['LBL_CONVERT_DISC_CLIENT_SYNC_SUBMIT'] );
        }
       $xtpl->parse("main.convert");
    }
     $xtpl->parse("main");
     $xtpl->out("main");
} // end of function ConvertDiscClient

ConvertDiscClient();

?>
