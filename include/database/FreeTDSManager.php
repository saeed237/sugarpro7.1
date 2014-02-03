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


include_once('include/database/MssqlManager.php');

/**
 * SQL Server driver for FreeTDS
 */
class FreeTDSManager extends MssqlManager
{
    public $dbName = 'FreeTDS SQL Server';
    public $variant = 'freetds';
    public $label = 'LBL_MSSQL2';

    protected $capabilities = array(
        "affected_rows" => true,
        'fulltext' => true,
        'limit_subquery' => true,
    );

    protected $type_map = array(
            'int'      => 'int',
            'double'   => 'float',
            'float'    => 'float',
            'uint'     => 'int',
            'ulong'    => 'int',
            'long'     => 'bigint',
            'short'    => 'smallint',
            'varchar'  => 'nvarchar',
            'text'     => 'nvarchar(max)',
            'longtext' => 'nvarchar(max)',
            'date'     => 'datetime',
            'enum'     => 'nvarchar',
            'relate'   => 'nvarchar',
            'multienum'=> 'nvarchar(max)',
            'html'     => 'nvarchar(max)',
			'longhtml' => 'text',
    		'datetime' => 'datetime',
            'datetimecombo' => 'datetime',
            'time'     => 'datetime',
            'bool'     => 'bit',
            'tinyint'  => 'tinyint',
            'char'     => 'char',
            'blob'     => 'nvarchar(max)',
            'longblob' => 'nvarchar(max)',
            'currency' => 'decimal(26,6)',
            'decimal'  => 'decimal',
            'decimal2' => 'decimal',
            'id'       => 'varchar(36)',
            'url'      => 'nvarchar',
            'encrypt'  => 'nvarchar',
            'file'     => 'nvarchar',
	        'decimal_tpl' => 'decimal(%d, %d)',
    );

    public function query($sql, $dieOnError = false, $msg = '', $suppress = false, $keepResult = false)
    {
		global $app_strings;
        if(is_array($sql)) {
            return $this->queryArray($sql, $dieOnError, $msg, $suppress);
        }

		$sql = $this->_appendN($sql);
		return parent::query($sql, $dieOnError, $msg, $suppress, $keepResult);
    }

    /**
     * Check if this driver can be used
     * @return bool
     */
    public function valid()
    {
        return function_exists("mssql_connect") && DBManagerFactory::isFreeTDS();
    }
}
