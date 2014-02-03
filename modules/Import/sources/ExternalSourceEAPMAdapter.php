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


require_once('modules/Import/sources/ImportDataSource.php');


class ExternalSourceEAPMAdapter extends ImportDataSource
{

    /**
     * @var string The name of the EAPM object.
     */
    private $_eapmName = 'Google';

    /**
     * @var int Total record count of rows that will be imported
     */
    private $_totalRecordCount = -1;

    /**
     * @var The record set loaded from the external source
     */
    private $_recordSet = array();

    protected $_localeSettings = array('importlocale_charset' => 'UTF-8',
                                       'importlocale_dateformat' => 'Y-m-d',
                                       'importlocale_timeformat' => 'H:i',
                                       'importlocale_timezone' => '',
                                       'importlocale_currency' => '',
                                       'importlocale_default_currency_significant_digits' => '',
                                       'importlocale_num_grp_sep' => '',
                                       'importlocale_dec_sep' => '',
                                       'importlocale_default_locale_name_format' => '');


    public function __construct($eapmName)
    {
        global $current_user, $locale;
        $this->_eapmName = $eapmName;
      
        $this->_localeSettings['importlocale_num_grp_sep'] = $current_user->getPreference('num_grp_sep');
        $this->_localeSettings['importlocale_dec_sep'] = $current_user->getPreference('dec_sep');
        $this->_localeSettings['importlocale_default_currency_significant_digits'] = $locale->getPrecedentPreference('default_currency_significant_digits', $current_user);
        $this->_localeSettings['importlocale_default_locale_name_format'] = $locale->getLocaleFormatMacro($current_user);
        $this->_localeSettings['importlocale_currency'] = $locale->getPrecedentPreference('currency', $current_user);
        $this->_localeSettings['importlocale_timezone'] = $current_user->getPreference('timezone');

        $this->setSourceName();
    }
    /**
     * Return a feed of google contacts using the EAPM and Connectors farmework.
     *
     * @throws Exception
     * @param  $maxResults
     * @return array
     */
    public function loadDataSet($maxResults = 0)
    {
         if ( !$eapmBean = EAPM::getLoginInfo($this->_eapmName,true) )
         {
            throw new Exception("Authentication error with {$this->_eapmName}");
         }

        $api = ExternalAPIFactory::loadAPI($this->_eapmName);
        $api->loadEAPM($eapmBean);
        $conn = $api->getConnector();

        $feed = $conn->getList(array('maxResults' => $maxResults, 'startIndex' => $this->_offset));
        if($feed !== FALSE)
        {
            $this->_totalRecordCount = $feed['totalResults'];
            $this->_recordSet = $feed['records'];
        }
        else
        {
            throw new Exception("Unable to retrieve {$this->_eapmName} feed.");
        }
    }

    public function getHeaderColumns()
    {
        return '';
    }
    
    public function getTotalRecordCount()
    {
        return $this->_totalRecordCount;
    }

    public function setSourceName($sourceName = '')
    {
        $this->_sourcename = $this->_eapmName;
    }

    //Begin Implementation for SPL's Iterator interface
    public function current()
    {
        $this->_currentRow =  current($this->_recordSet);
        return $this->_currentRow;
    }

    public function key()
    {
        return key($this->_recordSet);
    }
    
    public function rewind()
    {
        reset($this->_recordSet);
    }

    public function next()
    {
        $this->_rowsCount++;
        next($this->_recordSet);
    }

    public function valid()
    {
        return (current($this->_recordSet) !== FALSE);
    }
}

