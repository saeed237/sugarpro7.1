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



require_once 'vendor/Zend/Gdata/Extension.php';


class Zend_Gdata_Contacts_Extension_Name extends Zend_Gdata_Extension
{

    protected $_rootNamespace = 'gd';
    protected $_rootElement = 'name';
    protected $_names = array('first_name' => '', 'last_name' => '', 'full_name' => '');
    /**
     * Constructs a new Zend_Gdata_Contacts_Extension_Name object.
     * @param string $value (optional) The text content of the element.
     */
    public function __construct($value = null)
    {
        $this->registerAllNamespaces(Zend_Gdata_Contacts::$namespaces);
        parent::__construct();
    }

    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName)
        {
            case $this->lookupNamespace('gd') . ':' . 'fullName';
                $entry = new Zend_Gdata_Entry();
                $entry->transferFromDOM($child);
                $this->_names['full_name'] = $entry->getText();
                break;

            case $this->lookupNamespace('gd') . ':' . 'givenName';
                $entry = new Zend_Gdata_Entry();
                $entry->transferFromDOM($child);
                $this->_names['first_name'] = $entry->getText();
                break;

             case $this->lookupNamespace('gd') . ':' . 'familyName';
                $entry = new Zend_Gdata_Entry();
                $entry->transferFromDOM($child);
                $this->_names['last_name'] = $entry->getText();
                break;
            default:
                parent::takeChildFromDOM($child);
                break;
        }
    }

    public function toArray()
    {
        return $this->_names;
    }
}
 
