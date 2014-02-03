<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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


/**
 * Provide application specific logic to the session object.
 * @api
 */
class SugarSession{
	private static $_instance;
	public static $sessionId;

	/**
	 * When constructing the session object, be sure to check if the session_id() already exists as is the case of session.auto_start = 1
	 *
	 */
	public function __construct(){

	}

	public function setSessionId($sessionId){
		self::$sessionId = session_id($sessionId);
	}

	public function start(){
		$session_id = session_id();
		if(empty($session_id)){
			session_start();
			self::$sessionId = session_id();
		}else{
			self::$sessionId = $session_id;
		}
	}

	public static function getInstance(){
		if(!isset(self::$_instance)){
			$className = __CLASS__;
			self::$_instance = new $className();
		}

		return self::$_instance;
	}

	public function destroy(){
		foreach ($_SESSION as $var => $val) {
        	$_SESSION[$var] = null;
        }
		session_destroy();
	}

	public function __clone(){

	}

	public function __get($var){
		return (!empty($_SESSION[$var]) ? $_SESSION[$var] : '');
	}

	public function __set($var, $val){
		return ($_SESSION[$var] = $val);
	}

	public function __destruct(){
		session_write_close();
	}
}
?>