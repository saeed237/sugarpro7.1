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


class Zend_Gdata_Contacts_Extension_Email extends Zend_Gdata_Extension
{

    protected $_rootNamespace = 'gd';
    protected $_rootElement = 'email';
    protected $_isPrimary = FALSE;
    protected $_emailType = null;
    protected $_email = null;
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
            default:
                parent::takeChildFromDOM($child);
                break;
        }
    }

    /**
     * Extracts XML attributes from the DOM and converts them to the
     * appropriate object members.
     *
     * @param DOMNode $attribute The DOMNode attribute to be handled.
     */
    protected function takeAttributeFromDOM($attribute)
    {
        switch ($attribute->localName)
        {
            case 'primary':
                if(strtolower($attribute->nodeValue) == 'true')
                    $this->_isPrimary = true;
                else
                    $this->_isPrimary = false;
            break;
            
            case 'rel':
                $this->_emailType = $attribute->nodeValue;
            break;

            case 'address':
                $this->_email = $attribute->nodeValue;
            break;

            default:
                parent::takeAttributeFromDOM($attribute);
            break;
        }
    }

    public function getEmailType()
    {
        if($this->_emailType == null)
            return '';
        else
            return str_replace($this->lookupNamespace('gd') . '#', '', $this->_emailType);
    }
    
    public function getEmail()
    {
        return $this->_email;
    }

    public function isPrimary()
    {
        return $this->_isPrimary;
    }
}
 
