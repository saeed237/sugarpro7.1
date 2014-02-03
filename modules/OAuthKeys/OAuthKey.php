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


require_once 'vendor/Zend/Oauth/Provider.php';

/**
 * OAuth customer key
 */
class OAuthKey extends Basic
{
	public $module_dir = 'OAuthKeys';
	public $object_name = 'OAuthKey';
	public $table_name = 'oauth_consumer';
	public $c_key;
	public $c_secret;
	public $name;
	public $disable_row_level_security = true;

	static public $keys_cache = array();

	/**
	 * Get record by consumer key
	 * @param string $key
     * @param string $oauth_type Either "oauth1" or "oauth2", defaults to "oauth1"
	 * @return OAuthKey|false
	 */
	public function getByKey($key,$oauth_type="oauth1")
	{
	    $this->retrieve_by_string_fields(array("c_key" => $key,"oauth_type"=>$oauth_type));
	    if(empty($this->id)) return false;
	    // need this to decrypt the key
        $this->check_date_relationships_load();
	    return $this;
	}

	/**
	 * Fetch customer key by id
	 * @param string $key
     * @param string $oauth_type Either "oauth1" or "oauth2", defaults to "oauth1"
	 * @return OAuthKey|false
	 */
	public static function fetchKey($key,$oauth_type="oauth1")
	{
	    if(isset(self::$keys_cache[$key])&&self::$keys_cache[$key]->oauth_type==$oauth_type) {
	        return self::$keys_cache[$key];
	    }
	    $k = new self();
	    if($k->getByKey($key,$oauth_type)) {
	        self::$keys_cache[$key] = $k;
	        BeanFactory::registerBean("OAuthKeys", $k);
	        return $k;
	    }
	    return false;
	}

	/**
	 * Delete the key
	 * also removed all tokens
	 */
	public function mark_deleted($id)
	{
	    $this->db->query("DELETE from {$this->table_name} WHERE id='".$this->db->quote($id)."'");
	    $this->db->query("DELETE from oauth_tokens WHERE consumer='".$this->db->quote($id)."'");
	}

}
