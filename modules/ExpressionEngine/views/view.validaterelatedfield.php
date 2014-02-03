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

require_once('include/MVC/View/views/view.ajax.php');
require_once("data/BeanFactory.php");

class ViewValidateRelatedField extends ViewAjax
{
    var $vars = array("tmodule", "link", "related");

    public function __construct()
    {
        parent::ViewAjax();
        foreach($this->vars as $var)
        {
            if (empty($_REQUEST[$var]))
                sugar_die("Required paramter $var not set in ViewRelFields");
            $this->$var = $_REQUEST[$var];
        }
        $mb = new ModuleBuilder();
        $this->package = empty($_REQUEST['package']) || $_REQUEST['package'] == 'studio' ? "" : $mb->getPackage($_REQUEST['package']);
    }

    function display() {
        $linkName = $this->link;

        if (empty ($this->package))
        {
            //First, create a dummy bean to access the relationship info
            $focus = BeanFactory::newBean($this->tmodule);
            $focus->id = create_guid();
            //Next, figure out what the related module is
            if(!$focus->load_relationship($linkName)){
                echo "Invalid Link : \$$linkName";
                return;
            }
            $relatedModule = $focus->$linkName->getRelatedModuleName();
        } else {
            $module = $this->package->getModule ($this->tmodule);
            $linksFields = $module->getLinkFields();
            if (empty($linksFields[$linkName]))
            {
                echo "Invalid Link \$$linkName";
                return;
            }
            $relatedModule = $linksFields[$linkName]['module'];
        }

        $mbModule = null;
        if (!empty($this->package))
            $mbModule = $this->package->getModuleByFullName($relatedModule);

        if (empty($mbModule)) {
            //If the related module is deployed, use create a seed bean with the bean factory
            $relBean = BeanFactory::getBean($relatedModule);
            $field_defs = $relBean->field_defs;
        } else {
            //Otherwise the mbModule will exist and we can pull the vardef from there
            $field_defs = $mbModule->getVardefs(false);
            $field_defs = $field_defs['fields'];
        }

        //First check if the field exists
        if(!isset($field_defs[$this->related]) || !is_array($field_defs[$this->related]))
        {
            echo(json_encode("Unknown Field : $this->related"));
        }
        //Otherwise, send it to the formula builder to evaluate further
        else
        {
            echo json_encode($field_defs[$this->related]);
        }
    }
}