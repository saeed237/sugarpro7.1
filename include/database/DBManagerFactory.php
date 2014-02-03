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

/*********************************************************************************

* Description: This file generates the appropriate manager for the database
*
* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
* All Rights Reserved.
* Contributor(s): ______________________________________..
********************************************************************************/

require_once('include/database/DBManager.php');

/**
 * Database driver factory
 * @api
 * Instantiates and configures appropriate DB drivers
 */
class DBManagerFactory
{
    static $instances = array();

    /**
     * Returns a reference to the DB object of specific type
     *
     * @param  string $type DB type
     * @param array $config DB configuration
     * @return object DBManager instance
     */
    public static function getTypeInstance($type, $config = array())
    {
        global $sugar_config;

        if(empty($config['db_manager'])) {
            // standard types
            switch($type) {
                case "mysql":
                    if (empty($sugar_config['mysqli_disabled']) && function_exists('mysqli_connect')) {
                        $my_db_manager = 'MysqliManager';
                    } else {
                        $my_db_manager = "MysqlManager";
                    }
                    break;
                case "mssql":
                  	if ( function_exists('sqlsrv_connect')
                                && (empty($config['db_mssql_force_driver']) || $config['db_mssql_force_driver'] == 'sqlsrv' )) {
                        $my_db_manager = 'SqlsrvManager';
                    } elseif (self::isFreeTDS()
                                && (empty($config['db_mssql_force_driver']) || $config['db_mssql_force_driver'] == 'freetds' )) {
                        $my_db_manager = 'FreeTDSManager';
                    } else {
                        $my_db_manager = 'MssqlManager';
                    }
                    break;
                default:
                    $my_db_manager = self::getManagerByType($type, false);
                    if(empty($my_db_manager)) {
                        echo $type . "\n";
                        display_stack_trace();
                        $GLOBALS['log']->fatal("unable to load DB manager for: $type");
                        sugar_die("Cannot load DB manager");
                    }
            }
        } else {
            $my_db_manager = $config['db_manager'];
        }

        // sanitize the name
        $my_db_manager = preg_replace("/[^A-Za-z0-9_-]/", "", $my_db_manager);

        if(!empty($config['db_manager_class'])){
            $my_db_manager = $config['db_manager_class'];
        } else {
            SugarAutoLoader::requireWithCustom("include/database/{$my_db_manager}.php");
        }

        if(class_exists($my_db_manager)) {
            return new $my_db_manager();
        } else {
            return null;
        }
    }

    /**
	 * Returns a reference to the DB object for instance $instanceName, or the default
     * instance if one is not specified
     *
     * @param  string $instanceName optional, name of the instance
     * @return object DBManager instance
     */
	public static function getInstance($instanceName = '')
    {
        global $sugar_config;
        static $count = 0, $old_count = 0;
        if(empty($sugar_config['dbconfig'])) {
            return false;
        }
        //fall back to the default instance name
        if(empty($sugar_config['db'][$instanceName])){
        	$instanceName = '';
        }
        if(!isset(self::$instances[$instanceName])){
            $config = $sugar_config['dbconfig'];
            $count++;
                self::$instances[$instanceName] = self::getTypeInstance($config['db_type'], $config);
                if(!empty($sugar_config['dbconfigoption'])) {
                    self::$instances[$instanceName]->setOptions($sugar_config['dbconfigoption']);
                }
                self::$instances[$instanceName]->connect($config, true);
                self::$instances[$instanceName]->count_id = $count;
                self::$instances[$instanceName]->references = 0;
        } else {
            $old_count++;
            self::$instances[$instanceName]->references = $old_count;
        }
        return self::$instances[$instanceName];
    }

    /**
     * Disconnect all DB connections in the system
     */
    public static function disconnectAll()
    {
        foreach(self::$instances as $instance) {
            $instance->disconnect();
        }
        self::$instances = array();
    }


    /**
     * Get DB manager class name by type name
     *
     * For use in install
     * @param string $type
     * @param bool $validate Return only valid drivers or any?
     * @return string
     */
    public static function getManagerByType($type, $validate = true)
    {
        $drivers = self::getDbDrivers($validate);
        if(!empty($drivers[$type])) {
            return get_class($drivers[$type]);
        }
        return false;
    }

    /**
     * Scan directory for valid DB drivers
     * @param string $dir
     * @param array $drivers
     * @param bool $validate Return only valid drivers or all of them?
     */
    protected static function scanDriverDir($dir, &$drivers, $validate = true)
    {
        if(!is_dir($dir)) return;
        $scandir = opendir($dir);
        if($scandir === false) return;
        while(($name = readdir($scandir)) !== false) {
            if(substr($name, -11) != "Manager.php") continue;
            if($name == "DBManager.php") continue;
            require_once("$dir/$name");
            $classname = substr($name, 0, -4);
            if(!class_exists($classname)) continue;
            $driver = new $classname;
            if(!$validate || $driver->valid()) {
                if(empty($drivers[$driver->dbType])) {
                    $drivers[$driver->dbType]  = array();
                }
                $drivers[$driver->dbType][] = $driver;
            }
        }

    }

    /**
     * Compares two drivers by priority
     * @internal
     * @param object $a
     * @param object $b
     * @return int
     */
    public static function _compareDrivers($a, $b)
    {
        return $b->priority - $a->priority;
    }

    /**
     * Get list of all available DB drivers
     * @param bool $validate Return only valid drivers or all of them?
     * @return array List of Db drivers, key - variant (mysql, mysqli), value - driver type (mysql, mssql)
     */
    public static function getDbDrivers($validate = true)
    {
        $drivers = array();
        self::scanDriverDir("include/database", $drivers, $validate);
        self::scanDriverDir("custom/include/database", $drivers, $validate);

        $result = array();
        foreach($drivers as $type => $tdrivers) {
            if(empty($tdrivers)) continue;
            if(count($tdrivers) > 1) {
                usort($tdrivers, array(__CLASS__, "_compareDrivers"));
            }
            $result[$type] = $tdrivers[0];
        }
        return $result;
    }

    /**
     * Check if we have freeTDS driver installed
     * Invoked when connected to mssql. checks if we have freetds version of mssql library.
	 * the response is put into a global variable.
     * @return bool
     */
    public static function isFreeTDS()
    {
        static $is_freetds = null;

        if($is_freetds === null) {
    		ob_start();
    		phpinfo(INFO_MODULES);
    		$info=ob_get_contents();
    		ob_end_clean();

    		$is_freetds = (strpos($info,'FreeTDS') !== false);
        }

        return $is_freetds;
     }
}