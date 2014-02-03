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

require_once('vendor/Pear/Crypt_Blowfish/Blowfish.php');

function sugarEncode($key, $data){
	return base64_encode($data);
}


function sugarDecode($key, $encoded){
	$data = base64_decode($encoded);
	return $data;
}

///////////////////////////////////////////////////////////////////////////////
////	BLOWFISH
/**
 * retrives the system's private key; will build one if not found, but anything encrypted before is gone...
 * @param string type
 * @return string key
 */
function blowfishGetKey($type)
{
	$key = array();

	$type = str_rot13($type);

	$keyCache = "custom/blowfish/{$type}.php";

	// build cache dir if needed
	if(!file_exists('custom/blowfish')) {
		mkdir_recursive('custom/blowfish');
	}

	// get key from cache, or build if not exists
	if(file_exists($keyCache)) {
		include($keyCache);
	} else {
		// create a key
		$key[0] = create_guid();
		write_array_to_file('key', $key, $keyCache);
	}
	return $key[0];
}

/**
 * Uses blowfish to encrypt data and base 64 encodes it. It stores the iv as part of the data
 * @param STRING key - key to base encoding off of
 * @param STRING data - string to be encrypted and encoded
 * @return string
 */
function blowfishEncode($key, $data){
   	$bf = new Crypt_Blowfish($key);
	$encrypted = $bf->encrypt($data);
	return base64_encode($encrypted);
}

/**
 * Uses blowfish to decode data assumes data has been base64 encoded with the iv stored as part of the data
 * @param STRING key - key to base decoding off of
 * @param STRING encoded base64 encoded blowfish encrypted data
 * @return string
 */
function blowfishDecode($key, $encoded){
    $data = base64_decode($encoded);
	$bf = new Crypt_Blowfish($key);
	return trim($bf->decrypt($data));
}

?>