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

 * Description:  Class to handle splitting a file into separate parts
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/

class ImportFileSplitter
{
    /**
     * Filename of file we are splitting
     */
    private $_sourceFile;

    /**
     * Count of files that we split the $_sourceFile into
     */
    private $_fileCount;

    /**
     * Count of records in $_sourceFile
     */
    private $_recordCount;

     /**
     * Maximum number of records per file
     */
    private $_recordThreshold;

    /**
     * Constructor
     *
     * @param string $source filename we are splitting
     */
    public function __construct(
        $source = null,
        $recordThreshold = 1000
        )
    {
            // sanitize crazy values to the default value
        if ( !is_int($recordThreshold) || $recordThreshold < 1 ){
        	//if this is not an int but is still a
        	//string representation of a number, then cast to an int
        	if(!is_int($recordThreshold) && is_numeric($recordThreshold)){
        		//cast the string to an int
        		$recordThreshold = (int)$recordThreshold;
        	}else{
        		//if not a numeric string, or less than 1, then default to 100
            	$recordThreshold = 100;
        	}
        }
        $this->_recordThreshold = $recordThreshold;
        $this->_sourceFile      = $source;
    }

    /**
     * Returns true if the filename given exists and is readable
     *
     * @return bool
     */
    public function fileExists()
    {
        if ( !is_file($this->_sourceFile) || !is_readable($this->_sourceFile)) {
           return false;
        }

        return true;
    }

    /**
     * Actually split the file into parts
     *
     * @param string $delimiter
     * @param string $enclosure
     * @param bool $has_header true if file has a header row
     */
    public function splitSourceFile(
        $delimiter = ',',
        $enclosure = '"',
        $has_header = false
        )
    {
        if (!$this->fileExists())
            return false;
        $importFile = new ImportFile($this->_sourceFile,$delimiter,$enclosure,false);
        $filecount = 0;
        $fw = sugar_fopen("{$this->_sourceFile}-{$filecount}","w");
        $count = 0;
        // skip first row if we have a header row
        if ( $has_header && $importFile->getNextRow() ) {
            // mark as duplicate to stick header row in the dupes file
            $importFile->markRowAsDuplicate();
            // same for error records file
            $importFile->writeErrorRecord();
        }
        while ( $row = $importFile->getNextRow() ) {
            // after $this->_recordThreshold rows, close this import file and goto the next one
            if ( $count >= $this->_recordThreshold ) {
                fclose($fw);
                $filecount++;
                $fw = sugar_fopen("{$this->_sourceFile}-{$filecount}","w");
                $count = 0;
            }
            // Bug 25119: Trim the enclosure string to remove any blank spaces that may have been added.
            $enclosure = trim($enclosure);
			if(!empty($enclosure)) {
				foreach($row as $key => $v){
					$row[$key] =preg_replace("/$enclosure/","$enclosure$enclosure", $v);
				}
			}
            $line = $enclosure.implode($enclosure.$delimiter.$enclosure, $row).$enclosure.PHP_EOL;
			//Would normally use fputcsv() here. But when enclosure character is used and the field value doesn't include delimiter, enclosure, escape character, "\n", "\r", "\t", or " ", php default function 'fputcsv' will not use enclosure for this string.
			 fputs($fw, $line);
            $count++;
        }

        fclose($fw);
        $this->_fileCount   = $filecount;
        $this->_recordCount = ($filecount * $this->_recordThreshold) + $count;
        // increment by one to get true count of files created
        ++$this->_fileCount;
    }

    /**
     * Return the count of records in the file, if it's been processed with splitSourceFile()
     *
     * @return int count of records in the file
     */
    public function getRecordCount()
    {
        if ( !isset($this->_recordCount) )
            return false;

        return $this->_recordCount;
    }

    /**
     * Return the count of files created by the split, if it's been processed with splitSourceFile()
     *
     * @return int count of files created by the split
     */
    public function getFileCount()
    {
        if ( !isset($this->_fileCount) )
            return false;

        return $this->_fileCount;
    }

    /**
     * Return file name of one of the split files
     *
     * @param int $filenumber which split file we want
     *
     * @return string filename
     */
    public function getSplitFileName(
        $filenumber = 0
        )
    {
        if ( $filenumber >= $this->getFileCount())
            return false;

        return "{$this->_sourceFile}-{$filenumber}";
    }

}

