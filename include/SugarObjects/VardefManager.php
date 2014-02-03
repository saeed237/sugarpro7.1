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


/**
 * Vardefs management
 * @api
 */
class VardefManager{
    static $custom_disabled_modules = array();
    static $linkFields;
    public static $inReload = array();

    /**
     * this method is called within a vardefs.php file which extends from a SugarObject.
     * It is meant to load the vardefs from the SugarObject.
     */
    static function createVardef($module, $object, $templates = array('default'), $object_name = false)
    {
        global $dictionary;

        include_once('modules/TableDictionary.php');

        //reverse the sort order so priority goes highest to lowest;
        $templates = array_reverse($templates);
        foreach ($templates as $template)
        {
            VardefManager::addTemplate($module, $object, $template, $object_name);
        }
        LanguageManager::createLanguageFile($module, $templates);

        if (isset(VardefManager::$custom_disabled_modules[$module]))
        {
            $vardef_paths = array(
                SugarAutoLoader::loadExtension("vardefs", $module),
                'custom/Extension/modules/' . $module . '/Ext/Vardefs/vardefs.php'
            );

            //search a predefined set of locations for the vardef files
            foreach ($vardef_paths as $path)
            {
                // file_exists here is only for custom/Extension since loadExtension already checks
                // the file map and will return false if something's wrong
                if(!empty($path) && file_exists($path)) {
                    require($path);
                }
            }
        }
    }

    /**
     * Enables/Disables the loading of custom vardefs for a module.
     * @param String $module Module to be enabled/disabled
     * @param Boolean $enable true to enable, false to disable
     * @return  null
     */
    public static function setCustomAllowedForModule($module, $enable) {
        if ($enable && isset($custom_disabled_modules[$module])) {
              unset($custom_disabled_modules[$module]);
        } else if (!$enable) {
              $custom_disabled_modules[$module] = true;
        }
    }

    static function addTemplate($module, $object, $template, $object_name=false){
        if($template == 'default')$template = 'basic';
        $templates = array();
        $fields = array();
        if(empty($object_name))$object_name = $object;
        $_object_name = strtolower($object_name);
        if(!empty($GLOBALS['dictionary'][$object]['table'])){
            $table_name = $GLOBALS['dictionary'][$object]['table'];
        }else{
            $table_name = strtolower($module);
        }

        if(empty($templates[$template])){
            foreach(SugarAutoLoader::existing(
                'include/SugarObjects/templates/' . $template . '/vardefs.php',
                'include/SugarObjects/implements/' . $template . '/vardefs.php'
            ) as $path) {
                require($path);
                $templates[$template] = $vardefs;
            }
        }

        if(!empty($templates[$template])){
            if(empty($GLOBALS['dictionary'][$object]['fields']))$GLOBALS['dictionary'][$object]['fields'] = array();
            if(empty($GLOBALS['dictionary'][$object]['relationships']))$GLOBALS['dictionary'][$object]['relationships'] = array();
            if(empty($GLOBALS['dictionary'][$object]['indices']))$GLOBALS['dictionary'][$object]['indices'] = array();
            $GLOBALS['dictionary'][$object]['fields'] = array_merge($templates[$template]['fields'], $GLOBALS['dictionary'][$object]['fields']);
            if(!empty($templates[$template]['relationships']))$GLOBALS['dictionary'][$object]['relationships'] = array_merge($templates[$template]['relationships'], $GLOBALS['dictionary'][$object]['relationships']);
            if(!empty($templates[$template]['indices']))$GLOBALS['dictionary'][$object]['indices'] = array_merge($templates[$template]['indices'], $GLOBALS['dictionary'][$object]['indices']);
            if(isset($templates[$template]['favorites']) && !isset($GLOBALS['dictionary'][$object]['favorites']))
            {
            	$GLOBALS['dictionary'][$object]['favorites'] = $templates[$template]['favorites'];
            }
            if(empty($GLOBALS['dictionary'][$object]['visibility']))
            {
                $GLOBALS['dictionary'][$object]['visibility'] = array();
            }
            if(!empty($templates[$template]['visibility']))
            {
                $GLOBALS['dictionary'][$object]['visibility'] = array_merge($templates[$template]['visibility'], $GLOBALS['dictionary'][$object]['visibility']);
            }
            if(empty($GLOBALS['dictionary'][$object]['acls']))
            {
                $GLOBALS['dictionary'][$object]['acls'] = array();
            }
            if(!empty($templates[$template]['acls']))
            {
                $GLOBALS['dictionary'][$object]['acls'] = array_merge($templates[$template]['acls'], $GLOBALS['dictionary'][$object]['acls']);
            }
            // maintain a record of this objects inheritance from the SugarObject templates...
            $GLOBALS['dictionary'][$object]['templates'][ $template ] = $template ;
        }
    }


    /**
     * Remove invalid field definitions
     * @static
     * @param Array $fieldDefs
     * @return  Array
     */
    static function cleanVardefs($fieldDefs)
    {
        foreach($fieldDefs as $field => $defs) {
            if (empty($defs['name']) || empty($defs['type'])) {
                unset($fieldDefs[$field]);
            }
        }

        return $fieldDefs;
    }

    /**
     * Save the dictionary object to the cache
     * @param string $module the name of the module
     * @param string $object the name of the object
     */
    static function saveCache($module,$object, $additonal_objects= array()){
        if (empty($GLOBALS['dictionary'][$object]))
            $object = BeanFactory::getObjectName($module);

        $file = self::getCacheFileName($module, $object);

        $GLOBALS['dictionary'][$object]['fields'] = self::cleanVardefs($GLOBALS['dictionary'][$object]['fields']);
        $out="<?php \n \$GLOBALS[\"dictionary\"][\"". $object . "\"]=" . var_export($GLOBALS['dictionary'][$object], true) .";";
        sugar_file_put_contents_atomic($file, $out);

    }

    /**
     * clear out the vardef cache. If we receive a module name then just clear the vardef cache for that module
     * otherwise clear out the cache for every module
     * @param string module_dir the module_dir to clear, if not specified then clear
     *                      clear vardef cache for all modules.
     * @param string object_name the name of the object we are clearing this is for sugar_cache
     */
    static function clearVardef($module_dir = '', $object_name = ''){
        //if we have a module name specified then just remove that vardef file
        //otherwise go through each module and remove the vardefs.php
        if(!empty($module_dir) && !empty($object_name)){
            VardefManager::_clearCache($module_dir, $object_name);
        }else{
            global $beanList;
            foreach($beanList as $module_dir => $object_name){
                VardefManager::_clearCache($module_dir, $object_name);
            }
        }
    }

    /**
     * PRIVATE function used within clearVardefCache so we do not repeat logic
     * @param string module_dir the module_dir to clear
     * @param string object_name the name of the object we are clearing this is for sugar_cache
     */
    static function _clearCache($module_dir = '', $object_name = ''){
        if(!empty($module_dir) && !empty($object_name)){

            //Some modules like cases have a bean name that doesn't match the object name
            if (empty($GLOBALS['dictionary'][$object_name])) {
                $newName = BeanFactory::getObjectName($module_dir);
                $object_name = $newName != false ? $newName : $object_name;
            }

            $file = self::getCacheFileName($module_dir, $object_name);

            if(file_exists($file)){
                unlink($file);
            }
        }
    }

    /**
     * Given a module, search all of the specified locations, and any others as specified
     * in order to refresh the cache file
     *
     * @param string $module the given module we want to load the vardefs for
     * @param string $object the given object we wish to load the vardefs for
     * @param array $additional_search_paths an array which allows a consumer to pass in additional vardef locations to search
     */
    static function refreshVardefs($module, $object, $additional_search_paths = null, $cacheCustom = true, $params = array())
    {
        // Some of the vardefs do not correctly define dictionary as global.  Declare it first.
        global $dictionary, $beanList;
        // some tests do new SugarBean(), we can't do much with it here.
        if(empty($module)) return;
        $guard_name = "$module:$object";
        if(isset(self::$inReload[$guard_name])) {
            self::$inReload[$guard_name]++;
            if(self::$inReload[$guard_name] > 2) {
                return;
            }
        } else {
            self::$inReload[$guard_name] = 1;
        }
        $vardef_paths = array(
                    'modules/'.$module.'/vardefs.php',
                    SugarAutoLoader::loadExtension("vardefs", $module),
                    'custom/Extension/modules/'.$module.'/Ext/Vardefs/vardefs.php'
                 );

        // Add in additional search paths if they were provided.
        if(!empty($additional_search_paths) && is_array($additional_search_paths))
        {
            $vardef_paths = array_merge($vardef_paths, $additional_search_paths);
        }
        $found = false;
        //search a predefined set of locations for the vardef files
        foreach(SugarAutoLoader::existing($vardef_paths) as $path){
            require($path);
            $found = true;
        }
        if(!empty($params['bean'])) {
            $bean = $params['bean'];
        } else {
            if(!empty($dictionary[$object])) {
                // to avoid extra refresh - we'll fill it in later
                if(!isset($GLOBALS['dictionary'][$object]['related_calc_fields'])) {
                    $GLOBALS['dictionary'][$object]['related_calc_fields'] = array();
                }
            }
            // we will instantiate here even though dictionary may not be there,
            // since in case somebody calls us with wrong module name we need bean
            // to get $module_dir. This may cause a loop but since the second call will
            // have the right module name the loop should be short.
            $bean = BeanFactory::newBean($module);
        }
        //Some modules have multiple beans, we need to see if this object has a module_dir that is different from its module_name
        if(!$found){
            if ($bean instanceof SugarBean) // weed out non-bean modules
            {
                $object_name = BeanFactory::getObjectName($bean->module_dir);
                if ($bean->module_dir != $bean->module_name && !empty($object_name))
                {
                    unset($params["bean"]); // don't pass this bean down - it may be wrong bean for that module
                    self::refreshVardefs($bean->module_dir, $object_name, $additional_search_paths, $cacheCustom, $params);
                }
            }
        }

        //Some modules like cases have a bean name that doesn't match the object name
        if(empty($dictionary[$object])) {
             $newName = BeanFactory::getObjectName($module);
             if(!empty($newName)) {
                $object = $newName;
            }
        }

        //load custom fields into the vardef cache
        if($cacheCustom && !empty($GLOBALS['dictionary'][$object]['fields'])){
            require_once("modules/DynamicFields/DynamicField.php");
            $df = new DynamicField ($module) ;
            $df->buildCache($module, false);
        }
        if (empty($params['ignore_rel_calc_fields'])) {
            self::updateRelCFModules($module, $object);
        }

        // Put ACLStatic into vardefs for beans supporting ACLs
        if(!empty($bean) && ($bean instanceof SugarBean) && !empty($dictionary[$object]) && !isset($dictionary[$object]['acls']['SugarACLStatic'])
            && $bean->bean_implements('ACL')) {
            $dictionary[$object]['acls']['SugarACLStatic'] = true;
        }

        //great! now that we have loaded all of our vardefs.
        //let's go save them to the cache file.
        if(!empty($dictionary[$object])) {
            VardefManager::saveCache($module, $object);
        }
        if(isset(self::$inReload[$guard_name])) {
            if(self::$inReload[$guard_name] > 1) {
                self::$inReload[$guard_name]--;
            } else {
                unset(self::$inReload[$guard_name]);
            }
        }
    }

    /**
     * @static
     * @param  $module
     * @param  $object
     * @return array|bool  returns a list of all fields in the module of type 'link'.
     */
    protected static function getLinkFieldsForModule($module, $object)
    {
        global $dictionary;
        //Some modules like cases have a bean name that doesn't match the object name
        if (empty($dictionary[$object])) {
            $newName = BeanFactory::getObjectName($module);
            $object = $newName != false ? $newName : $object;
        }
        if (empty($dictionary[$object])) {
            self::loadVardef($module, $object, false, array('ignore_rel_calc_fields' => true));
        }
        if (empty($dictionary[$object]))
        {
            $GLOBALS['log']->debug("Failed to load vardefs for $module:$object in linkFieldsForModule<br/>");
            return false;
        }

        //Cache link fields for this call in a static variable
        if (!isset(self::$linkFields))
            self::$linkFields = array();

        if (isset(self::$linkFields[$object]))
            return self::$linkFields[$object];

        $vardef = $dictionary[$object];
        $links = array();
        foreach($vardef['fields'] as $name => $def)
        {
            //Look through all link fields for related modules that have calculated fields that use that relationship
            if(!empty($def['type']) && $def['type'] == 'link' && !empty($def['relationship']))
            {
                $links[$name] = $def;
            }
        }

        self::$linkFields[$object] = $links;

        return $links;
    }


    public static function getLinkFieldForRelationship($module, $object, $relName)
    {
        $cacheKey = "LFR{$module}{$object}{$relName}";
        $cacheValue = sugar_cache_retrieve($cacheKey);
        if(!empty($cacheValue))
            return $cacheValue;

        $relLinkFields = self::getLinkFieldsForModule($module, $object);
        $matches = array();
        if (!empty($relLinkFields))
        {
            foreach($relLinkFields as $rfName => $rfDef)
            {
                if ($rfDef['relationship'] == $relName)
                {
                    $matches[] = $rfDef;
                }
            }
        }
        if (empty($matches))
            return false;
        if (sizeof($matches) == 1)
            $results = $matches[0];
        else
            //For relationships where both sides are the same module, more than one link will be returned
            $results = $matches;

        sugar_cache_put($cacheKey, $results);
        return $results ;
    }

    /**
     * @static
     * @param  $module String name of module.
     * @param  $object String name of module Bean.
     * Updates a list of link fields which have relationships to modules with calculated fields
     * that use this module. Needed to cause an update to those modules when this module is updated.
     * @return bool
     */
    protected static function updateRelCFModules($module, $object){
        global $dictionary, $beanList;
        if (empty($dictionary[$object]) || empty($dictionary[$object]['fields']))
            return false;

        $linkFields = self::getLinkFieldsForModule($module, $object);
        if (empty($linkFields))
        {
            $dictionary[$object]['related_calc_fields'] = array();
            return false;
        }

        $linksWithCFs = array();

        foreach($linkFields as $name => $def)
        {
            $relName = $def['relationship'];

            //Start by getting the relation
            $relDef = false;
            if (!empty($def['module']))
                $relMod = $def['module'];
            else {
                if (!empty($dictionary[$relName]['relationships'][$relName]))
                    $relDef = $dictionary[$relName]['relationships'][$relName];//[$relName];
                else if (!empty($dictionary[$object][$relName]))
                    $relDef = $dictionary[$object][$relName];
                else {
                    $relDef = SugarRelationshipFactory::getInstance()->getRelationshipDef($relName);
                    if (!$relDef)
                        continue;
                }

                if(empty($relDef['lhs_module']))
                {
                    continue;
                }
                $relMod = $relDef['lhs_module'] == $module ? $relDef['rhs_module'] : $relDef['lhs_module'];
            }

            if (empty($beanList[$relMod]))
                continue;

            $relObject = BeanFactory::getObjectName($relMod);
            $relLinkFields = self::getLinkFieldsForModule($relMod, $relObject);
            if (!empty($relLinkFields))
            {
                foreach($relLinkFields as $rfName => $rfDef)
                {
                    if ($rfDef['relationship'] == $relName && self::modHasCalcFieldsWithLink($relMod, $relObject, $rfName))
                    {
                        $linksWithCFs[$name] = true;
                    }
                }
            }
        }

        $dictionary[$object]['related_calc_fields'] = array_keys($linksWithCFs);
    }



    /**
     * @static
     * @param  $module
     * @param  $object
     * @param  $linkName
     * @return bool return true if the module contains calculated fields with the specified link in the formula.
     */
    public static function modHasCalcFieldsWithLink($module, $object, $linkName)
    {
        global $dictionary;
        //Some modules like cases have a bean name that doesn't match the object name
        $newName = BeanFactory::getObjectName($module);
        $object = empty($newName) ? $object : $newName;

        if (empty($dictionary[$object]))
            self::loadVardef($module, $object);
        if (empty($dictionary[$object])){
            return false;
        }

        $vardef = $dictionary[$object];
        $hasFieldsWithLink = false;
        if (!empty($vardef['fields']))
        {
            foreach($vardef['fields'] as $name => $def)
            {
                //Look through all calculated fields for uses of this link field
                if(!empty($def['formula']) && preg_match('/\W\$' . $linkName . '\W/', $def['formula']))
                {
                    $hasFieldsWithLink = true;
                    break;
                }
            }
        }
        return $hasFieldsWithLink;
    }

    /**
     * @static
     * @param SugarBean $focus
     * @param String $formula
     * @return array of related modules used in the formula
     */
    public static function getLinkedModulesFromFormula($focus, $formula)
    {
        global $dictionary, $beanList;
        $links = self::getLinkFieldsForModule($focus->module_name, $focus->object_name);
        $relMods = array();
        if (!empty($links))
        {
            foreach($links as $name => $def)
            {
                //Look through all calculated fields for uses of this link field
                if(preg_match('/\W\$' . $name . '\W/', $formula))
                {
                    $focus->load_relationship($name);
                    $relMod = $focus->$name->getRelatedModuleName();
                    if (!empty($beanList[$relMod]))
                        $relMods[$relMod] = $beanList[$relMod];
                }
            }
        }
        return $relMods;
    }



    /**
     * applyGlobalAccountRequirements
     *
     * This method ensures that the account_name relationships are set to always be required if the configuration file specifies
     * so.  For more information on this require_accounts parameter, please see the administrators guide or go to the
     * developers.sugarcrm.com website to find articles relating to the use of this field.
     *
     * @param Array $vardef The vardefs of the module to apply the account_name field requirement to
     * @return Array $vardef The vardefs of the module with the updated required setting based on the system configuration
     */
    static function applyGlobalAccountRequirements($vardef)
    {
        if (isset($GLOBALS['sugar_config']['require_accounts']))
        {
            if (isset($vardef['fields'])
                && isset($vardef['fields']['account_name'])
                && isset($vardef['fields']['account_name']['type'])
                && $vardef['fields']['account_name']['type'] == 'relate'
                && isset($vardef['fields']['account_name']['required']))
            {
                $vardef['fields']['account_name']['required'] = $GLOBALS['sugar_config']['require_accounts'];
            }

        }
        return $vardef;
    }


    /**
     * load the vardefs for a given module and object
     * @param string $module the given module we want to load the vardefs for
     * @param string $object the given object we wish to load the vardefs for
     * @param bool   $refresh whether or not we wish to refresh the cache file.
     */
    static function loadVardef($module, $object, $refresh=false, $params = array()){
        if ( empty($module) || empty($object) ) {
            return;
        }

        if (empty($params['ignore_rel_calc_fields']) &&
            !empty($GLOBALS['dictionary'][$object]) &&
            !isset($GLOBALS['dictionary'][$object]['related_calc_fields'])) {
            $refresh = true;
        }

        // Some of the vardefs do not correctly define dictionary as global.  Declare it first.
        global $dictionary;
        if(empty($GLOBALS['dictionary'][$object]) || $refresh){
            //if the consumer has demanded a refresh or the cache/modules... file
            //does not exist, then we should do out and try to reload things

			$cachedfile = self::getCacheFileName($module, $object);
			if($refresh || !file_exists($cachedfile)){
				VardefManager::refreshVardefs($module, $object, null, true, $params);
			}

            //at this point we should have the cache/modules/... file
            //which was created from the refreshVardefs so let's try to load it.
            if(file_exists($cachedfile))
            {
                @include($cachedfile);
                // now that we have loaded the data from disk, load it in the global dictionary
                if(!empty($GLOBALS['dictionary'][$object])) {
                    $GLOBALS['dictionary'][$object] = self::applyGlobalAccountRequirements($GLOBALS['dictionary'][$object]);
                }
            }
        }
    }

    /**
     * Gets the cache file name
     * @param string $module the given module we want to load the vardefs for
     * @param string $object the given object we wish to load the vardefs for
     * @return string The filename for the vardef cache
     */
    static function getCacheFileName($module, $object){
        return create_cache_directory('modules/' . $module . '/' . $object . 'vardefs.php');
    }
    
}
