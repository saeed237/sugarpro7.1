<?php
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

define('PACKAGE_MANAGER_DOWNLOAD_SERVER', 'https://depot.sugarcrm.com/depot/');
define('PACKAGE_MANAGER_DOWNLOAD_PAGE', 'download.php');
class PackageManagerDownloader{

	/**
	 * Using curl we will download the file from the depot server
	 *
	 * @param session_id		the session_id this file is queued for
	 * @param file_name			the file_name to download
	 * @param save_dir			(optional) if specified it will direct where to save the file once downloaded
	 * @param download_sever	(optional) if specified it will direct the url for the download
	 *
	 * @return the full path of the saved file
	 */
	function download($session_id, $file_name, $save_dir = '', $download_server = ''){
		if(empty($save_dir)){
			$save_dir = "upload://";
		}
		if(empty($download_server)){
			$download_server = PACKAGE_MANAGER_DOWNLOAD_SERVER;
		}
		$download_server .= PACKAGE_MANAGER_DOWNLOAD_PAGE;
		$ch = curl_init($download_server . '?filename='. $file_name);
		$fp = sugar_fopen($save_dir . $file_name, 'w');
		curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID='.$session_id. ';');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		return $save_dir . $file_name;
	}
}
?>