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


require_once('include/connectors/sources/default/source.php');

class ext_eapm_google extends source {
	protected $_enable_in_wizard = false;
	protected $_enable_in_hover = false;
	protected $_has_testing_enabled = false;
    protected $_gdClient = null;

    private function loadGdClient()
    {
        if($this->_gdClient == null)
        {
            $this->_eapm->getClient("contacts");
            $this->_gdClient = $this->_eapm->gdClient;
            $maxResults = $GLOBALS['sugar_config']['list_max_entries_per_page'];
            $this->_gdClient->setMaxResults($maxResults);
        }
    }

	public function getItem($args=array(), $module=null)
    {
        if( !isset($args['id']) )
            throw new Exception("Unable to return google contact entry with missing id.");
        
        $this->loadGdClient();

        $entry = FALSE;
        try
        {
            $entry = $this->_gdClient->getContactEntry( $args['id'] );
        }
        catch(Zend_Gdata_App_HttpException $e)
        {
            $GLOBALS['log']->fatal("Received exception while trying to retrieve google contact item:" .  $e->getResponse());
        }
        catch(Exception $e)
        {
            $GLOBALS['log']->fatal("Unable to retrieve single item " . var_export($e, TRUE));
        }

        return $entry;

    }
	public function getList($args=array(), $module=null)
    {
        $feed = FALSE;
        $this->loadGdClient();

        if( !empty($args['maxResults']) )
        {
            $this->_gdClient->setMaxResults($args['maxResults']);
        }

        if( !empty($args['startIndex']) )
        {
            $this->_gdClient->setStartIndex($args['startIndex']);
        }

        $results = array('totalResults' => 0, 'records' => array());
        try
        {
            $feed = $this->_gdClient->getContactListFeed($args);
            $results['totalResults'] = $feed->totalResults->getText();

            $rows = array();
            foreach ($feed->entries as $entry)
            {
                $rows[] = $entry->toArray();
            }
            $results['records'] = $rows;
        }
        catch(Zend_Gdata_App_HttpException $e)
        {
            $GLOBALS['log']->fatal("Received exception while trying to retrieve google contact list:" .  $e->getResponse());
        }
        catch(Exception $e)
        {
            $GLOBALS['log']->fatal("Unable to retrieve item list for google contact connector.");
        }

        return $results;
    }
}
