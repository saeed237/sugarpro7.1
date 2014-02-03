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


class contextMenu {
    var $menuItems;
    var $objectName;
    
    function contextMenu() {
        $this->menuItems = array();
    } 

    function getScript() {
        $json = getJSONobj();
        return "SUGAR.contextMenu.registerObjectType('{$this->objectName}', " . $json->encode($this->menuItems) . ");\n";
    }
    
    /**
     * adds a menu item to the current contextMenu
     * 
     * @param string $text text of the item
     * @param string $action function or pointer to the javascript function to call
     * @param array $params other parameters includes:
     *      url - The URL for the MenuItem's anchor's "href" attribute.
     *      target - The value to be used for the MenuItem's anchor's "target" attribute.
     *      helptext - Additional instructional text to accompany the text for a MenuItem. Example: If the text is 
     *                 "Copy" you might want to add the help text "Ctrl + C" to inform the user there is a keyboard
     *                 shortcut for the item.
     *      emphasis - If set to true the text for the MenuItem will be rendered with emphasis (using <em>).
     *      strongemphasis - If set to true the text for the MenuItem will be rendered with strong emphasis (using <strong>).
     *      disabled - If set to true the MenuItem will be dimmed and will not respond to user input or fire events.
     *      selected - If set to true the MenuItem will be highlighted.
     *      submenu - Appends / removes a menu (and it's associated DOM elements) to / from the MenuItem.
     *      checked - If set to true the MenuItem will be rendered with a checkmark.
     */
    function addMenuItem($text, $action, $module = null, $aclAction = null, $params = null) {
        // check ACLs if module and aclAction set otherwise no ACL check
        if(((!empty($module) && !empty($aclAction)) && ACLController::checkAccess($module, $aclAction)) || (empty($module) || empty($aclAction))) {
            $item = array('text' => translate($text),
                          'action' => $action);
            foreach(array('url', 'target', 'helptext', 'emphasis', 'strongemphasis', 'disabled', 'selected', 'submenu', 'checked') as $param) {
                if(!empty($params[$param])) $item[$param] = $params[$param];
            }
            array_push($this->menuItems, $item);
        }
    }
    
    /**
     * Loads up menu items from files located in include/contextMenus/menuDefs
     * @param string $name name of the object
     */
    function loadFromFile($name) {
        global $menuDef;
    	clean_string($name, 'FILE');
        require_once('include/contextMenus/menuDefs/' . $name . '.php');
        $this->loadFromDef($name, $menuDef[$name]);
    }
    
    /**
     * Loads up menu items from def
     * @param string $name name of the object type
     * @param array $defs menu item definitions
     */
    function loadFromDef($name, $defs) {
        $this->objectName = $name;
        foreach($defs as $def) {
            $this->addMenuItem($def['text'], $def['action'], 
                               (empty($def['module']) ? null : $def['module']), 
                               (empty($def['aclAction']) ? null : $def['aclAction']), 
                               (empty($def['params']) ? null : $def['params']));
        }
    }
}
?>
