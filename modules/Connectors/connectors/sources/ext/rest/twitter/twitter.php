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
* Description:
* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
* Reserved. Contributor(s): contact@synolia.com - www.synolia.com
* *******************************************************************************/

require_once('include/connectors/sources/ext/rest/rest.php');

class ext_rest_twitter extends ext_rest {

    protected $_has_testing_enabled = true;

    public function __construct(){
        parent::__construct();
        $this->_enable_in_wizard = false;
        $this->_enable_in_hover = true;
    }

    /**
     * test
     * This method is called from the administration interface to run a test of the service
     * It is up to subclasses to implement a test and set _has_testing_enabled to true so that
     * a test button is rendered in the administration interface
     *
     * @return result boolean result of the test function
     */
    public function test() {
        require_once 'vendor/Zend/Oauth/Consumer.php';

        $api = ExternalAPIFactory::loadAPI('Twitter', true);

        if ($api) {
            $properties = $this->getProperties();
            $config = array(
                'callbackUrl' => 'http://www.sugarcrm.com',
                'siteUrl' => $api->getOauthRequestURL(),
                'consumerKey' => $properties['oauth_consumer_key'],
                'consumerSecret' => $properties['oauth_consumer_secret']
            );

            $consumer = new Zend_Oauth_Consumer($config);
            $consumer->getRequestToken();
            return true;
        }
        
        return false;
    }

    /*
     * getItem
     *
     * As the twitter connector does not have a true API call, we simply
     * override this abstract
     */
    public function getItem($args=array(), $module=null){}


    /*
     * getList
     *
     * As the twitter connector does not have a true API call, we simply
     * override this abstract method
     */
    public function getList($args=array(), $module=null){}
}

?>
