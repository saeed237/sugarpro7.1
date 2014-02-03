<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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


require_once 'data/Link2.php';

/**
 * Assists in backporting 6.6 Metadata formats to legacy style in order to
 * maintain backward compatibility with old clients consuming the V3 and V4 apis.
 */
class MetaDataConverter
{
    /**
     * An instantiated object of MetaDataConverter type
     *
     * @var MetaDataConverter
     */
    protected static $converter = null;

    /**
     * Actions associated to their ACLAction type
     *
     * @var array
     */
    protected $aclActionList = array(
        'EditView' => 'edit',
        '' => 'list',
        'index' => 'list',
        'Import' => 'import',
        'Reports' => 'list',
        'DetailView' => 'view',
    );

    /**
     * Converts edit and detail view defs that contain fieldsets to a compatible
     * defs that does not contain fieldsets. In essence, it splits up any fieldsets
     * and moves them out of their grouping into individual fields within the panel.
     *
     * This method assumes that the defs have already been converted to a legacy
     * format.
     *
     * @param array $defs
     * @return array
     */
    public static function fromGridFieldsets(array $defs)
    {
        if (isset($defs['panels']) && is_array($defs['panels'])) {
            $newpanels = array();
            $offset = 0;
            foreach ($defs['panels'] as $row) {
                if (is_array($row[0]) && isset($row[0]['type'])
                    && $row[0]['type'] == 'fieldset' && isset($row[0]['related_fields'])
                ) {
                    // Fieldset.... convert
                    foreach ($row[0]['related_fields'] as $fName) {
                        $newpanels[$offset] = array($fName);
                        $offset++;
                    }
                } else {
                    // do nothing
                    $newpanels[$offset] = $row;
                    $offset++;
                }
            }

            $defs['panels'] = $newpanels;
        }

        return $defs;
    }

    /**
     * Static entry point, will instantiate an object of itself to run the process.
     * Will convert $defs to legacy format $viewtype if there is a converter for
     * it, otherwise will return the defs as-is with no modification.
     *
     * @static
     * @param string $viewtype One of list|edit|detail
     * @param array $defs The defs to convert
     * @return array Converted defs if there is a converter, else the passed in defs
     */
    public static function toLegacy($viewtype, $defs)
    {
        if (null === self::$converter) {
            self::$converter = new self;
        }

        $method = 'toLegacy' . ucfirst(strtolower($viewtype));
        if (method_exists(self::$converter, $method)) {
            return self::$converter->$method($defs);
        }

        return $defs;
    }

    /**
     * Takes in a 6.6+ version of mobile|portal|sidecar list view metadata and
     * converts it to pre-6.6 format for legacy clients. The formats of the defs
     * are pretty dissimilar so the steps are going to be:
     *  - Take in all defs
     *  - Clip everything but the fields portion of the panels section of the defs
     *  - Modify the fields array to be keyed on UPPERCASE field name
     *
     * @param array $defs Field defs to convert
     * @return array
     */
    public function toLegacyList(array $defs)
    {
        $return = array();

        // Check our panels first
        if (isset($defs['panels']) && is_array($defs['panels'])) {
            foreach ($defs['panels'] as $panels) {
                // Handle fields if there are any (there should be)
                if (isset($panels['fields']) && is_array($panels['fields'])) {
                    // Logic here is simple... pull the name index value out, UPPERCASE it and
                    // set that as the new index name
                    foreach ($panels['fields'] as $field) {
                        if (isset($field['name'])) {
                            $name = strtoupper($field['name']);
                            unset($field['name']);
                            $return[$name] = $field;
                        }
                    }
                }
            }
        }


        return $return;
    }

    /**
     * Takes a Sidecar Subpanel view def and returns a BWC compatibile Subpanel view def
     *
     * @param array $oldDefs Field defs to convert
     * @param string $moduleName, the module we are converting
     * @return array BWC defs
     */
    public function toLegacySubpanelsViewDefs(array $defs, $moduleName)
    {
        if (!isset($defs['panels'])) {
            return array();
        }

        $oldDefs = array();

        // for BWC, we need to have some top buttons.  Sidecar doesn't have buttons in the def
        $oldDefs['top_buttons'] = array(
            array(
                'widget_class' => 'SubPanelTopCreateButton'
            ),
            array(
                'widget_class' => 'SubPanelTopSelectButton',
                'popup_module' => $moduleName,
            ),
        );

        $oldDefs['list_fields'] = $this->toLegacyList($defs);
        return $oldDefs;
    }

    protected $subpanelNameTranslation = array(
        'email1' => 'email',
    );

    /**
     * Convert legacy subpanels view defs to sidecar subpanel view defs
     * @param array $defs
     * @param string module
     * @return array
     */
    public function fromLegacySubpanelsViewDefs(array $defs, $module)
    {
        if (!isset($defs['list_fields'])) {
            throw new \RuntimeException("Subpanel is defined without fields");
        }

        $viewdefs = array('panels' => array(), 'type' => 'subpanel-list');

        $viewdefs['panels'][0]['name'] = 'panel_header';
        $viewdefs['panels'][0]['label'] = 'LBL_PANEL_1';

        $viewdefs['panels'][0]['fields'] = array();
        $bean = BeanFactory::getBean($module);

        foreach ($defs['list_fields'] as $fieldName => $details) {
            if (isset($details['vname'])) {
                $details['label'] = $details['vname'];
            }
            // disregard buttons
            if ((isset($details['label']) && stripos($details['label'], 'button') !== false) ||
                stripos($fieldName, 'button') !== false
            ) {
                continue;
            }

            if (isset($details['usage'])) {
                continue;
            }

            if (!isset($details['default'])) {
                $details['default'] = true;
            }

            if (!isset($details['enabled'])) {
                $details['enabled'] = true;
            }
            if(!empty($this->subpanelNameTranslation[$fieldName])) {
                $details['name'] = $this->subpanelNameTranslation[$fieldName];
            } else {
                $details['name'] = $fieldName;
            }

            if(!empty($details['widget_class'])) {
                if($details['widget_class'] == 'SubPanelDetailViewLink') {
                    $details['link'] = true;
                } elseif($details['widget_class'] == 'SubPanelEmailLink') {
                    $details['type'] = 'email';
                }
            }

            if ($bean && !empty($bean->field_defs[$details['name']])) {
                $newDefs = $bean->field_defs[$details['name']];
                if (!empty($newDefs['fields'])) {
                    $details['fields'] = $newDefs['fields'];
                }
                if (empty($details['type']) && !empty($newDefs['type']) && $newDefs['type'] != 'varchar') {
                    $details['type'] = $newDefs['type'];
                }
            }

            $viewdefs['panels'][0]['fields'][] = $this->fromLegacySubpanelField($details);
        }
        return $viewdefs;
    }

    /**
     * Convert a single field from the old subpanel fielddef
     * to the new sidecar def.
     *
     * This will return an array that contains any of the following:
     * label - the field label, will use vname if label doesn't exist
     * width - the width of the field
     * type - the field type [varchar, etc]
     * target module - for link fields the target module
     * target record key - for link fields the target key for the target_module
     *
     * @param array $details
     * @return array
     */
    public function fromLegacySubpanelField(array $fieldDefs)
    {
        static $fieldMap = array(
            'name' => true,
            'label' => true,
            'type' => true,
            'target_module' => true,
            'target_record_key' => true,
            'default' => true,
            'enabled' => true,
            'link' => true,
            'fields' => true,
            'sortable' => true,
        );

        return array_intersect_key($fieldDefs, $fieldMap);
    }

    /**
     * This converts the sidecar subpanel name to the legacy subpanel name
     * @param array $def - Sidecar Subpanel Definition
     * @return string - the Legacy subpanel name
     */
    public function toLegacySubpanelName(array $def)
    {
        if (isset($def['override_subpanel_list_view'])) {
            if (is_array($def['override_subpanel_list_view']) && isset($def['override_subpanel_list_view']['view'])) {
                $legacyName = $def['override_subpanel_list_view']['view'];
            } else {
                $legacyName = $def['override_subpanel_list_view'];
            }
            $legacyName = str_replace('subpanel-', '', $legacyName);
            $legacyName = str_replace(' ', '', ucwords(str_replace('-', ' ', $legacyName)));
            // special awesome condition so aSubpanel doesn't blow up because the bwc is ProspectLists
            if ($legacyName == 'ForProspectlists') {
                $legacyName = 'ForProspectLists';
            }
        } else {
            $legacyName = 'default';
        }
        return $legacyName;
    }

    /**
     * @param array $layoutDefs
     * @param SugarBean $bean
     * @return array legacy LayoutDef
     */
    public function toLegacySubpanelLayoutDefs(array $layoutDefs, SugarBean $bean)
    {
        $return = array();

        foreach ($layoutDefs as $order => $def) {
            // no link can't move on
            if (empty($def['context']['link'])) {
                continue;
            }
            $link = new Link2($def['context']['link'], $bean);
            $linkModule = $link->getRelatedModuleName();

            $legacySubpanelName = $this->toLegacySubpanelName($def);

            // if we don't have a label at least set the module name as the label
            // similar to configure shortcut bar
            $label = isset($def['label']) ? $def['label'] : translate($linkModule);
            $return[$def['context']['link']] = array(
                'order' => $order,
                'module' => $linkModule,
                'subpanel_name' => $legacySubpanelName,
                'sort_order' => 'asc',
                'sort_by' => 'id',
                'title_key' => $label,
                'get_subpanel_data' => $def['context']['link'],
                'top_buttons' => array(
                    array(
                        'widget_class' => 'SubPanelTopButtonQuickCreate',
                    ),
                    array(
                        'widget_class' => 'SubPanelTopSelectButton',
                        'mode' => 'MultiSelect',
                    ),
                ),
            );
        }
        return array('subpanel_setup' => $return);
    }

    /**
     * Simple accessor into the grid legacy converter
     *
     * @param array $defs Field defs to convert
     * @return array
     */
    public function toLegacyEdit(array $defs)
    {
        return $this->toLegacyGrid($defs);
    }

    /**
     * Simple accessor into the grid legacy converter
     *
     * @param array $defs Field defs to convert
     * @return array
     */
    public function toLegacyDetail(array $defs)
    {
        return $this->toLegacyGrid($defs);
    }

    /**
     * Takes in a 6.6+ version of mobile|portal|sidecar edit|detail view metadata and
     * converts it to pre-6.6 format for legacy clients.
     *
     * NOTE: This will only work for layouts that have only one field per row. For
     * the 6.6 upgrade that is sufficient since we were only converting portal
     * and mobile viewdefs. As is, this method will NOT convert grid layout view
     * defs that have more than one field per row.
     *
     * @param array $defs
     * @return array
     */
    protected function toLegacyGrid(array $defs)
    {
        // Check our panels first
        if (isset($defs['panels']) && is_array($defs['panels'])) {
            // For our new panels
            $newpanels = array();
            foreach ($defs['panels'] as $panels) {
                // Handle fields if there are any (there should be)
                if (isset($panels['fields']) && is_array($panels['fields'])) {
                    // Logic is fairly straight forward... take each member of
                    // the fields array and make it an array of its own
                    foreach ($panels['fields'] as $field) {
                        $newpanels[] = array($field);
                    }
                }
            }

            unset($defs['panels']);
            $defs['panels'] = $newpanels;
        }

        return $defs;
    }

    /**
     * Convert a legacy subpanel name to the new sidecar name
     * Examples:
     * ForAccounts becomes subpanel-for-accounts
     * default becomes subpanel-list
     *
     * @param string $subpanelName the legacy subpanel
     * @return string the new subpanel name
     */
    public function fromLegacySubpanelName($subpanelName)
    {
        $newName = ($subpanelName === 'default') ? 'list' : str_replace('for', 'for-', strtolower($subpanelName));
        return 'subpanel-' . $newName;
    }

    /**
     * Convert a legacy subpanel path to the new sidecar path
     * @param string $filename the path to a legacy subpanel
     * @param string client the client
     * @return string the new sidecar subpanel path
     */
    public function fromLegacySubpanelPath($fileName, $client = 'base')
    {
        $pathInfo = pathinfo($fileName);

        $dirParts = explode(DIRECTORY_SEPARATOR, $pathInfo['dirname']);

        if (count($dirParts) < 3) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Directory '%s' is an incorrect path for a subpanel",
                    $fileName
                )
            );
        }

        $newSubpanelName = $this->fromLegacySubpanelName($pathInfo['filename']);

        $newPath = str_replace(
            "metadata/subpanels/{$pathInfo['filename']}.php",
            "clients/{$client}/views/{$newSubpanelName}/{$newSubpanelName}.php",
            $fileName
        );

        return $newPath;
    }

    /**
     * Convert a piece of a subpanel layoutdef to the new style
     * @param array $layoutdef old style layout
     * @return array new style layout for this piece
     */
    public function fromLegacySubpanelLayout(array $layoutdef)
    {
        $viewdefs = array(
            'layout' => 'subpanel',
        );

        // we aren't upgrading collections
        if (!empty($layoutdef['collection_list'])) {
            return $viewdefs;
        }

        foreach ($layoutdef as $key => $value) {
            if ($key == 'override_subpanel_name') {
                $viewdefs['override_subpanel_list_view'] = array(
                    'view' => $this->fromLegacySubpanelName($value),
                    'link' => $layoutdef['get_subpanel_data'],
                );
            }

            if ($key == 'title_key') {
                $viewdefs['label'] = $value;
            } elseif ($key == 'get_subpanel_data') {
                $viewdefs['context']['link'] = $value;
            }
        }

        return $viewdefs;
    }

    /**
     * Converts a legacy menu to the new style menu
     *
     * @param $module module converting
     * @param array $menu menu contents
     * @param bool $ext is this an Extension
     * @return string new menu layout
     */
    public function fromLegacyMenu($moduleName, array $menu)
    {
        $arrayName = "viewdefs['{$moduleName}']['base']['menu']['header']";

        $dataItems = array();

        foreach ($menu as $option) {
            $data = array();
            // get the menu manip done
            $url = parse_url($option[0]);
            parse_str($url['query'], $menuOptions);
            $data['label'] = trim($option[1]);
            if (isset($this->aclActionList[$menuOptions['module']])) {
                $data['acl_action'] = trim($this->aclActionList[$menuOptions['module']]);
                $data['acl_module'] = $moduleName;
            } elseif (isset($this->aclActionList[$menuOptions['action']])) {
                $data['acl_action'] = trim($this->aclActionList[$menuOptions['action']]);
                $data['acl_module'] = trim($menuOptions['module']);
            }

            if ($menuOptions['action'] == 'EditView' && empty($menuOptions['record'])) {
                $data['icon'] = "icon-plus";
            } else if($menuOptions['module'] == 'Import') {
                $data['icon'] = 'icon-upload-alternative';
            } else if($menuOptions['module'] == 'Reports' && $moduleName != 'Reports') {
                $data['icon'] = 'icon-bar-chart';
            }

            $data['route'] = $this->buildMenuRoute($menuOptions, $option[0]);
            $dataItems[] = $data;
        }

        return array('name' => $arrayName, 'data' => $dataItems);
    }

    /**
     * @param array $menuOptions the request variables
     * @param string $link the legacy link
     * @return string the correct route for the menu option
     */
    protected function buildMenuRoute(array $menuOptions, $link)
    {
        global $bwcModules;

        $url = parse_url($link);
        $currSiteUrl = parse_url($GLOBALS['sugar_config']['site_url']);

        // most likely another server, return the URL provided
        if (!empty($url['host']) && $url['host'] != $currSiteUrl['host']) {
            return $link;
        }

        if (in_array($menuOptions['module'], $bwcModules)) {
            return "#bwc/index.php?" . http_build_query($menuOptions);
        }

        $route = null;

        if ($menuOptions['action'] == 'EditView' && empty($menuOptions['record'])) {
            $route = "#{$menuOptions['module']}/create";
        } elseif (($menuOptions['action'] == 'EditView' || $menuOptions['action'] == 'DetailView') &&
            !empty($menuOptions['record'])
        ) {
            $route = "#{$menuOptions['module']}/{$menuOptions['record']}";
        } elseif (empty($menuOptions['action']) || $menuOptions['action'] == 'index') {
            $route = "#{$menuOptions['module']}";
        } else {
            $route = "#bwc/index.php?" . http_build_query($menuOptions);
        }

        return $route;
    }
}