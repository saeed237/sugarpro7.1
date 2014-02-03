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

 * Description:  Defines the base class for all data entities used throughout the
 * application.  The base class including its methods and variables is designed to
 * be overloaded with module-specific methods and variables particular to the
 * module's base entity class.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 *******************************************************************************/

require_once('modules/DynamicFields/DynamicField.php');
require_once 'data/BeanVisibility.php';
require_once 'data/BeanDuplicateCheck.php';
require_once 'data/SugarACL.php';
require_once "modules/Mailer/MailerFactory.php"; // imports all of the Mailer classes that are needed
require_once('include/Expressions/Expression/Parser/Parser.php');

/**
 * SugarBean is the base class for all business objects in Sugar.  It implements
 * the primary functionality needed for manipulating business objects: create,
 * retrieve, update, delete.  It allows for searching and retrieving list of records.
 * It allows for retrieving related objects (e.g. contacts related to a specific account).
 *
 * In the current implementation, there can only be one bean per folder.
 * Naming convention has the bean name be the same as the module and folder name.
 * All bean names should be singular (e.g. Contact).  The primary table name for
 * a bean should be plural (e.g. contacts).
 * @api
 */
class SugarBean
{
    /**
     * A pointer to the database object
     *
     * @var DBManager
     */
    var $db;

    /**
     * Unique object identifier
     *
     * @var string
     */
    public $id;

    /**
	 * When createing a bean, you can specify a value in the id column as
	 * long as that value is unique.  During save, if the system finds an
	 * id, it assumes it is an update.  Setting new_with_id to true will
	 * make sure the system performs an insert instead of an update.
	 *
	 * @var BOOL -- default false
	 */
	var $new_with_id = false;

	/**
	 * Pro Only -- When all data of a specifiy module is publically available,
	 * row level security can be turned off.  This should only be used for modules
	 * that do not need row level security.
	 *
	 * @var BOOL -- default false
	 */
	var $disable_row_level_security =false;

	/**
	 * Bean visibility manager
	 * @var BeanVisibility
	 */
	protected $visibility;


	/**
	 * How deep logic hooks can go
	 * @var int
	 */
	protected $max_logic_depth = 10;

	/**
	 * Disble vardefs.  This should be set to true only for beans that do not have varders.  Tracker is an example
	 *
	 * @var BOOL -- default false
	 */
    var $disable_vardefs = false;


    /**
     * holds the full name of the user that an item is assigned to.  Only used if notifications
     * are turned on and going to be sent out.
     *
     * @var String
     */
    var $new_assigned_user_name;

	/**
	 * An array of booleans.  This array is cleared out when data is loaded.
	 * As date/times are converted, a "1" is placed under the key, the field is converted.
	 *
	 * @var Array of booleans
	 */
	var $processed_dates_times = array();

	/**
	 * Whether to process date/time fields for storage in the database in GMT
	 *
	 * @var BOOL
	 */
	var $process_save_dates =true;

    /**
     * This signals to the bean that it is being saved in a mass mode.
     * Examples of this kind of save are import and mass update.
     * We turn off notificaitons of this is the case to make things more efficient.
     *
     * @var BOOL
     */
    var $save_from_post = true;

	/**
	 * When running a query on related items using the method: retrieve_by_string_fields
	 * this value will be set to true if more than one item matches the search criteria.
	 *
	 * @var BOOL
	 */
	var $duplicates_found = false;

	/**
	 * true if this bean has been deleted, false otherwise.
	 *
	 * @var BOOL
	 */
	var $deleted = 0;

    /**
     * Should the date modified column of the bean be updated during save?
     * This is used for admin level functionality that should not be updating
     * the date modified.  This is only used by sync to allow for updates to be
     * replicated in a way that will not cause them to be replicated back.
     *
     * @var BOOL
     */
    var $update_date_modified = true;

    /**
     * Should the modified by column of the bean be updated during save?
     * This is used for admin level functionality that should not be updating
     * the modified by column.  This is only used by sync to allow for updates to be
     * replicated in a way that will not cause them to be replicated back.
     *
     * @var BOOL
     */
    var $update_modified_by = true;

    /**
     * Setting this to true allows for updates to overwrite the date_entered
     *
     * @var BOOL
     */
    var $update_date_entered = false;

    /**
     * This allows for seed data to be created without using the current uesr to set the id.
     * This should be replaced by altering the current user before the call to save.
     *
     * @var unknown_type
     */
    //TODO This should be replaced by altering the current user before the call to save.
    var $set_created_by = true;

    var $team_set_id;

    /**
     * The database table where records of this Bean are stored.
     *
     * @var String
     */
    var $table_name = '';

    /**
    * This is the singular name of the bean.  (i.e. Contact).
    *
    * @var String
    */
    var $object_name = '';

    /** Set this to true if you query contains a sub-select and bean is converting both select statements
    * into count queries.
    */
    var $ungreedy_count=false;

    /**
    * The name of the module folder for this type of bean.
    *
    * @var String
    */
    var $module_dir = '';
    var $module_name = '';
    var $field_name_map;
    var $field_defs;
    var $custom_fields;
    var $column_fields = array();
    var $list_fields = array();
    var $additional_column_fields = array();
    var $relationship_fields = array();
    var $current_notify_user;
    var $fetched_row=false;
    var $fetched_rel_row = array();
    var $layout_def;
    var $force_load_details = false;
    var $optimistic_lock = false;
    var $disable_custom_fields = false;
    var $number_formatting_done = false;
    var $process_field_encrypted=false;
    var $my_favorite;
    /*
    * The default ACL type
    */
    var $acltype = 'module';

    var $vardef_handler;
    var $rel_handler;

    var $additional_meta_fields = array();

    /**
     * Set to true in the child beans if the module supports importing
     */
    var $importable = false;

    /**
    * Set to true in the child beans if the module use the special notification template
    */
    var $special_notification = false;

    /**
     * Set to true if the bean is being dealt with in a workflow
     */
    var $in_workflow = false;

    /**
     *
     * By default it will be true but if any module is to be kept non visible
     * to tracker, then its value needs to be overriden in that particular module to false.
     *
     */
    var $tracker_visibility = true;

    /**
     * Used to pass inner join string to ListView Data.
     */
    var $listview_inner_join = array();

    /**
     * Set to true in <modules>/Import/views/view.step4.php if a module is being imported
     */
    var $in_import = false;

    /**
     * Default ACL classes, for dynamic ACL/customizations
     * @var array
     */
    protected static $default_acls = array();
    /**
     * Default visibility classes, for dynamic ACL/customizations
     * @var array
     */
    protected static $default_visibility = array();

    /**
     * A way to keep track of the loaded relationships so when we clone the object we can unset them.
     *
     * @var array
     */
    protected $loaded_relationships = array();

	/**
     * set to true if dependent fields updated
     */
    protected $is_updated_dependent_fields = false;

    /**
     * duplicate check manager that interfaces with the duplicate check strategy
     */
    protected $duplicate_check_manager;

    /**
     * Blowfish encryption key
     * Blowfish encryption keys
     * @var array
     */
    static protected $field_key = array();

    /**
     * Encryption key ID for module
     * @var string
     */
    protected $module_key = 'encrypt_field';

    /**
     * Beans corresponding to various links on the bean
     * @var array
     */
    public $related_beans = array();

    /**
     * Create Bean
     * @deprecated
     * @param string $beanName
     * @return SugarBean
     * FIXME: this will be removed, needed for ensuring BeanFactory is always used
     */
    public static function _createBean($beanName)
    {
        return new $beanName();
    }

    /**
     * Encrypted fields storage
     * @var array
     */
    protected $encfields = array();
    /**
     * Plaintext storage for encrypted fields
     * @var array
     */
    protected $encfield_plain = array();
    /**
     * Bean required fields
     * @var array
     */
    public $required_fields = array();
    /**
     * Logic hook tracking
     * @var array
     */
    public $logicHookDepth = array();
    /**
     * Store relationship fields
     * @var array
     */
    public $rel_fields_before_value = array();

    /**
     * Store Email Address Data
     * @var array
     */
    public $emailData = array();

    /**
     * This method has been moved into the __construct() method to follow php standards
     *
     * Please start using __construct() as this method will be removed in a future version
     *
     * @see __construct()
     * @deprecated
     */
    protected function SugarBean()
    {
        self::__construct();
    }

    // FIXME: this will be removed, needed for ensuring BeanFactory is always used
    protected function checkBacktrace()
    {
        if($this instanceof UserPreference || $this instanceof DynamicField || $this instanceof System) {
            return true;
        }
        $back = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS|DEBUG_BACKTRACE_PROVIDE_OBJECT, 10);
        foreach($back as $traceitem) {
            if($traceitem['function'] == '_createBean') {
                return true;
            }
            if(!empty($traceitem['object']) && $traceitem['object'] !== $this) {
                break;
            }
        }
        throw new Exception("Bean created not via createBean!");
    }


    /**
     * Constructor for the bean, it performs following tasks:
     *
     * 1. Initalized a database connections
     * 2. Load the vardefs for the module implemeting the class. cache the entries
     *    if needed
     * 3. Setup row-level security preference
     * All implementing classes  must call this constructor using the parent::__construct()
     *
     */
    public function __construct()
    {
        // FIXME: this will be removed, needed for ensuring BeanFactory is always used
        //$this->checkBacktrace();

        global  $dictionary, $current_user;
        static $loaded_defs = array();
        $this->db = DBManagerFactory::getInstance();
        if (empty($this->module_name))
            $this->module_name = $this->module_dir;

        if(isset($this->disable_team_security)){
            $this->disable_row_level_security = $this->disable_team_security;
        }
        // Verify that current user is not null then do an ACL check.  The current user check is to support installation.
        if(!$this->disable_row_level_security && !empty($current_user->id) &&
                (is_admin($current_user) ||
                ($this->bean_implements('ACL') && (ACLAction::getUserAccessLevel($current_user->id,$this->module_dir, 'access')
                == ACL_ALLOW_ENABLED && (ACLAction::getUserAccessLevel($current_user->id, $this->module_dir, 'admin')
                == ACL_ALLOW_ADMIN || ACLAction::getUserAccessLevel($current_user->id, $this->module_dir, 'admin')
                == ACL_ALLOW_ADMIN_DEV)))))
        {
            $this->disable_row_level_security =true;
        }
        if (false == $this->disable_vardefs && (empty($loaded_defs[$this->object_name]) || !empty($GLOBALS['reload_vardefs'])))
        {

            $refresh = inDeveloperMode() || !empty($_SESSION['developerMode']);
            if($refresh && !empty(VardefManager::$inReload["{$this->module_dir}:{$this->object_name}"])) {
                // if we're already reloading this vardef, no need to do it again
                $refresh = false;
            }
            VardefManager::loadVardef($this->module_dir, $this->object_name, $refresh, array("bean" => $this));

            // build $this->column_fields from the field_defs if they exist
            if (!empty($dictionary[$this->object_name]['fields'])) {
                foreach ($dictionary[$this->object_name]['fields'] as $key=>$value_array) {
                    $column_fields[] = $key;
                    if(!empty($value_array['required']) && !empty($value_array['name'])) {
                        $this->required_fields[$value_array['name']] = 1;
                    }
                }
                $this->column_fields = $column_fields;
            }

            //setup custom fields
            if(!isset($this->custom_fields) &&
                empty($this->disable_custom_fields))
            {
                $this->setupCustomFields($this->module_dir);
            }
            //load up field_arrays from CacheHandler;
            if(empty($this->list_fields))
                $this->list_fields = $this->_loadCachedArray($this->module_dir, $this->object_name, 'list_fields');
            if(empty($this->column_fields))
                $this->column_fields = $this->_loadCachedArray($this->module_dir, $this->object_name, 'column_fields');
            if(empty($this->required_fields))
                $this->required_fields = $this->_loadCachedArray($this->module_dir, $this->object_name, 'required_fields');

            if(isset($GLOBALS['dictionary'][$this->object_name]) && !$this->disable_vardefs)
            {
                $this->field_name_map = $dictionary[$this->object_name]['fields'];
                $this->field_defs =	$dictionary[$this->object_name]['fields'];

                if(!empty($dictionary[$this->object_name]['optimistic_locking']))
                {
                    $this->optimistic_lock=true;
                }
            }
            $loaded_defs[$this->object_name]['column_fields'] =& $this->column_fields;
            $loaded_defs[$this->object_name]['list_fields'] =& $this->list_fields;
            $loaded_defs[$this->object_name]['required_fields'] =& $this->required_fields;
            $loaded_defs[$this->object_name]['field_name_map'] =& $this->field_name_map;
            $loaded_defs[$this->object_name]['field_defs'] =& $this->field_defs;
        }
        else
        {
            $this->column_fields =& $loaded_defs[$this->object_name]['column_fields'] ;
            $this->list_fields =& $loaded_defs[$this->object_name]['list_fields'];
            $this->required_fields =& $loaded_defs[$this->object_name]['required_fields'];
            $this->field_name_map =& $loaded_defs[$this->object_name]['field_name_map'];
            $this->field_defs =& $loaded_defs[$this->object_name]['field_defs'];
            $this->added_custom_field_defs = true;

            if(!isset($this->custom_fields) &&
                empty($this->disable_custom_fields))
            {
                $this->setupCustomFields($this->module_dir, false);
            }
            if(!empty($dictionary[$this->object_name]['optimistic_locking']))
            {
                $this->optimistic_lock=true;
            }
        }

        // Verify that current user is not null then do an ACL check.  The current user check is to support installation.
        if(!$this->disable_row_level_security && !empty($current_user->id) && !isset($this->disable_team_security)
			&& !SugarACL::checkAccess($this->module_dir, 'team_security', array('bean' => $this))) {
        	// We can disable team security for this module
        	$this->disable_row_level_security =true;
        }

        if($this->bean_implements('ACL') && !empty($GLOBALS['current_user'])){
            $this->acl_fields = (isset($dictionary[$this->object_name]['acl_fields']) && $dictionary[$this->object_name]['acl_fields'] === false)?false:true;
            ACLField::loadUserFields($this->module_dir,$this->object_name, $GLOBALS['current_user']->id);
            $this->addVisibilityStrategy("ACLVisibility");
        }
        $this->populateDefaultValues();
        if(isset($this->disable_team_security)){
            $this->disable_row_level_security = $this->disable_team_security;
        }
    }

    /**
     * Get default visibility settings
     * @return array
     */
    public static function getDefaultVisibility()
    {
        return self::$default_visibility;
    }

    /**
     * Set default visibility settings
     * @return array
     */
    public static function setDefaultVisibility($data)
    {
        self::$default_visibility = $data;
    }

    /**
     * Get default ACL settings
     * @return array
     */
    public static function getDefaultACL()
    {
        return self::$default_acls;
    }

    /**
     * Set default ACL settings
     * @return array
     */
    public static function setDefaultACL($data)
    {
        self::$default_acls = $data;
    }

    /**
     * Load visibility manager
     * @return BeanVisibility
     */
    public function loadVisibility()
    {
        if(empty($this->visibility)) {
            $data = isset($GLOBALS['dictionary'][$this->object_name]['visibility'])?$GLOBALS['dictionary'][$this->object_name]['visibility']:array();
            $this->visibility = new BeanVisibility($this, array_merge($data, self::$default_visibility));
        }
        return $this->visibility;
    }

    /**
     * Dynamically add visibility strategy to the bean
     * @param string $strategy Strategy class name
     * @param mixed $data Parameters
     */
    public function addVisibilityStrategy($strategy, $data = null)
    {
        return $this->loadVisibility()->addStrategy($strategy, $data);
    }

    /**
     * Add visibility clauses to the query
     * @param string $query
     */
    public function addVisibilityFrom(&$query, $options = null)
    {
        return $this->loadVisibility()->addVisibilityFrom($query, $options);
    }

    /**
     * Add visibility clauses to the query
     * @param string $query
     */
    public function addVisibilityWhere(&$query, $options = null)
    {
        return $this->loadVisibility()->addVisibilityWhere($query, $options);
    }
    /**
     * Add visibility to a SugarQuery Object
     * @param SugarQuery $query
     * @param array $options
     * @return SugarQuery
     */
    public function addVisibilityQuery($query, $options = null)
    {
        $query = $this->loadVisibility()->addVisibilityFromQuery($query, $options);
        $query = $this->loadVisibility()->addVisibilityWhereQuery($query, $options);
        return $query;
    }

    /**
     * Returns the object name. If object_name is not set, table_name is returned.
     *
     * All implementing classes must set a value for the object_name variable.
     *
     * @param array $arr row of data fetched from the database.
     * @return  nothing
     *
     */
    function getObjectName()
    {
        if ($this->object_name)
            return $this->object_name;

        // This is a quick way out. The generated metadata files have the table name
        // as the key. The correct way to do this is to override this function
        // in bean and return the object name. That requires changing all the beans
        // as well as put the object name in the generator.
        return $this->table_name;
    }

    /**
     * Returns a list of fields with their definitions that have the audited property set to true.
     * Before calling this function, check whether audit has been enabled for the table/module or not.
     * You would set the audit flag in the implemting module's vardef file.
     *
     * @return array
     * @see is_AuditEnabled
     *
     * Internal function, do not override.
     */
    function getAuditEnabledFieldDefinitions()
    {
        if (!isset($this->audit_enabled_fields))
        {
            $this->audit_enabled_fields=array();
            foreach ($this->field_defs as $field => $properties)
            {
                if (
                (
                $field == 'team_id' or
                !empty($properties['Audited']) || !empty($properties['audited']))
                && SugarACL::checkField($this->module_dir, $field, "access", array("bean" => $this))
                )
                {

                    $this->audit_enabled_fields[$field]=$properties;
                }
            }

        }
        return $this->audit_enabled_fields;
    }

    /**
     * Return true if auditing is enabled for this object
     * You would set the audit flag in the implemting module's vardef file.
     *
     * @return boolean
     *
     * Internal function, do not override.
     */
    function is_AuditEnabled()
    {
        global $dictionary;
        if (isset($dictionary[$this->getObjectName()]['audited']))
        {
            return $dictionary[$this->getObjectName()]['audited'];
        }
        else
        {
            return false;
        }
    }



    /**
     * Returns the name of the audit table.
     * Audit table's name is based on implementing class' table name.
     *
     * @return String Audit table name.
     *
     * Internal function, do not override.
     */
    function get_audit_table_name()
    {
        return $this->getTableName().'_audit';
    }
    /**
     * Return true if activity is enabled for this object
     * You would set the activity flag in the implemting module's vardef file.
     *
     * @return boolean
     *
     * Internal function, do not override.
     */
    function isActivityEnabled()
    {
        global $dictionary;
        if (isset($dictionary[$this->getObjectName()]['activity_enabled']))
        {
            return $dictionary[$this->getObjectName()]['activity_enabled'];
        }
        else
        {
            return false;
        }
    }

    /**
     * Returns a list of fields with their definitions that have the activity_enabled property set to true.
     * Before calling this function, check whether activity has been enabled for the table/module or not.
     * You would set the activity flag in the implemting module's vardef file.
     *
     * @return an array of
     * @see isActivityEnabled
     *
     * Internal function, do not override.
     */
    function getActivityEnabledFieldDefinitions()
    {
        if (!isset($this->activity_enabled_fields))
        {
            $this->activity_enabled_fields=array();
            foreach ($this->field_defs as $field => $properties)
            {
                $field_type = '';
                if (isset($properties['type'])) {
                    $field_type=$properties['type'];
                } else {
                    if (isset($properties['dbType']))
                        $field_type=$properties['dbType'];
                    else if(isset($properties['data_type']))
                        $field_type=$properties['data_type'];
                    else
                        $field_type=$properties['dbtype'];
                }
                if ($field != 'modified_user_id' && !empty($field_type) && $field_type != 'datetime') // other date types? exceptions?
                {
                    $this->activity_enabled_fields[$field]=$properties;
                }
            }

        }
        return $this->activity_enabled_fields;
    }

    /**
     * Returns the name of the custom table.
     * Custom table's name is based on implementing class' table name.
     *
     * @return String Custom table name.
     *
     * Internal function, do not override.
     */
    public function get_custom_table_name()
    {
        return $this->getTableName().'_cstm';
    }

    /**
     * If auditing is enabled, create the audit table.
     *
     * Function is used by the install scripts and a repair utility in the admin panel.
     *
     * Internal function, do not override.
     */
    function create_audit_table()
    {
        global $dictionary;
        $table_name=$this->get_audit_table_name();

        require('metadata/audit_templateMetaData.php');

        // Bug: 52583 Need ability to customize template for audit tables
        $custom = 'custom/metadata/audit_templateMetaData_' . $this->getTableName() . '.php';
        if (file_exists($custom))
        {
            require($custom);
        }

        $fieldDefs = $dictionary['audit']['fields'];
        $indices = $dictionary['audit']['indices'];

        // Renaming template indexes to fit the particular audit table (removed the brittle hard coding)
        foreach($indices as $nr => $properties){
            $indices[$nr]['name'] = 'idx_' . strtolower($this->getTableName()) . '_' . $properties['name'];
        }

        $engine = null;
        if(isset($dictionary['audit']['engine'])) {
            $engine = $dictionary['audit']['engine'];
        } else if(isset($dictionary[$this->getObjectName()]['engine'])) {
            $engine = $dictionary[$this->getObjectName()]['engine'];
        }

        $this->db->createTableParams($table_name, $fieldDefs, $indices, $engine);
    }

    /**
     * Returns the implementing class' table name.
     *
     * All implementing classes set a value for the table_name variable. This value is returned as the
     * table name. If not set, table name is extracted from the implementing module's vardef.
     *
     * @return String Table name.
     *
     * Internal function, do not override.
     */
    public function getTableName()
    {
        if(isset($this->table_name))
        {
            return $this->table_name;
        }
        global $dictionary;
        return $dictionary[$this->getObjectName()]['table'];
    }

    /**
     * Returns field definitions for the implementing module.
     *
     * The definitions were loaded in the constructor.
     *
     * @return Array Field definitions.
     *
     * Internal function, do not override.
     */
    function getFieldDefinitions()
    {
        return $this->field_defs;
    }

    /**
     * Returns index definitions for the implementing module.
     *
     * The definitions were loaded in the constructor.
     *
     * @return Array Index definitions.
     *
     * Internal function, do not override.
     */
    function getIndices()
    {
        global $dictionary;
        if(isset($dictionary[$this->getObjectName()]['indices']))
        {
            return $dictionary[$this->getObjectName()]['indices'];
        }
        return array();
    }

    /**
     * Returns field definition for the requested field name.
     *
     * The definitions were loaded in the constructor.
     *
     * @param string field name,
     * @return Array Field properties or boolean false if the field doesn't exist
     *
     * Internal function, do not override.
     */
    function getFieldDefinition($name)
    {
        if ( !isset($this->field_defs[$name]) )
            return false;

        return $this->field_defs[$name];
    }

    /**
     * Returnss  definition for the id field name.
     *
     * The definitions were loaded in the constructor.
     *
     * @return Array Field properties.
     *
     * Internal function, do not override.
     */
    function getPrimaryFieldDefinition()
    {
        $def = $this->getFieldDefinition("id");
        if(empty($def)) {
            $def = $this->getFieldDefinition(0);
        }
        if (empty($def)) {
            $defs = $this->field_defs;
            reset($defs);
            $def = current($defs);
        }
        return $def;
    }
    public function isFavoritesEnabled()
    {
    	if(isset($GLOBALS['dictionary'][$this->getObjectName()]['favorites']))
    	{
    		return $GLOBALS['dictionary'][$this->getObjectName()]['favorites'];
    	}
        return false;
    }

    /**
     * Returns the value for the requested field.
     *
     * When a row of data is fetched using the bean, all fields are created as variables in the context
     * of the bean and then fetched values are set in these variables.
     *
     * @param string field name,
     * @return varies Field value.
     *
     * Internal function, do not override.
     */
    function getFieldValue($name)
    {
        if (!isset($this->$name)){
            return false;
        }
        if($this->$name === true){
            return 1;
        }
        if($this->$name === false){
            return 0;
        }
        return $this->$name;
    }

    /**
     * Basically undoes the effects of SugarBean::populateDefaultValues(); this method is best called right after object
     * initialization.
     */
    public function unPopulateDefaultValues()
    {
        if ( !is_array($this->field_defs) )
            return;

        foreach ($this->field_defs as $field => $value) {
		    if( !empty($this->$field)
                  && ((isset($value['default']) && $this->$field == $value['default']) || (!empty($value['display_default']) && $this->$field == $value['display_default']))
                    ) {
                $this->$field = null;
                continue;
            }
            if(!empty($this->$field) && !empty($value['display_default']) && in_array($value['type'], array('date', 'datetime', 'datetimecombo')) &&
            $this->$field == $this->parseDateDefault($value['display_default'], ($value['type'] != 'date'))) {
                $this->$field = null;
            }
        }
    }

    /**
     * Create date string from default value
     * like '+1 month'
     * @param string $value
     * @param bool $time Should be expect time set too?
     * @return string
     */
    protected function parseDateDefault($value, $time = false)
    {
        global $timedate;
        if($time) {
            $dtAry = explode('&', $value, 2);
            $dateValue = $timedate->getNow(true)->modify($dtAry[0]);
            if(!empty($dtAry[1])) {
                $timeValue = $timedate->fromString($dtAry[1]);
                $dateValue->setTime($timeValue->hour, $timeValue->min, $timeValue->sec);
            }
            return $timedate->asUser($dateValue);
        } else {
            return $timedate->asUserDate($timedate->getNow(true)->modify($value));
        }
    }

    function populateDefaultValues($force=false){
        if ( !is_array($this->field_defs) )
            return;
        foreach($this->field_defs as $field=>$value){
            if((isset($value['default']) || !empty($value['display_default'])) && ($force || empty($this->$field))){
                $type = $value['type'];

                switch($type){
                    case 'date':
                        if(!empty($value['display_default'])){
                            $this->$field = $this->parseDateDefault($value['display_default']);
                        }
                        break;
                   case 'datetime':
                   case 'datetimecombo':
                        if(!empty($value['display_default'])){
                            $this->$field = $this->parseDateDefault($value['display_default'], true);
                        }
                        break;
                    case 'multienum':
                        if(empty($value['default']) && !empty($value['display_default']))
                            $this->$field = $value['display_default'];
                        else
                            $this->$field = $value['default'];
                        break;
                    case 'bool':
                    	if(isset($this->$field)){
                    		break;
                    	}
                    default:
                        if ( isset($value['default']) && $value['default'] !== '' ) {
                            $this->$field = htmlentities($value['default'], ENT_QUOTES, 'UTF-8');
                        } else {
                            $this->$field = '';
                        }
                } //switch
            }
        } //foreach
    }


    /**
     * Removes relationship metadata cache.
     *
     * Every module that has relationships defined with other modules, has this meta data cached.  The cache is
     * stores in 2 locations: relationships table and file system. This method clears the cache from both locations.
     *
     * @param string $key  module whose meta cache is to be cleared.
     * @param string $db database handle.
     * @param string $tablename table name
     * @param string $dictionary vardef for the module
     * @param string $module_dir name of subdirectory where module is installed.
     *
     * @return Nothing
     * @static
     *
     * Internal function, do not override.
     */
    function removeRelationshipMeta($key,$db,$tablename,$dictionary,$module_dir)
    {
        //load the module dictionary if not supplied.
        if ((!isset($dictionary) or empty($dictionary)) && !empty($module_dir))
        {
            $filename='modules/'. $module_dir . '/vardefs.php';
            if(SugarAutoLoader::fileExists($filename))
            {
                include($filename);
            }
        }
        if (!is_array($dictionary) or !array_key_exists($key, $dictionary))
        {
            $GLOBALS['log']->fatal("removeRelationshipMeta: Metadata for table ".$tablename. " does not exist");
            display_notice("meta data absent for table ".$tablename." keyed to $key ");
        }
        else
        {
            if (isset($dictionary[$key]['relationships']))
            {
                $RelationshipDefs = $dictionary[$key]['relationships'];
                foreach ($RelationshipDefs as $rel_name => $rel_data)
                {
                    $relationship = BeanFactory::getBean('Relationships');
                    $relationship->delete($rel_name,$db);
                }
            }
        }
    }


    /**
     * This method has been deprecated.
     *
    * @see removeRelationshipMeta()
     * @deprecated 4.5.1 - Nov 14, 2006
     * @static
    */
    function remove_relationship_meta($key,$db,$log,$tablename,$dictionary,$module_dir)
    {
        SugarBean::removeRelationshipMeta($key,$db,$tablename,$dictionary,$module_dir);
    }


    /**
     * Populates the relationship meta for a module.
     *
     * It is called during setup/install. It is used statically to create relationship meta data for many-to-many tables.
     *
     * 	@param string $key name of the object.
     * 	@param object $db database handle.
     *  @param string $tablename table, meta data is being populated for.
     *  @param array dictionary vardef dictionary for the object.     *
     *  @param string module_dir name of subdirectory where module is installed.
     *  @param boolean $iscustom Optional,set to true if module is installed in a custom directory. Default value is false.
     *  @static
     *
     *  Internal function, do not override.
     */
    function createRelationshipMeta($key,$db,$tablename,$dictionary,$module_dir,$iscustom=false)
    {
        //load the module dictionary if not supplied.
        if (empty($dictionary) && !empty($module_dir))
        {
            if($iscustom)
            {
                $filename='custom/modules/' . $module_dir . '/Ext/Vardefs/vardefs.ext.php';
            }
            else
            {
                if ($key == 'User')
                {
                    // a very special case for the Employees module
                    // this must be done because the Employees/vardefs.php does an include_once on
                    // Users/vardefs.php
                    $filename='modules/Users/vardefs.php';
                }
                else
                {
                    $filename='modules/'. $module_dir . '/vardefs.php';
                }
            }

            if(file_exists($filename))
            {
                include($filename);
                // cn: bug 7679 - dictionary entries defined as $GLOBALS['name'] not found
                if(empty($dictionary) || !empty($GLOBALS['dictionary'][$key]))
                {
                    $dictionary = $GLOBALS['dictionary'];
                }
            }
            else
            {
                $GLOBALS['log']->debug("createRelationshipMeta: no metadata file found" . $filename);
                return;
            }
        }

        if (!is_array($dictionary) or !array_key_exists($key, $dictionary))
        {
            $GLOBALS['log']->fatal("createRelationshipMeta: Metadata for table ".$tablename. " does not exist");
            display_notice("meta data absent for table ".$tablename." keyed to $key ");
        }
        else
        {
            if (isset($dictionary[$key]['relationships']))
            {

                $RelationshipDefs = $dictionary[$key]['relationships'];

                $delimiter=',';
                global $beanList;
                $beanList_ucase=array_change_key_case  ( $beanList ,CASE_UPPER);
                foreach ($RelationshipDefs as $rel_name=>$rel_def)
                {
                    if (isset($rel_def['lhs_module']) and !isset($beanList_ucase[strtoupper($rel_def['lhs_module'])])) {
                        $GLOBALS['log']->debug('skipping orphaned relationship record ' . $rel_name . ' lhs module is missing ' . $rel_def['lhs_module']);
                        continue;
                    }
                    if (isset($rel_def['rhs_module']) and !isset($beanList_ucase[strtoupper($rel_def['rhs_module'])])) {
                        $GLOBALS['log']->debug('skipping orphaned relationship record ' . $rel_name . ' rhs module is missing ' . $rel_def['rhs_module']);
                        continue;
                    }


                    //check whether relationship exists or not first.
                    if (Relationship::exists($rel_name,$db))
                    {
                        $GLOBALS['log']->debug('Skipping, reltionship already exists '.$rel_name);
                    }
                    else
                    {
                        $seed = BeanFactory::getBean("Relationships");
                        $keys = array_keys($seed->field_defs);
                        $toInsert = array();
                        foreach($keys as $key)
                        {
                            if ($key == "id")
                            {
                                $toInsert[$key] = create_guid();
                            }
                            else if ($key == "relationship_name")
                            {
                                $toInsert[$key] = $rel_name;
                            }
                            else if (isset($rel_def[$key]))
                            {
                                $toInsert[$key] = $rel_def[$key];
                            }
                            //todo specify defaults if meta not defined.
                        }


                        $column_list = implode(",", array_keys($toInsert));
                        $value_list = "'" . implode("','", array_values($toInsert)) . "'";

                        //create the record. todo add error check.
                        $insert_string = "INSERT into relationships (" .$column_list. ") values (".$value_list.")";
                        $db->query($insert_string, true);
                    }
                }
            }
            else
            {
                //todo
                //log informational message stating no relationships meta was set for this bean.
            }
        }
    }

    /**
     * This method has been deprecated.
    * @see createRelationshipMeta()
     * @deprecated 4.5.1 - Nov 14, 2006
     * @static
    */
    function create_relationship_meta($key,&$db,&$log,$tablename,$dictionary,$module_dir)
    {
        SugarBean::createRelationshipMeta($key,$db,$tablename,$dictionary,$module_dir);
    }


    /**
     * Handle the following when a SugarBean object is cloned
     *
     * Currently all this does it unset any relationships that were created prior to cloning the object
     *
     * @api
     */
    public function __clone()
    {
        if(!empty($this->loaded_relationships)) {
            foreach($this->loaded_relationships as $rel) {
                unset($this->$rel);
            }
        }
    }


    /**
     * Loads the request relationship. This method should be called before performing any operations on the related data.
     *
     * This method searches the vardef array for the requested attribute's definition. If the attribute is of the type
     * link then it creates a similary named variable and loads the relationship definition.
     *
     * @param string $rel_name  relationship/attribute name.
     * @return nothing.
     */
    function load_relationship($rel_name)
    {
        $GLOBALS['log']->debug("SugarBean[{$this->object_name}].load_relationships, Loading relationship (".$rel_name.").");

        if (empty($rel_name))
        {
            $GLOBALS['log']->error("SugarBean.load_relationships, Null relationship name passed.");
            return false;
        }
        $fieldDefs = $this->getFieldDefinitions();

        //find all definitions of type link.
        if (!empty($fieldDefs[$rel_name]))
        {
            //initialize a variable of type Link
            require_once('data/Link2.php');
            $class = load_link_class($fieldDefs[$rel_name]);
            if (isset($this->$rel_name) && $this->$rel_name instanceof $class) {
                    return true;
            }
            //if rel_name is provided, search the fieldef array keys by name.
            if (isset($fieldDefs[$rel_name]['type']) && $fieldDefs[$rel_name]['type'] == 'link')
            {
                if ($class == "Link2")
                    $this->$rel_name = new $class($rel_name, $this);
                else
                    $this->$rel_name = new $class($fieldDefs[$rel_name]['relationship'], $this, $fieldDefs[$rel_name]);

                if (empty($this->$rel_name) ||
                        (method_exists($this->$rel_name, "loadedSuccesfully") && !$this->$rel_name->loadedSuccesfully()))
                {
                    unset($this->$rel_name);
                    return false;
                }
                // keep track of the loaded relationships
                $this->loaded_relationships[] = $rel_name;
                return true;
            }
        }
        $GLOBALS['log']->debug("SugarBean.load_relationships, Error Loading relationship (".$rel_name.")");
        return false;
    }

    /**
     * Loads all attributes of type link.
     *
     * DO NOT CALL THIS FUNCTION IF YOU CAN AVOID IT. Please use load_relationship directly instead.
     *
     * Method searches the implmenting module's vardef file for attributes of type link, and for each attribute
     * create a similary named variable and load the relationship definition.
     *
     * @return Nothing
     *
     * Internal function, do not override.
     */
    function load_relationships()
    {
        $GLOBALS['log']->debug("SugarBean.load_relationships, Loading all relationships of type link.");
        $linked_fields=$this->get_linked_fields();
        foreach($linked_fields as $name=>$properties)
        {
            $this->load_relationship($name);
        }
    }

    /**
     * Returns an array of beans of related data.
     *
     * For instance, if an account is related to 10 contacts , this function will return an array of contacts beans (10)
     * with each bean representing a contact record.
     * Method will load the relationship if not done so already.
     *
     * @param string $field_name relationship to be loaded.
     * @param string $bean name  class name of the related bean.
     * @param array $sort_array optional, unused
     * @param int $begin_index Optional, default 0, unused.
     * @param int $end_index Optional, default -1
     * @param int $deleted Optional, Default 0, 0  adds deleted=0 filter, 1  adds deleted=1 filter.
     * @param string $optional_where, Optional, default empty.
     *
     * Internal function, do not override.
     */
    function get_linked_beans($field_name,$bean_name, $sort_array = array(), $begin_index = 0, $end_index = -1,
                              $deleted=0, $optional_where="")
    {
        //if bean_name is Case then use aCase
        if($bean_name=="Case")
            $bean_name = "aCase";

        if($this->load_relationship($field_name)) {
            if ($this->$field_name instanceof Link) {
                // some classes are still based on Link, e.g. TeamSetLink
                return array_values($this->$field_name->getBeans(BeanFactory::newBeanByName($bean_name), $sort_array, $begin_index, $end_index, $deleted, $optional_where));
            } else {
                // Link2 style
                if ($end_index != -1 || !empty($deleted) || !empty($optional_where))
                    return array_values($this->$field_name->getBeans(array(
                        'where' => $optional_where,
                        'deleted' => $deleted,
                        'limit' => ($end_index - $begin_index)
                    )));
                else
                    return array_values($this->$field_name->getBeans());
            }
        }
        else
            return array();
    }

    /**
     * Returns an array of fields that are of type link.
     *
     * @return array List of fields.
     *
     * Internal function, do not override.
     */
    function get_linked_fields()
    {

        $linked_fields=array();

 //   	require_once('data/Link.php');

        $fieldDefs = $this->getFieldDefinitions();

        //find all definitions of type link.
        if (!empty($fieldDefs))
        {
            foreach ($fieldDefs as $name=>$properties)
            {
                if (isset($properties['type']) && $properties['type'] == 'link' ) {
                    $linked_fields[$name]=$properties;
                }
            }
        }

        return $linked_fields;
    }

    /**
     * Returns an array of fields that are able to be Imported into
     * i.e. 'importable' not set to 'false'
     *
     * @return array List of fields.
     *
     * Internal function, do not override.
     */
    function get_importable_fields()
    {
        $importableFields = array();

        $fieldDefs= $this->getFieldDefinitions();

        if (!empty($fieldDefs)) {
            foreach ($fieldDefs as $key=>$value_array) {
                if ( (isset($value_array['importable'])
                        && (is_string($value_array['importable']) && $value_array['importable'] == 'false'
                            || is_bool($value_array['importable']) && $value_array['importable'] == false))
                    || (isset($value_array['type']) && $value_array['type'] == 'link')
                    || (isset($value_array['type']) && $value_array['type'] == 'image')
                    || (isset($value_array['auto_increment'])
                        && ($value_array['type'] == true || $value_array['type'] == 'true')) ) {
                    // only allow import if we force it
                    if (isset($value_array['importable'])
                        && (is_string($value_array['importable']) && $value_array['importable'] == 'true'
                           || is_bool($value_array['importable']) && $value_array['importable'] == true)) {
                        $importableFields[$key]=$value_array;
                    }
                }
                else {

                    //Expose the cooresponding id field of a relate field if it is only defined as a link so that users can relate records by id during import
                    if( isset($value_array['type']) && ($value_array['type'] == 'relate') && isset($value_array['id_name']) )
                    {
                        $idField = $value_array['id_name'];
                        if( isset($fieldDefs[$idField]) && isset($fieldDefs[$idField]['type'] ) && $fieldDefs[$idField]['type'] == 'link' )
                        {
                            $tmpFieldDefs = $fieldDefs[$idField];
                            $tmpFieldDefs['vname'] = translate($value_array['vname'], $this->module_dir) . " " . $GLOBALS['app_strings']['LBL_ID'];
                            $importableFields[$idField]=$tmpFieldDefs;
                        }
                    }

                    $importableFields[$key]=$value_array;
                }
            }
        }

        return $importableFields;
    }

    /**
     * Returns an array of fields that are of type relate.
     *
     * @return array List of fields.
     *
     * Internal function, do not override.
     */
    function get_related_fields()
    {

        $related_fields=array();

//    	require_once('data/Link.php');

        $fieldDefs = $this->getFieldDefinitions();

        //find all definitions of type link.
        if (!empty($fieldDefs))
        {
            foreach ($fieldDefs as $name=>$properties)
            {
                if (array_search('relate',$properties) === 'type')
                {
                    $related_fields[$name]=$properties;
                }
            }
        }

        return $related_fields;
    }

    /**
     * Returns an array of fields that are required for import
     *
     * @return array
     */
    function get_import_required_fields()
    {
        $importable_fields = $this->get_importable_fields();
        $required_fields   = array();

        foreach ( $importable_fields as $name => $properties ) {
            if ( isset($properties['importable']) && is_string($properties['importable']) && $properties['importable'] == 'required' ) {
                $required_fields[$name] = $properties;
            }
        }

        return $required_fields;
    }

    /**
     * Iterates through all the relationships and deletes all records for reach relationship.
     *
     * @param string $id Primary key value of the parent reocrd
     */
    function delete_linked($id)
    {
        // Ensure that Activity Messages do not occur in the context of a Delete action (e.g. unlink)
        // and do so for all nested calls within the Top Level Delete Context
        $opflag = static::enterOperation('delete');
        $aflag = Activity::isEnabled();
        Activity::disable();
        $linked_fields=$this->get_linked_fields();
        foreach ($linked_fields as $name => $value)
        {
            if ($this->load_relationship($name))
            {
                $this->$name->delete($id);
            }
            else
            {
                $GLOBALS['log']->fatal("error loading relationship $name");
            }
        }
        if(static::leaveOperation('delete', $opflag) && $aflag) {
            Activity::enable();
        }

    }

    /**
     * Creates tables for the module implementing the class.
     * If you override this function make sure that your code can handles table creation.
     *
     */
    function create_tables()
    {
        global $dictionary;

        $key = $this->getObjectName();
        if (!array_key_exists($key, $dictionary))
        {
            $GLOBALS['log']->fatal("create_tables: Metadata for table ".$this->table_name. " does not exist");
            display_notice("meta data absent for table ".$this->table_name." keyed to $key ");
        }
        else
        {
            if(!$this->db->tableExists($this->table_name)) {
                $this->db->createTable($this);
                if ($this->bean_implements('ACL')) {
                    $aclList = SugarACL::loadACLs($this->getACLCategory());
                    foreach($aclList as $acl) {
                        if($acl instanceof SugarACLStatic) {
                            $createACL = true;
                        }
                    }
                }
                if(!empty($createACL)) {
                    if (!empty($this->acltype)) {
                        ACLAction::addActions($this->getACLCategory(), $this->acltype);
                    } else {
                        ACLAction::addActions($this->getACLCategory());
                    }
                }
            } else {
                display_notice("Table already exists : {$this->table_name}<br>");
            }
            if($this->is_AuditEnabled()){
                    if (!$this->db->tableExists($this->get_audit_table_name())) {
                        $this->create_audit_table();
                    }
            }

        }
    }

    /**
     * Delete the primary table for the module implementing the class.
     * If custom fields were added to this table/module, the custom table will be removed too, along with the cache
     * entries that define the custom fields.
     *
     */
    function drop_tables()
    {
        global $dictionary;
        $key = $this->getObjectName();
        if (!array_key_exists($key, $dictionary))
        {
            $GLOBALS['log']->fatal("drop_tables: Metadata for table ".$this->table_name. " does not exist");
            echo "meta data absent for table ".$this->table_name."<br>\n";
        } else {
            if(empty($this->table_name))return;
            if ($this->db->tableExists($this->table_name))

                $this->db->dropTable($this);
            if ($this->db->tableExists($this->table_name. '_cstm'))
            {
                $this->db->dropTableName($this->table_name. '_cstm');
                DynamicField::deleteCache();
            }
            if ($this->db->tableExists($this->get_audit_table_name())) {
                $this->db->dropTableName($this->get_audit_table_name());
            }


        }
    }


    /**
     * Loads the definition of custom fields defined for the module.
     * Local file system cache is created as needed.
     *
     * @param string $module_name setting up custom fields for this module.
     * @param boolean $clean_load Optional, default true, rebuilds the cache if set to true.
     */
    function setupCustomFields($module_name, $clean_load=true)
    {
        if (empty($module_name)) {
            // No need to load every single dynamic field here
            return;
        }
        $this->custom_fields = new DynamicField($module_name);
        $this->custom_fields->setup($this);

    }

    /**
    * Cleans char, varchar, text, etc. fields of XSS type materials
    */
    function cleanBean()
    {
        foreach ($this->field_defs as $key => $def) {

            if (isset($def['type'])) {
                $type = $def['type'];
            }
            if (isset($def['dbType'])) {
                $type .= $def['dbType'];
            }

            if ($def['type'] == 'html' || $def['type'] == 'longhtml') {
                $this->$key = SugarCleaner::cleanHtml($this->$key, true);
            } elseif ((strpos($type, 'char') !== false || strpos($type, 'text') !== false || $type == 'enum')
                && !empty($this->$key)
                && strpos($type, 'json') === false
            ) {
                if(!defined('ENTRY_POINT_TYPE') || constant('ENTRY_POINT_TYPE') != 'api') {
                    // for API, text fields are not cleaned, only HTML fields are
                    // since text fields supposed to be encoded by HBS templates when displaying
                    $this->$key = SugarCleaner::cleanHtml($this->$key);
                }
            }
        }
    }

    /**
    * Implements a generic insert and update logic for any SugarBean
    * This method only works for subclasses that implement the same variable names.
    * This method uses the presence of an id field that is not null to signify and update.
    * The id field should not be set otherwise.
    *
    * @param boolean $check_notify Optional, default false, if set to true assignee of the record is notified via email.
    * @todo Add support for field type validation and encoding of parameters.
    */
    function save($check_notify = false)
    {
        $this->in_save = true;
        // cn: SECURITY - strip XSS potential vectors
        $this->cleanBean();
        // This is used so custom/3rd-party code can be upgraded with fewer issues, this will be removed in a future release
        $this->fixUpFormatting();
        global $timedate;
        global $current_user, $action;

        $isUpdate = true;
        if(empty($this->id) || !empty($this->new_with_id)) {
            $isUpdate = false;
        }

		if(empty($this->date_modified) || $this->update_date_modified)
		{
			$this->date_modified = $GLOBALS['timedate']->nowDb();
		}

        $this->_checkOptimisticLocking($action, $isUpdate);

        if(!empty($this->modified_by_name)) $this->old_modified_by_name = $this->modified_by_name;
        if($this->update_modified_by)
        {
            $this->modified_user_id = 1;

            if (!empty($current_user))
            {
                $this->modified_user_id = $current_user->id;
                $this->modified_by_name = $current_user->user_name;
            }
        }
        if ($this->deleted != 1)
            $this->deleted = 0;
        if(!$isUpdate)
        {
            if (empty($this->date_entered))
            {
                $this->date_entered = $this->date_modified;
            }
            if($this->set_created_by == true)
            {
                // created by should always be this user
                $this->created_by = (isset($current_user)) ? $current_user->id : "";
            }
            if( $this->new_with_id == false)
            {
                $this->id = create_guid();
            }
        }


        // if the module has a team_id field and no team_id is specified, set team_id as the current_user's default team
        // currently, the default_team is only enforced in the presentation layer-- this enforces it at the data layer as well

        $usedDefaultTeam = false;
        if (empty($this->team_id) && isset($this->field_defs['team_id']) && isset($current_user)){
            $this->team_id = $current_user->team_id;
            $usedDefaultTeam = true;
        }

        require_once("data/BeanFactory.php");
        BeanFactory::registerBean($this->module_name, $this);

        if (!static::inOperation('saving_related') && static::enterOperation('updating_relationships')) {
            // let subclasses save related field changes
            $this->save_relationship_changes($isUpdate);
            static::leaveOperation('updating_relationships');
        }
        $this->updateCalculatedFields();
        if($isUpdate && !$this->update_date_entered)
        {
            unset($this->date_entered);
        }
        // call the custom business logic
        $custom_logic_arguments = array(
            'check_notify' => $check_notify,
            'isUpdate' => $isUpdate,
        );

        $this->call_custom_logic("before_save", $custom_logic_arguments);
        unset($custom_logic_arguments);

        if(isset($this->custom_fields))
        {
            $this->custom_fields->bean = $this;
            $this->custom_fields->save($isUpdate);
        }
        //rrs new functionality to check if the team_id is set and the team_set_id is not set,
        //then see what we can do about saving to team_set_id. It is important for this code block to be below
        //the 'before_save' custom logic hook as that is where workflow is called.
        if (isset($this->field_defs['team_id'])){
            if(empty($this->teams)){
                $this->load_relationship('teams');
            }
            if(!empty($this->teams)){
                //we do not need to the TeamSetLink to update the bean's table here
                //since it will be handled below.
                $this->teams->save(false, $usedDefaultTeam);
            }
        }

        // use the db independent query generator
        $this->preprocess_fields_on_save();

        $dataChanges = $this->db->getDataChanges($this);

        //construct the SQL to create the audit record if auditing is enabled.
        $auditDataChanges=array();
        if ($this->is_AuditEnabled()) {
            if ($isUpdate && !isset($this->fetched_row)) {
                $GLOBALS['log']->debug('Auditing: Retrieve was not called, audit record will not be created.');
            } else {
                $auditFields = $this->getAuditEnabledFieldDefinitions();
                $auditDataChanges = array_intersect_key($dataChanges, $auditFields);
            }
        }
        $this->_sendNotifications($check_notify);

        if ($isUpdate) {
            $this->db->update($this);
        } elseif ($this->db->insert($this)) {
            //Now that the record has been saved, we don't want to insert again on further saves
            $this->new_with_id = false;
        }

        if (!empty($auditDataChanges) && is_array($auditDataChanges))
        {
            foreach ($auditDataChanges as $change)
            {
                $this->db->save_audit_records($this,$change);
            }
        }

        $this->updateRelatedCalcFields();

        // populate fetched row with newest changes in the bean
        foreach ($dataChanges as $change) {
            $this->fetched_row[$change['field_name']] = $change['after'];
        }

        // the reason we need to skip this is so that any RelatedBeans that are targeted to be saved
        // after the delete happens, wait to be saved till them.
        if (!static::inOperation('delete')) {
            SugarRelationship::resaveRelatedBeans();
        }

        //rrs - bug 7908
        $this->process_workflow_alerts();
        //rrs

        //If we aren't in setup mode and we have a current user and module, then we track
        if(isset($GLOBALS['current_user']) && isset($this->module_dir))
        {
            $this->track_view($current_user->id, $this->module_dir, 'save');
        }

        $this->call_custom_logic('after_save', array(
            'isUpdate' => $isUpdate,
            'dataChanges' => $auditDataChanges,
        ));

        $this->in_save = false;
        return $this->id;
    }

    /**
    * Retrieves and executes the CF dependencies for this bean
    */
    function updateCalculatedFields()
    {
        require_once("include/Expressions/DependencyManager.php");
        $deps = DependencyManager::getCalculatedFieldDependencies($this->field_defs, false, true);
        foreach($deps as $dep)
        {
            if ($dep->getFireOnLoad())
            {
                $dep->fire($this);
            }
        }
        //Check for other on-save dependencies
        $deps = DependencyManager::getModuleDependenciesForAction($this->module_dir, "save");
        foreach($deps as $dep)
        {
            if ($dep->getFireOnLoad())
            {
                $dep->fire($this);
            }
        }
    }

    /**
     * Run any dependency that fields may have
     *
     * @return void
     */
    function updateDependentField($filter_fields = null)
    {
        // This is ignored when coming via a webservice as it's only needed for display and not just raw data.
        // It results in a huge performance gain when pulling multiple records via webservices.
        if(!isset($GLOBALS['service_object']) && !$this->is_updated_dependent_fields) {
            require_once("include/Expressions/DependencyManager.php");

            if (empty($filter_fields)) {
                $filterFields = $this->field_defs;
            }
            else {
                $filterFields = array_intersect_key($this->field_defs, $filter_fields);
            }

            $deps = DependencyManager::getDependentFieldDependencies($filterFields);
            foreach($deps as $dep)
            {
                if ($dep->getFireOnLoad())
                {
                    $dep->fire($this);
                }
            }
        }
    }

    /**
     * Update any related calculated fields
     *
     * @param string $linkName      The specific link that needs updating
     */
    public function updateRelatedCalcFields($linkName = "")
    {
        // we don't have an id, lets not run this code.
        if (empty($this->id) || !empty($this->new_with_id)) {
            return;
        }

        global $dictionary, $sugar_config;

        if(!empty($sugar_config['disable_related_calc_fields'])){
            return;
        }

        if (!static::enterOperation('saving_related')) {
            return;
        }

        // If linkName is empty then we need to handle all links
        if (empty($linkName)) {
            $GLOBALS['log']->debug("Updating records related to {$this->module_dir} {$this->id}");
            if (!empty($dictionary[$this->object_name]['related_calc_fields'])) {
                $links = $dictionary[$this->object_name]['related_calc_fields'];
                foreach($links as $lname) {
                    if ((empty($this->$lname) && !$this->load_relationship($lname)) || !($this->$lname instanceof Link2)) {
                        continue;
                    }

                    $this->addParentRecordsToResave($lname);

                    $influencing_fields = $this->get_fields_influencing_linked_bean_calc_fields($lname);
                    $data_changes = $this->db->getDataChanges($this);
                    $changed_fields = array_keys($data_changes);

                    // if fetched_row is empty we have a new record, so don't check for changed_fields
                    // if deleted is 1, we need to update all related items
                    // the only time we want to check if any of the influcenceing fields have changed is when, it's a, non-deleted record
                    // and when we are updating a row.
                    if (!empty($this->fetched_row) && $this->deleted == 0 && !array_intersect($influencing_fields, $changed_fields)) {
                        continue;
                    }

                    $beans = $this->$lname->getBeans();
                    //Resave any related beans
                    if(!empty($beans))  {
                        foreach($beans as $rBean) {
                            if (empty($rBean->deleted)) {
                                SugarRelationship::addToResaveList($rBean);
                            }
                        }
                    }
                }
            }
        }
        else if ($this->has_calc_field_with_link($linkName)) {
            //Save will update the saved_beans array
            SugarRelationship::addToResaveList($this);
        }

        static::leaveOperation('saving_related');
    }

    protected function addParentRecordsToResave($lname) {
        //If this module has a parent field that changed, resave the old parent
        //Check that the fields are set in the request and that they don't match the current values.
        if (!empty($this->field_defs['parent_type']) && $this->field_defs['parent_type']['type'] == 'parent_type'
            && !empty($this->field_defs['parent_id']) && $this->field_defs['parent_id']['type'] == 'id'
            && !empty($this->fetched_row['parent_type']) && !empty($this->fetched_row['parent_id'])
            && (!isset($this->parent_id) || $this->parent_id != $this->fetched_row['parent_id']))
        {
            if ($this->$lname->getRelatedModuleName() == $this->fetched_row['parent_type'])
            {
                SugarRelationship::addToResaveList(
                    BeanFactory::getBean($this->fetched_row['parent_type'], $this->fetched_row['parent_id'])
                );
            }
        }
        //If we have a new parent record that uses this link, make sure to resave that one as well
        if (!empty($this->field_defs['parent_type']) && $this->field_defs['parent_type']['type'] == 'parent_type'
            && !empty($this->field_defs['parent_id']) && $this->field_defs['parent_id']['type'] == 'id'
            && isset($this->parent_id) && $this->parent_id != $this->fetched_row['parent_id']
            && isset($this->parent_type) && $this->$lname->getRelatedModuleName() == $this->parent_type
        ) {
            SugarRelationship::addToResaveList(
                BeanFactory::getBean($this->parent_type, $this->parent_id)
            );
        }
    }


    /**
     * Tests if the current module has a calculated field with a link.
     * if a link name is specified, it will return true when a field uses that specific link
     * Otherwise it will test for all link fields.
     * @param string $linkName
     * @return bool
     */
    function has_calc_field_with_link($linkName = ""){
        $links = array();
        if (empty($linkName))
        {
            foreach ($this->field_defs as $field => $def)
            {
                if (!empty ($def['type']) && $def['type'] == "link")
                    $links[$field] = true;
            }
        }
        else {
            $links[$linkName] = true;
        }
        if (!empty($links))
        {
            foreach($this->field_defs as $name => $def)
            {
                //Look through all calculated fields for uses of this link field
                if(!empty($def['formula']))
                {
		    require_once("include/Expressions/Expression/Parser/Parser.php");
                    $fields = Parser::getFieldsFromExpression($def['formula']);
                    foreach($fields as $var)
                    {
                        if (!empty($links[$var]))
                            return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Performs a check if the record has been modified since the specified date
     *
     * @param date $date Datetime for verification
     * @param string $modified_user_id User modified by
     */
    function has_been_modified_since($date, $modified_user_id)
    {
        global $current_user;
        $date = $this->db->convert($this->db->quoted($date), 'datetime');
        if (isset($current_user))
        {
            $query = "SELECT date_modified FROM $this->table_name WHERE id='$this->id' AND modified_user_id != '$current_user->id'
            	AND (modified_user_id != '$modified_user_id' OR date_modified > $date)";
            $result = $this->db->query($query);

            if($this->db->fetchByAssoc($result))
            {
                return true;
            }
        }
        return false;
    }

    /**
    * Determines which users receive a notification
    */
    function get_notification_recipients() {
        $user_list = array();
        if(isset($this->assigned_user_id) && !empty($this->assigned_user_id)) {
            $notify_user = BeanFactory::retrieveBean('Users', $this->assigned_user_id);
            if ( ! $notify_user ) {
                // The user to notify has been deleted.
                return $user_list;
            }
            $this->new_assigned_user_name = $notify_user->full_name;

            $GLOBALS['log']->info("Notifications: recipient is $this->new_assigned_user_name");

            $user_list[] = $notify_user;
        }
        return $user_list;
    }

    protected function create_notification_email($notify_user) {
        return MailerFactory::getSystemDefaultMailer();
    }

    protected function getTemplateNameForNotificationEmail() {
        global $beanList;

        $templateName = null;

        if ($this->module_dir == "Cases") {
            $templateName = "Case"; //we should use Case, you can refer to the en_us.notify_template.html.
        } else {
            $templateName = $beanList[$this->module_dir]; //bug 20637, in workflow this->object_name = strange chars.
        }

        if (!in_array('set_notification_body', get_class_methods($this))) {
            $templateName = "Default";
        }

        if (!empty($_SESSION["special_notification"]) && $_SESSION["special_notification"]) {
            $templateName = $beanList[$this->module_dir].'Special';
        }

        if ($this->special_notification) {
            $templateName = $beanList[$this->module_dir].'Special';
        }

        return $templateName;
    }

    /**
    * Handles sending out email notifications when items are first assigned to users
    *
    * @param string $notify_user user to notify
    * @param string $admin the admin user that sends out the notification
    */
    function send_assignment_notifications($notify_user, $admin) {
        if ( ($this->object_name == 'Meeting' || $this->object_name == 'Call')
            || (isset($notify_user->receive_notifications) && $notify_user->receive_notifications) ) {
            $this->current_notify_user = $notify_user;

            $templateName = $this->getTemplateNameForNotificationEmail();
            $xtpl         = $this->createNotificationEmailTemplate($templateName);
            $subject      = $xtpl->text($templateName . "_Subject");
            $body         = trim($xtpl->text($templateName));


            $mailTransmissionProtocol = "unknown";

            try {
                $mailer                   = $this->create_notification_email($notify_user);
                $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();

                // by default, use the following admin settings for the From email header
                $fromEmail = $admin->settings['notify_fromaddress'];
                $fromName  = $admin->settings['notify_fromname'];

                if (!empty($admin->settings['notify_send_from_assigning_user'])) {
                    // the "notify_send_from_assigning_user" admin setting is set
                    // use the current user's email address and name for the From email header
                    $usersEmail = $GLOBALS["current_user"]->emailAddress->getReplyToAddress($GLOBALS["current_user"]);
                    $usersName  = $GLOBALS["current_user"]->full_name;

                    // only use it if a valid email address is returned for the current user
                    if (!empty($usersEmail)) {
                        $fromEmail = $usersEmail;
                        $fromName = $usersName;
                    }
                }

                // set the From and Reply-To email headers according to the values determined above (either default
                // or current user)
                $from = new EmailIdentity($fromEmail, $fromName);
                $mailer->setHeader(EmailHeaders::From, $from);
                $mailer->setHeader(EmailHeaders::ReplyTo, $from);

                // set the subject of the email
                $mailer->setSubject($subject);

                // set the body of the email...
                $textOnly = EmailFormatter::isTextOnly($body);
                if ($textOnly) {
                    $mailer->setTextBody($body);
                } else {
                    $textBody = strip_tags(br2nl($body)); // need to create the plain-text part
                    $mailer->setTextBody($textBody);
                    $mailer->setHtmlBody($body);
                }

                // add the recipient
                $recipientEmailAddress = $notify_user->emailAddress->getPrimaryAddress($notify_user);
                $recipientName         = $notify_user->full_name;

                try {
                    $mailer->addRecipientsTo(new EmailIdentity($recipientEmailAddress, $recipientName));
                } catch (MailerException $me) {
                    $GLOBALS['log']->warn("Notifications: no e-mail address set for user {$notify_user->user_name}, cancelling send");
                }

                $mailer->send();
                $GLOBALS['log']->info("Notifications: e-mail successfully sent");
            } catch (MailerException $me) {
                $message = $me->getMessage();

                switch ($me->getCode()) {
                    case MailerException::FailedToConnectToRemoteServer:
                        $GLOBALS['log']->error("Notifications: error sending e-mail, smtp server was not found ");
                        break;
                    default:
                        $GLOBALS['log']->error("Notifications: error sending e-mail (method: {$mailTransmissionProtocol}), (error: {$message})");
                        break;
                }
            }
        }
    }

   /**
    * This function handles create the email notifications email.
    * @param string $templateName the name of the template used for the email content
    * @return XTemplate
    */
    protected function createNotificationEmailTemplate($templateName) {
        global $sugar_config,
               $current_user,
               $sugar_version;

        $currentLanguage = (!empty($_SESSION['authenticated_user_language'])) ?
            $_SESSION['authenticated_user_language'] :
            $sugar_config['default_language'];

        $xtpl = new XTemplate(get_notify_template_file($currentLanguage));

        if (in_array('set_notification_body', get_class_methods($this))) {
            $xtpl = $this->set_notification_body($xtpl, $this);
        } else {
            $xtpl->assign("OBJECT", translate('LBL_MODULE_NAME'));
        }

        $xtpl->assign("ASSIGNED_USER", $this->new_assigned_user_name);
        $xtpl->assign("ASSIGNER", $current_user->name);

        $parsedSiteUrl = parse_url($sugar_config['site_url']);
        $host          = $parsedSiteUrl['host'];

        if (!isset($parsedSiteUrl['port'])) {
            $parsedSiteUrl['port'] = 80;
        }

        $port		= ($parsedSiteUrl['port'] != 80) ? ":".$parsedSiteUrl['port'] : '';
        $path		= !empty($parsedSiteUrl['path']) ? $parsedSiteUrl['path'] : "";
        $cleanUrl	= "{$parsedSiteUrl['scheme']}://{$host}{$port}{$path}";

        $xtpl->assign("URL", $cleanUrl."/index.php?module={$this->module_dir}&action=DetailView&record={$this->id}");
        $xtpl->assign("SUGAR", "Sugar v{$sugar_version}");
        $xtpl->parse($templateName);
        $xtpl->parse($templateName . "_Subject");

        return $xtpl;
    }

    /**
     * This function is a good location to save changes that have been made to a relationship.
     * This should be overridden in subclasses that have something to save.
     *
     * @param boolean $is_update    true if this save is an update.
     * @param array $exclude        a way to exclude relationships
     */
    public function save_relationship_changes($is_update, $exclude = array())
    {
        list($new_rel_id, $new_rel_link) = $this->set_relationship_info($exclude);

        $new_rel_id = $this->handle_preset_relationships($new_rel_id, $new_rel_link, $exclude);

        $this->handle_remaining_relate_fields($exclude);

        $this->update_parent_relationships($exclude);

        $this->handle_request_relate($new_rel_id, $new_rel_link);
    }

    /**
     * Look in the bean for the new relationship_id and relationship_name if $this->not_use_rel_in_req is set to true,
     * otherwise check the $_REQUEST param for a relate_id and relate_to field.  Once we have that make sure that it's
     * not excluded from the passed in array of relationships to exclude
     *
     * @param array $exclude        any relationship's to exclude
     * @return array                The relationship_id and relationship_name in an array
     */
    protected function set_relationship_info($exclude = array())
    {

        $new_rel_id = false;
        $new_rel_link = false;
        // check incoming data
        if (isset($this->not_use_rel_in_req) && $this->not_use_rel_in_req == true) {
            // if we should use relation data from properties (for REQUEST-independent calls)
            $rel_id = isset($this->new_rel_id) ? $this->new_rel_id : '';
            $rel_link = isset($this->new_rel_relname) ? $this->new_rel_relname : '';
        }
        else
        {
            // if we should use relation data from REQUEST
            $rel_id = isset($_REQUEST['relate_id']) ? $_REQUEST['relate_id'] : '';
            $rel_link = isset($_REQUEST['relate_to']) ? $_REQUEST['relate_to'] : '';
        }

        // filter relation data
        if ($rel_id && $rel_link && !in_array($rel_link, $exclude) && $rel_id != $this->id) {
            $new_rel_id = $rel_id;
            $new_rel_link = $rel_link;
            // Bug #53223 : wrong relationship from subpanel create button
            // if LHSModule and RHSModule are same module use left link to add new item b/s of:
            // $rel_id and $rel_link are not emty - request is from subpanel
            // $rel_link contains relationship name - checked by call load_relationship
            $isRelationshipLoaded = $this->load_relationship($rel_link);
            if ($isRelationshipLoaded && !empty($this->$rel_link) && $this->$rel_link->getRelationshipObject() && $this->$rel_link->getRelationshipObject()->getLHSModule() == $this->$rel_link->getRelationshipObject()->getRHSModule() )
            {
                // It's a self-referencing relationship
                if ( $this->$rel_link->getRelationshipObject()->getLHSLink() != $this->$rel_link->getRelationshipObject()->getRHSLink() ) {
                    $new_rel_link = $this->$rel_link->getRelationshipObject()->getRHSLink();
                } else {
                    // Doesn't have a right hand side, so let's just use the LHS
                    $new_rel_link = $this->$rel_link->getRelationshipObject()->getLHSLink();
                }
            }
            else
            {
                //Try to find the link in this bean based on the relationship
                foreach ($this->field_defs as $key => $def)
                {
                    if (isset($def['type']) && $def['type'] == 'link' && isset($def['relationship']) && $def['relationship'] == $rel_link)
                    {
                        $new_rel_link = $key;
                    }
                }
            }
        }

        return array($new_rel_id, $new_rel_link);
    }

    /**
     * Handle the preset fields listed in the fixed relationship_fields array hardcoded into the OOB beans
     *
     * TODO: remove this mechanism and replace with mechanism exclusively based on the vardefs
     *
     * @api
     * @see save_relationship_changes
     * @param string|boolean $new_rel_id    String of the ID to add
     * @param string                        Relationship Name
     * @param array $exclude                any relationship's to exclude
     * @return string|boolean               Return the new_rel_id if it was not used.  False if it was used.
     */
    protected function handle_preset_relationships($new_rel_id, $new_rel_link, $exclude = array())
    {
        if (isset($this->relationship_fields) && is_array($this->relationship_fields)) {
            foreach ($this->relationship_fields as $id => $rel_name)
            {

                if (in_array($id, $exclude)) continue;

                if(!empty($this->$id))
                {
                    // Bug #44930 We do not need to update main related field if it is changed from sub-panel.
                    if ($rel_name == $new_rel_link && $this->$id != $new_rel_id)
                    {
                        $new_rel_id = '';
                    }
                    $GLOBALS['log']->debug('save_relationship_changes(): From relationship_field array - adding a relationship record: '.$rel_name . ' = ' . $this->$id);
                    //already related the new relationship id so let's set it to false so we don't add it again using the _REQUEST['relate_i'] mechanism in a later block
                    $this->load_relationship($rel_name);
                    $rel_add = $this->$rel_name->add($this->$id);
                    // move this around to only take out the id if it was save successfully
                    if ($this->$id == $new_rel_id && $rel_add == true) {
                        $new_rel_id = false;
                    }
                } else {
                    //if before value is not empty then attempt to delete relationship
                    if (!empty($this->rel_fields_before_value[$id])) {
                        $GLOBALS['log']->debug('save_relationship_changes(): From relationship_field array - attempting to remove the relationship record, using relationship attribute' . $rel_name);
                        $this->load_relationship($rel_name);
                        $this->$rel_name->delete($this->id, $this->rel_fields_before_value[$id]);
                    }
                }
            }
        }

        return $new_rel_id;
    }

    /**
     * Next, we'll attempt to update all of the remaining relate fields in the vardefs that have 'save' set in their field_def
     * Only the 'save' fields should be saved as some vardef entries today are not for display only purposes and break the application if saved
     * If the vardef has entries for field <a> of type relate, where a->id_name = <b> and field <b> of type link
     * then we receive a value for b from the MVC in the _REQUEST, and it should be set in the bean as $this->$b
     *
     * @api
     * @see save_relationship_changes
     * @param array $exclude            any relationship's to exclude
     * @return array                    the list of relationships that were added or removed successfully or if they were a failure
     */
    protected function handle_remaining_relate_fields($exclude = array())
    {

        $modified_relationships = array(
            'add' => array('success' => array(), 'failure' => array()),
            'remove' => array('success' => array(), 'failure' => array()),
        );

        foreach ($this->field_defs as $def)
        {
            if ($def ['type'] == 'relate' && isset ($def ['id_name']) && isset ($def ['link'])) {
                $linkField = $def ['link'];
                if (isset ($def['save']))
                {
                    if (in_array($def['id_name'], $exclude) || in_array($def['id_name'], $this->relationship_fields))
                        continue; // continue to honor the exclude array and exclude any relationships that will be handled by the relationship_fields mechanism

                    if (isset($this->field_defs[$linkField])) {
                        if ($this->load_relationship($linkField)) {
                            $idName = $def['id_name'];

                            if (!empty($this->rel_fields_before_value[$idName]) && empty($this->$idName)) {
                                //if before value is not empty then attempt to delete relationship
                                $GLOBALS['log']->debug("save_relationship_changes(): From field_defs - attempting to remove the relationship record: {$def [ 'link' ]} = {$this->rel_fields_before_value[$def [ 'id_name' ]]}");
                                $success = $this->$def ['link']->delete($this->id, $this->rel_fields_before_value[$def ['id_name']]);
                                // just need to make sure it's true and not an array as it's possible to return an array
                                if($success == true) {
                                    $modified_relationships['remove']['success'][] = $def['link'];
                                } else {
                                    $modified_relationships['remove']['failure'][] = $def['link'];
                                }
                                $GLOBALS['log']->debug("save_relationship_changes(): From field_defs - attempting to remove the relationship record returned " . var_export($success, true));
                            }

                            if (!empty($this->$idName) && is_string($this->$idName)) {
                                $GLOBALS['log']->debug("save_relationship_changes(): From field_defs - attempting to add a relationship record - {$def [ 'link' ]} = {$this->$def [ 'id_name' ]}");

                                $success = $this->$linkField->add($this->$idName);

                                // just need to make sure it's true and not an array as it's possible to return an array
                                if($success == true) {
                                    $modified_relationships['add']['success'][] = $linkField;
                                } else {
                                    $modified_relationships['add']['failure'][] = $linkField;
                                }

                                $GLOBALS['log']->debug("save_relationship_changes(): From field_defs - add a relationship record returned " . var_export($success, true));
                            }
                        } else {
                            $GLOBALS['log']->fatal("Failed to load relationship {$linkField} while saving {$this->module_dir}");
                        }
                    }
                }
                else if (!empty($this->$linkField) && is_a($this->$linkField, "Link2")) {
                    //We need to mark these links as out of date, even if we aren't going to update them yet
                    $this->$linkField->resetLoaded();
                }
            }
        }

        return $modified_relationships;
    }


    /**
     * Updates relationships based on changes to fields of type 'parent' which
     * may or may not have links associated with them
     *
     * @param array $exclude
     */
    protected function update_parent_relationships($exclude = array())
    {
        foreach ($this->field_defs as $def)
        {
            if (!empty($def['type']) && $def['type'] == "parent")
            {
                if (empty($def['type_name']) || empty($def['id_name']))
                    continue;
                $typeField = $def['type_name'];
                $idField = $def['id_name'];

                // save the new id
                $newIdValue = $this->$idField;
                if (in_array($idField, $exclude))
                    continue;
                //Determine if the parent field has changed.
                if (
                    //First check if the fetched row parent existed and now we no longer have one
                    (!empty($this->fetched_row[$typeField]) && !empty($this->fetched_row[$idField])
                        && (empty($this->$typeField) || empty($this->$idField))
                    ) ||
                    //Next check if we have one now that doesn't match the fetch row
                    (!empty($this->$typeField) && !empty($this->$idField) &&
                        (empty($this->fetched_row[$typeField]) || empty($this->fetched_row[$idField])
                        || $this->fetched_row[$idField] != $this->$idField)
                    ) ||
                    // Check if we are deleting the bean, should remove the bean from any relationships
                    $this->deleted == 1
                ) {
                    $parentLinks = array();
                    //Correlate links to parent field module types
                    foreach ($this->field_defs as $ldef)
                    {
                        if (!empty($ldef['type']) && $ldef['type'] == "link" && !empty($ldef['relationship']))
                        {
                            $relDef = SugarRelationshipFactory::getInstance()->getRelationshipDef($ldef['relationship']);
                            if (!empty($relDef['relationship_role_column']) && $relDef['relationship_role_column'] == $typeField)
                            {
                                $parentLinks[$relDef['lhs_module']] = $ldef;
                            }
                        }
                    }

                    //If we used to have a parent, call remove on that relationship
                    if (!empty($this->fetched_row[$typeField]) && !empty($this->fetched_row[$idField])
                        && !empty($parentLinks[$this->fetched_row[$typeField]])
                        && ($this->fetched_row[$idField] != $this->$idField))
                    {
                        $oldParentLink = $parentLinks[$this->fetched_row[$typeField]]['name'];
                        //Load the relationship
                        if ($this->load_relationship($oldParentLink))
                        {
                            $this->$oldParentLink->delete($this->fetched_row[$idField]);
                            // Should resave the old parent, if the current user has access to it and can save it
                            $beanToSave = BeanFactory::getBean($this->fetched_row[$typeField], $this->fetched_row[$idField]);
                            if (!empty($beanToSave->id)) {
                                SugarRelationship::addToResaveList($beanToSave);
                            }
                        }
                    }

                    // If both parent type and parent id are set, save it unless the bean is being deleted
                    if (!empty($this->$typeField) && !empty($newIdValue) && !empty($parentLinks[$this->$typeField]['name']) && $this->deleted != 1)
                    {
                        //Now add the new parent
                        $parentLink = $parentLinks[$this->$typeField]['name'];
                        if ($this->load_relationship($parentLink))
                        {
                            $this->$parentLink->add($newIdValue);
                        }
                    }
                }
            }
        }
    }

    /**
     * Finally, we update a field listed in the _REQUEST['%/relate_id']/_REQUEST['relate_to'] mechanism (if it has not already been updated)
     *
     * @api
     * @see save_relationship_changes
     * @param string|boolean $new_rel_id
     * @param string $new_rel_link
     * @return boolean
     */
    protected function handle_request_relate($new_rel_id, $new_rel_link)
    {
        if (!empty($new_rel_id)) {

            if ($this->load_relationship($new_rel_link)) {
                return $this->$new_rel_link->add($new_rel_id);
            } else {
                $lower_link = strtolower($new_rel_link);
                if ($this->load_relationship($lower_link)) {
                    return $this->$lower_link->add($new_rel_id);

                } else {
                    require_once('data/Link2.php');
                    $rel = Relationship::retrieve_by_modules($new_rel_link, $this->module_dir, $this->db, 'many-to-many');

                    if (!empty($rel)) {
                        foreach ($this->field_defs as $field => $def) {
                            if ($def['type'] == 'link' && !empty($def['relationship']) && $def['relationship'] == $rel) {
                                $this->load_relationship($field);
                                return $this->$field->add($new_rel_id);
                            }

                        }
                        //ok so we didn't find it in the field defs let's save it anyway if we have the relationshp
                        $this->$rel = new Link2($rel, $this, array());
                        return $this->$rel->add($new_rel_id);
                    }
                }
            }
        }

        // nothing was saved so just return false;
        return false;
    }

    /**
    * This function retrieves a record of the appropriate type from the DB.
    * It fills in all of the fields from the DB into the object it was called on.
    *
    * @param $id - If ID is specified, it overrides the current value of $this->id.  If not specified the current value of $this->id will be used.
    * @return this - The object that it was called apon or null if exactly 1 record was not found.
    *
	*/

	function check_date_relationships_load()
	{
		global $disable_date_format;
		global $timedate;
		if (empty($timedate))
			$timedate=TimeDate::getInstance();

		if(empty($this->field_defs))
		{
			return;
		}
		foreach($this->field_defs as $fieldDef)
		{
			$field = $fieldDef['name'];
			if(!isset($this->processed_dates_times[$field]))
			{
				$this->processed_dates_times[$field] = '1';
				if(empty($this->$field)) continue;
				if($field == 'date_modified' || $field == 'date_entered')
				{
					$this->$field = $this->db->fromConvert($this->$field, 'datetime');
					if(empty($disable_date_format)) {
						$this->$field = $timedate->to_display_date_time($this->$field);
					}
				}
				elseif(isset($this->field_name_map[$field]['type']))
				{
					$type = $this->field_name_map[$field]['type'];

					if($type == 'relate'  && isset($this->field_name_map[$field]['custom_module']))
					{
						$type = $this->field_name_map[$field]['type'];
					}

					if($type == 'date')
					{
						if($this->$field == '0000-00-00')
						{
							$this->$field = '';
						} elseif(!empty($this->field_name_map[$field]['rel_field']))
						{
							$rel_field = $this->field_name_map[$field]['rel_field'];

							if(!empty($this->$rel_field))
							{
								if(empty($disable_date_format)) {
									$mergetime = $timedate->merge_date_time($this->$field,$this->$rel_field);
									$this->$field = $timedate->to_display_date($mergetime);
									$this->$rel_field = $timedate->to_display_time($mergetime);
								}
							}
						}
						else
						{
							if(empty($disable_date_format)) {
								$this->$field = $timedate->to_display_date($this->$field, false);
							}
						}
					} elseif($type == 'datetime' || $type == 'datetimecombo')
					{
						if($this->$field == '0000-00-00 00:00:00')
						{
							$this->$field = '';
						}
						else
						{
							if(empty($disable_date_format)) {
								$this->$field = $timedate->to_display_date_time($this->$field, true, true);
							}
						}
					} elseif($type == 'time')
					{
						if($this->$field == '00:00:00')
						{
							$this->$field = '';
						} else
						{
							//$this->$field = from_db_convert($this->$field, 'time');
							if(empty($this->field_name_map[$field]['rel_field']) && empty($disable_date_format))
							{
								$this->$field = $timedate->to_display_time($this->$field,true, false);
							}
						}
					} elseif($type == 'encrypt' && empty($disable_date_format)){
					    $this->encfields[$field] = $this->$field;
					    unset($this->$field); // unset it so when it is accessed the data comes through __get
					}
				}
			}
		}
	}

    /**
     * This function processes the fields before save.
     * Interal function, do not override.
     */
    function preprocess_fields_on_save()
    {
        $GLOBALS['log']->deprecated('SugarBean.php: preprocess_fields_on_save() is deprecated');
    }

    /**
    * Removes formatting from values posted from the user interface.
     * It only unformats numbers.  Function relies on user/system prefernce for format strings.
     *
     * Internal Function, do not override.
    */
    function unformat_all_fields()
    {
        $GLOBALS['log']->deprecated('SugarBean.php: unformat_all_fields() is deprecated');
    }

    /**
    * This functions adds formatting to all number fields before presenting them to user interface.
     *
     * Internal function, do not override.
    */
    function format_all_fields()
    {
        $GLOBALS['log']->deprecated('SugarBean.php: format_all_fields() is deprecated');
    }

    function format_field($fieldDef)
        {
        $GLOBALS['log']->deprecated('SugarBean.php: format_field() is deprecated');
        }

    /**
     * Function corrects any bad formatting done by 3rd party/custom code
     *
     * This function will be removed in a future release, it is only here to assist upgrading existing code that expects formatted data in the bean
     */
    function fixUpFormatting()
    {
        global $timedate;
        static $boolean_false_values = array('off', 'false', '0', 'no');


        foreach($this->field_defs as $field=>$def)
            {
            if ( !isset($this->$field) ) {
                continue;
                }
            if ( (isset($def['source'])&&$def['source']=='non-db') || $field == 'deleted' ) {
                continue;
            }
            if ( isset($this->fetched_row[$field]) && $this->$field == $this->fetched_row[$field] ) {
                // Don't hand out warnings because the field was untouched between retrieval and saving, most database drivers hand pretty much everything back as strings.
                continue;
            }
            $reformatted = false;
            switch($def['type']) {
                case 'datetime':
                case 'datetimecombo':
                    if(empty($this->$field)) break;
                    if ($this->$field == 'NULL') {
                    	$this->$field = '';
                    	break;
                    }
                    if ( ! preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/',$this->$field) ) {
                        // This appears to be formatted in user date/time
                        $this->$field = $timedate->to_db($this->$field);
                        $reformatted = true;
                    }
                    break;
                case 'date':
                    if(empty($this->$field)) break;
                    if ($this->$field == 'NULL') {
                    	$this->$field = '';
                    	break;
                    }
                    if ( ! preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',$this->$field) ) {
                        // This date appears to be formatted in the user's format
                        $this->$field = $timedate->to_db_date($this->$field, false);
                        $reformatted = true;
                    }
                    break;
                case 'time':
                    if(empty($this->$field)) break;
                    if ($this->$field == 'NULL') {
                    	$this->$field = '';
                    	break;
                    }
                    if ( preg_match('/(am|pm)/i',$this->$field) ) {
                        // This time appears to be formatted in the user's format
                        $this->$field = $timedate->fromUserTime($this->$field)->format(TimeDate::DB_TIME_FORMAT);
                        $reformatted = true;
                    }
                    break;
                case 'decimal':
                case 'currency':
                    if ( $this->$field === '' || $this->$field == null || $this->$field == 'NULL') {
                        continue;
                    }
                    // always want string for currency/decimal values
                    if(!is_string($this->$field) || !is_numeric($this->$field)) {
                        $this->$field = (string)unformat_number($this->$field);
                        $reformatted = true;
                    }
                    break;
                case 'double':
                case 'float':
                    if ( $this->$field === '' || $this->$field == null || $this->$field == 'NULL') {
                        continue;
                    }
                    if ( is_string($this->$field) ) {
                        $this->$field = (float)unformat_number($this->$field);
                        $reformatted = true;
                    }
                    break;
               case 'uint':
               case 'ulong':
               case 'long':
               case 'short':
               case 'tinyint':
               case 'int':
                    if ( $this->$field === '' || $this->$field == null || $this->$field == 'NULL') {
                        continue;
                    }
                    if ( is_string($this->$field) ) {
                        $this->$field = (int)unformat_number($this->$field);
                        $reformatted = true;
                    }
                   break;
               case 'bool':
                   if (empty($this->$field)) {
                       $this->$field = false;
                   } else if(true === $this->$field || 1 == $this->$field) {
                       $this->$field = true;
                   } else if(in_array(strval($this->$field), $boolean_false_values)) {
                       $this->$field = false;
                       $reformatted = true;
                   } else {
                       $this->$field = true;
                       $reformatted = true;
                   }
                   break;
               case 'encrypt':
                    $this->$field = $this->encrpyt_before_save($this->$field);
                    break;
            }
            if ( $reformatted ) {
                $GLOBALS['log']->deprecated('Formatting correction: '.$this->module_dir.'->'.$field.' had formatting automatically corrected. This will be removed in the future, please upgrade your external code');
            }
        }

    }

    protected function getUsersJoin($field, $alias)
    {
        return array(
            ", users_$alias.first_name as {$alias}_first_name, users_$alias.last_name as {$alias}_last_name",
            " LEFT JOIN users users_$alias ON users_$alias.id = {$this->table_name}.$field"
        );
    }


    /**
     * Function fetches a single row of data given the primary key value.
     *
     * The fetched data is then set into the bean. The function also processes the fetched data by formattig
     * date/time and numeric values.
     *
     * @param string $id Optional, default -1, is set to -1 id value from the bean is used, else, passed value is used
     * @param boolean $encode Optional, default true, encodes the values fetched from the database.
     * @param boolean $deleted Optional, default true, if set to false deleted filter will not be added.
     *
     * Internal function, do not override.
    */
    function retrieve($id='-1', $encode=true,$deleted=true)
    {

        $custom_logic_arguments['id'] = $id;
        $this->call_custom_logic('before_retrieve', $custom_logic_arguments);

        if ($id == -1)
        {
            $id = $this->id;
        }
        if (empty($this->table_name)) {
            // I don't know how to fetch from something without a table
            return null;
        }

        $custom_join = $this->getCustomJoin();

        $query_select = "{$this->table_name}.*";
        $query_from = $this->table_name;
        $where = " WHERE $this->table_name.id = ".$this->db->quoted($id);
        if ($deleted) $where .= " AND $this->table_name.deleted=0";

        $query_select .= " ".$custom_join['select'];
        $query_from .= ' '.$custom_join['join'];

        // Add user names
        if(!empty($this->field_defs['assigned_user_name']) && !empty($this->field_defs['assigned_user_id'])) {
            list($usel, $ufrom) = $this->getUsersJoin("assigned_user_id", 'au');
            $query_select .= $usel;
            $query_from .= $ufrom;
        }
        if(!empty($this->field_defs['created_by_name']) && !empty($this->field_defs['created_by'])) {
            list($usel, $ufrom) = $this->getUsersJoin("created_by", 'cbu');
            $query_select .= $usel;
            $query_from .= $ufrom;
        }
        if(!empty($this->field_defs['modified_by_name']) && !empty($this->field_defs['modified_user_id'])) {
        	list($usel, $ufrom) = $this->getUsersJoin("modified_user_id", 'mbu');
        	$query_select .= $usel;
        	$query_from .= $ufrom;
        }
        if(!empty($this->field_defs['team_name']) && !empty($this->field_defs['team_id']) && (empty($this->field_defs['team_id']['source']))) {
            $query_select .= ", teams_tn.name as tn_name, teams_tn.name_2 as tn_name_2";
            $query_from .= " LEFT JOIN teams teams_tn ON teams_tn.id = {$this->table_name}.team_id";
        }





        // ADD FAVORITES LEFT JOIN, this will add favorites to the bean
        // TODO: add global vardef for my_favorite field
        // We should only add Favorites if we know what module we are using and if we have a user.

        if(isset($this->module_name) && !empty($this->module_name) && !empty($GLOBALS['current_user']) && $this->isFavoritesEnabled()) {
            $query_select .= ', sf.id AS my_favorite';
            $query_from .= " LEFT JOIN sugarfavorites sf ON sf.deleted = 0 AND sf.module = '{$this->module_name}' AND sf.record_id = {$this->db->quoted($id)} AND sf.assigned_user_id = '{$GLOBALS['current_user']->id}'";
        }

        $query = "SELECT $query_select FROM $query_from ";
        if(!$this->disable_row_level_security)
        {
            //$this->table_name != 'users' && $this->table_name != 'teams' && $this->table_name != 'team_memberships' && $this->table_name != 'currencies')
            $this->addVisibilityFrom($query);
        }

        $query .= $where;
        if(!$this->disable_row_level_security) {
            $this->addVisibilityWhere($query);
        }

        $GLOBALS['log']->debug("Retrieve $this->object_name : ".$query);
        $result = $this->db->limitQuery($query,0,1,true, "Retrieving record by id $this->table_name:$id found ");
        if(empty($result))
        {
            return null;
        }

        $row = $this->db->fetchByAssoc($result, $encode);
        if(empty($row))
        {
            return null;
        }

        //make copy of the fetched row for construction of audit record and for business logic/workflow
        $this->fetched_row=$this->populateFromRow($row, true);

        global $module, $action;
        //Just to get optimistic locking working for this release
        if($this->optimistic_lock && $module == $this->module_dir && $action =='EditView' )
        {
            $_SESSION['o_lock_id']= $id;
            $_SESSION['o_lock_dm']= $this->date_modified;
            $_SESSION['o_lock_on'] = $this->object_name;
        }
        $this->processed_dates_times = array();
        $this->check_date_relationships_load();

        if(isset($this->custom_fields))
        {
            $this->custom_fields->fill_relationships();
        }

		$this->is_updated_dependent_fields = false;
        $this->fill_in_additional_detail_fields();
        $this->fill_in_relationship_fields();
// save related fields values for audit
         foreach ($this->get_related_fields() as $rel_field_name)
         {
             if (! empty($this->$rel_field_name['name']))
             {
                 $this->fetched_rel_row[$rel_field_name['name']] = $this->$rel_field_name['name'];
             }
         }
        //make a copy of fields in the relationship_fields array. These field values will be used to
        //clear relationship.
        foreach ( $this->field_defs as $key => $def )
        {
            if ($def [ 'type' ] == 'relate' && isset ( $def [ 'id_name'] ) && isset ( $def [ 'link'] ) && isset ( $def[ 'save' ])) {
                if (isset($this->$key)) {
                    $this->rel_fields_before_value[$key]=$this->$key;
                    if (isset($this->$def [ 'id_name']))
                        $this->rel_fields_before_value[$def [ 'id_name']]=$this->$def [ 'id_name'];
                }
                else
                    $this->rel_fields_before_value[$key]=null;
           }
        }
        if (isset($this->relationship_fields) && is_array($this->relationship_fields))
        {
            foreach ($this->relationship_fields as $rel_id=>$rel_name)
            {
                if (isset($this->$rel_id))
                    $this->rel_fields_before_value[$rel_id]=$this->$rel_id;
                else
                    $this->rel_fields_before_value[$rel_id]=null;
            }
        }

        // call the custom business logic
        $custom_logic_arguments['id'] = $id;
        $custom_logic_arguments['encode'] = $encode;
        $this->call_custom_logic("after_retrieve", $custom_logic_arguments);
        unset($custom_logic_arguments);
        return $this;
    }

    /**
     * Sets value from fetched row into the bean.
     *
     * @param array $row Fetched row
     * @param bool $convert Apply convertField to fields
     *
     * Internal function, do not override.
     */
    function populateFromRow($row, $convert = false)
    {
        foreach($this->field_defs as $field=>$field_value)
        {
            if(isset($row[$field]))
            {
                if($convert) {
                    $row[$field] = $this->convertField($row[$field], $field_value);
                }
                $this->$field = $row[$field];
                $owner = $field . '_owner';
                if(!empty($row[$owner])){
                    $this->$owner = $row[$owner];
                }
            } else {
                $this->$field = '';
            }
        }
        // TODO: add a vardef for my_favorite
        $this->my_favorite = false;
        if(!empty($row['my_favorite'])) {
            $this->my_favorite = true;
        }
        return $row;
    }



    /**
    * Add any required joins to the list count query.  The joins are required if there
    * is a field in the $where clause that needs to be joined.
    *
    * @param string $query
    * @param string $where
    *
    * Internal Function, do Not override.
    */
    function add_list_count_joins(&$query, $where)
    {
        $custom_join = $this->getCustomJoin();
        $query .= $custom_join['join'];

    }

    /**
    * Changes the select expression of the given query to be 'count(*)' so you
    * can get the number of items the query will return.  This is used to
    * populate the upper limit on ListViews.
     *
     * @param string $query Select query string
     * @return string count query
     *
     * Internal function, do not override.
    */
    function create_list_count_query($query)
    {
        // remove the 'order by' clause which is expected to be at the end of the query
        $pattern = '/\sORDER BY.*/is';  // ignores the case
        $replacement = '';
        $query = preg_replace($pattern, $replacement, $query);
        //handle distinct clause
        $star = '*';
        if(substr_count(strtolower($query), 'distinct')){
            if (!empty($this->seed) && !empty($this->seed->table_name ))
                $star = 'DISTINCT ' . $this->seed->table_name . '.id';
            else
                $star = 'DISTINCT ' . $this->table_name . '.id';

        }

        // change the select expression to 'count(*)'
        $pattern = '/SELECT(.*?)(\s){1}FROM(\s){1}/is';  // ignores the case
        $replacement = 'SELECT count(' . $star . ') c FROM ';

        //if the passed query has union clause then replace all instances of the pattern.
        //this is very rare. I have seen this happening only from projects module.
        //in addition to this added a condition that has  union clause and uses
        //sub-selects.
        if (strstr($query," UNION ALL ") !== false) {

            //separate out all the queries.
            $union_qs=explode(" UNION ALL ", $query);
            foreach ($union_qs as $key=>$union_query) {
                $star = '*';
                preg_match($pattern, $union_query, $matches);
                if (!empty($matches)) {
                    if (stristr($matches[0], "distinct")) {
                        if (!empty($this->seed) && !empty($this->seed->table_name ))
                            $star = 'DISTINCT ' . $this->seed->table_name . '.id';
                        else
                            $star = 'DISTINCT ' . $this->table_name . '.id';
                    }
                } // if
                $replacement = 'SELECT count(' . $star . ') c FROM ';
                $union_qs[$key] = preg_replace($pattern, $replacement, $union_query,1);
            }
            $modified_select_query=implode(" UNION ALL ",$union_qs);
        } else {
            $modified_select_query = preg_replace($pattern, $replacement, $query,1);
        }


        return $modified_select_query;
    }

    /**
    * This function returns a paged list of the current object type.  It is intended to allow for
    * hopping back and forth through pages of data.  It only retrieves what is on the current page.
    *
    * @internal This method must be called on a new instance.  It trashes the values of all the fields in the current one.
    * @param string $order_by
    * @param string $where Additional where clause
    * @param int $row_offset Optaional,default 0, starting row number
    * @param init $limit Optional, default -1
    * @param int $max Optional, default -1
    * @param boolean $show_deleted Optional, default 0, if set to 1 system will show deleted records.
    * @return array Fetched data.
    *
    * Internal function, do not override.
    *
    */
    function get_list($order_by = "", $where = "", $row_offset = 0, $limit=-1, $max=-1, $show_deleted = 0, $singleSelect=false, $select_fields = array())
    {
        $GLOBALS['log']->debug("get_list:  order_by = '$order_by' and where = '$where' and limit = '$limit'");
        if(isset($_SESSION['show_deleted']))
        {
            $show_deleted = 1;
        }

        // FIXME: duplicate with create_new_list_query, why?
        $this->addVisibilityWhere($where);
        $query = $this->create_new_list_query($order_by, $where,$select_fields,array(), $show_deleted,'',false,null,$singleSelect);
        return $this->process_list_query($query, $row_offset, $limit, $max, $where);
    }

    /**
    * Prefixes column names with this bean's table name.
    *
    * @param string $order_by  Order by clause to be processed
    * @param SugarBean $submodule name of the module this order by clause is for
    * @param boolean $suppress_table_name Whether table name should be suppressed
    * @return string Processed order by clause
    *
    * Internal function, do not override.
    */
    public function process_order_by($order_by, $submodule = null, $suppress_table_name = false)
    {
        if (empty($order_by))
            return $order_by;
        //submodule is empty,this is for list object in focus
        if (empty($submodule))
        {
            $bean_queried = $this;
        }
        else
        {
            //submodule is set, so this is for subpanel, use submodule
            $bean_queried = $submodule;
        }

        $raw_elements = explode(',', $order_by);
        $valid_elements = array();
        foreach ($raw_elements as $key => $value) {

            $is_valid = false;

            //value might have ascending and descending decorations
            $list_column = preg_split('/\s/', trim($value), 2);
            $list_column = array_map('trim', $list_column);

            $list_column_name = $list_column[0];
            if (isset($bean_queried->field_defs[$list_column_name])) {
                $field_defs = $bean_queried->field_defs[$list_column_name];
                $source = isset($field_defs['source']) ? $field_defs['source'] : 'db';

                if (empty($field_defs['table']) && !$suppress_table_name) {
                    if ($source == 'db') {
                        $list_column[0] = $bean_queried->table_name . '.' . $list_column[0] ;
                    } elseif ($source == 'custom_fields') {
                        $list_column[0] = $bean_queried->table_name . '_cstm' . $list_column[0] ;
                    }
                }

                // Bug 38803 - Use CONVERT() function when doing an order by on ntext, text, and image fields
                if ($source != 'non-db'
                    && $this->db->isTextType($this->db->getFieldType($bean_queried->field_defs[$list_column_name]))) {
                    $list_column[0] = $this->db->convert($list_column[0], "text2char");
                }

                $is_valid = true;

                if (isset($list_column[1])) {
                    switch (strtolower($list_column[1])) {
                        case 'asc':
                        case 'desc':
                            break;
                        default:
                            $GLOBALS['log']->debug("process_order_by: ($list_column[1]) is not a valid order.");
                            unset($list_column[1]);
                            break;
                    }
                }
            } else {
                $GLOBALS['log']->debug("process_order_by: ($list_column[0]) does not have a vardef entry.");
            }

            if ($is_valid) {
                $valid_elements[$key] = implode(' ', $list_column);
            }
        }

        return implode(', ', $valid_elements);

    }


    /**
    * Returns a detail object like retrieving of the current object type.
    *
    * It is intended for use in navigation buttons on the DetailView.  It will pass an offset and limit argument to the sql query.
    * @internal This method must be called on a new instance.  It overrides the values of all the fields in the current one.
    *
    * @param string $order_by
    * @param string $where Additional where clause
    * @param int $row_offset Optaional,default 0, starting row number
    * @param init $limit Optional, default -1
    * @param int $max Optional, default -1
    * @param boolean $show_deleted Optioanl, default 0, if set to 1 system will show deleted records.
    * @return array Fetched data.
    *
    * Internal function, do not override.
    */
    function get_detail($order_by = "", $where = "",  $offset = 0, $row_offset = 0, $limit=-1, $max=-1, $show_deleted = 0)
    {
        $GLOBALS['log']->debug("get_detail:  order_by = '$order_by' and where = '$where' and limit = '$limit' and offset = '$offset'");
        if(isset($_SESSION['show_deleted']))
        {
            $show_deleted = 1;
        }

        // FIXME: Duplicate with create_new_list_query - why?
        $this->addVisibilityWhere($where);
        $query = $this->create_new_list_query($order_by, $where,array(),array(), $show_deleted, $offset);

        return $this->process_detail_query($query, $row_offset, $limit, $max, $where, $offset);
    }

    /**
    * Fetches data from all related tables.
    *
    * @param object $child_seed
    * @param string $related_field_name relation to fetch data for
    * @param string $order_by Optional, default empty
    * @param string $where Optional, additional where clause
    * @return array Fetched data.
    *
    * Internal function, do not override.
    */
    function get_related_list($child_seed,$related_field_name, $order_by = "", $where = "",
    $row_offset = 0, $limit=-1, $max=-1, $show_deleted = 0)
    {
        global $layout_edit_mode;
        $query_array = array();

        if(isset($layout_edit_mode) && $layout_edit_mode)
        {
            $response = array();
            $child_seed->assign_display_fields($child_seed->module_dir);
            $response['list'] = array($child_seed);
            $response['row_count'] = 1;
            $response['next_offset'] = 0;
            $response['previous_offset'] = 0;

            return $response;
        }
        $GLOBALS['log']->debug("get_related_list:  order_by = '$order_by' and where = '$where' and limit = '$limit'");
        if(isset($_SESSION['show_deleted']))
        {
            $show_deleted = 1;
        }

        $this->load_relationship($related_field_name);

        if ($this->$related_field_name instanceof Link) {

            $query_array = $this->$related_field_name->getQuery(true);
        } else {

            $query_array = $this->$related_field_name->getQuery(array(
                "return_as_array" => true,
                'where' => '1=1' // hook for 'where' clause in M2MRelationship file
                    ));
        }

        $entire_where = $query_array['where'];
        if(!empty($where))
        {
            if(empty($entire_where))
            {
                $entire_where = ' WHERE ' . $where;
            }
            else
            {
                $entire_where .= ' AND ' . $where;
            }
        }

        $query = 'SELECT '.$child_seed->table_name.'.* ' . $query_array['from'] . ' ' . $entire_where;
        if(!empty($order_by))
        {
            $query .= " ORDER BY " . $order_by;
        }

        return $child_seed->process_list_query($query, $row_offset, $limit, $max, $where);
    }


    protected static function build_sub_queries_for_union($subpanel_list, $subpanel_def, $parentbean, $order_by)
    {
        global $layout_edit_mode, $beanFiles, $beanList;
        $subqueries = array();
        foreach($subpanel_list as $this_subpanel)
        {
            if(!$this_subpanel->isDatasourceFunction() || ($this_subpanel->isDatasourceFunction()
                && isset($this_subpanel->_instance_properties['generate_select'])
                && $this_subpanel->_instance_properties['generate_select']==true))
            {
                //the custom query function must return an array with
                if ($this_subpanel->isDatasourceFunction()) {
                    $shortcut_function_name = $this_subpanel->get_data_source_name();
                    $parameters=$this_subpanel->get_function_parameters();
                    if (!empty($parameters))
                    {
                        //if the import file function is set, then import the file to call the custom function from
                        if (is_array($parameters)  && isset($parameters['import_function_file'])){
                            //this call may happen multiple times, so only require if function does not exist
                            if(!function_exists($shortcut_function_name)){
                                require_once($parameters['import_function_file']);
                            }
                            //call function from required file
                            $query_array = $shortcut_function_name($parameters);
                        }else{
                            //call function from parent bean
                            $query_array = $parentbean->$shortcut_function_name($parameters);
                        }
                    }
                    else
                    {
                        $query_array = $parentbean->$shortcut_function_name();
                    }
                }  else {
                    $related_field_name = $this_subpanel->get_data_source_name();
                    if (!$parentbean->load_relationship($related_field_name)){
                        unset ($parentbean->$related_field_name);
                        continue;
                    }
                    $query_array = $parentbean->$related_field_name->getSubpanelQuery(array(), true);
                }
                $table_where = preg_replace('/^\s*WHERE/i', '', $this_subpanel->get_where());
                $where_definition = preg_replace('/^\s*WHERE/i', '', $query_array['where']);

                if(!empty($table_where))
                {
                    if(empty($where_definition))
                    {
                        $where_definition = $table_where;
                    }
                    else
                    {
                        $where_definition .= ' AND ' . $table_where;
                    }
                }

                $submodulename = $this_subpanel->_instance_properties['module'];
                $submodule = BeanFactory::newBean($submodulename);
                $subwhere = $where_definition;

                $list_fields = $this_subpanel->get_list_fields();
                $acl_fields = array();
                foreach($list_fields as $list_key=>$list_field) {
                    if(isset($list_field['usage']) && $list_field['usage'] == 'display_only') {
                        unset($list_fields[$list_key]);
                        continue;
                    }
                    $acl_fields[$list_key] = true;
                }

                SugarACL::listFilter($submodule->module_dir, $acl_fields, array("bean" => $submodule, "owner_override" => true), array("blank_value" => true));
                foreach($list_fields as $list_key=>$list_field)
                {
                    if(empty($acl_fields[$list_key])) {
                        $list_fields[$list_key]['force_blank']=true;
                    }
                }

                //Retrieve team_set.team_count column as well
		        if(!empty($list_fields['team_name']) && empty($list_fields['team_count'])){
		            $list_fields['team_count'] = true;

		            //Add the team_id entry so that we can retrieve the team_id to display primary team
		            $list_fields['team_id'] = true;
		        }

                if(!$subpanel_def->isCollection() && isset($list_fields[$order_by]) && isset($submodule->field_defs[$order_by])&& (!isset($submodule->field_defs[$order_by]['source']) || $submodule->field_defs[$order_by]['source'] == 'db'))
                {
                    $order_by = $submodule->table_name .'.'. $order_by;
                }
                $table_name = $this_subpanel->table_name;
                $panel_name=$this_subpanel->name;
                $params = array();
                $params['distinct'] = $this_subpanel->distinct_query();

                $params['joined_tables'] = $query_array['join_tables'];
                $params['include_custom_fields'] = !$subpanel_def->isCollection();
                $params['collection_list'] = $subpanel_def->get_inst_prop_value('collection_list');

                // use single select in case when sorting by relate field
                $singleSelect = $submodule->is_relate_field($order_by);

                $subquery = $submodule->create_new_list_query('',$subwhere ,$list_fields,$params, 0,'', true,$parentbean, $singleSelect);

                $subquery['select'] = $subquery['select']." , '$panel_name' panel_name ";
                $subquery['from'] = $subquery['from'].$query_array['join'];
                $subquery['query_array'] = $query_array;
                $subquery['params'] = $params;

                $subqueries[] = $subquery;
            }
        }
        return $subqueries;
    }

    /**
     * Constructs a query to fetch data for supanels and list views
     *
     * It constructs union queries for activities subpanel.
     *
     * @param SugarBean $parentbean constructing queries for link attributes in this bean
     * @param string $order_by Optional, order by clause
     * @param string $sort_order Optional, sort order
     * @param string $where Optional, additional where clause
     * @param int $row_offset
     * @param int $limit
     * @param int $max
     * @param int $show_deleted
     * @param aSubPanel $subpanel_def
     *
     * @return array
     *
     * Internal Function, do not overide.
     */
    function get_union_related_list($parentbean, $order_by = "", $sort_order='', $where = "",
    $row_offset = 0, $limit=-1, $max=-1, $show_deleted = 0, $subpanel_def)
    {
        $secondary_queries = array();
        global $layout_edit_mode, $beanFiles, $beanList;

        if(isset($_SESSION['show_deleted']))
        {
            $show_deleted = 1;
        }
        $final_query = '';
        $final_query_rows = '';
        $subpanel_list=array();
        if ($subpanel_def->isCollection())
        {
            $subpanel_def->load_sub_subpanels();
            $subpanel_list=$subpanel_def->sub_subpanels;
        }
        else
        {
            $subpanel_list[]=$subpanel_def;
        }

        $first = true;

        //Breaking the building process into two loops. The first loop gets a list of all the sub-queries.
        //The second loop merges the queries and forces them to select the same number of columns
        //All columns in a sub-subpanel group must have the same aliases
        //If the subpanel is a datasource function, it can't be a collection so we just poll that function for the and return that
        foreach($subpanel_list as $this_subpanel)
        {
            if($this_subpanel->isDatasourceFunction() && empty($this_subpanel->_instance_properties['generate_select']))
            {
                $shortcut_function_name = $this_subpanel->get_data_source_name();
                $parameters=$this_subpanel->get_function_parameters();
                if (!empty($parameters))
                {
                    //if the import file function is set, then import the file to call the custom function from
                    if (is_array($parameters)  && isset($parameters['import_function_file'])){
                        //this call may happen multiple times, so only require if function does not exist
                        if(!function_exists($shortcut_function_name)){
                            require_once($parameters['import_function_file']);
                        }
                        //call function from required file
                        $tmp_final_query =  $shortcut_function_name($parameters);
                    }else{
                        //call function from parent bean
                        $tmp_final_query =  $parentbean->$shortcut_function_name($parameters);
                    }
                } else {
                    $tmp_final_query = $parentbean->$shortcut_function_name();
                }
                if(!$first)
                    {
                        $final_query_rows .= ' UNION ALL ( '.$parentbean->create_list_count_query($tmp_final_query, $parameters) . ' )';
                        $final_query .= ' UNION ALL ( '.$tmp_final_query . ' )';
                    } else {
                        $final_query_rows = '(' . $parentbean->create_list_count_query($tmp_final_query, $parameters) . ')';
                        $final_query = '(' . $tmp_final_query . ')';
                        $first = false;
                    }
                }
        }
        //If final_query is still empty, its time to build the sub-queries
        if (empty($final_query))
        {
            $subqueries = SugarBean::build_sub_queries_for_union($subpanel_list, $subpanel_def, $parentbean, $order_by);
            $all_fields = array();
            foreach($subqueries as $i => $subquery)
            {
                $query_fields = $GLOBALS['db']->getSelectFieldsFromQuery($subquery['select']);
                foreach($query_fields as $field => $select)
                {
                    if (!in_array($field, $all_fields))
                        $all_fields[] = $field;
                }
                $subqueries[$i]['query_fields'] = $query_fields;
            }
            $first = true;
            //Now ensure the queries have the same set of fields in the same order.
            foreach($subqueries as $subquery)
            {
                $subquery['select'] = "SELECT";
                foreach($all_fields as $field)
                {
                    if (!isset($subquery['query_fields'][$field]))
                    {
                        $subquery['select'] .= " ' ' $field,";
                    }
                    else
                    {
                        $subquery['select'] .= " {$subquery['query_fields'][$field]},";
                    }
                }
                $subquery['select'] = substr($subquery['select'], 0 , strlen($subquery['select']) - 1);
                //Put the query into the final_query
                $query =  $subquery['select'] . " " . $subquery['from'] . " " . $subquery['where'];
                if(!$first)
                {
                    $query = ' UNION ALL ( '.$query . ' )';
                    $final_query_rows .= " UNION ALL ";
                } else {
                    $query = '(' . $query . ')';
                    $first = false;
                }
                $query_array = $subquery['query_array'];
                $select_position=strpos($query_array['select'],"SELECT");
                $distinct_position=strpos($query_array['select'],"DISTINCT");
                if (!empty($subquery['params']['distinct']) && !empty($subpanel_def->table_name))
                {
                    $query_rows = "( SELECT count(DISTINCT ". $subpanel_def->table_name . ".id)".  $subquery['from_min'].$query_array['join']. $subquery['where'].' )';
                }
                elseif ($select_position !== false && $distinct_position!= false)
                {
                    $query_rows = "( ".substr_replace($query_array['select'],"SELECT count(",$select_position,6). ")" .  $subquery['from_min'].$query_array['join']. $subquery['where'].' )';
                }
                else
                {
                    //resort to default behavior.
                    $query_rows = "( SELECT count(*)".  $subquery['from_min'].$query_array['join']. $subquery['where'].' )';
                }
                if(!empty($subquery['secondary_select']))
                {

                    $subquerystring= $subquery['secondary_select'] . $subquery['secondary_from'].$query_array['join']. $subquery['where'];
                    if (!empty($subquery['secondary_where']))
                    {
                        if (empty($subquery['where']))
                        {
                            $subquerystring.=" WHERE " .$subquery['secondary_where'];
                        }
                        else
                        {
                            $subquerystring.=" AND " .$subquery['secondary_where'];
                        }
                    }
                    $secondary_queries[]=$subquerystring;
                }
                $final_query .= $query;
                $final_query_rows .= $query_rows;
            }
        }

        if(!empty($order_by))
        {
            $isCollection = $subpanel_def->isCollection();
            if ($isCollection) {
                /** @var aSubPanel $header */
                $header = $subpanel_def->get_header_panel_def();
                $submodule = $header->template_instance;
                $suppress_table_name = true;
            } else {
                $submodule = $subpanel_def->template_instance;
                $suppress_table_name = false;
            }

            if (!empty($sort_order)) {
                $order_by .= ' ' . $sort_order;
            }

            $order_by = $parentbean->process_order_by($order_by, $submodule, $suppress_table_name);
            if (!empty($order_by)) {
                $final_query .= ' ORDER BY ' . $order_by;
            }
        }


        if(isset($layout_edit_mode) && $layout_edit_mode)
        {
            $response = array();
            if(!empty($submodule))
            {
                $submodule->assign_display_fields($submodule->module_dir);
                $response['list'] = array($submodule);
            }
            else
        {
                $response['list'] = array();
            }
            $response['parent_data'] = array();
            $response['row_count'] = 1;
            $response['next_offset'] = 0;
            $response['previous_offset'] = 0;

            return $response;
        }

        return $parentbean->process_union_list_query($parentbean, $final_query, $row_offset, $limit, $max, '',$subpanel_def, $final_query_rows, $secondary_queries);
    }


    /**
    * Returns a full (ie non-paged) list of the current object type.
    *
    * @param string $order_by the order by SQL parameter. defaults to ""
    * @param string $where where clause. defaults to ""
    * @param boolean $check_dates. defaults to false
    * @param int $show_deleted show deleted records. defaults to 0
    */
    function get_full_list($order_by = "", $where = "", $check_dates=false, $show_deleted = 0)
    {
        $GLOBALS['log']->debug("get_full_list:  order_by = '$order_by' and where = '$where'");
        if(isset($_SESSION['show_deleted']))
        {
            $show_deleted = 1;
        }
        $query = $this->create_new_list_query($order_by, $where,array(),array(), $show_deleted);
        return $this->process_full_list_query($query, $check_dates);
    }

    /**
     * Return the list query used by the list views and export button. Next generation of create_new_list_query function.
     *
     * Override this function to return a custom query.
     *
     * @param string $order_by custom order by clause
     * @param string $where custom where clause
     * @param array $filter Optional
     * @param array $params Optional     *
     * @param int $show_deleted Optional, default 0, show deleted records is set to 1.
     * @param string $join_type
     * @param boolean $return_array Optional, default false, response as array
     * @param object $parentbean creating a subquery for this bean.
     * @param boolean $singleSelect Optional, default false.
     * @return String select query string, optionally an array value will be returned if $return_array= true.
     */
	function create_new_list_query($order_by, $where,$filter=array(),$params=array(), $show_deleted = 0,$join_type='', $return_array = false,$parentbean=null, $singleSelect = false, $ifListForExport = false)
    {
        $favorites = (!empty($params['favorites']))?$params['favorites']: 0;
        global $beanFiles, $beanList;
        $selectedFields = array();
        $secondarySelectedFields = array();
        $ret_array = array();
        $distinct = '';

        $this->addVisibilityWhere($where);

        if(!empty($params['distinct']))
        {
            $distinct = ' DISTINCT ';
        }
        if(empty($filter))
        {
            $ret_array['select'] = " SELECT $distinct $this->table_name.* ";
        }
        else
        {
            $ret_array['select'] = " SELECT $distinct $this->table_name.id ";
        }
        $ret_array['from'] = " FROM $this->table_name ";
        $this->addVisibilityFrom($ret_array['from']);
        $ret_array['from_min'] = $ret_array['from'];
        $ret_array['secondary_from'] = $ret_array['from'] ;
        $ret_array['where'] = '';
        $ret_array['order_by'] = '';
        //secondary selects are selects that need to be run after the primary query to retrieve additional info on main
        if($singleSelect)
        {
            $ret_array['secondary_select']=& $ret_array['select'];
            $ret_array['secondary_from'] = & $ret_array['from'];
        }
        else
        {
            $ret_array['secondary_select'] = '';
        }
        $custom_join = $this->getCustomJoin( empty($filter)? true: $filter );
        if((!isset($params['include_custom_fields']) || $params['include_custom_fields']))
        {
            $ret_array['select'] .= $custom_join['select'];
        }

        $ret_array['from'] .= $custom_join['join'];
        // Bug 52490 - Captivea (Sve) - To be able to add custom fields inside where clause in a subpanel
        $ret_array['from_min'] .= $custom_join['join'];
        $jtcount = 0;
        //LOOP AROUND FOR FIXIN VARDEF ISSUES
        foreach(SugarAutoLoader::existingCustom('include/VarDefHandler/listvardefoverride.php') as $file) {
            require $file;
        }

        $joined_tables = array();
        if(!empty($params['joined_tables']))
        {
            foreach($params['joined_tables'] as $table)
            {
                $joined_tables[$table] = 1;
            }
        }

        if(!empty($filter))
        {
            $filterKeys = array_keys($filter);
            if(is_numeric($filterKeys[0]))
            {
                $fields = array();
                foreach($filter as $field)
                {
                    $field = strtolower($field);
                    //remove out id field so we don't duplicate it
                    if ( $field == 'id' && !empty($filter) ) {
                        continue;
                    }
                    if(isset($this->field_defs[$field]))
                    {
                        $fields[$field]= $this->field_defs[$field];
                    }
                    else
                    {
                        $fields[$field] = array('force_exists'=>true);
                    }
                }
            }else{
                $fields = 	$filter;
            }
            /* add mandatory fields */
            foreach($this->field_defs as $field=>$value) {
                if(!empty($value['force_exists'])) {
                    $fields[$field] = $value;
                }
            }
        }
        else
        {
            $fields = 	$this->field_defs;
        }

        $used_join_key = array();


        foreach($fields as $field=>$value)
        {
            //alias is used to alias field names
            $alias='';
            if 	(isset($value['alias']))
            {
                $alias =' as ' . $value['alias'] . ' ';
            }

            if(empty($this->field_defs[$field]) || !empty($value['force_blank']) )
            {
                if(!empty($filter) && isset($filter[$field]['force_exists']) && $filter[$field]['force_exists'])
                {
                    if ( isset($filter[$field]['force_default']) )
                        $ret_array['select'] .= ", {$filter[$field]['force_default']} $field ";
                    else
                    //spaces are a fix for length issue problem with unions.  The union only returns the maximum number of characters from the first select statement.
                        $ret_array['select'] .= ", '                                                                                                                                                                                                                                                              ' $field ";
                }
                continue;
            }
            else
            {
                $data = $this->field_defs[$field];
            }

            //ignore fields that are a part of the collection and a field has been removed as a result of
            //layout customization.. this happens in subpanel customizations, use case, from the contacts subpanel
            //in opportunities module remove the contact_role/opportunity_role field.
            $process_field=true;
            if (!empty($data['relationship_fields']))
            {
                foreach ($data['relationship_fields'] as $field_name)
                {
                    if (!isset($fields[$field_name]))
                    {
                        $process_field=false;
                    }
                }
            }
            if (!$process_field)
            {
                continue;
            }

            if(  (!isset($data['source']) || $data['source'] == 'db') && (!empty($alias) || !empty($filter) ))
            {
                $ret_array['select'] .= ", $this->table_name.$field $alias";
                $selectedFields["$this->table_name.$field"] = true;
            } else if(  (!isset($data['source']) || $data['source'] == 'custom_fields') && (!empty($alias) || !empty($filter) )) {
                //add this column only if it has NOT already been added to select statement string
                $colPos = strpos($ret_array['select'],"$this->table_name"."_cstm".".$field");
                if(!$colPos || $colPos<0)
                {
                    $ret_array['select'] .= ", $this->table_name"."_cstm".".$field $alias";
                }

                $selectedFields["$this->table_name.$field"] = true;
            }

            if($data['type'] != 'relate' && isset($data['db_concat_fields']))
            {
                $ret_array['select'] .= ", " . $this->db->concat($this->table_name, $data['db_concat_fields']) . " as $field";
                $selectedFields[$this->db->concat($this->table_name, $data['db_concat_fields'])] = true;
            }
            //Custom relate field or relate fields built in module builder which have no link field associated.
            if ($data['type'] == 'relate' && (isset($data['custom_module']) || isset($data['ext2']))) {
                $joinTableAlias = 'jt' . $jtcount;
                $relateJoinInfo = $this->custom_fields->getRelateJoin($data, $joinTableAlias);
                $ret_array['select'] .= $relateJoinInfo['select'];
                $ret_array['from'] .= $relateJoinInfo['from'];
                //Replace any references to the relationship in the where clause with the new alias
                //If the link isn't set, assume that search used the local table for the field
                $searchTable = isset($data['link']) ? $relateJoinInfo['rel_table'] : $this->table_name;
                $field_name = $relateJoinInfo['rel_table'] . '.' . !empty($data['name'])?$data['name']:'name';
                $where = preg_replace('/(^|[\s(])' . $field_name . '/' , '${1}' . $relateJoinInfo['name_field'], $where);
                $jtcount++;
            }
            //Parent Field
            if ($data['type'] == 'parent') {
                //See if we need to join anything by inspecting the where clause
                $match = preg_match('/(^|[\s(])parent_(\w+)_(\w+)\.name/', $where, $matches);
                if ($match) {
                    $joinTableAlias = 'jt' . $jtcount;
                    $joinModule = $matches[2];
                    $joinTable = $matches[3];
                    $localTable = $this->table_name;
                    if (!empty($data['custom_module'])) {
                        $localTable .= '_cstm';
                    }
                    $rel_mod = BeanFactory::getBean($joinModule);
                    $nameField = "$joinTableAlias.name";
                    if (isset($rel_mod->field_defs['name']))
                    {
                        $name_field_def = $rel_mod->field_defs['name'];
                        if(isset($name_field_def['db_concat_fields']))
                        {
                            $nameField = $this->db->concat($joinTableAlias, $name_field_def['db_concat_fields']);
                        }
                    }
                    $ret_array['select'] .= ", $nameField {$data['name']} ";
                    $ret_array['from'] .= " LEFT JOIN $joinTable $joinTableAlias
                        ON $localTable.{$data['id_name']} = $joinTableAlias.id";
                    //Replace any references to the relationship in the where clause with the new alias
                    $where = preg_replace('/(^|[\s(])parent_' . $joinModule . '_' . $joinTable . '\.name/', '${1}' . $nameField, $where);
                    $jtcount++;
                }
            }

            if ($this->is_relate_field($field))
            {
                $this->load_relationship($data['link']);
                if(!empty($this->$data['link']))
                {
                    $params = array();
                    if(empty($join_type))
                    {
                        $params['join_type'] = ' LEFT JOIN ';
                    }
                    else
                    {
                        $params['join_type'] = $join_type;
                    }
                    if(isset($data['join_name']))
                    {
                        $params['join_table_alias'] = $data['join_name'];
                    }
                    else
                    {
                        $params['join_table_alias']	= 'jt' . $jtcount;

                    }
                    if(isset($data['join_link_name']))
                    {
                        $params['join_table_link_alias'] = $data['join_link_name'];
                    }
                    else
                    {
                        $params['join_table_link_alias'] = 'jtl' . $jtcount;
                    }
                    $join_primary = !isset($data['join_primary']) || $data['join_primary'];

                    $join = $this->$data['link']->getJoin($params, true);
                    $used_join_key[] = $join['rel_key'];
                    $table_joined = !empty($joined_tables[$params['join_table_alias']]) || (!empty($joined_tables[$params['join_table_link_alias']]) && isset($data['link_type']) && $data['link_type'] == 'relationship_info');

					//if rname is set to 'name', and bean files exist, then check if field should be a concatenated name
					$rel_mod = $this->getRelatedBean($data['link']);
					$rel_module = $rel_mod->module_name;
					if($data['rname'] && !empty($rel_mod)) {
						//if bean has first and last name fields, then name should be concatenated
						if(isset($rel_mod->field_name_map['first_name']) && isset($rel_mod->field_name_map['last_name'])){
								$data['db_concat_fields'] = array(0=>'first_name', 1=>'last_name');
						}
					}


    				if($join['type'] == 'many-to-many')
    				{
    					if(empty($ret_array['secondary_select']))
    					{
    						$ret_array['secondary_select'] = " SELECT $this->table_name.id ref_id  ";
                            if(!empty($rel_mod) && $join_primary)
                            {
                                if(isset($rel_mod->field_defs['assigned_user_id']))
                                {
                                    $ret_array['secondary_select'].= " , ".	$params['join_table_alias'] . ".assigned_user_id {$field}_owner, '$rel_module' {$field}_mod";
                                }
                                else
                                {
                                    if(isset($rel_mod->field_defs['created_by']))
                                    {
                                        $ret_array['secondary_select'].= " , ".	$params['join_table_alias'] . ".created_by {$field}_owner , '$rel_module' {$field}_mod";
                                    }
                                }
                            }
                        }

                        if(isset($data['db_concat_fields']))
                        {
                            $ret_array['secondary_select'] .= ' , ' . $this->db->concat($params['join_table_alias'], $data['db_concat_fields']) . ' ' . $field;
                        }
                        else
                        {
                            if(!isset($data['relationship_fields']))
                            {
                                $ret_array['secondary_select'] .= ' , ' . $params['join_table_alias'] . '.' . $data['rname'] . ' ' . $field;
                            }
                        }
                        if(!$singleSelect)
                        {
                            $ret_array['select'] .= ", '                                                                                                                                                                                                                                                              ' $field ";
                        }
                        $count_used =0;
                        foreach($used_join_key as $used_key) {
                            if($used_key == $join['rel_key']) $count_used++;
                        }
                        if($count_used <= 1) {//27416, the $ret_array['secondary_select'] should always generate, regardless the dbtype
                            // add rel_key only if it was not aready added
                            if(!$singleSelect)
                            {
                                $ret_array['select'] .= ", '                                    '  " . $join['rel_key'] . ' ';
                            }
                            $ret_array['secondary_select'] .= ', ' . $params['join_table_link_alias'].'.'. $join['rel_key'] .' ' . $join['rel_key'];
                        }
                        if(isset($data['relationship_fields']))
                        {
                            foreach($data['relationship_fields'] as $r_name=>$alias_name)
                            {
                                if(!empty( $secondarySelectedFields[$alias_name]))continue;
                                $ret_array['secondary_select'] .= ', ' . $params['join_table_link_alias'].'.'. $r_name .' ' . $alias_name;
                                $secondarySelectedFields[$alias_name] = true;
                            }
                        }
                        if(!$table_joined)
                        {
                            $ret_array['secondary_from'] .= ' ' . $join['join']. ' AND ' . $params['join_table_alias'].'.deleted=0';
                            if (isset($data['link_type']) && $data['link_type'] == 'relationship_info' && ($parentbean instanceOf SugarBean))
                            {
                                $ret_array['secondary_where'] = $params['join_table_link_alias'] . '.' . $join['rel_key']. "='" .$parentbean->id . "'";
                            }
                        }
                    }
                    else
                    {
                        if(isset($data['db_concat_fields']))
                        {
                            //rrs for teams we have to check the user's locale format to determine how to display the team name
                            if($data['name'] == 'team_name'){
                                global $current_user;
                                if($current_user->showLastNameFirst()){
                                    $data['db_concat_fields'] = array_reverse($data['db_concat_fields']);
                                }
                            }
                            $ret_array['select'] .= ' , ' . $this->db->concat($params['join_table_alias'], $data['db_concat_fields']) . ' ' . $field;
                        }
                        else
                        {
                            $ret_array['select'] .= ' , ' . $params['join_table_alias'] . '.' . $data['rname'] . ' ' . $field;
                        }
                        if(isset($data['additionalFields'])){
                            foreach($data['additionalFields'] as $k=>$v){
                                $ret_array['select'] .= ' , ' . $params['join_table_alias'] . '.' . $k . ' ' . $v;
                            }
                        }
                        if(!$table_joined)
                        {
                            $ret_array['from'] .= ' ' . $join['join']. ' AND ' . $params['join_table_alias'].'.deleted=0';
                            $rel_mod = BeanFactory::getBean($rel_module);
                            if(!empty($rel_mod))
                            {
                                if(isset($value['target_record_key']) && !empty($filter))
                                {
                                    $selectedFields[$this->table_name.'.'.$value['target_record_key']] = true;
                                    $ret_array['select'] .= " , $this->table_name.{$value['target_record_key']} ";
                                }
                                if(isset($rel_mod->field_defs['assigned_user_id']))
                                {
                                    $ret_array['select'] .= ' , ' .$params['join_table_alias'] . '.assigned_user_id ' .  $field . '_owner';
                                }
                                else
                                {
                                    $ret_array['select'] .= ' , ' .$params['join_table_alias'] . '.created_by ' .  $field . '_owner';
                                }
                                $ret_array['select'] .= "  , '".$rel_module  ."' " .  $field . '_mod';

                            }
                        }
                    }
                    // To fix SOAP stuff where we are trying to retrieve all the accounts data where accounts.id = ..
                    // and this code changes accounts to jt4 as there is a self join with the accounts table.
                    //Martin fix #27494
                    if(isset($data['db_concat_fields'])){
                    	$buildWhere = false;
                        if(in_array('first_name', $data['db_concat_fields']) && in_array('last_name', $data['db_concat_fields']))
                    	{
                     	   $exp = '/\(\s*?'.$data['name'].'.*?\%\'\s*?\)/';
                    	   if(preg_match($exp, $where, $matches))
                    	   {
                    	   	  $search_expression = $matches[0];
                    	   	  //Create three search conditions - first + last, first, last
                    	   	  $first_name_search = str_replace($data['name'], $params['join_table_alias'] . '.first_name', $search_expression);
                    	   	  $last_name_search = str_replace($data['name'], $params['join_table_alias'] . '.last_name', $search_expression);
							  $full_name_search = str_replace($data['name'], $this->db->concat($params['join_table_alias'], $data['db_concat_fields']), $search_expression);
							  $buildWhere = true;
							  $where = str_replace($search_expression, '(' . $full_name_search . ' OR ' . $first_name_search . ' OR ' . $last_name_search . ')', $where);
                    	   }
                    	}

                    	if(!$buildWhere)
                    	{
	                       $db_field = $this->db->concat($params['join_table_alias'], $data['db_concat_fields']);
	                       $where = preg_replace('/'.$data['name'].'/', $db_field, $where);
                    	}
                    }else{
                        $where = preg_replace('/(^|[\s(])' . $data['name'] . '/', '${1}' . $params['join_table_alias'] . '.'.$data['rname'], $where);
                    }
                    if(!$table_joined)
                    {
                        $joined_tables[$params['join_table_alias']]=1;
                        $joined_tables[$params['join_table_link_alias']]=1;
                    }

                    $jtcount++;
                }
            }

            if($data['type'] == 'custom_query' && !empty($data['query_function'])) {
                $result = $this->callUserFunction($data['query_function'], $this, array($ret_array, $data));
                if(!empty($result)) {
                    $ret_array = $result;
                    $selectedFields[$field] = true;
                }
            }
        }

        if(!empty($filter))
        {
            if(isset($this->field_defs['assigned_user_id']) && empty($selectedFields[$this->table_name.'.assigned_user_id']))
            {
                $ret_array['select'] .= ", $this->table_name.assigned_user_id ";
            }
            else if(isset($this->field_defs['created_by']) &&  empty($selectedFields[$this->table_name.'.created_by']))
            {
                $ret_array['select'] .= ", $this->table_name.created_by ";
            }
            if(isset($this->field_defs['system_id']) && empty($selectedFields[$this->table_name.'.system_id']))
            {
                $ret_array['select'] .= ", $this->table_name.system_id ";
            }
            if(isset($selectedFields[$this->table_name.'.team_id']) && isset($this->field_defs['team_set_id']) && empty($selectedFields[$this->table_name.'.team_set_id']))
            {
            $ret_array['select'] .= ", $this->table_name.team_set_id ";
            }
        }

	if ($ifListForExport) {
		if(isset($this->field_defs['email1'])) {
			$ret_array['select'].= " ,email_addresses.email_address email1";
			$ret_array['from'].= " LEFT JOIN email_addr_bean_rel on {$this->table_name}.id = email_addr_bean_rel.bean_id and email_addr_bean_rel.bean_module='{$this->module_dir}' and email_addr_bean_rel.deleted=0 and email_addr_bean_rel.primary_address=1 LEFT JOIN email_addresses on email_addresses.id = email_addr_bean_rel.email_address_id ";
		}
	}

        if(!empty($favorites)){
            $ret_array['select'] .= " , sfav.id is_favorite ";
            if($favorites == 2){
                $ret_array['from'] .= " INNER JOIN ";
            }else{
                $ret_array['from'] .= " LEFT JOIN ";
            }

        $ret_array['from'] .= " sugarfavorites sfav ON sfav.module ='{$this->module_dir}' AND sfav.record_id={$this->table_name}.id AND sfav.created_by='{$GLOBALS['current_user']->id}' AND sfav.deleted=0 ";
        }
        $where_auto = '1=1';
        if($show_deleted == 0)
        {
            $where_auto = "$this->table_name.deleted=0";
        }else if($show_deleted == 1)
        {
            $where_auto = "$this->table_name.deleted=1";
        }
        if($where != "")
            $ret_array['where'] = " where ($where) AND $where_auto";
        else
            $ret_array['where'] = " where $where_auto";

        //make call to process the order by clause
        $order_by = $this->process_order_by($order_by);
        if (!empty($order_by)) {
            $ret_array['order_by'] = " ORDER BY " . $order_by;
        }
        if($singleSelect)
        {
            unset($ret_array['secondary_where']);
            unset($ret_array['secondary_from']);
            unset($ret_array['secondary_select']);
        }

        if($return_array)
        {
            return $ret_array;
        }

        return  $ret_array['select'] . $ret_array['from'] . $ret_array['where']. $ret_array['order_by'];
    }
    /**
     * Returns parent record data for objects that store relationship information
     *
     * @param array $type_info
     *
     * Interal function, do not override.
     */
    function retrieve_parent_fields($type_info)
    {
        $queries = array();
        global $beanList, $beanFiles;
        $templates = array();
        $parent_child_map = array();
        foreach($type_info as $children_info)
        {
            foreach($children_info as $child_info)
            {
                if($child_info['type'] == 'parent')
                {
                    if(empty($templates[$child_info['parent_type']]))
                    {
                        //Test emails will have an invalid parent_type, don't try to load the non-existent parent bean
                        if ($child_info['parent_type'] == 'test') {
                            continue;
                        }
                        $parent_bean = BeanFactory::getBean($child_info['parent_type']);
                        if (empty($parent_bean)) {
                            $GLOBALS['log']->error($this->object_name."::retrieve_parent_fields() - cannot load bean of type {$child_info['parent_type']}, skip loading.");
                            continue;
                        }
                        $templates[$child_info['parent_type']] = $parent_bean;
                    }

                    if(empty($queries[$child_info['parent_type']]))
                    {
                        $queries[$child_info['parent_type']] = "SELECT id ";
                        $field_def = $templates[$child_info['parent_type']]->field_defs['name'];
                        if(isset($field_def['db_concat_fields']))
                        {
                            $queries[$child_info['parent_type']] .= ' , ' . $this->db->concat($templates[$child_info['parent_type']]->table_name, $field_def['db_concat_fields']) . ' parent_name';
                        }
                        else
                        {
                            $queries[$child_info['parent_type']] .= ' , name parent_name';
                        }
                        if(isset($templates[$child_info['parent_type']]->field_defs['assigned_user_id']))
                        {
                            $queries[$child_info['parent_type']] .= ", assigned_user_id parent_name_owner , '{$child_info['parent_type']}' parent_name_mod";;
                        }else if(isset($templates[$child_info['parent_type']]->field_defs['created_by']))
                        {
                            $queries[$child_info['parent_type']] .= ", created_by parent_name_owner, '{$child_info['parent_type']}' parent_name_mod";
                        }
                        $queries[$child_info['parent_type']] .= " FROM " . $templates[$child_info['parent_type']]->table_name ." WHERE id IN ('{$child_info['parent_id']}'";
                    }
                    else
                    {
                        if(empty($parent_child_map[$child_info['parent_id']]))
                        $queries[$child_info['parent_type']] .= " ,'{$child_info['parent_id']}'";
                    }
                    $parent_child_map[$child_info['parent_id']][] = $child_info['child_id'];
                }
            }
        }
        $results = array();
        foreach($queries as $query)
        {
            $result = $this->db->query($query . ')');
            while($row = $this->db->fetchByAssoc($result))
            {
                $results[$row['id']] = $row;
            }
        }

        $child_results = array();
        foreach($parent_child_map as $parent_key=>$parent_child)
        {
            foreach($parent_child as $child)
            {
                if(isset( $results[$parent_key]))
                {
                    $child_results[$child] = $results[$parent_key];
                }
            }
        }
        return $child_results;
    }

    /**
     * Processes the list query and return fetched row.
     *
     * Internal function, do not override.
     * @param string $query select query to be processed.
     * @param int $row_offset starting position
     * @param int $limit Optioanl, default -1
     * @param int $max_per_page Optional, default -1
     * @param string $where Optional, additional filter criteria.
     * @return array Fetched data
     */
    function process_list_query($query, $row_offset, $limit= -1, $max_per_page = -1, $where = '')
    {
        global $sugar_config;
        $db = DBManagerFactory::getInstance('listviews');
        /**
        * if the row_offset is set to 'end' go to the end of the list
        */
        $toEnd = strval($row_offset) == 'end';
        $GLOBALS['log']->debug("process_list_query: ".$query);
        if($max_per_page == -1)
        {
            $max_per_page 	= $sugar_config['list_max_entries_per_page'];
        }
        // Check to see if we have a count query available.
        if(empty($sugar_config['disable_count_query']) || $toEnd)
        {
            $count_query = $this->create_list_count_query($query);
            if(!empty($count_query) && (empty($limit) || $limit == -1))
            {
                // We have a count query.  Run it and get the results.
                $result = $db->query($count_query, true, "Error running count query for $this->object_name List: ");
                $assoc = $db->fetchByAssoc($result);
                if(!empty($assoc['c']))
                {
                    $rows_found = $assoc['c'];
                    $limit = $sugar_config['list_max_entries_per_page'];
                }
                if( $toEnd)
                {
                    $row_offset = (floor(($rows_found -1) / $limit)) * $limit;
                }
            }
        }
        else
        {
            if((empty($limit) || $limit == -1))
            {
                if ( $max_per_page != -99 || $max_per_page != -1 ) {
                    $limit = $max_per_page + 1;
                } else {
                    $limit = $max_per_page;
                }
                $max_per_page = $limit;
            }

        }

        if(empty($row_offset))
        {
            $row_offset = 0;
        }
        if(!empty($limit) && $limit != -1 && $limit != -99)
        {
            $result = $db->limitQuery($query, $row_offset, $limit,true,"Error retrieving $this->object_name list: ");
        }
        else
        {
            $result = $db->query($query,true,"Error retrieving $this->object_name list: ");
        }

        $list = Array();

        $previous_offset = $row_offset - $max_per_page;
        $next_offset = $row_offset + $max_per_page;

            //FIXME: Bug? we should remove the magic number -99
            //use -99 to return all
            $index = $row_offset;
            while ($max_per_page == -99 || ($index < $row_offset + $max_per_page))
            {
                $row = $db->fetchByAssoc($result);
                if (empty($row)) break;

                //instantiate a new class each time. This is because php5 passes
                //by reference by default so if we continually update $this, we will
                //at the end have a list of all the same objects
                $temp = $this->getCleanCopy();

                foreach($this->field_defs as $field=>$value)
                {
                    if (isset($row[$field]))
                    {
                        $temp->$field = $row[$field];
                        $owner_field = $field . '_owner';
                        if(isset($row[$owner_field]))
                        {
                            $temp->$owner_field = $row[$owner_field];
                        }

                        $GLOBALS['log']->debug("$temp->object_name({$row['id']}): ".$field." = ".$temp->$field);
                    }else if (isset($row[$this->table_name .'.'.$field]))
                    {
                        $temp->$field = $row[$this->table_name .'.'.$field];
                    }
                    else
                    {
                        $temp->$field = "";
                    }
                }

                $temp->check_date_relationships_load();
                $temp->fill_in_additional_list_fields();
                if($temp->hasCustomFields()) $temp->custom_fields->fill_relationships();
                $temp->call_custom_logic("process_record");

                // fix defect #44206. implement the same logic as sugar_currency_format
                // Smarty modifier does.
                if (property_exists($temp, 'currency_id') && -99 == $temp->currency_id)
                {
                    // manually retrieve default currency object as long as it's
                    // not stored in database and thus cannot be joined in query
                    $currency = BeanFactory::getBean('Currencies', $temp->currency_id);

                    // walk through all currency-related fields
                    foreach ($temp->field_defs as $temp_field)
                    {
                        if (isset($temp_field['type']) && 'relate' == $temp_field['type']
                            && isset($temp_field['module'])  && 'Currencies' == $temp_field['module']
                            && isset($temp_field['id_name']) && 'currency_id' == $temp_field['id_name'])
                        {
                            // populate related properties manually
                            $temp_property     = $temp_field['name'];
                            $currency_property = $temp_field['rname'];
                            $temp->$temp_property = $currency->$currency_property;
                        }
                    }
                }

                $list[] = $temp;

                $index++;
            }
        if(!empty($sugar_config['disable_count_query']) && !empty($limit))
        {

            $rows_found = $row_offset + count($list);

            unset($list[$limit - 1]);
            if(!$toEnd)
            {
                $next_offset--;
                $previous_offset++;
            }
        } else if(!isset($rows_found)){
            $rows_found = $row_offset + count($list);
        }

        $response = Array();
        $response['list'] = $list;
        $response['row_count'] = $rows_found;
        $response['next_offset'] = $next_offset;
        $response['previous_offset'] = $previous_offset;
        $response['current_offset'] = $row_offset ;
        return $response;
    }

    /**
    * Returns the number of rows that the given SQL query should produce
     *
     * Internal function, do not override.
     * @param string $query valid select  query
     * @param boolean $is_count_query Optional, Default false, set to true if passed query is a count query.
     * @return int count of rows found
    */
    function _get_num_rows_in_query($query, $is_count_query=false)
    {
        $num_rows_in_query = 0;
        if (!$is_count_query)
        {
            $count_query = SugarBean::create_list_count_query($query);
        } else
            $count_query=$query;

        $result = $this->db->query($count_query, true, "Error running count query for $this->object_name List: ");
        $row_num = 0;
        while($row = $this->db->fetchByAssoc($result, true))
        {
            $num_rows_in_query += current($row);
        }

        return $num_rows_in_query;
    }

    /**
     * Call function defined in the vardef field
     * @param array $function
     * @param SugarBean $current_bean Current bean, can be different from $this
     * @param array $execute_params additional execute params, come before ones in the definition
     */
    protected function callUserFunction($function, $current_bean, $execute_params = array())
    {
        if(!empty($function['function_class'])) {
            $execute_function = array($function['function_class'], $function['function_name']);
        } else {
            $execute_function	= $function['function_name'];
        }
        if(!empty($function['function_params'])) {
            if (empty($function['function_params_source']) || $function['function_params_source']=='parent') {
                $bean = $this;
            } else if ($function['function_params_source']=='this') {
                $bean = $current_bean;
            } else {
                $bean = null;
            }

            foreach($function['function_params'] as $param ) {
                if($param == '$this') {
                    if(empty($bean)) {
                        return null;
                    }
                    $execute_params[] = $bean;
                } else if(empty($bean->$param)) {
                    return null;
                } else {
                    $execute_params[] = $bean->$param;
                }
            }
        }

        if(!empty($function['function_require'])) {
            require_once($function['function_require']);
        }
        if(!is_callable($execute_function)) {
            $GLOBALS['log']->fatal("callUserFunction failed for: ".var_export($execute_function, true));
            return null;
        }
        return call_user_func_array($execute_function, $execute_params);
     }

    /**
     * Applies pagination window to union queries used by list view and subpanels,
     * executes the query and returns fetched data.
     *
     * Internal function, do not override.
     * @param object $parent_bean
     * @param string $query query to be processed.
     * @param int $row_offset
     * @param int $limit optional, default -1
     * @param int $max_per_page Optional, default -1
     * @param string $where Custom where clause.
     * @param array $subpanel_def definition of sub-panel to be processed
     * @param string $query_row_count
     * @param array $seconday_queries
     * @return array Fetched data.
     */
    function process_union_list_query($parent_bean, $query,
    $row_offset, $limit= -1, $max_per_page = -1, $where = '', $subpanel_def, $query_row_count='', $secondary_queries = array())

    {
        $db = DBManagerFactory::getInstance('listviews');
        /**
        * if the row_offset is set to 'end' go to the end of the list
        */
        $toEnd = strval($row_offset) == 'end';
        global $sugar_config;
        $use_count_query=false;
        $processing_collection=$subpanel_def->isCollection();

        $GLOBALS['log']->debug("process_union_list_query: ".$query);
        if($max_per_page == -1)
        {
            $max_per_page 	= $sugar_config['list_max_entries_per_subpanel'];
        }
        if(empty($query_row_count))
        {
            $query_row_count = $query;
        }
        $distinct_position=strpos($query_row_count,"DISTINCT");

        if ($distinct_position!= false)
        {
            $use_count_query=true;
        }
        $performSecondQuery = true;
        if(empty($sugar_config['disable_count_query']) || $toEnd)
        {
            $rows_found = $this->_get_num_rows_in_query($query_row_count,$use_count_query);
            if($rows_found < 1)
            {
                $performSecondQuery = false;
            }
            if(!empty($rows_found) && (empty($limit) || $limit == -1))
            {
                $limit = $sugar_config['list_max_entries_per_subpanel'];
            }
            if( $toEnd)
            {
                $row_offset = (floor(($rows_found -1) / $limit)) * $limit;

            }
        }
        else
        {
            if((empty($limit) || $limit == -1))
            {
                $limit = $max_per_page + 1;
                $max_per_page = $limit;
            }
        }

        if(empty($row_offset))
        {
            $row_offset = 0;
        }
        $list = array();
        $previous_offset = $row_offset - $max_per_page;
        $next_offset = $row_offset + $max_per_page;

        if($performSecondQuery)
        {
            if(!empty($limit) && $limit != -1 && $limit != -99)
            {
                $result = $db->limitQuery($query, $row_offset, $limit,true,"Error retrieving $parent_bean->object_name list: ");
            }
            else
            {
                $result = $db->query($query,true,"Error retrieving $this->object_name list: ");
            }
                //use -99 to return all

                // get the current row
                $index = $row_offset;
                $row = $db->fetchByAssoc($result);

                $post_retrieve = array();
                $isFirstTime = true;
                while($row)
                {
                    $function_fields = array();
                    if(($index < $row_offset + $max_per_page || $max_per_page == -99))
                    {
                        if ($processing_collection)
                        {
                            $current_bean = $subpanel_def->sub_subpanels[$row['panel_name']]->template_instance;
                        } else {
                            $current_bean = $subpanel_def->template_instance;
                        }
                        if(!$isFirstTime)
                        {
                            $current_bean = $current_bean->getCleanCopy();
                        }

                        $isFirstTime = false;
                        //set the panel name in the bean instance.
                        if (isset($row['panel_name']))
                        {
                            $current_bean->panel_name=$row['panel_name'];
                        }
                        foreach($current_bean->field_defs as $field=>$value)
                        {

                            if (isset($row[$field]))
                            {
                                $current_bean->$field = $this->convertField($row[$field], $value);
                                unset($row[$field]);
                            }
                            else if (isset($row[$this->table_name .'.'.$field]))
                            {
                                $current_bean->$field = $this->convertField($row[$this->table_name .'.'.$field], $value);
                                unset($row[$this->table_name .'.'.$field]);
                            }
                            else
                            {
                                $current_bean->$field = "";
                                unset($row[$field]);
                            }
                            if(isset($value['source']) && $value['source'] == 'function')
                            {
                                $function_fields[]=$field;
                            }
                        }
                        foreach($row as $key=>$value)
                        {
                            $current_bean->$key = $value;
                        }
                        foreach($function_fields as $function_field)
                        {
                            $current_bean->$function_field = $this->callUserFunction($current_bean->field_defs[$function_field], $current_bean);
                        }

                        if(!empty($current_bean->parent_type) && !empty($current_bean->parent_id))
                        {
                            if(!isset($post_retrieve[$current_bean->parent_type]))
                            {
                                $post_retrieve[$current_bean->parent_type] = array();
                            }
                            $post_retrieve[$current_bean->parent_type][] = array('child_id'=>$current_bean->id, 'parent_id'=> $current_bean->parent_id, 'parent_type'=>$current_bean->parent_type, 'type'=>'parent');
                        }
                        //$current_bean->fill_in_additional_list_fields();
                        $list[$current_bean->id] = $current_bean;
                    }
                    // go to the next row
                    $index++;
                    $row = $db->fetchByAssoc($result);
                }
            //now handle retrieving many-to-many relationships
            if(!empty($list))
            {
                foreach($secondary_queries as $query2)
                {
                    $result2 = $db->query($query2);

                    $row2 = $db->fetchByAssoc($result2);
                    while($row2)
                    {
                        $id_ref = $row2['ref_id'];

                        if(isset($list[$id_ref]))
                        {
                            foreach($row2 as $r2key=>$r2value)
                            {
                                if($r2key != 'ref_id')
                                {
                                    $list[$id_ref]->$r2key = $r2value;
                                }
                            }
                        }
                        $row2 = $db->fetchByAssoc($result2);
                    }
                }

            }

            if(isset($post_retrieve))
            {
                $parent_fields = $this->retrieve_parent_fields($post_retrieve);
            }
            else
            {
                $parent_fields = array();
            }
            if(!empty($sugar_config['disable_count_query']) && !empty($limit) && $limit != -1 && $limit != -99)
            {
            	//C.L. Bug 43535 - Use the $index value to set the $rows_found value here
                $rows_found = isset($index) ? $index : $row_offset + count($list);

                if(count($list) >= $limit)
                {
                    array_pop($list);
                }
                if(!$toEnd)
                {
                    $next_offset--;
                    $previous_offset++;
                }
            }
        }
        else
        {
            $row_found 	= 0;
            $parent_fields = array();
        }
        $response = array();
        $response['list'] = $list;
        $response['parent_data'] = $parent_fields;
        $response['row_count'] = $rows_found;
        $response['next_offset'] = $next_offset;
        $response['previous_offset'] = $previous_offset;
        $response['current_offset'] = $row_offset ;
        $response['query'] = $query;

        return $response;
    }

    /**
     * Applies pagination window to select queries used by detail view,
     * executes the query and returns fetched data.
     *
     * Internal function, do not override.
     * @param string $query query to be processed.
     * @param int $row_offset
     * @param int $limit optional, default -1
     * @param int $max_per_page Optional, default -1
     * @param string $where Custom where clause.
     * @param int $offset Optional, default 0
     * @return array Fetched data.
     *
     */
    function process_detail_query($query, $row_offset, $limit= -1, $max_per_page = -1, $where = '', $offset = 0)
    {
        global $sugar_config;
        $GLOBALS['log']->debug("process_detail_query: ".$query);
        if($max_per_page == -1)
        {
            $max_per_page 	= $sugar_config['list_max_entries_per_page'];
        }

        // Check to see if we have a count query available.
        $count_query = $this->create_list_count_query($query);

        if(!empty($count_query) && (empty($limit) || $limit == -1))
        {
            // We have a count query.  Run it and get the results.
            $result = $this->db->query($count_query, true, "Error running count query for $this->object_name List: ");
            $assoc = $this->db->fetchByAssoc($result);
            if(!empty($assoc['c']))
            {
                $total_rows = $assoc['c'];
            }
        }

        if(empty($row_offset))
        {
            $row_offset = 0;
        }

        $result = $this->db->limitQuery($query, $offset, 1, true,"Error retrieving $this->object_name list: ");

        $previous_offset = $row_offset - $max_per_page;
        $next_offset = $row_offset + $max_per_page;

        $row = $this->db->fetchByAssoc($result);
        $this->retrieve($row['id']);

        $response = Array();
        $response['bean'] = $this;
        if (empty($total_rows))
            $total_rows=0;
        $response['row_count'] = $total_rows;
        $response['next_offset'] = $next_offset;
        $response['previous_offset'] = $previous_offset;

        return $response;
    }

    /**
     * Processes fetched list view data
     *
     * Internal function, do not override.
     * @param string $query query to be processed.
     * @param boolean $check_date Optional, default false. if set to true date time values are processed.
     * @return array Fetched data.
     *
     */
    function process_full_list_query($query, $check_date=false)
    {

        $GLOBALS['log']->debug("process_full_list_query: query is ".$query);
        $result = $this->db->query($query, false);
        $GLOBALS['log']->debug("process_full_list_query: result is ".print_r($result,true));
        // We have some data.
        while (($row = $this->db->fetchByAssoc($result)) != null)
        {
            $row = $this->convertRow($row);
            $bean = $this->getCleanCopy();

            foreach($bean->field_defs as $field=>$value)
            {
                if (isset($row[$field]))
                {
                    $bean->$field = $row[$field];
                    $GLOBALS['log']->debug("process_full_list: $bean->object_name({$row['id']}): ".$field." = ".$bean->$field);
                }
                else
                {
                    $bean->$field = '';
                }
            }
            if($check_date)
            {
                $bean->processed_dates_times = array();
                $bean->check_date_relationships_load();
            }
            $bean->fill_in_additional_list_fields();
            $bean->call_custom_logic("process_record");
            $bean->fetched_row = $row;

            $list[] = $bean;
        }
        //}
        if (isset($list)) return $list;
        else return null;
    }

    /**
    * Tracks the viewing of a detail record.
    * This leverages get_summary_text() which is object specific.
    *
    * Internal function, do not override.
    * @param string $user_id - String value of the user that is viewing the record.
    * @param string $current_module - String value of the module being processed.
    * @param string $current_view - String value of the current view
	*/
	function track_view($user_id, $current_module, $current_view='')
	{
	    $trackerManager = TrackerManager::getInstance();
		if($monitor = $trackerManager->getMonitor('tracker')){
	        $monitor->setValue('team_id', $GLOBALS['current_user']->getPrivateTeamID());
	        $monitor->setValue('date_modified', $GLOBALS['timedate']->nowDb());
	        $monitor->setValue('user_id', $user_id);
	        $monitor->setValue('module_name', $current_module);
	        $monitor->setValue('action', $current_view);
	        $monitor->setValue('item_id', $this->id);
	        $monitor->setValue('item_summary', $this->get_summary_text());
	        $monitor->setValue('visible', $this->tracker_visibility);
	        $trackerManager->saveMonitor($monitor);
		}
	}

    /**
     * Returns the summary text that should show up in the recent history list for this object.
     *
     * @return string
     */
    public function get_summary_text()
    {
        return "Base Implementation.  Should be overridden.";
    }

    /**
    * This is designed to be overridden and add specific fields to each record.
    * This allows the generic query to fill in the major fields, and then targeted
    * queries to get related fields and add them to the record.  The contact's
    * account for instance.  This method is only used for populating extra fields
    * in lists.
    */
    function fill_in_additional_list_fields(){
        if(!empty($this->field_defs['parent_name']) && empty($this->parent_name)){
            $this->fill_in_additional_parent_fields();
        }
    }

    /**
    * This is designed to be overridden and add specific fields to each record.
    * This allows the generic query to fill in the major fields, and then targeted
    * queries to get related fields and add them to the record.  The contact's
    * account for instance.  This method is only used for populating extra fields
    * in the detail form
    */
    function fill_in_additional_detail_fields()
    {
        global $locale;
        if(!empty($this->field_defs['assigned_user_name']) && !empty($this->assigned_user_id) && empty($this->assigned_user_name) && !empty($this->fetched_row['au_last_name'])){
             $this->assigned_user_name = $locale->getLocaleFormattedName($this->fetched_row['au_first_name'],$this->fetched_row['au_last_name']);
        }
 		if(!empty($this->field_defs['created_by_name']) && !empty($this->created_by) && !empty($this->fetched_row['cbu_last_name'])) {
 		    $this->created_by_name = $locale->getLocaleFormattedName($this->fetched_row['cbu_first_name'],$this->fetched_row['cbu_last_name']);
 		}
 		if(!empty($this->field_defs['modified_by_name']) && !empty($this->modified_user_id) && !empty($this->fetched_row['mbu_last_name'])) {
 		    $this->modified_by_name = $locale->getLocaleFormattedName($this->fetched_row['mbu_first_name'],$this->fetched_row['mbu_last_name']);
 		}

        if(!empty($this->field_defs['team_name']) && !empty($this->team_id) && empty($this->team_name) && !empty($this->fetched_row['tn_name'])) {
            if(!empty($GLOBALS['current_user']) && $GLOBALS['current_user']->showLastNameFirst()) {
		        $this->assigned_name = $this->team_name = trim($this->fetched_row['tn_name_2'] . ' ' . $this->fetched_row['tn_name']);
		    } else {
		      $this->assigned_name = $this->team_name = trim($this->fetched_row['tn_name'] . ' ' . $this->fetched_row['tn_name_2']);
		    }
        }

		if(!empty($this->field_defs['parent_name'])){
			$this->fill_in_additional_parent_fields();
		}
        $this->updateDependentField();
    }

    /**
    * This is desgined to be overridden or called from extending bean. This method
    * will fill in any parent_name fields.
    */
    function fill_in_additional_parent_fields() {
        // Added empty parent name check because beans with parent_name in vardef
        // were being nullified on retrieve AFTER save but were not passing the
        // parent_id/last_parent_id conditional, so the bean was losing parent_name
        // rgonzalez
        if(!empty($this->parent_id) && !empty($this->last_parent_id) && $this->last_parent_id == $this->parent_id && !empty($this->parent_name)){
            return false;
        }else{
            $this->parent_name = '';
        }
        if(!empty($this->parent_type)) {
            $this->last_parent_id = $this->parent_id;
            $this->getRelatedFields($this->parent_type, $this->parent_id, array('name'=>'parent_name', 'document_name' => 'parent_document_name', 'first_name'=>'parent_first_name', 'last_name'=>'parent_last_name'));
            if(!empty($this->parent_first_name) || !empty($this->parent_last_name) ){
                $this->parent_name = $GLOBALS['locale']->getLocaleFormattedName($this->parent_first_name, $this->parent_last_name);
                //note that the line below uses isset() AND checks for blank instead of using empty() on purpose
                //expected values could return a 0 which would not pass the empty() check.
            } else if(isset($this->parent_document_name) && $this->parent_document_name != '') {
                $this->parent_name = $this->parent_document_name;
            }
        }
    }

/*
     * Fill in a link field
     */

    function fill_in_link_field( $linkFieldName , $def)
    {
        $idField = $linkFieldName;
        //If the id_name provided really was an ID, don't try to load it as a link. Use the normal link
        if (!empty($this->field_defs[$linkFieldName]['type']) && $this->field_defs[$linkFieldName]['type'] == "id" && !empty($def['link']))
        {
            $linkFieldName = $def['link'];
        }
        if ($this->load_relationship($linkFieldName))
        {
            $list=$this->$linkFieldName->get();
            $this->$idField = '' ; // match up with null value in $this->populateFromRow()
            if (!empty($list))
                $this->$idField = $list[0];
        }
    }

    /**
    * Fill in fields where type = relate
    */
    function fill_in_relationship_fields()
    {
        global $fill_in_rel_depth;
        if(empty($fill_in_rel_depth) || $fill_in_rel_depth < 0)
            $fill_in_rel_depth = 0;

        if($fill_in_rel_depth > 1)
            return;

        $fill_in_rel_depth++;

        foreach($this->field_defs as $field)
        {
            if($field['type'] == 'relate' && !empty($field['module']))
            {
                $name = $field['name'];
                if(empty($this->$name))
                {
                    // set the value of this relate field in this bean ($this->$field['name']) to the value of the 'name' field in the related module for the record identified by the value of $this->$field['id_name']
                    $related_module = $field['module'];
                    $id_name = $field['id_name'];

                    if (empty($this->$id_name))
                    {
                       $this->fill_in_link_field($id_name, $field);
                    }
                    if(!empty($this->$id_name) && isset($this->$name) && ( $this->object_name != $related_module || ( $this->object_name == $related_module && $this->$id_name != $this->id ))){
                        $mod = BeanFactory::getBean($related_module, $this->$id_name
                        , array("disable_row_level_security" => true)
                        );
                        if ($mod){
                            if (!empty($field['rname'])) {
                                $this->$name = $mod->$field['rname'];
                            } else if (isset($mod->name)) {
                                $this->$name = $mod->name;
                            }
                        }
                    }
                    if(!empty($this->$id_name) && isset($this->$name))
                    {
                        if(!isset($field['additionalFields']))
                           $field['additionalFields'] = array();
                        if(!empty($field['rname']))
                        {
                            $field['additionalFields'][$field['rname']]= $name;
                        }
                        else
                        {
                            $field['additionalFields']['name']= $name;
                        }
                        $this->getRelatedFields($related_module, $this->$id_name, $field['additionalFields']);
                    }
                }
            }
        }
        $fill_in_rel_depth--;
    }

    /**
    * This is a helper function that is used to quickly created indexes when creating tables.
    */
    function create_index($query)
    {
        $GLOBALS['log']->info("create_index: $query");

        $result = $this->db->query($query, true, "Error creating index:");
    }

    /**
     * This function should be overridden in each module.  It marks an item as deleted.
     *
     * If it is not overridden, then marking this type of item is not allowed
	 */
    public function mark_deleted($id)
    {
        global $current_user;
        $date_modified = $GLOBALS['timedate']->nowDb();
        if (isset($_SESSION['show_deleted'])) {
            $this->mark_undeleted($id);
        } else {
            // Ensure that Activity Messages do not occur in the context of a Delete action (e.g. unlink)
            // and do so for all nested calls within the Top Level Delete Context
            $opflag = static::enterOperation('delete');
            $aflag = Activity::isEnabled();
            Activity::disable();
            // call the custom business logic
            $custom_logic_arguments['id'] = $id;
            $this->call_custom_logic("before_delete", $custom_logic_arguments);
            $this->deleted = 1;
            $this->mark_relationships_deleted($id);
            if (isset($this->field_defs['modified_user_id'])) {
                if (!empty($current_user)) {
                    $this->modified_user_id = $current_user->id;
                } else {
                    $this->modified_user_id = 1;
                }
                $query = "UPDATE $this->table_name set deleted=1, date_modified = '$date_modified',
                            modified_user_id = '$this->modified_user_id' where id='$id'";
                if ($this->isFavoritesEnabled()) {
                    SugarFavorites::markRecordDeletedInFavorites($id, $date_modified, $this->modified_user_id);
                }
            } else {
                $query = "UPDATE $this->table_name set deleted=1 , date_modified = '$date_modified' where id='$id'";
                if ($this->isFavoritesEnabled()) {
                    SugarFavorites::markRecordDeletedInFavorites($id, $date_modified);
                }
            }
            $this->db->query($query, true, "Error marking record deleted: ");

            // Take the item off the recently viewed lists
            $tracker = BeanFactory::getBean('Trackers');
            $tracker->makeInvisibleForAll($id);

            require_once('include/SugarSearchEngine/SugarSearchEngineFactory.php');
            $searchEngine = SugarSearchEngineFactory::getInstance();
            $searchEngine->delete($this);

            SugarRelationship::resaveRelatedBeans();

            // call the custom business logic
            $this->call_custom_logic("after_delete", $custom_logic_arguments);
            if(static::leaveOperation('delete', $opflag) && $aflag) {
                Activity::enable();
            }
        }
    }

    /**
     * Restores data deleted by call to mark_deleted() function.
     *
     * Internal function, do not override.
    */
    function mark_undeleted($id)
    {
        // call the custom business logic
        $custom_logic_arguments['id'] = $id;
        $this->call_custom_logic("before_restore", $custom_logic_arguments);

		$date_modified = $GLOBALS['timedate']->nowDb();
		$query = "UPDATE $this->table_name set deleted=0 , date_modified = '$date_modified' where id='$id'";
		$this->db->query($query, true,"Error marking record undeleted: ");

        // call the custom business logic
        $this->call_custom_logic("after_restore", $custom_logic_arguments);
    }

   /**
    * This function deletes relationships to this object.  It should be overridden
    * to handle the relationships of the specific object.
    * This function is called when the item itself is being deleted.
    *
    * @param int $id id of the relationship to delete
    */
   function mark_relationships_deleted($id)
   {
    $this->delete_linked($id);
   }

    /**
    * This function is used to execute the query and create an array template objects
    * from the resulting ids from the query.
    * It is currently used for building sub-panel arrays.
    *
    * @param string $query - the query that should be executed to build the list
    * @param object $template - The object that should be used to copy the records.
    * @param int $row_offset Optional, default 0
    * @param int $limit Optional, default -1
    * @return array
    */
    function build_related_list($query, $template, $row_offset = 0, $limit = -1)
    {
        $GLOBALS['log']->debug("Finding linked records $this->object_name: ".$query);
        $db = DBManagerFactory::getInstance('listviews');

        if(!empty($row_offset) && $row_offset != 0 && !empty($limit) && $limit != -1)
        {
            $result = $db->limitQuery($query, $row_offset, $limit,true,"Error retrieving $template->object_name list: ");
        }
        else
        {
            $result = $db->query($query, true);
        }

        $list = Array();
        while($row = $this->db->fetchByAssoc($result))
        {
            $record = BeanFactory::retrieveBean($template->module_name, $row['id']
            , array("disable_row_level_security" => $template->disable_row_level_security)
            );
            if(!empty($record))
            {
                // this copies the object into the array
                $list[] = $record;
            }
        }
        return $list;
    }

  /**
    * This function is used to execute the query and create an array template objects
    * from the resulting ids from the query.
    * It is currently used for building sub-panel arrays. It supports an additional
    * where clause that is executed as a filter on the results
    *
    * @param string $query - the query that should be executed to build the list
    * @param object $template - The object that should be used to copy the records.
    */
  function build_related_list_where($query, $template, $where='', $in='', $order_by, $limit='', $row_offset = 0)
  {
    $db = DBManagerFactory::getInstance('listviews');
    // No need to do an additional query
    $GLOBALS['log']->debug("Finding linked records $this->object_name: ".$query);
    if(empty($in) && !empty($query))
    {
        $idList = $this->build_related_in($query);
        $in = $idList['in'];
    }
    // MFH - Added Support For Custom Fields in Searches
    $custom_join = $this->getCustomJoin();

    $query = "SELECT id ";

    $query .= $custom_join['select'];
    $query .= " FROM $this->table_name ";

    $query .= $custom_join['join'];

    $query .= " WHERE deleted=0 AND id IN $in";
    if(!empty($where))
    {
        $query .= " AND $where";
    }


    if(!empty($order_by))
    {
        $query .= "ORDER BY $order_by";
    }
    if (!empty($limit))
    {
        $result = $db->limitQuery($query, $row_offset, $limit,true,"Error retrieving $this->object_name list: ");
    }
    else
    {
        $result = $db->query($query, true);
    }

    $list = Array();
    while($row = $db->fetchByAssoc($result))
    {
        $record = BeanFactory::retrieveBean($template->module_dir, $row['id']
        , array("disable_row_level_security" => $template->disable_row_level_security)
        );
        if(!empty($record))
        {
            // this copies the object into the array
            $list[] = $template;
        }
    }

    return $list;
  }

    /**
     * Constructs an comma separated list of ids from passed query results.
     *
     * @param string @query query to be executed.
     *
     */
    function build_related_in($query)
    {
        $idList = array();
        $result = $this->db->query($query, true);
        $ids = '';
        while($row = $this->db->fetchByAssoc($result))
        {
            $idList[] = $row['id'];
            if(empty($ids))
            {
                $ids = "('" . $row['id'] . "'";
            }
            else
            {
                $ids .= ",'" . $row['id'] . "'";
            }
        }
        if(empty($ids))
        {
            $ids = "('')";
        }else{
            $ids .= ')';
        }

        return array('list'=>$idList, 'in'=>$ids);
    }

    /**
    * Optionally copies values from fetched row into the bean.
    *
    * Internal function, do not override.
    *
    * @param string $query - the query that should be executed to build the list
    * @param object $template - The object that should be used to copy the records
    * @param array $field_list List of  fields.
    * @return array
    */
    function build_related_list2($query, $template, &$field_list)
    {
        $GLOBALS['log']->debug("Finding linked values $this->object_name: ".$query);

        $result = $this->db->query($query, true);

        $list = Array();
        while($row = $this->db->fetchByAssoc($result))
        {
        	$record = $template->getCleanCopy();
            foreach($field_list as $field)
            {
                // Copy the relevant fields
                $record->$field = $row[$field];
            }

            // this copies the object into the array
            $list[] = $record;
        }

        return $list;
    }

    /**
     * Let implementing classes to fill in row specific columns of a list view form
     *
     */
    function list_view_parse_additional_sections(&$list_form)
    {
    }
	/*
     * fix bug #54042: ListView calculates all field dependencies
     *
     * return listDef for bean
     */
    function updateDependentFieldForListView($listview_def_main = '', $filter_fields = null)
    {
        static $listview_def = '';
        static $module_name = '';
        // for subpanels
        if (!empty($listview_def_main))
        {
            $listview_def = $listview_def_main;
        } elseif (empty($listview_def) || $module_name != $this->module_name)
        {
            $view = new SugarView();
            $view->type = 'list';
            $view->module = $this->module_name;
            $listview_meta_file = $view->getMetaDataFile();
            if (!empty($listview_meta_file))
            {
                require $listview_meta_file;
                if (isset($listViewDefs[$this->module_name]))
                {
                    $listview_def = $listViewDefs[$this->module_name];
                } else if (isset($listViewDefs[$this->object_name])) {
                    $listview_def = $listViewDefs[$this->object_name];

                }
            }
            $module_name = $this->module_name;
        }

        $this->updateDependentField($filter_fields);
        $this->is_updated_dependent_fields = true;
    }

    /**
     * Assigns all of the values into the template for the list view
     */
    function get_list_view_array()
    {
        static $cache = array();
        // cn: bug 12270 - sensitive fields being passed arbitrarily in listViews
        $sensitiveFields = array('user_hash' => '');

        $return_array = Array();
        global $app_list_strings, $mod_strings;
        foreach($this->field_defs as $field=>$value){

            if(isset($this->$field)){

                // cn: bug 12270 - sensitive fields being passed arbitrarily in listViews
                if(isset($sensitiveFields[$field]))
                    continue;
                if(!isset($cache[$field]))
                    $cache[$field] = strtoupper($field);

                //Fields hidden by Dependent Fields
                if (isset($value['hidden']) && $value['hidden'] === true) {
                        $return_array[$cache[$field]] = "";

                }
                //cn: if $field is a _dom, detect and return VALUE not KEY
                //cl: empty function check for meta-data enum types that have values loaded from a function
                else if (((!empty($value['type']) && ($value['type'] == 'enum' || $value['type'] == 'radioenum') ))  && empty($value['function'])){
                    if(!empty($value['options']) && !empty($app_list_strings[$value['options']][$this->$field])){
                        $return_array[$cache[$field]] = $app_list_strings[$value['options']][$this->$field];
                    }
                    //nsingh- bug 21672. some modules such as manufacturers, Releases do not have a listing for select fields in the $app_list_strings. Must also check $mod_strings to localize.
                    elseif(!empty($value['options']) && !empty($mod_strings[$value['options']][$this->$field]))
                    {
                        $return_array[$cache[$field]] = $mod_strings[$value['options']][$this->$field];
                    }
                    else{
                        $return_array[$cache[$field]] = $this->$field;
                    }
                    //end bug 21672
// tjy: no need to do this str_replace as the changes in 29994 for ListViewGeneric.tpl for translation handle this now
//				}elseif(!empty($value['type']) && $value['type'] == 'multienum'&& empty($value['function'])){
//					$return_array[strtoupper($field)] = str_replace('^,^', ', ', $this->$field );
                }elseif(!empty($value['custom_module']) && $value['type'] != 'currency'){
//					$this->format_field($value);
                    $return_array[$cache[$field]] = $this->$field;
                }else{
                    $return_array[$cache[$field]] = $this->$field;
                }
                // handle "Assigned User Name"
                if($field == 'assigned_user_name'){
                    $return_array['ASSIGNED_USER_NAME'] = get_assigned_user_name($this->assigned_user_id);
                }
            }
        }
        return $return_array;
    }
    /**
     * Override this function to set values in the array used to render list view data.
     *
     */
    function get_list_view_data()
    {
        return $this->get_list_view_array();
    }

    /**
     * Construct where clause from a list of name-value pairs.
     * @param array $fields_array Name/value pairs for column checks
     * @param boolean $deleted Optional, default true, if set to false deleted filter will not be added.
     * @return string The WHERE clause
     */
    function get_where($fields_array, $deleted=true)
    {
        $where_clause = "";
        foreach ($fields_array as $name=>$value)
        {
            if (!empty($where_clause)) {
                $where_clause .= " AND ";
            }
            $name = $this->db->getValidDBName($name);

            $where_clause .= "$name = ".$this->db->quoted($value,false);
        }
        if(!empty($where_clause)) {
            if($deleted) {
                return "WHERE $where_clause AND deleted=0";
            } else {
                return "WHERE $where_clause";
            }
        } else {
            return "";
        }
    }


    /**
     * Constructs a select query and fetch 1 row using this query, and then process the row
     *
     * Internal function, do not override.
     * @param array @fields_array  array of name value pairs used to construct query.
     * @param boolean $encode Optional, default true, encode fetched data.
     * @param boolean $deleted Optional, default true, if set to false deleted filter will not be added.
     * @return object Instance of this bean with fetched data.
     */
    function retrieve_by_string_fields($fields_array, $encode=true, $deleted=true)
    {
        $where_clause = $this->get_where($fields_array, $deleted);
        $custom_join = $this->getCustomJoin();
        $query = "SELECT $this->table_name.*". $custom_join['select']. " FROM $this->table_name " . $custom_join['join'];
        $query .= " $where_clause";
        $GLOBALS['log']->debug("Retrieve $this->object_name: ".$query);
        //requireSingleResult has been deprecated.
        //$result = $this->db->requireSingleResult($query, true, "Retrieving record $where_clause:");
        $result = $this->db->limitQuery($query,0,1,true, "Retrieving record $where_clause:");


        if( empty($result))
        {
            return null;
        }
        $row = $this->db->fetchByAssoc($result, $encode);
        if(empty($row))
        {
            return null;
        }
        // Removed getRowCount-if-clause earlier and insert duplicates_found here as it seems that we have found something
        // if we didn't return null in the previous clause.
        $this->duplicates_found = true;
        $row = $this->convertRow($row);
        $this->fetched_row = $row;
        $this->fromArray($row);
		$this->is_updated_dependent_fields = false;
        $this->fill_in_additional_detail_fields();
        return $this;
    }

    /**
    * This method is called during an import before inserting a bean
    * Define an associative array called $special_fields
    * the keys are user defined, and don't directly map to the bean's fields
    * the value is the method name within that bean that will do extra
    * processing for that field. example: 'full_name'=>'get_names_from_full_name'
    *
    */
    function process_special_fields()
    {
        foreach ($this->special_functions as $func_name)
        {
            if ( method_exists($this,$func_name) )
            {
                $this->$func_name();
            }
        }
    }

    /**
     * Override this function to build a where clause based on the search criteria set into bean .
     * @abstract
     */
    function build_generic_where_clause($value)
    {
    }

    function getRelatedFields($module, $id, $fields, $return_array = false){
        if(empty($GLOBALS['beanList'][$module]))return '';
        $object = BeanFactory::getObjectName($module);

        VardefManager::loadVardef($module, $object);
        if(empty($GLOBALS['dictionary'][$object]['table']))return '';
        $table = $GLOBALS['dictionary'][$object]['table'];
        $query  = 'SELECT id';
        foreach($fields as $field=>$alias){
            if(!empty($GLOBALS['dictionary'][$object]['fields'][$field]['db_concat_fields'])){
                $query .= ' ,' .$this->db->concat($table, $GLOBALS['dictionary'][$object]['fields'][$field]['db_concat_fields']) .  ' as ' . $alias ;
            }else if(!empty($GLOBALS['dictionary'][$object]['fields'][$field]) &&
                (empty($GLOBALS['dictionary'][$object]['fields'][$field]['source']) ||
                $GLOBALS['dictionary'][$object]['fields'][$field]['source'] != "non-db"))
            {
                $query .= ' ,' .$table . '.' . $field . ' as ' . $alias;
            }
            if(!$return_array)$this->$alias = '';
        }
        if($query == 'SELECT id' || empty($id)){
            return '';
        }


        if(isset($GLOBALS['dictionary'][$object]['fields']['assigned_user_id']))
        {
            $query .= " , ".	$table  . ".assigned_user_id owner";

        }
        else if(isset($GLOBALS['dictionary'][$object]['fields']['created_by']))
        {
            $query .= " , ".	$table . ".created_by owner";

        }
        $query .=  ' FROM ' . $table . ' WHERE deleted=0 AND id=';
        $result = $GLOBALS['db']->query($query . "'$id'" );
        $row = $GLOBALS['db']->fetchByAssoc($result);
        if($return_array){
            return $row;
        }
        $owner = (empty($row['owner']))?'':$row['owner'];
        foreach($fields as $alias){
            $this->$alias = (!empty($row[$alias]))? $row[$alias]: '';
            $alias = $alias  .'_owner';
            $this->$alias = $owner;
            $a_mod = $alias  .'_mod';
            $this->$a_mod = $module;
        }


    }

    /**
     * Add visibility clauses to the query
     * @param string $query
     */
    function add_team_security_where_clause(&$query,$table_alias='',$join_type='INNER',$force_admin=false,$join_teams=false)
    {
        // join type & force admin ignored since they are not used anywhere
        $options = array();
        if(!empty($table_alias)) {
            $options['table_alias'] = $table_alias;
        }
        if(!empty($join_teams)) {
            $options['join_teams'] = true;
        }
        return $this->addVisibilityFrom($query, $options);
    }

    /**
    * Add a join to the query to enforce the data returned will only be for
    * teams to which this user has membership
     *
     * Internal function, do not override.
     * @deprecated
    */
    private function _add_team_security(&$query,$table_alias='',$join_type='INNER',$force_admin=false,$join_teams=false)
    {
        // We need to confirm that the user is a member of the team of the item.

        global $current_user;
        if(empty($current_user) || empty($current_user->id))
        {
            return;
        }

        // The user either has to be an admin, or be assigned to the team that owns the data
        $team_table_alias = 'team_memberships';

        if (! empty( $table_alias))
        {
            $team_table_alias .= $table_alias;
        }
        else
        {
            $table_alias = $this->table_name;
        }
        if ( ( (!$current_user->isAdminForModule($this->module_dir)) || $force_admin ) &&
        !$this->disable_row_level_security	&& ($this->module_dir != 'WorkFlow')){

            $query .= " " . $join_type . " JOIN (select tst.team_set_id from team_sets_teams tst";
            $query .= " " . $join_type . " JOIN team_memberships {$team_table_alias} ON tst.team_id = {$team_table_alias}.team_id
                                    AND {$team_table_alias}.user_id = '$current_user->id'
                                    AND {$team_table_alias}.deleted=0 group by tst.team_set_id) {$table_alias}_tf on {$table_alias}_tf.team_set_id  = {$table_alias}.team_set_id ";

            if ( $join_teams ){
                $query .= " INNER JOIN teams ON teams.id = team_memberships.team_id AND teams.deleted=0 ";
            }
        }
    }

    function &parse_additional_headers(&$list_form, $xTemplateSection)
    {
        return $list_form;
    }

    function assign_display_fields($currentModule)
    {
        global $timedate;
        foreach($this->column_fields as $field)
        {
            if(isset($this->field_name_map[$field]) && empty($this->$field))
            {
                if($this->field_name_map[$field]['type'] != 'date' && $this->field_name_map[$field]['type'] != 'enum')
                $this->$field = $field;
                if($this->field_name_map[$field]['type'] == 'date')
                {
                    $this->$field = $timedate->to_display_date('1980-07-09');
                }
                if($this->field_name_map[$field]['type'] == 'enum')
                {
                    $dom = $this->field_name_map[$field]['options'];
                    global $current_language, $app_list_strings;
                    $mod_strings = return_module_language($current_language, $currentModule);

                    if(isset($mod_strings[$dom]))
                    {
                        $options = $mod_strings[$dom];
                        foreach($options as $key=>$value)
                        {
                            if(!empty($key) && empty($this->$field ))
                            {
                                $this->$field = $key;
                            }
                        }
                    }
                    if(isset($app_list_strings[$dom]))
                    {
                        $options = $app_list_strings[$dom];
                        foreach($options as $key=>$value)
                        {
                            if(!empty($key) && empty($this->$field ))
                            {
                                $this->$field = $key;
                            }
                        }
                    }


                }
            }
        }

        $this->assigned_name = 'Assigned To Team Name';
        $this->assigned_user_id = '1';
        $this->assigned_user_name = 'Assigned To User Name';
        $this->team_name = 'Assigned To Team Name';
        $this->team_id = '1';

    }

    /*
    * 	RELATIONSHIP HANDLING
    */

    function set_relationship($table, $relate_values, $check_duplicates = true,$do_update=false,$data_values=null)
    {
        $where = '';

		// make sure there is a date modified
		$date_modified = $this->db->convert("'".$GLOBALS['timedate']->nowDb()."'", 'datetime');

        $row=null;
        if($check_duplicates)
        {
            $query = "SELECT * FROM $table ";
            $where = "WHERE deleted = '0'  ";
            foreach($relate_values as $name=>$value)
            {
                $where .= " AND $name = '$value' ";
            }
            $query .= $where;
            $result = $this->db->query($query, false, "Looking For Duplicate Relationship:" . $query);
            $row=$this->db->fetchByAssoc($result);
        }

        if(!$check_duplicates || empty($row) )
        {
            unset($relate_values['id']);
            if ( isset($data_values))
            {
                $relate_values = array_merge($relate_values,$data_values);
            }
            $query = "INSERT INTO $table (id, ". implode(',', array_keys($relate_values)) . ", date_modified) VALUES ('" . create_guid() . "', " . "'" . implode("', '", $relate_values) . "', ".$date_modified.")" ;

            $this->db->query($query, false, "Creating Relationship:" . $query);
        }
        else if ($do_update)
        {
            $conds = array();
            foreach($data_values as $key=>$value)
            {
                array_push($conds,$key."='".$this->db->quote($value)."'");
            }
            $query = "UPDATE $table SET ". implode(',', $conds).",date_modified=".$date_modified." ".$where;
            $this->db->query($query, false, "Updating Relationship:" . $query);
        }
    }

    function retrieve_relationships($table, $values, $select_id)
    {
        $query = "SELECT $select_id FROM $table WHERE deleted = 0  ";
        foreach($values as $name=>$value)
        {
            $query .= " AND $name = '$value' ";
        }
        $query .= " ORDER BY $select_id ";
        $result = $this->db->query($query, false, "Retrieving Relationship:" . $query);
        $ids = array();
        while($row = $this->db->fetchByAssoc($result))
        {
            $ids[] = $row;
        }
        return $ids;
    }

    // TODO: this function needs adjustment
    function loadLayoutDefs()
    {
        global $layout_defs;
        if(empty($this->layout_def)) {
            foreach(SugarAutoLoader::existing("modules/{$this->module_dir}/layout_defs.php",
                "custom/modules/{$this->module_dir}/Ext/Layoutdefs/layoutdefs.ext.php") as $file) {
                require $file;
            }
            if ( empty( $layout_defs[get_class($this)]))
            {
                $GLOBALS['log']->fatal("\$layout_defs[" . get_class($this) . "]; does not exist");
                $this->layout_def = array();
            } else {
                $this->layout_def = $layout_defs[get_class($this)];
            }
        }
    }
    /*
    The vardef handler allows you set filters against the vardefs for a bean
    and return an array with what you need.  This is being used right now for
    the workflow UI
    */
    function call_vardef_handler($meta_array_type=null)
    {
        include_once('include/VarDefHandler/VarDefHandler.php');
        $this->vardef_handler = new VarDefHandler($this, $meta_array_type);
        //end function call_vardef_handler
    }
    /*
    The relationship handler allows you grab necessary related module information.
    This is being used right now for the workflow UI
    */
    function call_relationship_handler($target_base="module_dir", $return_handler=false)
    {
        include_once('modules/Relationships/RelationshipHandler.php');

        $rel_handler = null;
        if($return_handler==true)
        {
            $rel_handler = new RelationshipHandler($this->db, $this->$target_base);
            $rel_handler->base_bean = $this;
        }
        else
        {
            $this->rel_handler = new RelationshipHandler($this->db, $this->$target_base);
            $this->base_bean = $this;
        }

        return $rel_handler;
    }


    /**
    * Trigger custom logic for this module that is defined for the provided hook
    * The custom logic file is located under custom/modules/[CURRENT_MODULE]/logic_hooks.php.
    * That file should define the $hook_version that should be used.
    * It should also define the $hook_array.  The $hook_array will be a two dimensional array
    * the first dimension is the name of the event, the second dimension is the information needed
    * to fire the hook.  Each entry in the top level array should be defined on a single line to make it
    * easier to automatically replace this file.  There should be no contents of this file that are not replacable.
    *
    * $hook_array['before_save'][] = Array(1, testtype, 'custom/modules/Leads/test12.php', 'TestClass', 'lead_before_save_1');
    * This sample line creates a before_save hook.  The hooks are procesed in the order in which they
    * are added to the array.  The second dimension is an array of:
    *		processing index (for sorting before exporting the array)
    *		A logic type hook
    *		label/type
    *		php file to include
    *		php class the method is in
    *		php method to call
    *
    * The method signature for version 1 hooks is:
    * function NAME(&$bean, $event, $arguments)
    * 		$bean - $this bean passed in by reference.
    *		$event - The string for the current event (i.e. before_save)
    * 		$arguments - An array of arguments that are specific to the event.
    */
    function call_custom_logic($event, $arguments = null)
    {
        if(!isset($this->processed) || $this->processed == false){
            //add some logic to ensure we do not get into an infinite loop
            if(!empty($this->logicHookDepth[$event])) {
                if($this->logicHookDepth[$event] > $this->max_logic_depth)
                    return;
            }else
                $this->logicHookDepth[$event] = 0;

            //we have to put the increment operator here
            //otherwise we may never increase the depth for that event in the case
            //where one event will trigger another as in the case of before_save and after_save
            //Also keeping the depth per event allow any number of hooks to be called on the bean
            //and we only will return if one event gets caught in a loop. We do not increment globally
            //for each event called.
            $this->logicHookDepth[$event]++;

            //method defined in 'include/utils/LogicHook.php'

            $logicHook = new LogicHook();
            $logicHook->setBean($this);
            $logicHook->call_custom_logic($this->module_dir, $event, $arguments);
            $this->logicHookDepth[$event]--;
            //Fire dependency manager dependencies here for some custom logic types.
            if (in_array($event, array('after_relationship_add', 'after_relationship_delete', 'before_delete')))
            {
                $this->updateRelatedCalcFields(isset($arguments['link']) ? $arguments['link'] : "");
            }
        }
    }

    /**
     * Any alerts that have been placed into the session, be sure to process them.
     * This function was created as a result of bug 7908
     */
    function process_workflow_alerts()
    {
        require_once('include/workflow/WorkFlowHandler.php');
        $handler = new WorkFlowHandler($this, 'after_save');
        if(!empty($_SESSION['WORKFLOW_ALERTS']))
        {
            $id_for_save = true;
            // Bug 55942 the in-save id gets overwritten during resaveRelatedBeans process
            // here we want to make sure the correct in-save id is used to send the alert
            if (isset($_SESSION['WORKFLOW_ALERTS']['id']))
            {
                $id_for_save = ($_SESSION['WORKFLOW_ALERTS']['id'] == $this->id ? true : false);
            }

            if ($id_for_save)
            {
                $handler->process_alerts($this, $_SESSION['WORKFLOW_ALERTS'][$this->module_dir]);
                unset( $_SESSION['WORKFLOW_ALERTS'][$this->module_dir]);
                if (isset($_SESSION['WORKFLOW_ALERTS']['id']))
                {
                    unset( $_SESSION['WORKFLOW_ALERTS']['id']);
                }
            }
        }
    }

    /*	When creating a custom field of type Dropdown, it creates an enum row in the DB.
     A typical get_list_view_array() result will have the *KEY* value from that drop-down.
     Since custom _dom objects are flat-files included in the $app_list_strings variable,
     We need to generate a key-key pair to get the true value like so:
     ([module]_cstm->fields_meta_data->$app_list_strings->*VALUE*)*/
    function getRealKeyFromCustomFieldAssignedKey($name)
    {
        if ($this->custom_fields->avail_fields[$name]['ext1'])
        {
            $realKey = 'ext1';
        }
        elseif ($this->custom_fields->avail_fields[$name]['ext2'])
        {
            $realKey = 'ext2';
        }
        elseif ($this->custom_fields->avail_fields[$name]['ext3'])
        {
            $realKey = 'ext3';
        }
        else
        {
            $GLOBALS['log']->fatal("SUGARBEAN: cannot find Real Key for custom field of type dropdown - cannot return Value.");
            return false;
        }
        if(isset($realKey))
        {
            return $this->custom_fields->avail_fields[$name][$realKey];
        }
    }

    function bean_implements($interface)
    {
        return false;
    }

    /**
     * Default ACL implementations for a bean
     * @return array
     */
    public function defaultACLs()
    {
        $data = isset($GLOBALS['dictionary'][$this->object_name]['acls'])?$GLOBALS['dictionary'][$this->object_name]['acls']:array();
        if(!isset($data['SugarACLStatic']) && $this->bean_implements('ACL')) {
             $data['SugarACLStatic'] = true;
        }
        return array_merge($data, self::$default_acls);
    }

    /**
     * Filter fields for specific view - null those that aren't allowed by ACL
     * @param string $view
     * @param array $context
     */
    public function ACLFilterFields($view = 'detail', $context = array())
    {
        if(empty($context['bean'])) {
            $context['bean'] = $this;
        }
        $acl_category = $this->getACLCategory();
        foreach($this->field_defs as $field=>$def){
            if(isset($this->$field) && $def['type'] != 'link'){
                if(!SugarACL::checkField($acl_category, $field, $view, $context)) {
                    $this->$field = '';
                }
            }
        }
    }

    /**
     * Filter list of fields and remove/blank fields that we can not access
     * Modifies the list directly.
     * @param array $list list of fields, keys are field names
     * @param array $context
     * @param array options Filtering options:
     * - blank_value (bool) - instead of removing inaccessible field put '' there
     * - add_acl (bool) - instead of removing fields add 'acl' value with access level
     * - suffix (string) - strip suffix from field names
     * - min_access (int) - require this level of access for field
     * - use_value (bool) - look for field name in value, not in key of the list
     */
    public function ACLFilterFieldList(&$list, $context = array(), $options = array())
    {
        if(empty($context['bean'])) {
            $context['bean'] = $this;
        }
        SugarACL::listFilter($this->getACLCategory(), $list, $context, $options);
    }

    /**
     * Check field access for certain field
     * @param string $field Field name
     * @param string $action Action to check
     * @param array $context
     * @return bool has access?
     */
    public function ACLFieldAccess($field, $action = 'access', $context = array())
    {
        if(empty($context['bean'])) {
            $context['bean'] = $this;
        }
        return SugarACL::checkField($this->getACLCategory(), $field, $action, $context);
    }

    /**
     * Get field access level
     * @param string $field Field name
     * @param array $context
     * @return int Access level
     */
    public function ACLFieldGet($field, $context = array())
    {
        if(empty($context['bean'])) {
            $context['bean'] = $this;
        }
        return SugarACL::getFieldAccess($this->getACLCategory(), $field, $context);
    }

    /**
     * Check ACL access to certain view for this object
     * @param string $view
     * @param array $context
     * @return bool has access?
     */
    public function ACLAccess($view, $context = null)
    {
        if(is_bool($context)) {
            // BC hack to accept owner override
           $context = array('owner_override' => $context);
        }
        if(empty($context) || $context == 'not_set') {
            $context = array();
        }
        if(!isset($context['bean'])) {
            $context['bean'] = $this;
        }
        return SugarACL::checkAccess($this->getACLCategory(), $view, $context);
    }


    /**
    * Check whether the user has access to a particular view for the current bean/module
    * @deprecated
    * @param $view string required, the view to determine access for i.e. DetailView, ListView...
    * @param $is_owner bool optional, this is part of the ACL check if the current user is an owner they will receive different access
    */
    private function _ACLAccess($view,$is_owner='not_set')
    {
        global $current_user;
        if($current_user->isAdminForModule($this->getACLCategory())) {
            return true;
        }
        $not_set = false;
        if($is_owner == 'not_set')
        {
            $not_set = true;
            $is_owner = $this->isOwner($current_user->id);
        }

        // If we don't implement ACLs, return true.
        if(!$this->bean_implements('ACL'))
        return true;
        $view = strtolower($view);
        switch ($view)
        {
            case 'list':
            case 'index':
            case 'listview':
                return ACLController::checkAccess($this->module_dir,'list', true);
            case 'edit':
            case 'save':
                if( !$is_owner && $not_set && !empty($this->id)){
                    $temp = $this->getCleanCopy();
                    if(!empty($this->fetched_row) && !empty($this->fetched_row['id']) && !empty($this->fetched_row['assigned_user_id']) && !empty($this->fetched_row['created_by'])){
                        $temp->populateFromRow($this->fetched_row);
                    }else{
                        $temp->retrieve($this->id);
                    }
                    $is_owner = $temp->isOwner($current_user->id);
                }
            case 'popupeditview':
            case 'editview':
                return ACLController::checkAccess($this->module_dir,'edit', $is_owner, $this->acltype);
            case 'view':
            case 'detail':
            case 'detailview':
                return ACLController::checkAccess($this->module_dir,'view', $is_owner, $this->acltype);
            case 'delete':
                return ACLController::checkAccess($this->module_dir,'delete', $is_owner, $this->acltype);
            case 'export':
                return ACLController::checkAccess($this->module_dir,'export', $is_owner, $this->acltype);
            case 'import':
                return ACLController::checkAccess($this->module_dir,'import', true, $this->acltype);
        }
        //if it is not one of the above views then it should be implemented on the page level
        return true;
    }

    /**
    * Get owner field
    *
    * @return STRING
    */
    function getOwnerField($returnFieldName = false)
    {
        if (isset($this->field_defs['assigned_user_id']))
        {
            return $returnFieldName? 'assigned_user_id': $this->assigned_user_id;
        }

        if (isset($this->field_defs['created_by']))
        {
            return $returnFieldName? 'created_by': $this->created_by;
        }

        return '';
    }

    /**
    * Returns true of false if the user_id passed is the owner
    *
    * @param GUID $user_id
    * @return boolean
    */
    function isOwner($user_id)
    {
        //if we don't have an id we must be the owner as we are creating it
        if (!isset($this->id) || !empty($this->new_with_id)) {
            return true;
        }
        //if there is an assigned_user that is the owner
        if (isset($this->assigned_user_id)) {
            if ($this->assigned_user_id == $user_id) {
                return true;
            }
            if (isset($this->fetched_row['assigned_user_id'])
                && $this->fetched_row['assigned_user_id'] == $user_id) {
                return true;
            }
            return false;
        } else {
            //other wise if there is a created_by that is the owner
            if (isset($this->created_by) && $this->created_by == $user_id) {
                return true;
            }
        }
        return false;
    }
    /**
    * Gets there where statement for checking if a user is an owner
    *
    * @param GUID $user_id
    * @return STRING
    */
    function getOwnerWhere($user_id)
    {
        if(isset($this->field_defs['assigned_user_id']))
        {
            return " $this->table_name.assigned_user_id ='$user_id' ";
        }
        if(isset($this->field_defs['created_by']))
        {
            return " $this->table_name.created_by ='$user_id' ";
        }
        return '';
    }

    /**
    *
    * Used in order to manage ListView links and if they should
    * links or not based on the ACL permissions of the user
    *
    * @return ARRAY of STRINGS
    */
    function listviewACLHelper()
    {
        $array_assign = array();
        if($this->ACLAccess('DetailView'))
        {
            $array_assign['MAIN'] = 'a';
        }
        else
        {
            $array_assign['MAIN'] = 'span';
        }
        return $array_assign;
    }

    /**
    * returns this bean as an array
    *
    * @return array of fields with id, name, access and category
    */
    function toArray($dbOnly = false, $stringOnly = false, $upperKeys=false)
    {
        static $cache = array();
        $arr = array();

        foreach($this->field_defs as $field=>$data)
        {
            if( !$dbOnly || !isset($data['source']) || $data['source'] == 'db')
            if(!$stringOnly || is_string($this->$field))
            if($upperKeys)
            {
                                if(!isset($cache[$field])){
                                    $cache[$field] = strtoupper($field);
                                }
                $arr[$cache[$field]] = $this->$field;
            }
            else
            {
                if(isset($this->$field)){
                    $arr[$field] = $this->$field;
                }else{
                    $arr[$field] = '';
                }
            }
        }
        return $arr;
    }

    /**
    * Converts an array into an acl mapping name value pairs into files
    *
    * @param Array $arr
    */
    function fromArray($arr)
    {
        foreach($arr as $name=>$value)
        {
            $this->$name = $value;
        }
    }

    /**
     * Convert row data from DB format to internal format
     * Mostly useful for dates/times
     * @param array $row
     * @return array $row
     */
    public function convertRow($row)
    {
        foreach($this->field_defs as $name => $fieldDef)
		{
		    // skip empty fields and non-db fields
            if (isset($name) && !empty($row[$name])) {
                $row[$name] = $this->convertField($row[$name], $fieldDef);
            }
        }
		return $row;
    }

    /**
     * Converts the field value based on the provided fieldDef
     * @param $fieldvalue
     * @param $fieldDef
     * @return string
     */
    public function convertField($fieldvalue, $fieldDef)
    {
        if (!empty($fieldvalue)) {
            if (!(isset($fieldDef['source']) &&
                !in_array($fieldDef['source'], array('db', 'custom_fields', 'relate'))
                && !isset($fieldDef['dbType']))
            ) {
                // fromConvert other fields
                $fieldvalue = $this->db->fromConvert($fieldvalue, $this->db->getFieldType($fieldDef));
            }
        }
        return $fieldvalue;
    }

    /**
     * Loads a row of data into instance of a bean. The data is passed as an array to this function
     *
     * @param array $arr row of data fetched from the database.
     * @return  nothing
     *
     * Internal function do not override.
     */
    function loadFromRow($arr, $convert = false)
    {
        $this->fetched_row = $this->populateFromRow($arr, $convert);
        $this->processed_dates_times = array();
        $this->check_date_relationships_load();

        $this->fill_in_additional_list_fields();

        if($this->hasCustomFields())$this->custom_fields->fill_relationships();
        $this->call_custom_logic("process_record");
    }

    function hasCustomFields()
    {
        return !empty($GLOBALS['dictionary'][$this->object_name]['custom_fields']);
    }

   /**
    * Ensure that fields within order by clauses are properly qualified with
    * their tablename.  This qualification is a requirement for sql server support.
    *
    * @param string $order_by original order by from the query
    * @param string $qualify prefix for columns in the order by list.
    * @return  prefixed
    *
    * Internal function do not override.
    */
   function create_qualified_order_by( $order_by, $qualify)
   {	// if the column is empty, but the sort order is defined, the value will throw an error, so do not proceed if no order by is given
    if (empty($order_by))
    {
        return $order_by;
    }
    $order_by_clause = " ORDER BY ";
    $tmp = explode(",", $order_by);
    $comma = ' ';
    foreach ( $tmp as $stmp)
    {
        $stmp = (substr_count($stmp, ".") > 0?trim($stmp):"$qualify." . trim($stmp));
        $order_by_clause .= $comma . $stmp;
        $comma = ", ";
    }
    return $order_by_clause;
   }

   /**
    * Combined the contents of street field 2 thru 4 into the main field
    *
    * @param string $street_field
    */

   function add_address_streets(
       $street_field
       )
    {
        $street_field_2 = $street_field.'_2';
        $street_field_3 = $street_field.'_3';
        $street_field_4 = $street_field.'_4';
        if ( isset($this->$street_field_2)) {
            $this->$street_field .= "\n". $this->$street_field_2;
            unset($this->$street_field_2);
        }
        if ( isset($this->$street_field_3)) {
            $this->$street_field .= "\n". $this->$street_field_3;
            unset($this->$street_field_3);
        }
        if ( isset($this->$street_field_4)) {
            $this->$street_field .= "\n". $this->$street_field_4;
            unset($this->$street_field_4);
        }
        if ( isset($this->$street_field)) {
            $this->$street_field = trim($this->$street_field, "\n");
        }
    }

    protected function getEncryptKey()
    {
        if(empty(self::$field_key[$this->module_key])) {
            self::$field_key[$this->module_key] = blowfishGetKey($this->module_key);
        }
        return self::$field_key[$this->module_key];
    }

/**
 * Encrpyt and base64 encode an 'encrypt' field type in the bean using Blowfish. The default system key is stored in cache/Blowfish/{keytype}
 * @param STRING value -plain text value of the bean field.
 * @return string
 */
    function encrpyt_before_save($value)
    {
        require_once("include/utils/encryption_utils.php");
        return blowfishEncode($this->getEncryptKey(), $value);
    }

/**
 * Decode and decrypt a base 64 encoded string with field type 'encrypt' in this bean using Blowfish.
 * @param STRING value - an encrypted and base 64 encoded string.
 * @return string
 */
    public function decrypt_after_retrieve($value)
    {
        if(empty($value)) return $value; // no need to decrypt empty
        require_once("include/utils/encryption_utils.php");
        return blowfishDecode($this->getEncryptKey(), $value);
    }

    /**
    * Moved from save() method, functionality is the same, but this is intended to handle
    * Optimistic locking functionality.
    */
    private function _checkOptimisticLocking($action, $isUpdate){
        if($this->optimistic_lock && !isset($_SESSION['o_lock_fs'])){
            if(isset($_SESSION['o_lock_id']) && $_SESSION['o_lock_id'] == $this->id && $_SESSION['o_lock_on'] == $this->object_name)
            {
                if($action == 'Save' && $isUpdate && isset($this->modified_user_id) && $this->has_been_modified_since($_SESSION['o_lock_dm'], $this->modified_user_id))
                {
                    $_SESSION['o_lock_class'] = get_class($this);
                    $_SESSION['o_lock_module'] = $this->module_dir;
                    $_SESSION['o_lock_object'] = $this->toArray();
                    $saveform = "<form name='save' id='save' method='POST'>";
                    foreach($_POST as $key=>$arg)
                    {
                        $saveform .= "<input type='hidden' name='". addslashes($key) ."' value='". addslashes($arg) ."'>";
                    }
                    $saveform .= "</form><script>document.getElementById('save').submit();</script>";
                    $_SESSION['o_lock_save'] = $saveform;
                    header('Location: index.php?module=OptimisticLock&action=LockResolve');
                    die();
                }
                else
                {
                    unset ($_SESSION['o_lock_object']);
                    unset ($_SESSION['o_lock_id']);
                    unset ($_SESSION['o_lock_dm']);
                }
            }
        }
        else
        {
            if(isset($_SESSION['o_lock_object']))	{ unset ($_SESSION['o_lock_object']); }
            if(isset($_SESSION['o_lock_id']))		{ unset ($_SESSION['o_lock_id']); }
            if(isset($_SESSION['o_lock_dm']))		{ unset ($_SESSION['o_lock_dm']); }
            if(isset($_SESSION['o_lock_fs']))		{ unset ($_SESSION['o_lock_fs']); }
            if(isset($_SESSION['o_lock_save']))		{ unset ($_SESSION['o_lock_save']); }
        }
    }

    /**
    * Send assignment notifications and invites for meetings and calls
    */
    private function _sendNotifications($check_notify){
        if($check_notify || (isset($this->notify_inworkflow) && $this->notify_inworkflow == true) // cn: bug 5795 - no invites sent to Contacts, and also bug 25995, in workflow, it will set the notify_on_save=true.
           && !$this->isOwner($this->created_by) )  // cn: bug 42727 no need to send email to owner (within workflow)
        {
            $admin = Administration::getSettings();
            $sendNotifications = false;

            if ($admin->settings['notify_on']) {
                $GLOBALS['log']->info("Notifications: user assignment has changed, checking if user receives notifications");
                $sendNotifications = true;
            } elseif(isset($this->send_invites) && $this->send_invites == true) {
                // cn: bug 5795 Send Invites failing for Contacts
                $sendNotifications = true;
            } else {
                $GLOBALS['log']->info("Notifications: not sending e-mail, notify_on is set to OFF");
            }


            if($sendNotifications == true)
            {
                $notify_list = $this->get_notification_recipients();
                foreach ($notify_list as $notify_user)
                {
                    $this->send_assignment_notifications($notify_user, $admin);
                }
            }
        }
    }

    /**
    * Set the given module's default team in SuagrCRM Professional
    */
    function setDefaultTeam(){
        global $current_user;
        if(!empty($current_user)) {
            $this->team_id = $current_user->default_team;	//default_team is a team id
            $this->team_set_id = $current_user->team_set_id; //default team_set_id is the set of default teams
        } else {
            $this->team_id = 1; // make the item globally accessible
        }

    }

    /**
     * Called from ImportFieldSanitize::relate(), when creating a new bean in a related module. Will
     * copies fields over from the current bean into the related. Designed to be overriden in child classes.
     *
     * @param SugarBean $newbean newly created related bean
     */
    public function populateRelatedBean(
        SugarBean $newbean
        )
    {
    }

    /**
     * Called during the import process before a bean save, to handle any needed pre-save logic when
     * importing a record
     */
    public function beforeImportSave()
    {
    }

    /**
     * Called during the import process after a bean save, to handle any needed post-save logic when
     * importing a record
     */
    public function afterImportSave()
    {
    }

    /**
     * This function is designed to cache references to field arrays that were previously stored in the
     * bean files and have since been moved to separate files. Was previously in include/CacheHandler.php
     *
     * @deprecated
     * @param $module_dir string the module directory
     * @param $module string the name of the module
     * @param $key string the type of field array we are referencing, i.e. list_fields, column_fields, required_fields
     **/
    private function _loadCachedArray(
        $module_dir,
        $module,
        $key
        )
    {
        static $moduleDefs = array();

        $fileName = 'field_arrays.php';

        $cache_key = "load_cached_array.$module_dir.$module.$key";
        $result = sugar_cache_retrieve($cache_key);
        if(!empty($result))
        {
        	// Use SugarCache::EXTERNAL_CACHE_NULL_VALUE to store null values in the cache.
        	if($result == SugarCache::EXTERNAL_CACHE_NULL_VALUE)
        	{
        		return null;
        	}

            return $result;
        }

        if(SugarAutoLoader::fileExists('modules/'.$module_dir.'/'.$fileName))
        {
            // If the data was not loaded, try loading again....
            if(!isset($moduleDefs[$module]))
            {
                include('modules/'.$module_dir.'/'.$fileName);
                $moduleDefs[$module] = $fields_array;
            }
            // Now that we have tried loading, make sure it was loaded
            if(empty($moduleDefs[$module]) || empty($moduleDefs[$module][$module][$key]))
            {
                // It was not loaded....  Fail.  Cache null to prevent future repeats of this calculation
				sugar_cache_put($cache_key, SugarCache::EXTERNAL_CACHE_NULL_VALUE);
                return  null;
            }

            // It has been loaded, cache the result.
            sugar_cache_put($cache_key, $moduleDefs[$module][$module][$key]);
            return $moduleDefs[$module][$module][$key];
        }

        // It was not loaded....  Fail.  Cache null to prevent future repeats of this calculation
        sugar_cache_put($cache_key, SugarCache::EXTERNAL_CACHE_NULL_VALUE);
		return null;
	}

    /**
     * Returns the ACL category for this module; defaults to the SugarBean::$acl_category if defined
     * otherwise it is SugarBean::$module_dir
     *
     * @return string
     */
    public function getACLCategory()
    {
        return !empty($this->acl_category)?$this->acl_category:$this->module_dir;
    }

    /**
     * Returns the query used for the export functionality for a module. Override this method if you wish
     * to have a custom query to pull this data together instead
     *
     * @param string $order_by
     * @param string $where
     * @return string SQL query
     */
	public function create_export_query($order_by, $where)
	{
		return $this->create_new_list_query($order_by, $where, array(), array(), 0, '', false, $this, true, true);
	}

	/**
	 * Returns a clean instance of the same type as this SugarBean.
	 * Note that this does not mean it duplicates this bean.  This creates a new untouched instance instead.
	 * @return SugarBean a new instance of this bean
	 */
	public function getCleanCopy()
	{
        $bean =  BeanFactory::getBean($this->module_name);
        /**
         * If not a common bean, we can create a new instance the old fashioned way.
         */
        if($bean == null){
            $klass = get_class($this);
            $bean = new $klass();
        }
        return $bean;
	}

    /**
     * Find possible duplicate records for this bean
     * @return array
     */
    public function findDuplicates()
    {
        $dupeCheckManager = $this->loadDuplicateCheckManager();
        return $dupeCheckManager->findDuplicates();
    }

    /**
     * Create a duplicate check manager to handle loading the appropriate duplicate check strategy
     *
     * @return BeanDuplicateCheck
     */
    protected function loadDuplicateCheckManager()
    {
        if(empty($this->duplicate_check_manager)) {
            $data = isset($GLOBALS['dictionary'][$this->object_name]['duplicate_check'])?$GLOBALS['dictionary'][$this->object_name]['duplicate_check']:array();
            $this->duplicate_check_manager = new BeanDuplicateCheck($this, $data);
        }
        return $this->duplicate_check_manager;
    }

    /**
     * Fallback file name getter, simply gets the filename for the given bean
     *
     * @return string
     */
    public function getFileName() {
        return empty($this->filename) ? '' : $this->filename;
    }

    /**
     * Determine whether the given field is a relate field
     *
     * @param string $field Field name
     * @return bool
     */
    protected function is_relate_field($field)
    {
        if (!isset($this->field_defs[$field]))
        {
            return false;
        }

        $field_def = $this->field_defs[$field];

        return isset($field_def['type'])
            && $field_def['type'] == 'relate'
            && isset($field_def['link']);
    }
    /**
     * Returns array of linked bean's calculated fields which use relation to
     * the current bean in their formulas
     *
     * @param string $linkName Name of current bean's link
     * @return array
     */
    protected function get_fields_influencing_linked_bean_calc_fields($linkName)
    {
        global $dictionary;

        $result = array();

        if (!$this->load_relationship($linkName)) {
            return $result;
        }

        /** @var Link2 $link */
        $link = $this->$linkName;
        $relatedModuleName = $link->getRelatedModuleName();
        $relatedBeanName   = BeanFactory::getObjectName($relatedModuleName);
        $relatedLinkName   = $link->getRelatedModuleLinkName();

        if (empty($relatedBeanName) || empty($dictionary[$relatedBeanName])) {
            $GLOBALS['log']->fatal("Cannot load field defs for $relatedBeanName");
            return $result;
        }
        // iterate over related bean fields
        foreach ($dictionary[$relatedBeanName]['fields'] as $def) {
            if (!empty($def['formula'])) {
                $expr = Parser::evaluate($def['formula'], $this);
                $fields = $this->get_formula_related_fields($expr, $relatedLinkName);
                $result = array_merge($result, $fields);
            }
        }

        return array_unique($result);
    }

    /**
     * Retrieve names of fields of the bean related by the given link included
     * in expression
     *
     * @param AbstractExpression $expr Parsed formula expression or nested expression
     * @param string $linkName Name of the link to filter "related" expressions by
     * @return array
     */
    protected function get_formula_related_fields(AbstractExpression $expr, $linkName)
    {
        $result = array();

        if ($expr instanceof RelatedFieldExpression
            || $expr instanceof MinRelatedExpression
            || $expr instanceof MaxRelatedExpression
            || $expr instanceof AverageRelatedExpression
            || $expr instanceof SumRelatedExpression
            || $expr instanceof CurrencySumRelatedExpression
        ) {
            /** @var AbstractExpression[] $params */
            $params = $expr->getParameters();

            // here we don't evaluate the first param since we need the field name
            // but not it's value
            if ($params[0] instanceof SugarFieldExpression
                && $params[0]->varName == $linkName
            ) {
                $result[] = $params[1]->evaluate();
            }
            return $result;
        }

        $params = $expr->getParameters();
        if (is_array($params)) {
            /** @var AbstractExpression $param */
            foreach ($params as $param) {
                $result = array_merge(
                    $result,
                    $this->get_formula_related_fields($param, $linkName)
                );
            }
        } else if ($params instanceof AbstractExpression) {
             $result = array_merge(
                 $result,
                 $this->get_formula_related_fields($params, $linkName)
             );
        }

        return array_unique($result);
    }

    /**
     * Proxy method for DynamicField::getJOIN
     * @param bool $expandedList
     * @param bool $includeRelates
     * @param string|bool $where
     * @return array
     */
    public function getCustomJoin($expandedList = false, $includeRelates = false, &$where = false)
    {
        $result = array(
            'select' => '',
            'join' => ''
        );
        if(isset($this->custom_fields))
        {
            $result = $this->custom_fields->getJOIN($expandedList, $includeRelates, $where);
        }
        return $result;
    }

    /**
     * Get bean for certain link
     * @api
     * @param string $link
     */
    public function getRelatedBean($link)
    {
       if(!isset($this->related_beans[$link])) {
           $this->load_relationship($link);
           if(empty($this->$link)) {
               $this->related_beans[$link] = false;
           } else {
               $this->related_beans[$link] = BeanFactory::getBean($this->$link->getRelatedModuleName());
           }
       }
       return $this->related_beans[$link];
    }

    /**
     * Determines a user's access to the current bean, taking both team security
     * and ACLs into consideration.
     * @param  User $user
     * @param  string $bf Do not use. Used for testing only.
     * @return bool       True if $user has access, false otherwise.
     */
    public function checkUserAccess(User $user = null, $bf = 'BeanFactory')
    {
        $userHasAccess = false;
        if (is_null($user)) {
            $user = $GLOBALS['current_user'];
        }

        $save_user = $GLOBALS['current_user'];
        $GLOBALS['current_user'] = $user;

        if (!empty($this->id) && empty($this->new_with_id)) {
            $newBean = $bf::retrieveBean($this->module_name, $this->id, array('use_cache' => false));
            if (!empty($newBean)) {
                $context = array('user' => $user);
                $userHasAccess = $this->ACLAccess('view', $context);
            }
        }

        $GLOBALS['current_user'] = $save_user;
        return $userHasAccess;
    }

	/**
	 * __isset handler to work with encrypted fields
	 * @param string $varname
	 * @return boolean
	 */
	public function __isset($varname)
	{
	    if(isset($this->encfields[$varname])) {
	        return true;
	    }
	    return false;
	}

	/**
	 * __get handler to work with encrypted fields
	 * @param string $varname
	 * @return mixed
	 */
	public function &__get($varname)
	{
	    if(isset($this->encfields[$varname])) {
	        $this->$varname = $this->decrypt_after_retrieve($this->encfields[$varname]);
	        return $this->$varname;
	    }
	    $var = null;
	    return $var;
	}

	/**
	 * Operations status
	 * Known operations:
	 * - saving_related - SugarBean is resaving related records
	 * - updating_relationships - SugarBean is updating relationships on Save
	 * - delete - Deleting a bean
	 * @var array
	 */
	protected static $opStatus = array();

	/**
	 * Enter operation
	 * @param string $opname Operation name
	 * @return boolean True if operation successfully started, false if we're already in this operation
	 */
	public static function enterOperation($opname)
	{
	    if (!empty(self::$opStatus[$opname])) {
	        return false;
	    }
	    $GLOBALS['log']->info("Entered operation status: $opname");
	    self::$opStatus[$opname] = true;
	    return true;
	}

	/**
	 * Leave operation
	 * @param string $opname Operation name
	 * @param bool $flag Success flag - if false, don't try do anything. This is for linking with enterOperation() via flag
	 * @return boolean True if left successfully, false if no changes were made
	 */
	public static function leaveOperation($opname, $flag = true)
	{
	    if (empty($flag) && empty(self::$opStatus[$opname])) {
	        return false;
	    }
	    $GLOBALS['log']->info("Left operation status: $opname");
	    unset(self::$opStatus[$opname]);
	    return true;
	}

	/**
	 * Are we inside certain operation?
	 * @param string $opname
	 * @return boolean
	 */
	public static function inOperation($opname)
	{
	    return !empty(self::$opStatus[$opname]);
	}

	/**
	 * Clear operation status
	 */
	public static function resetOperations()
	{
	    self::$opStatus = array();
	}
}
