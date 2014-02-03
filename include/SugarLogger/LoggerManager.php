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
 * Log management
 * @api
 */
class LoggerManager
{
	//this the the current log level
	private $_level = 'fatal';

	//this is a list of different loggers that have been loaded
	private static $_loggers = array();

	//this is the instance of the LoggerManager
	private static $_instance = NULL;

	//these are the mappings for levels to different log types
	private static $_logMapping = array(
		'default' => 'SugarLogger',
	);

	//these are the log level mappings anything with a lower value than your current log level will be logged
	private static $_levelMapping = array(
		'debug'      => 100,
		'info'       => 70,
		'warn'       => 50,
		'deprecated' => 40,
		'error'      => 25,
		'fatal'      => 10,
		'security'   => 5,
		'off'        => 0,
	);

	//only let the getLogger instantiate this object
	private function __construct()
	{
		$level = SugarConfig::getInstance()->get('logger.level', $this->_level);
		if (!empty($level))
			$this->setLevel($level);

		if ( empty(self::$_loggers) )
		    $this->_findAvailableLoggers();
	}

	/**
	 * Overloaded method that handles the logging requests.
	 *
	 * @param string $method
	 * @param string $message - also handles array as parameter, though that is deprecated.
	 */
 	public function __call(
 	    $method,
 	    $message
 	    )
 	{
        if ( !isset(self::$_levelMapping[$method]) )
            $method = $this->_level;
 		//if the method is a direct match to our level let's let it through this allows for custom levels
 		if($method == $this->_level
                //otherwise if we have a level mapping for the method and that level is less than or equal to the current level let's let it log
                || (!empty(self::$_levelMapping[$method])
                    && self::$_levelMapping[$this->_level] >= self::$_levelMapping[$method]) ) {
 			//now we get the logger type this allows for having a file logger an email logger, a firebug logger or any other logger you wish you can set different levels to log differently
 			$logger = (!empty(self::$_logMapping[$method])) ?
 			    self::$_logMapping[$method] : self::$_logMapping['default'];
 			//if we haven't instantiated that logger let's instantiate
 			if (!isset(self::$_loggers[$logger])) {
 			    self::$_loggers[$logger] = new $logger();
 			}
 			//tell the logger to log the message
 			self::$_loggers[$logger]->log($method, $message);
 		}
 	}

 	/**
 	 * Check if this log level will be producing any logging
 	 * @param string $method
 	 * @return boolean
 	 */
 	public function wouldLog($method)
 	{
 	    if ( !isset(self::$_levelMapping[$method]) )
 	    	$method = $this->_level;
 	    if($method == $this->_level
 	    		//otherwise if we have a level mapping for the method and that level is less than or equal to the current level let's let it log
 	    		|| (!empty(self::$_levelMapping[$method])
 	    				&& self::$_levelMapping[$this->_level] >= self::$_levelMapping[$method]) ) {
 	        return true;
 	    }
 	    return false;
 	}

	/**
     * Used for doing design-by-contract assertions in the code; when the condition fails we'll write
     * the message to the debug log
     *
     * @param string  $message
     * @param boolean $condition
     */
    public function assert(
        $message,
        $condition
        )
    {
        if ( !$condition )
            $this->__call('debug', $message);
	}

	/**
	 * Sets the logger to the level indicated
	 *
	 * @param string $name name of logger level to set it to
	 */
 	public function setLevel(
 	    $name
 	    )
 	{
        if ( isset(self::$_levelMapping[$name]) )
            $this->_level = $name;
 	}

 	/**
 	 * Returns a logger instance
 	 */
 	public static function getLogger()
	{
		if(!LoggerManager::$_instance){
			LoggerManager::$_instance = new LoggerManager();
		}
		return LoggerManager::$_instance;
	}

	/**
	 * Sets the logger to use a particular backend logger for the given level. Set level to 'default'
	 * to make it the default logger for the application
	 *
	 * @param string $level name of logger level to set it to
	 * @param string $logger name of logger class to use
	 */
	public static function setLogger(
 	    $level,
 	    $logger
 	    )
 	{
 	    self::$_logMapping[$level] = $logger;
 	}

 	/**
 	 * Finds all the available loggers in the application
 	 */
 	protected function _findAvailableLoggers()
 	{
 	    $locations = SugarAutoLoader::getFilesCustom('include/SugarLogger');
 	    foreach ( $locations as $location ) {
 	        $loggerClass = basename($location, ".php");
            if($loggerClass == "LoggerTemplate" || $loggerClass == "LoggerManager") {
                continue;
            }
            require_once $location;
            if ( class_exists($loggerClass) && class_implements($loggerClass,'LoggerTemplate') ) {
                self::$_loggers[$loggerClass] = new $loggerClass();
            }
        }
 	}

 	public static function getAvailableLoggers()
 	{
 	    return array_keys(self::$_loggers);
 	}

 	public static function getLoggerLevels()
 	{
 	    $loggerLevels = self::$_levelMapping;
 	    foreach ( $loggerLevels as $key => $value )
 	        $loggerLevels[$key] = ucfirst($key);

 	    return $loggerLevels;
 	}
}
