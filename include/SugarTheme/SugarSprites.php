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


// Singleton to load sprites metadata from SugarTheme

class SugarSprites {

	private static $instance;
	public $sprites = array();
	public $dirs = array();

	private function __construct() {
		// load default sprites
		$this->dirs['default'] = true;
		$this->loadMetaHelper('default','sprites');
		// load repeatable sprites
		//$this->dirs['Repeatable'] = true;
		//$this->loadMetaHelper('Repeatable','sprites');
	}

	public static function getInstance() {
		if(!self::$instance)
			self::$instance = new self();
		return self::$instance;
    }

	public function loadSpriteMeta($dir) {
		if(! isset($this->dirs[$dir])) {
			$this->loadMetaHelper($dir, 'sprites');
			$this->dirs[$dir] = true;
		}
	}

	private function loadMetaHelper($dir, $file) {
		if(file_exists("cache/sprites/{$dir}/{$file}.meta.php")) {
			$sprites = array();
			$GLOBALS['log']->debug("Sprites: Loading sprites metadata for $dir");
			include("cache/sprites/{$dir}/{$file}.meta.php");
			foreach($sprites as $id => $meta) {
				$this->sprites[$id] = $meta;
			}
		}
	}
}

?>
