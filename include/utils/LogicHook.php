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
 * Predefined logic hooks
 * after_ui_frame
 * after_ui_footer
 * after_save
 * before_save
 * before_retrieve
 * after_retrieve
 * process_record
 * before_delete
 * after_delete
 * before_restore
 * after_restore
 * server_roundtrip
 * before_logout
 * after_logout
 * before_login
 * after_login
 * login_failed
 * after_session_start
 * after_entry_point
 * before_filter
 *
 * @api
 */
class LogicHook{

	var $bean = null;

	function LogicHook(){
	}

	/**
	 * Static Function which returns and instance of LogicHook
	 *
	 * @return unknown
	 */
	static function initialize(){
		if(empty($GLOBALS['logic_hook']))
			$GLOBALS['logic_hook'] = new LogicHook();
		return $GLOBALS['logic_hook'];
	}

	function setBean($bean){
		$this->bean = $bean;
		return $this;
	}

	protected $hook_map = array();
	protected $hookscan = array();

	public function getHooksMap()
	{
	    return $this->hook_map;
	}

	public function getHooksList()
	{
	    return $this->hookscan;
	}

    public function scanHooksDir($extpath)
    {
		if(is_dir($extpath)){
		    $dir = dir($extpath);
			while($entry = $dir->read()){
				if($entry != '.' && $entry != '..' && strtolower(substr($entry, -4)) == ".php" && is_file($extpath.'/'.$entry)) {
				    unset($hook_array);
                    include($extpath.'/'.$entry);
                    if(!empty($hook_array)) {
                        foreach($hook_array as $type => $hookg) {
                            foreach($hookg as $index => $hook) {
                                $this->hookscan[$type][] = $hook;
                                $idx = count($this->hookscan[$type])-1;
                                $this->hook_map[$type][$idx] = array("file" => $extpath.'/'.$entry, "index" => $index);
                            }
                        }
                    }
				}
			}
		}
    }

	protected static $hooks = array();

    static public function refreshHooks()
    {
        self::$hooks = array();
    }

	public function loadHooks($module_dir)
	{
        $hook_array = array();
	    if(!empty($module_dir)) {
	        $custom = "custom/modules/$module_dir";
	    } else {
	        $custom = "custom/modules";
	    }
	    foreach(SugarAutoLoader::existing(
		    "$custom/logic_hooks.php",
	        SugarAutoLoader::loadExtension("logichooks", empty($module_dir)?"application":$module_dir)
	    ) as $file) {
            if(isset($GLOBALS['log'])){
	    	    $GLOBALS['log']->debug('Including hook file: '.$file);
            }
		    include $file;
		}
		return $hook_array;
	}

	public function getHooks($module_dir, $refresh = false)
	{
	    if($refresh || !isset(self::$hooks[$module_dir])) {
	        self::$hooks[$module_dir] = $this->loadHooks($module_dir);
	    }
	    return self::$hooks[$module_dir];
	}

	/**
	 * Provide a means for developers to create upgrade safe business logic hooks.
	 * If the bean is null, then we assume this call was not made from a SugarBean Object and
	 * therefore we do not pass it to the method call.
	 *
	 * @param string $module_dir
	 * @param string $event
	 * @param array $arguments
	 * @param SugarBean $bean
	 */
	function call_custom_logic($module_dir, $event, $arguments = null){
		// declare the hook array variable, it will be defined in the included file.
		$hook_array = null;
        if(isset($GLOBALS['log'])){
            $GLOBALS['log']->debug("Hook called: $module_dir::$event");
        }
		if(!empty($module_dir)){
			// This will load an array of the hooks to process
			$hooks = $this->getHooks($module_dir);
			if(!empty($hooks)) {
			    $this->process_hooks($hooks, $event, $arguments);
			}
		}
		$hooks = $this->getHooks('');
		if(!empty($hooks)) {
		    $this->process_hooks($hooks, $event, $arguments);
		}
	}

	/**
	 * This is called from call_custom_logic and actually performs the action as defined in the
	 * logic hook. If the bean is null, then we assume this call was not made from a SugarBean Object and
	 * therefore we do not pass it to the method call.
	 *
	 * @param array $hook_array
	 * @param string $event
	 * @param array $arguments
	 * @param SugarBean $bean
	 */
	function process_hooks($hook_array, $event, $arguments){
		// Now iterate through the array for the appropriate hook
		if(!empty($hook_array[$event])){

			// Apply sorting to the hooks using the sort index.
			// Hooks with matching sort indexes will be processed in no particular order.
			$sorted_indexes = array();
			foreach($hook_array[$event] as $idx => $hook_details)
			{
				$order_idx = $hook_details[0];
				$sorted_indexes[$idx] = $order_idx;
			}
			asort($sorted_indexes);

			$process_order = array_keys($sorted_indexes);

			foreach($process_order as $hook_index){
				$hook_details = $hook_array[$event][$hook_index];
				if(!file_exists($hook_details[2])){
                    if(isset($GLOBALS['log'])){
					    $GLOBALS['log']->error('Unable to load custom logic file: '.$hook_details[2]);
                    }
					continue;
				}
				include_once($hook_details[2]);
				$hook_class = $hook_details[3];
				$hook_function = $hook_details[4];

				// Make a static call to the function of the specified class
				//TODO Make a factory for these classes.  Cache instances accross uses
				if($hook_class == $hook_function){
                    if(isset($GLOBALS['log'])){
					    $GLOBALS['log']->debug('Creating new instance of hook class '.$hook_class.' with parameters');
                    }
					if(!is_null($this->bean))
						$class = new $hook_class($this->bean, $event, $arguments);
					else
						$class = new $hook_class($event, $arguments);
				}else{
                    if(isset($GLOBALS['log'])){
					    $GLOBALS['log']->debug('Creating new instance of hook class '.$hook_class.' without parameters');
                    }
					$class = new $hook_class();
                    if (!is_null($this->bean)) {
                        $callback = array($class, $hook_function);
                        $params = array_merge(array($this->bean, $event, $arguments), array_slice($hook_details, 5));
                        call_user_func_array($callback, $params);
                    }
					else
						$class->$hook_function($event, $arguments);
				}
			}
		}
	}
}
?>
