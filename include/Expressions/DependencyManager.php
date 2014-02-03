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

require_once("include/Expressions/Dependency.php");
require_once("include/Expressions/Trigger.php");
require_once("include/Expressions/Expression/Parser/Parser.php");
require_once("include/Expressions/Actions/ActionFactory.php");

/**
 * Dependent field manager
 * @api
 */
class DependencyManager
{
    static $default_trigger = "true";

    /**
     * Returns a new Dependency that will power the provided calculated field.
     *
     * @param Array<String=>Array> $fields, list of fields to get dependencies for.
     * @param Boolean $includeReadOnly include the read-only actions to ensure calculated fields are not modified by the user in edit views. These are not required on detail/list views
     * @param Boolean $orderMatters Order matters on views with multiple calculated fields that rely on each-other. If all the values are currently up to date, order doesn't matter.
     * @return array<Dependency>
     */
    public static function getCalculatedFieldDependencies($fields, $includeReadOnly = true, $orderMatters = false)
    {

        $deps = array();
        $ro_deps = array();
        require_once("include/Expressions/Actions/SetValueAction.php");
        //In order to make sure the deps are returned in an order such that fields that used by other formulas are calculated first,
        //we keep track of how many times a field is used and what fields that field references.
        $formulaFields = array();
        foreach ($fields as $field => $def) {
            if (isset($def['calculated']) && $def['calculated'] && !empty($def['formula'])) {
                $triggerFields = Parser::getFieldsFromExpression($def['formula'], $fields);
                $formulaFields[$field] = $triggerFields;
                $dep = new Dependency($field);
                $dep->setTrigger(new Trigger('true', $triggerFields));

                $dep->addAction(ActionFactory::getNewAction('SetValue', array('target' => $field, 'value' => $def['formula'])));

                if (isset($def['enforced']) && $def['enforced'] &&
                    //Check for the string "false"
                    (!is_string($def['enforced']) || strtolower($def['enforced']) !== "false")
                ) {
                    if ($includeReadOnly) {
                        $readOnlyDep = new Dependency("readOnly$field");
                        $readOnlyDep->setFireOnLoad(true);
                        $readOnlyDep->setTrigger(new Trigger('true', $triggerFields));
                        $readOnlyDep->addAction(ActionFactory::getNewAction('ReadOnly',
                            array('target' => $field,
                                'value' => 'true')));

                        $ro_deps[] = $readOnlyDep;
                    } else {
                        $dep->setFireOnLoad(true);
                    }
                }
                $deps[$field] = $dep;
            }
        }
        if ($orderMatters)
            $deps = self::orderCalculatedFields($deps, $formulaFields);
        else
            $deps = array_values($deps);

        return array_merge($deps, $ro_deps);
    }

    protected static function orderCalculatedFields($deps, $formulaFields)
    {
        $weights = array_fill_keys(array_keys($formulaFields), 0);
        foreach ($formulaFields as $field => $triggers)
        {
            $updated = array();
            //Add to the weights of fields this field relies on, don't loop or double add.
            self::updateWeights($weights, $updated, $formulaFields, $field);
        }
        //Calculate fields that are relied upon by other fields will now all be heavier than the
        //fields that rely upon them. Do a reverse sort to bring the heaviest to the top.
        arsort($weights);

        //Now build the result array from the weights
        $ret = array();
        foreach ($weights as $field => $weight)
        {
            $ret[] = $deps[$field];
        }
        return $ret;
    }

    /*
     * Recursively add weight to calculated fields that are used by the field in question
     */
    protected static function updateWeights(&$weights, &$updated, $formulaFields, $field)
    {
        foreach ($formulaFields[$field] as $tField)
        {
            if (isset($formulaFields[$tField]) && !isset($updated[$tField])) {
                if (isset($weights[$tField])) $weights[$tField]++;
                else $weights[$tField] = 1;

                $updated[$tField] = true;
                self::updateWeights($weights, $updated, $formulaFields, $tField);
            }
        }
    }

    /**
     * Used to get a set of Dependencies to drive the dependent fields for this module.
     * @static
     * @param array $fields fielddef array to create the dependencies from
     * @return array<Dependency>
     */
    public static function getDependentFieldDependencies($fields)
    {
        $deps = array();

        foreach ($fields as $field => $def) {
            if (!empty ($def ['dependency'])) {
                // normalize the dependency definition
                if (!is_array($def ['dependency'])) {
                    $triggerFields = Parser::getFieldsFromExpression($def ['dependency'], $fields);
                    $def ['dependency'] = array(array('trigger' => $triggerFields, 'action' => $def ['dependency']));
                }
                foreach ($def ['dependency'] as $depdef)
                {
                    $dep = new Dependency ("{$field}_vis");
                    if (is_array($depdef ['trigger'])) {
                        $triggerFields = $depdef ['trigger'];
                    } else {
                        $triggerFields = Parser::getFieldsFromExpression($depdef ['trigger'], $fields);
                    }
                    $dep->setTrigger(new Trigger ('true', $triggerFields));
                    $dep->addAction(ActionFactory::getNewAction('SetVisibility',
                        array('target' => $field, 'value' => $depdef ['action'])));
                    $dep->setFireOnLoad(true);
                    $deps[] = $dep;
                }
            }
        }
        return $deps;
    }

    /**
     * Used to get a set of Dependencies to drive the dependent fields for this module.
     * @static
     * @param array $fields fielddef array to create the dependencies from
     * @return array<Dependency>
     */

    public static function getDependentFieldTriggerFields($fields, $fieldDefs = array())
    {
        $ret = array();
        foreach ($fields as $field => $def) {
            if (!empty($fieldDefs[$field]))
                $def = $fieldDefs[$field];
            if (!empty ($def ['dependency'])) {
                $triggerFields = array();
                // normalize the dependency definition
                if (is_array($def ['dependency'])) {
                    $triggerFields = Parser::getFieldsFromExpression($def ['dependency']['action'], $fieldDefs);
                }
                else
                {
                    $triggerFields = Parser::getFieldsFromExpression($def ['dependency'], $fieldDefs);
                }
                foreach ($triggerFields as $name)
                {
                    $ret[$name] = true;
                }
            }
        }
        return array_keys($ret);
    }

    /**
     * Used to get a set of Dependencies to drive the Dependent Dropdown fields for this module.
     * @static
     * @param array $fields fielddef array to create the dependencies from
     * @return array<Dependency>
     */

    public static function getDropDownDependencies($fields)
    {
        $deps = array();
        global $app_list_strings;

        foreach ($fields as $field => $def) {
            if (isset($def['type']) && $def['type'] == "enum" && !empty ($def ['visibility_grid'])) {
                $grid = $def ['visibility_grid'];
                if (!isset($grid['values']) || !isset($fields[$grid['trigger']]) || empty($fields[$grid ['trigger']]['options']))
                    continue;

                $trigger_list_id = $fields[$grid ['trigger']]['options'];
                if (!isset($app_list_strings[$trigger_list_id]) || !is_array($app_list_strings[$trigger_list_id]) ||
                    !isset($app_list_strings[$def['options']]) || !is_array($app_list_strings[$def['options']])
                ) {
                    continue;
                }

                $trigger_values = $app_list_strings[$trigger_list_id];

                $options = $app_list_strings[$def['options']];
                $result_keys = array();
                foreach ($trigger_values as $label_key => $label) {
                    if (!empty($grid['values'][$label_key])) {
                        $key_list = array();
                        foreach ($grid['values'][$label_key] as $label_key) {
                            if (isset($options[$label_key])) {
                                $key_list[$label_key] = $label_key;
                            }
                        }
                        $result_keys[] = 'enum("' . implode('","', $key_list) . '")';
                    } else {
                        $result_keys[] = 'enum("")';
                    }
                }

                $keys = 'enum(' . implode(',', $result_keys) . ')';
                //If the trigger key doesn't appear in the child list, hide the child field.
                $keys_expression = 'cond(equal(indexOf($' . $grid ['trigger']
                    . ', getDD("' . $trigger_list_id . '")), -1), enum(""), '
                    . 'valueAt(indexOf($' . $grid ['trigger']
                    . ',getDD("' . $trigger_list_id . '")),' . $keys . '))';
                //Have SetOptionsAction pull from the javascript language files.
                $labels_expression = '"' . $def['options'] . '"';
                $dep = new Dependency ($field . "DDD");
                $dep->setTrigger(new Trigger ('true', $grid['trigger']));
                $dep->addAction(
                    ActionFactory::getNewAction('SetOptions', array(
                        'target' => $field,
                        'keys' => $keys_expression,
                        'labels' => $labels_expression)));
                $dep->setFireOnLoad(true);
                $deps[] = $dep;
            }
        }
        return $deps;
    }

    /**
     * Used to get a set of Dependencies to drive the dependent panels for this module.
     * @static
     * @param array $fields fielddef array to create the dependencies from
     * @return array<Dependency>
     */

    public static function getPanelDependency($panel_id, $dep_expression)
    {
        $dep = new Dependency ($panel_id . "_visibility");
        $dep->setTrigger(new Trigger('true', Parser::getFieldsFromExpression($dep_expression)));
        $dep->addAction(
            ActionFactory::getNewAction('SetPanelVisibility', array(
                'target' => $panel_id,
                'value' => $dep_expression,
            ))
        );
        $dep->setFireOnLoad(true);

        return $dep;
    }

    /**
     * Returns a full set of the SugarLogic Dependencies to drive the business logic for a given view.
     * @static
     * @param array $viewdef view metadata (editviewdefs, detailviewdefs, ect)
     * @param string $view name of view and its form element ("EditView", "DetailView", "QuickCreate", ect)
     * @param string $module Primary module for this view
     * @return array<Dependency>
     */
    public static function getDependenciesForView($viewdef, $view = "", $module = "")
    {
        global $currentModule;

        if (empty($module)) {
            $module = $currentModule;
        }

        $deps = array();
        if (isset($viewdef['templateMeta']) && !empty($viewdef['templateMeta']['panelDependencies'])) {
            foreach (($viewdef['templateMeta']['panelDependencies']) as $id => $expr) {
                $deps[] = static::getPanelDependency(strtoupper($id), $expr);
            }
        }

        $type = 'view';

        if ($view == "RecordView" || $view == "EditView" || $view == "CreateView" ||
            $view == "Create-actionsView" || strpos($view, "QuickCreate") !== false) {
            $type = 'edit';
        }

        return array_merge($deps, static::getModuleDependenciesForAction($module, $type, $view));
    }

    /**
     * Returns the set of the custom SugarLogic Dependencies defined in the dependency metadata
     * for a module that are valid for the given action.
     * @static
     * @param string $module Primary module for this action
     * @param string $action name of the action to get dependencies for ("edit", "view", "save", ect)
     * @param string $form name of the form element used on html forms
     * @return array<Dependency>
     */
    public static function getModuleDependenciesForAction($module, $action, $form = "EditView")
    {
        $meta = self::getModuleDependencyMetadata($module);
        $deps = array();
        foreach ($meta as $key => $def)
        {
            $hooks = empty($def['hooks']) ? array("all") : $def['hooks'];
            if (!is_array($hooks))
                $hooks = array($hooks);
            if (in_array('all', $hooks) || in_array($action, $hooks)) {
                $triggerExp = empty($def['trigger']) ? self::$default_trigger : $def['trigger'];
                $triggerFields = empty($def['triggerFields']) ?
                    Parser::getFieldsFromExpression($triggerExp) :
                    $def['triggerFields'];
                $actions = empty($def['actions']) || !is_array($def['actions']) ? array() : $def['actions'];
                $notActions = empty($def['notActions']) || !is_array($def['notActions']) ? array() : $def['notActions'];
                $dep = new Dependency("{$module}{$form}_{$key}");
                $dep->setTrigger(new Trigger($triggerExp, $triggerFields));
                foreach ($actions as $aDef)
                {
                    $dep->addAction(
                        ActionFactory::getNewAction($aDef['name'], $aDef['params']));
                }
                foreach ($notActions as $aDef)
                {
                    $dep->addFalseAction(
                        ActionFactory::getNewAction($aDef['name'], $aDef['params']));
                }
                $dep->setFireOnLoad(!isset($def['onload']) || $def['onload'] !== false);
                $deps[] = $dep;
            }
        }
        return $deps;
    }

    private static function getModuleDependencyMetadata($module)
    {
        /* //Disable caching for now
        $cacheLoc = create_cache_directory("modules/$module/dependencies.php");
        //If the cache file exists, use it.
        if(inDeveloperMode() && empty($_SESSION['developerMode']) && is_file($cacheLoc)) {
            include($cacheLoc);
        }
        //Otherwise load all the def locations and create the cache file.
        else {
        */
        $dependencies = array($module => array());
        foreach (SugarAutoLoader::existingCustom("modules/$module/metadata/dependencydefs.php") as $loc)
        {
            require $loc;
        }
        $defs = SugarAutoLoader::loadExtension("dependencies", $module);
        if($defs) {
            require $defs;
        }
        /*  //More disabled cache code
            $out = "<?php\n // created: " . date('Y-m-d H:i:s') . "\n"
                 . override_value_to_string('dependencies', $module, $dependencies[$module]);
            file_put_contents($cacheLoc, $out);
        }*/

        return $dependencies[$module];
    }

    static function getDependenciesForFields($fields, $view = "")
    {
        if ($view == "DetailView") {
            return array_merge(
                self::getDependentFieldDependencies($fields),
                self::getDropDownDependencies($fields)
            );
        } else
        {
            return array_merge(
                self::getCalculatedFieldDependencies($fields),
                self::getDependentFieldDependencies($fields),
                self::getDropDownDependencies($fields));
        }
    }

    /**
     * @static
     * @param  $user User, user to return SugarLogic variables for
     * @return string
     */
    public static function getJSUserVariables($user)
    {
        require_once("include/TimeDate.php");
        $ts = TimeDate::getInstance();
        return "SUGAR.expressions.userPrefs = " . json_encode(array(
            "num_grp_sep" => $user->getPreference("num_grp_sep"),
            "dec_sep" => $user->getPreference("dec_sep"),
            "datef" => $user->getPreference("datef"),
            "timef" => $user->getPreference("timef"),
            "gmt_offset" => $ts->getUserUTCOffset(),
            "default_locale_name_format" => $user->getPreference("default_locale_name_format"),
        )) . ";\n";
    }

    /**
     * @static returns the javascript for the link variables of this view.
     * @param  $fields array, field_defs for this view
     * @param  $view string, name of view (form name)
     * @return string
     */
    public static function getLinkFields($fields, $view)
    {
        $links = array();
        foreach ($fields as $name => $def)
        {
            if (isset($def['type']) && $def['type'] == 'link' && self::validLinkField($def)) {
                $links[$name] = array('relationship' => $def['relationship']);
                if (!empty($def['module']))
                    $links[$name]['module'] = $def['module'];
            }
        }
        //Now attempt to map the relate field to the link
        foreach ($fields as $name => $def)
        {
            if (isset($def['type']) && $def['type'] == 'relate' && !empty($def['link']) && isset($links[$def['link']]) && !empty($def['id_name'])) {
                $links[$def['link']]['id_name'] = $def['id_name'];
                if (empty($links[$def['link']]['module']) && !empty($def['module']))
                    $links[$def['link']]['module'] = $def['module'];
            }
        }
        return "SUGAR.forms.AssignmentHandler.LINKS['$view'] = " . json_encode($links) . "\n";
    }

    /**
     * Used internally to determine if a field def is a valid link for use in formulas
     * @static
     * @param  $def array, Link field definition.
     * @return bool true if field is valid.
     */
    protected static function validLinkField($def)
    {
        global $dictionary;
        $invalidModules = array("Emails" => true, "Teams" => true);

        if (empty($def['relationship'])) {
            return false; //Not a good link field
        }

        $rel = SugarRelationshipFactory::getInstance()->getRelationship($def['relationship']);
        if ($rel === false) {
            return false; //Unable to find a relationship definition
        }

        if (!empty($invalidModules[$rel->lhs_module]) || !empty($invalidModules[$rel->rhs_module])) {
            return false; //Invalid module
        }

        //Otherwise this link looks ok
        return true;
    }
}
