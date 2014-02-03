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

class Administration extends SugarBean {
    var $settings;
    var $table_name = "config";
    var $object_name = "Administration";
    var $new_schema = true;
    var $module_dir = 'Administration';
    var $config_categories = array(
        // 'mail', // cn: moved to include/OutboundEmail
        'disclosure', // appended to all outbound emails
        'notify',
        'system',
        'portal',
        'proxy',
        'massemailer',
        'ldap',
        'captcha',
        'honeypot',
        'sugarpdf',
        'base',


        'license',

    );
    var $disable_custom_fields = true;
    var $checkbox_fields = Array("notify_send_by_default", "mail_smtpauth_req", "notify_on", 'skypeout_on', 'system_mailmerge_on', 'proxy_auth', 'proxy_on', 'system_ldap_enabled','captcha_on', 'honeypot_on');
    public $disable_row_level_security = true;

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function Administration()
    {
        self::__construct();
    }

    public function __construct() {
        parent::__construct();

        $this->setupCustomFields('Administration');
        $this->disable_row_level_security =true;
    }

    function retrieveSettings($category = false, $clean=false) {
        // declare a cache for all settings
        $settings_cache = sugar_cache_retrieve('admin_settings_cache');

        if($clean) {
            $settings_cache = array();
        }

        // Check for a cache hit
        if(!empty($settings_cache)) {
            $this->settings = $settings_cache;
            if (!empty($this->settings[$category]))
            {
                return $this;
            }
        }

        if ( ! empty($category) ) {
            $query = "SELECT category, name, value, platform FROM {$this->table_name} WHERE category = '{$category}'";
        } else {
            $query = "SELECT category, name, value, platform FROM {$this->table_name}";
        }

        $result = $this->db->query($query, true, "Unable to retrieve system settings");

        if(empty($result)) {
            return null;
        }

        while($row = $this->db->fetchByAssoc($result)) {
            if($row['category']."_".$row['name'] == 'ldap_admin_password' || $row['category']."_".$row['name'] == 'proxy_password')
                $this->settings[$row['category']."_".$row['name']] = $this->decrypt_after_retrieve($row['value']);
            else
                $this->settings[$row['category']."_".$row['name']] = $row['value'];
        }
        $this->settings[$category] = true;

        // outbound email settings
        $oe = new OutboundEmail();
        $oe->getSystemMailerSettings();

        foreach($oe->field_defs as $def) {
            if(strpos($def, "mail_") !== false)
                $this->settings[$def] = $oe->$def;
        }

        // At this point, we have built a new array that should be cached.
        sugar_cache_put('admin_settings_cache',$this->settings);
        return $this;
    }

    function saveConfig() {
        // outbound email settings
        $oe = new OutboundEmail();

        foreach($_POST as $key => $val) {
            $prefix = $this->get_config_prefix($key);
            if(in_array($prefix[0], $this->config_categories)) {
                if(is_array($val)){
                    $val=implode(",",$val);
                }
                $this->saveSetting($prefix[0], $prefix[1], $val);
            }
            if(strpos($key, "mail_") !== false) {
                if(in_array($key, $oe->field_defs)) {
                    $oe->$key = $val;
                }
            }
        }

        //saving outbound email from here is probably redundant, adding a check to make sure
        //smtpserver name is set.
        if (!empty($oe->mail_smtpserver)) {
            $oe->saveSystem();
        }

        $this->retrieveSettings(false, true);
    }

    /**
     * @param string $category      Category for the config value
     * @param string $key           Key for the config value
     * @param string $value         Value of the config param
     * @param string $platform      Which platform this belongs to (API use only, If platform is empty it will not be returned in the API calls)
     * @return int                  Number of records Returned
     */
    public function saveSetting($category, $key, $value, $platform = '') {
        // platform is always lower case
        $platform = strtolower($platform);
        if (empty($platform)) {
            $result = $this->db->query("SELECT count(*) AS the_count FROM config WHERE category = '{$category}' AND name = '{$key}' AND (platform = '{$platform}' OR platform IS NULL)");
        } else {
            $result = $this->db->query("SELECT count(*) AS the_count FROM config WHERE category = '{$category}' AND name = '{$key}' AND platform = '{$platform}'");
        }
        $row = $this->db->fetchByAssoc($result);
        $row_count = $row['the_count'];

        if($category."_".$key == 'ldap_admin_password' || $category."_".$key == 'proxy_password')
            $value = $this->encrpyt_before_save($value);

        if( $row_count == 0){
            $result = $this->db->query("INSERT INTO config (value, category, name, platform) VALUES ('$value','$category', '$key', '$platform')");
        }
        else{
            if (empty($platform)) {
                $result = $this->db->query("UPDATE config SET value = '{$value}' WHERE category = '{$category}' AND name = '{$key}' AND (platform = '{$platform}' OR platform IS NULL)");
            } else {
                $result = $this->db->query("UPDATE config SET value = '{$value}' WHERE category = '{$category}' AND name = '{$key}' AND platform = '{$platform}'");
            }
        }
        sugar_cache_clear('admin_settings_cache');

        // check to see if category is a module
        if(!empty($platform)) {
            // we have an api call so lets clear out the cache for the module + platform
            global $moduleList;
            if(in_array($category, $moduleList)) {
                $cache_key = "ModuleConfig-" . $category;
                if($platform != "base")  {
                    $cache_key .= $platform;
                }
                sugar_cache_clear($cache_key);
            }
        }

        return $result;
    }

    /**
     * Return the config for a specific module.
     *
     * @param string $module        The module we are wanting to get the config for
     * @param string $platform      The platform we want to get the data back for
     * @param boolean $clean        Get clean copy of module config
     * @return array
     */
    public function getConfigForModule($module, $platform = 'base', $clean = false) {
        // platform is always lower case
        $platform = strtolower($platform);

        $cache_key = "ModuleConfig-" . $module;
        if($platform != "base")  {
            $cache_key .= $platform;
        }

        if($clean){
            sugar_cache_clear($cache_key);
        } else {
            // try and see if there is a cache for this
            $moduleConfig = sugar_cache_retrieve($cache_key);

            if(!empty($moduleConfig)) {
                return $moduleConfig;
            }
        }

        $sql = "SELECT name, value FROM config WHERE category = '{$module}'";
        if($platform != "base") {
            // if the platform is not base, we need to order it so the platform we are looking for overrides any base values
            $sql .= "and platform in ('base', '{$platform}') ORDER BY CASE WHEN platform='base' THEN 0
                        WHEN platform='{$platform}' THEN 1 ELSE 2 END ASC";
        } else {
            $sql .= " and platform = '{$platform}'";
        }

        $result = $this->db->query($sql);

        $moduleConfig = array();
        while($row = $this->db->fetchByAssoc($result)) {
            $moduleConfig[$row['name']] = $this->decodeConfigVar($row['value']);
        }

        if(!empty($moduleConfig)) {
            sugar_cache_put($cache_key, $moduleConfig);
        }

        return $moduleConfig;
    }

    function get_config_prefix($str) {
        return Array(substr($str, 0, strpos($str, "_")), substr($str, strpos($str, "_")+1));
    }

    /**
     * Get the full config table as an associative array
     *
     * @return array
     */
    public function getAllSettings()
    {
        $sql = "SELECT category, name, value, platform FROM {$this->table_name}";
        $rows = $this->db->query($sql);

        $return = array();
        while($row = $this->db->fetchByAssoc($rows)) {
            $row['value'] = $this->decodeConfigVar($row['value']);
            $return[] = $row;
        }

        return $return;
    }

    /**
     * @param string $var
     * @return string
     * decode the config var
     */
    protected function decodeConfigVar($var)
    {
        $var = html_entity_decode(stripslashes($var));
        // make sure the value is not null and the length is greater than 0
        if (!is_null($var) && strlen($var) > 0) {
            // if it's not numeric, then lets run the json_decode on it
            if (!is_numeric($var)) {
                $decoded = json_decode($var, true);
                // if we didn't get a json error, then put the decoded value as the value we want to return
                if(json_last_error() == JSON_ERROR_NONE) {
                    $var = $decoded;
                }
            // if it's a numeric value and all the string only contains digits, the convert it to an integer
            } elseif (is_numeric($var) && ctype_digit($var)) {
                $var = intval($var);
            }
        }
        return $var;
    }

    /**
     * Return Administration object with filled in settings
     * @param string $category
     * @param bool $clean
     * @return Administration
     */
    public static function getSettings($category = false, $clean=false)
    {
        $admin = BeanFactory::getBean('Administration');
        $admin->retrieveSettings($category, $clean);
        return $admin;
    }

    /**
     * Check if the Bean Implements anything special
     * @param $interface 
     * @return bool
     */
    public function bean_implements($interface)
    {
        switch($interface){
            case 'ACL':return true;
        }
        return false;
    }    
}

