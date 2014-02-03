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



if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
//THIS IS TO FIX ANY VARDEFS IN CREATING LIST QUERIES (specifically relationships)
if (isset($this->field_defs['assigned_user_name']))
{
    $this->field_defs['assigned_user_name'] = array_merge(
        $this->field_defs['assigned_user_name'],
        array(
            'name' => 'assigned_user_name',
            'rname'=>'user_name',
            'vname' => 'LBL_ASSIGNED_TO',
            'type' => 'relate',
            'reportable' => false,
            'source' => 'non-db',
            'link' => 'assigned_user_link',
            'id_name' => 'assigned_user_id',
            'massupdate' => FALSE
        )
    );
}

if (isset($this->field_defs['created_by']))
{
    if (!isset($this->field_defs['created_by_name']))
    {
        $this->field_defs['created_by_name'] = array();
    }

    $this->field_defs['created_by_name'] = array_merge(
        $this->field_defs['created_by_name'],
        array(
            'name' => 'created_by_name',
            'rname'=>'user_name',
            'vname' => 'LBL_CREATED',
            'type' => 'relate',
            'reportable' => false,
            'source' => 'non-db',
            'link' => 'created_by_link'
        )
    );
}

if (isset($this->field_defs['modified_user_id']))
{
    if (!isset($this->field_defs['modified_user_name']))
    {
        $this->field_defs['modified_user_name'] = array();
    }

    $this->field_defs['modified_user_name'] = array_merge(
        $this->field_defs['modified_user_name'],
        array(
            'name' => 'modified_user_name',
            'rname' => 'user_name',
            'vname' => 'LBL_MODIFIED',
            'type' => 'relate',
            'reportable' => false,
            'source' => 'non-db',
            'link' => 'modified_user_link'
        )
    );

    if (!isset($this->field_defs['modified_by_name']))
    {
        $this->field_defs['modified_by_name'] = array();
    }

    $this->field_defs['modified_by_name'] = array_merge(
        $this->field_defs['modified_by_name'],
        array(
            'name' => 'modified_by_name',
            'rname' => 'user_name',
            'vname' => 'LBL_MODIFIED',
            'type' => 'relate',
            'reportable' => false,
            'source' => 'non-db',
            'link' => 'modified_user_link'
        )
    );
}
