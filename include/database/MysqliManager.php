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

* Description: This file handles the Data base functionality for the application.
* It acts as the DB abstraction layer for the application. It depends on helper classes
* which generate the necessary SQL. This sql is then passed to PEAR DB classes.
* The helper class is chosen in DBManagerFactory, which is driven by 'db_type' in 'dbconfig' under config.php.
*
* All the functions in this class will work with any bean which implements the meta interface.
* The passed bean is passed to helper class which uses these functions to generate correct sql.
*
* The meta interface has the following functions:
* getTableName()                Returns table name of the object.
* getFieldDefinitions()         Returns a collection of field definitions in order.
* getFieldDefintion(name)       Return field definition for the field.
* getFieldValue(name)           Returns the value of the field identified by name.
*                               If the field is not set, the function will return boolean FALSE.
* getPrimaryFieldDefinition()   Returns the field definition for primary key
*
* The field definition is an array with the following keys:
*
* name      This represents name of the field. This is a required field.
* type      This represents type of the field. This is a required field and valid values are:
*           �   int
*           �   long
*           �   varchar
*           �   text
*           �   date
*           �   datetime
*           �   double
*           �   float
*           �   uint
*           �   ulong
*           �   time
*           �   short
*           �   enum
* length    This is used only when the type is varchar and denotes the length of the string.
*           The max value is 255.
* enumvals  This is a list of valid values for an enum separated by "|".
*           It is used only if the type is �enum�;
* required  This field dictates whether it is a required value.
*           The default value is �FALSE�.
* isPrimary This field identifies the primary key of the table.
*           If none of the fields have this flag set to �TRUE�,
*           the first field definition is assume to be the primary key.
*           Default value for this field is �FALSE�.
* default   This field sets the default value for the field definition.
*
*
* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
* All Rights Reserved.
* Contributor(s): ______________________________________..
********************************************************************************/

require_once('include/database/MysqlManager.php');

/**
 * MySQL manager implementation for mysqli extension
 */
class MysqliManager extends MysqlManager
{
	/**
	 * @see DBManager::$dbType
	 */
	public $dbType = 'mysql';
	public $variant = 'mysqli';
	public $priority = 10;
	public $label = 'LBL_MYSQLI';


    /**
     * Create DB Driver
     */
	public function __construct()
	{
        parent::__construct();
        $this->capabilities["recursive_query"] = true;
	}

	/**
	 * @see DBManager::$backendFunctions
	 */
	protected $backendFunctions = array(
		'free_result'        => 'mysqli_free_result',
		'close'              => 'mysqli_close',
		'row_count'          => 'mysqli_num_rows',
		'affected_row_count' => 'mysqli_affected_rows',
		);

    public function query($sql, $dieOnError = false, $msg = '', $suppress = false, $keepResult = false)
    {
        $result = $this->queryMulti($sql, $dieOnError, $msg, $suppress, $keepResult, false);

        return $result;
    }



    /**
     * @see MysqlManager::query()
     */
    protected function queryMulti($sql, $dieOnError = false, $msg = '', $suppress = false, $keepResult = false, $multiquery = true)
    {
        if(is_array($sql)) {
            return $this->queryArray($sql, $dieOnError, $msg, $suppress);    //queryArray does not support any return sets
        }
        static $queryMD5 = array();
        $this->addDistinctClause($sql);

        parent::countQuery($sql);
        $GLOBALS['log']->info('Query:' . $sql);
        $this->checkConnection();
        $this->query_time = microtime(true);
        $this->lastsql = $sql;

        if ($multiquery) {
            $query_result = $suppress?@mysqli_multi_query($this->database,$sql):mysqli_multi_query($this->database,$sql);
            $result = mysqli_use_result($this->database);

            // Clear any remaining recordsets
            while (mysqli_next_result($this->database))  {
                $tmp_result = mysqli_use_result($this->database);
                mysqli_free_result($tmp_result);
            }
        }

        else
            $result = $suppress?@mysqli_query($this->database,$sql):mysqli_query($this->database,$sql);
        $md5 = md5($sql);

        if (empty($queryMD5[$md5]))
            $queryMD5[$md5] = true;

        $this->query_time = microtime(true) - $this->query_time;
        $GLOBALS['log']->info('Query Execution Time:'.$this->query_time);


        // This is some heavy duty debugging, leave commented out unless you need this:
        /*
          $bt = debug_backtrace();
          $line['file'] = 'NO_FILE';
          $line['line'] = 'NO_LINE';
          $line['function'] = 'NO_FUNCTION';
          $i = 0;
          foreach ( $bt as $i => $tryLine ) {
              if ( strpos($tryLine['file'],'include/database') === false && strpos($tryLine['file'],'include/SugarQuery') === false ) {
                  $line = $tryLine;
                  // Go function line up to find the real function
                  if ( isset($bt[($i+1)]['function']) ) {
                      $line['function'] = $bt[($i+1)]['function'];
                  }
                  break;
              }
          }
        $dumpQuery = str_replace(array('      ','     ','    ','   ','  ',"\n","\t","\r"),
                                 array(' ',     ' ',    ' ',   ' ',  ' ', ' ', ' ', ' ',),
                                 $sql);
          
        $GLOBALS['log']->fatal("{$line['file']}:{$line['line']} ${line['function']} \nQuery: $dumpQuery\n");
        */

		if($keepResult) {
			$this->lastResult = $result;
        }

        if ($this->database && mysqli_errno($this->database) == 2006 && $this->retryCount < 1) {
            $GLOBALS['log']->fatal('mysqli has gone away, retrying');
            $this->retryCount++;
            $this->disconnect();
            $this->connect();
            return $this->query($sql, $dieOnError, $msg, $suppress, $keepResult);
        } else {
            $this->retryCount = 0;
        }

        $this->checkError($msg.' Query Failed: ' . $sql, $dieOnError);

        return $result;
    }

    /**
	 * Returns the number of rows affected by the last query
	 *
	 * @return int
	 */
	public function getAffectedRowCount($result)
	{
		return mysqli_affected_rows($this->getDatabase());
	}

	/**
	 * Returns the number of rows returned by the result
	 *
	 * This function can't be reliably implemented on most DB, do not use it.
	 * @abstract
	 * @deprecated
	 * @param  resource $result
	 * @return int
	 */
	public function getRowCount($result)
	{
	    return mysqli_num_rows($result);
	}


    /**
	 * Disconnects from the database
	 *
	 * Also handles any cleanup needed
	 */
	public function disconnect()
	{
		$GLOBALS['log']->debug('Calling MySQLi::disconnect()');
		if(!empty($this->database)){
			$this->freeResult();
			mysqli_close($this->database);
			$this->database = null;
		}
	}

	/**
	 * @see DBManager::freeDbResult()
	 */
	protected function freeDbResult($dbResult)
	{
		if(!empty($dbResult))
			mysqli_free_result($dbResult);
	}

	/**
	 * @see DBManager::getFieldsArray()
	 */
	public function getFieldsArray($result, $make_lower_case = false)
	{
		$field_array = array();

		if (!isset($result) || empty($result))
			return 0;

		$i = 0;
		while ($i < mysqli_num_fields($result)) {
			$meta = mysqli_fetch_field_direct($result, $i);
			if (!$meta)
				return 0;

			if($make_lower_case == true)
				$meta->name = strtolower($meta->name);

			$field_array[] = $meta->name;

			$i++;
		}

		return $field_array;
	}

	/**
	 * @see DBManager::fetchRow()
	 */
	public function fetchRow($result)
	{
		if (empty($result))	return false;

		$row = mysqli_fetch_assoc($result);
		if($row == null) $row = false; //Make sure MySQLi driver results are consistent with other database drivers
		return $row;
	}

	/**
	 * @see DBManager::quote()
	 */
	public function quote($string)
	{
		return mysqli_real_escape_string($this->getDatabase(),$this->quoteInternal($string));
	}

	/**
	 * @see DBManager::connect()
	 */
	public function connect(array $configOptions = null, $dieOnError = false)
	{
		global $sugar_config;

		if (is_null($configOptions))
			$configOptions = $sugar_config['dbconfig'];

		if(!isset($this->database)) {

			//mysqli connector has a separate parameter for port.. We need to separate it out from the host name
			$dbhost=$configOptions['db_host_name'];
			$dbport=null;
			$pos=strpos($configOptions['db_host_name'],':');
			if ($pos !== false) {
				$dbhost=substr($configOptions['db_host_name'],0,$pos);
				$dbport=substr($configOptions['db_host_name'],$pos+1);
			}

			$this->database = mysqli_connect($dbhost,$configOptions['db_user_name'],$configOptions['db_password'],isset($configOptions['db_name'])?$configOptions['db_name']:'',$dbport);
			if(empty($this->database)) {
				$GLOBALS['log']->fatal("Could not connect to DB server ".$dbhost." as ".$configOptions['db_user_name'].". port " .$dbport . ": " . mysqli_connect_error());
				if($dieOnError) {
					if(isset($GLOBALS['app_strings']['ERR_NO_DB'])) {
						sugar_die($GLOBALS['app_strings']['ERR_NO_DB']);
					} else {
						sugar_die("Could not connect to the database. Please refer to sugarcrm.log for details.");
					}
				} else {
					return false;
				}
			}
		}

		if(!empty($configOptions['db_name']) && !@mysqli_select_db($this->database,$configOptions['db_name'])) {
			$GLOBALS['log']->fatal( "Unable to select database {$configOptions['db_name']}: " . mysqli_connect_error());
			if($dieOnError) {
					if(isset($GLOBALS['app_strings']['ERR_NO_DB'])) {
						sugar_die($GLOBALS['app_strings']['ERR_NO_DB']);
					} else {
						sugar_die("Could not connect to the database. Please refer to sugarcrm.log for details.");
					}
			} else {
				return false;
			}
	    }

		// cn: using direct calls to prevent this from spamming the Logs
	    mysqli_query($this->database,"SET CHARACTER SET utf8");
	    $names = "SET NAMES 'utf8'";
	    $collation = $this->getOption('collation');
	    if(!empty($collation)) {
	        $names .= " COLLATE '$collation'";
		}
	    mysqli_query($this->database,$names);

		if($this->checkError('Could Not Connect', $dieOnError))
			$GLOBALS['log']->info("connected to db");

		$this->connectOptions = $configOptions;
		return true;
	}

	/**
	 * (non-PHPdoc)
	 * @see MysqlManager::lastDbError()
	 */
	public function lastDbError()
	{
		if($this->database) {
		    if(mysqli_errno($this->database)) {
			    return "MySQL error ".mysqli_errno($this->database).": ".mysqli_error($this->database);
		    }
		} else {
			$err =  mysqli_connect_error();
			if($err) {
			    return $err;
			}
		}

		return false;
	}

	public function getDbInfo()
	{
		$charsets = $this->getCharsetInfo();
		$charset_str = array();
		foreach($charsets as $name => $value) {
			$charset_str[] = "$name = $value";
		}
		return array(
			"MySQLi Version" => @mysqli_get_client_info(),
			"MySQLi Host Info" => @mysqli_get_host_info($this->database),
			"MySQLi Server Info" => @mysqli_get_server_info($this->database),
			"MySQLi Client Encoding" =>  @mysqli_client_encoding($this->database),
			"MySQL Character Set Settings" => join(", ", $charset_str),
		);
	}

	/**
	 * Select database
	 * @param string $dbname
	 */
	protected function selectDb($dbname)
	{
		return mysqli_select_db($this->getDatabase(), $dbname);
	}

	/**
	 * Check if this driver can be used
	 * @return bool
	 */
	public function valid()
	{
		return function_exists("mysqli_connect") && empty($GLOBALS['sugar_config']['mysqli_disabled']);
	}


    /**
     * Create or updates the stored procedures for the recursive query capabilities
     * @return resource
     */
    public function createRecursiveQuerySPs()
    {

        $dropRecursiveQuerySPs_statement = "DROP PROCEDURE IF EXISTS _hierarchy";
        $this->query($dropRecursiveQuerySPs_statement);

        $createRecursiveQuerySPs_statement = "
            CREATE PROCEDURE _hierarchy( p_tablename              VARCHAR(100)
                                       , p_key_column             VARCHAR(100)
                                       , p_parent_key_column      VARCHAR(100)
                                       , p_mode                   VARCHAR(100)
                                       , p_startWith              VARCHAR(250)
                                       , p_level                  VARCHAR(100)    -- not used
                                       , p_fields                 VARCHAR(250)
                                       , p_where_clause           VARCHAR(250)
                                       )
            root:BEGIN

               DECLARE _level             INT;
               DECLARE _last_row_count    INT;

               CREATE TEMPORARY TABLE IF NOT EXISTS _hierarchy_return_set (
                      _id          VARCHAR(100)
                    , _parent_id   VARCHAR(100)
                    , _level       INT
                    , INDEX(_id, _level)
                    , INDEX(_parent_id, _level)
               );

               CREATE TEMPORARY TABLE  IF NOT EXISTS _hierarchy_current_set (
                      _id          VARCHAR(100)
                    , _parent_id   VARCHAR(100)
                    , _level       INT
               );

               SET _level := 1;
               TRUNCATE TABLE _hierarchy_return_set;
               TRUNCATE TABLE _hierarchy_current_set;

               -- cleanup WHERE clause
               IF LENGTH(TRIM(p_where_clause)) = 0 THEN
                  SET p_where_clause := NULL;
               END IF;
               IF p_where_clause IS NOT NULL THEN
                  SET p_where_clause := LTRIM(p_where_clause);
                  IF UPPER(SUBSTR(p_where_clause, 1, 5)) = 'WHERE' THEN  -- remove WHERE
                     SET p_where_clause := LTRIM(SUBSTR(p_where_clause, 6));
                  END IF;
                  IF UPPER(SUBSTR(p_where_clause, 1, 4)) <> 'AND ' THEN -- Add AND
                     SET p_where_clause := CONCAT('AND ', p_where_clause);
                  END IF;
               END IF;

               -- Get StartWith records
               SET @_sql = CONCAT( 'INSERT INTO  _hierarchy_current_set( _id, _parent_id, _level ) '
                                 ,'     SELECT  ', p_key_column, ', ', p_parent_key_column, ', ', _level
                                 ,'       FROM  ', p_tablename
                                 ,'      WHERE  ', p_startWith, ' '
                                 , IFNULL( p_where_clause, '' )
                                );
               PREPARE stmt FROM @_sql;
               EXECUTE stmt;
               SET _last_row_count = ROW_COUNT();


               -- Create the statement to get the next set of data
               IF p_mode = 'D' THEN -- Down the tree

                  SET @_sql = CONCAT( 'INSERT INTO  _hierarchy_current_set'
                                     ,'            ( _id, _parent_id, _level )'
                                     ,'    SELECT  ', p_key_column, ', ', p_parent_key_column, ', ', ' @_curr_level'
                                     ,'      FROM  ', p_tableName, ' t, _hierarchy_return_set hrs '
                                     ,'     WHERE  t.', p_parent_key_column, ' = hrs._id '                -- The Parent - Child equijoin
                                     ,'       AND  hrs._level = @_last_level  '
                                     , IFNULL( p_where_clause, '' )
                                     ,';'
                                    );
                  -- SELECT 'Down Tree Insert: ', @_sql;

               ELSEIF p_mode = 'U' THEN
                  SET @_sql = CONCAT( 'INSERT INTO  _hierarchy_current_set'
                                     ,'            ( _id, _parent_id, _level )'
                                     ,'    SELECT  ', p_key_column, ', ', p_parent_key_column, ', ', ' @_curr_level'
                                     ,'      FROM  ', p_tableName, ' t, _hierarchy_return_set hrs '
                                     ,'     WHERE  t.', p_key_column, ' = hrs._parent_id '                -- The Parent - Child equijoin
                                     ,'       AND  hrs._level = @_last_level   '
                                     , IFNULL( p_where_clause, '' )
                                     ,';'
                                    );

                  -- SELECT 'Up Tree Insert: ', @_sql;

               ELSE  -- Unknown mode, abort
                  LEAVE root;
               END IF;

               PREPARE next_recs_stmt FROM @_sql;

               -- loop recursively finding parents/children
               WHILE  ( _last_row_count > 0)
               DO
                  SET _level = _level+1;

                  INSERT INTO _hierarchy_return_set
                       SELECT *
                         FROM _hierarchy_current_set;

                  TRUNCATE TABLE _hierarchy_current_set;

                  SET @_last_level := _level-1;
                  SET @_curr_level := _level;

                  EXECUTE next_recs_stmt;
                  SET _last_row_count := ROW_COUNT();

               END WHILE;

               INSERT INTO _hierarchy_return_set
                    SELECT *
                      FROM _hierarchy_current_set;

            END;
        ";
        $this->query($createRecursiveQuerySPs_statement);
        return true;
    }


    public function preInstall()
    {
        $this->createRecursiveQuerySPs();
    }

    /**
     * Generates the a recursive SQL query or equivalent stored procedure implementation.
     * The DBManager's default implementation is based on SQL-99's recursive common table expressions.
     * Databases supporting recursive CTEs only need to set the recursive_query capability to true
     * @param string    $tablename       table name
     * @param string    $key             primary key field name
     * @param string    $parent_key      foreign key field name self referencing the table
     * @param string    $fields          list of fields that should be returned
     * @param bool      $lineage         find the lineage, if false, find the children
     * @param string    $startWith       identifies starting element(s) as in a where clause
     * @param string    $level           when not null returns a field named as level which indicates the level/dept from the starting point
     * @return string               Recursive SQL query or equivalent representation.
     */
    public function getRecursiveSelectSQL($tablename, $key, $parent_key, $fields, $lineage = false, $startWith = null, $level = null, $whereClause = null)
    {
        $mode = ($lineage) ? 'U' : 'D';
        // First execute the stored procedure to load the _hierarchy_return_set with the hierarchy data

        $startWith = is_null($startWith) ? '' : $this->quote($startWith);
        $level = is_null($level) ? '' : $level;
        $whereClause = is_null($whereClause) ? '' : $this->quote($whereClause);
        $sql_sp = "CALL _hierarchy('$tablename', '$key', '$parent_key', '$mode', '{$startWith}', '$level', '$fields', '{$whereClause}')";
        $result = $this->queryMulti($sql_sp, false, false, false, true);

        // Now build the sql to return that allows the caller to execute sql in a way to simulate the CTE of the other dbs,
        // i.e. return sql that is a combination of the callers sql and a join against the temp hierarchy table
        $sql = "SELECT $fields FROM _hierarchy_return_set hrs INNER JOIN $tablename t ON hrs._id = t." ."$key";
        $sql = "$sql ORDER BY hrs._id DESC";  // try and mimic other DB return orders for consistancy. breaks unit test otherwise
        return $sql;
    }

}
