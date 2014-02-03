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


/**
 * Class allows us to use XHprof for profiling
 * To enable profiling you should add next properties to config_override.php
 *
 * @see SugarXHprof::$enable            for $sugar_config['xhprof_config']['enable']
 * @see SugarXHprof::$manager           for $sugar_config['xhprof_config']['manager']
 * @see SugarXHprof::$log_to            for $sugar_config['xhprof_config']['log_to']
 * @see SugarXHprof::$sample_rate       for $sugar_config['xhprof_config']['sample_rate']
 * @see SugarXHprof::$ignored_functions for $sugar_config['xhprof_config']['ignored_functions']
 * @see SugarXHprof::$flags             for $sugar_config['xhprof_config']['flags']
 *
 * To run profiler you should call SugarXHprof::getInstance()->start();
 * To stop profiler you should call SugarXHprof::getInstance()->end();
 * 'start' method registers 'end' method as shutdown function because of it call of 'end' method is unnecessary if you want profile all calls
 * Also 'start' method is called automatically in entryPoint.php file
 *
 * Names of generated files are prefix.microtime.module.action for modules and prefix.microtime.'entryPoint'.entryPoint for entry points
 * If you want to see reports you should install https://github.com/facebook/xhprof to some directory and run it as http://your.domain/path2xhprof/xhprof_html/?run=prefix.microtime&source=module.action
 * For 507bf986e44d9.1350302086.9285.Leads.listview.xhprof file url will be look like http://your.domain/path2xhprof/xhprof_html/?run=507bf986e44d9.1350302086.9285&source=Leads.listview
 *
 * If you want to customize SugarXHprof you should create file in custom/include/SugarXHprof/ folder and name file as name of your custom class
 * Change $sugar_config['xhprof_config']['manager'] to be name of your custom class
 * Custom class has to extend from SugarXHprof
 * If custom class doesn't exist or doesn't extend from SugarXHprof then SugarXHprof be used
 */
class SugarXHprof
{
    /**
     * @var SugarXHprof instance of profiler
     */
    protected static $instance = null;

    /**
     * Because of unregister_shutdown_function is not present in php we have to skip calls of 'end' method if that property equals to false
     *
     * @var bool is shutdown function registered or not
     */
    protected $registered = false;

    /**
     * @var bool enable profiler or not, it will be disabled by some reasons
     * @see SugarXHprof::loadConfig()
     */
    protected static $enable = false;

    /**
     * @var string class of manager for customization, has to extend from SugarXHprof class
     */
    protected static $manager = __CLASS__;

    /**
     * @var string path to directory for logs, if log_to is empty then xhprof.output_dir be used
     */
    protected static $log_to = '';

    /**
     * @var int where value is a number and 1/value requests are profiled. So to sample all requests set it to 1
     */
    protected static $sample_rate = 10;

    /**
     * @var array array of function names to ignore from the profile (pass into xhprof_enable)
     */
    protected static $ignored_functions = array();

    /**
     * @var int flags for xhprof
     * @see http://www.php.net/manual/xhprof.constants.php
     */
    protected static $flags = 0;

    /**
     * Populates configuration from $sugar_config to self properties
     */
    protected static function loadConfig()
    {
        if (!empty($GLOBALS['sugar_config']['xhprof_config']))
        {
            foreach($GLOBALS['sugar_config']['xhprof_config'] as $k => $v)
            {
                if (isset($v) && property_exists(__CLASS__, $k))
                {
                    self::${$k} = $v;
                }
            }
        }

        // disabling profiler if XHprof extension is not loaded
        if (extension_loaded('xhprof') == false)
        {
            self::$enable = false;
        }

        // using default directory for profiler if it is not set
        if (empty(self::$log_to))
        {
            self::$log_to = ini_get('xhprof.output_dir');
        }

        // disabling profiler if directory is not exist or is not writable
        if (is_dir(self::$log_to) == false || is_writable(self::$log_to) == false)
        {
            self::$enable = false;
        }
    }

    /**
     * Tries to load custom profiler. If it doesn't exist then use itself
     *
     * @return SugarXHprof
     */
    public static function getInstance()
    {
        if (self::$instance != null)
        {
            return self::$instance;
        }

        self::loadConfig();

        if (is_file('custom/include/SugarXHprof/' . self::$manager . '.php'))
        {
            require_once 'custom/include/SugarXHprof/' . self::$manager . '.php';
        }
        elseif (is_file('include/SugarXHprof/' . self::$manager . '.php'))
        {
            require_once 'include/SugarXHprof/' . self::$manager . '.php';
        }
        if (class_exists(self::$manager) && is_subclass_of(self::$manager, __CLASS__))
        {
            self::$instance = new self::$manager();
        }
        else
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Method tries to detect entryPoint, service, module & action and returns it as string
     *
     * @return string action
     */
    static public function detectAction()
    {
        $action = '';

        // index.php
        if (!empty($GLOBALS['app']) && $GLOBALS['app'] instanceof SugarApplication && $GLOBALS['app']->controller instanceof SugarController)
        {
            if (!empty($_REQUEST['entryPoint']))
            {
                if (!empty($GLOBALS['app']->controller->entry_point_registry) && !empty($GLOBALS['app']->controller->entry_point_registry[$_REQUEST['entryPoint']]))
                {
                    $action .= '.entryPoint.' . $_REQUEST['entryPoint'];
                }
                else
                {
                    $action .= '.entryPoint.unknown';
                }
            }
            else
            {
                $action .= '.' . $GLOBALS['app']->controller->module . '.' . $GLOBALS['app']->controller->action;
            }
        }
        // soap.php
        elseif (!empty($GLOBALS['server']) && $GLOBALS['server'] instanceof soap_server)
        {
            if ($GLOBALS['server']->methodname)
            {
                $action .= '.soap.' . $GLOBALS['server']->methodname;
            }
            else
            {
                $action .= '.soap.wsdl';
            }
        }
        // service soap
        elseif (!empty($GLOBALS['service_object']) && $GLOBALS['service_object'] instanceof SugarSoapService)
        {
            $action .= '.soap.' . $GLOBALS['service_object']->getRegisteredClass();
            if ($GLOBALS['service_object']->getServer() instanceof soap_server)
            {
                if ($GLOBALS['service_object']->getServer()->methodname)
                {
                    $action .= '.' . $GLOBALS['service_object']->getServer()->methodname;
                }
                else
                {
                    $action .= '.wsdl';
                }
            }
            else
            {
                $action .= '.unknown';
            }
        }
        // service rest
        elseif (!empty($GLOBALS['service_object']) && $GLOBALS['service_object'] instanceof SugarRestService)
        {
            $action .= '.rest.' . $GLOBALS['service_object']->getRegisteredImplClass();
            if (!empty($_REQUEST['method']) && method_exists($GLOBALS['service_object']->implementation, $_REQUEST['method']))
            {
                $action .= '.' . $_REQUEST['method'];
            }
            elseif (empty($_REQUEST['method']))
            {
                $action .= '.index';
            }
            else
            {
                $action .= '.unknown';
            }
        }
        // unknown
        else
        {
            $action .= '.' . basename($_SERVER['SCRIPT_FILENAME']);
        }

        return $action;
    }

    /**
     * Tries to enabled xhprof if all settings were passed
     */
    public function start()
    {
        if (self::$enable == false)
        {
            return;
        }

        if (self::$sample_rate == 0)
        {
            return;
        }

        $rate = 1 / self::$sample_rate * 100;
        if (rand(0, 100) > $rate)
        {
            return;
        }

        register_shutdown_function(array(
            $this,
            'end'
        ));
        $this->registered = true;

        xhprof_enable(self::$flags, array(
            'ignored_functions' => self::$ignored_functions
        ));
    }

    /**
     * Tries to collect data from XHprof after call of 'start' method
     */
    public function end()
    {
        if ($this->registered == false)
        {
            return;
        }
        $this->registered = false;

        if (self::$enable == false)
        {
            return;
        }

        $data = xhprof_disable();
        $namespace = microtime(1) . self::detectAction();

        require_once 'include/SugarXHprof/xhprof_lib/utils/xhprof_runs.php';
        $xhprof_runs = new XHProfRuns_Default(self::$log_to);
        $xhprof_runs->save_run($data, $namespace);
    }
}
