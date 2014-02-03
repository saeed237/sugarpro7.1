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


require_once('data/visibility/OwnerVisibility.php');

/**
 *  Dashboards is used to store dashboard configuration data.
 */
class Dashboard extends Basic 
{    
    public $table_name = "dashboards";
    public $module_name = 'Dashboards';
    public $module_dir = 'Dashboards';
    public $object_name = "Dashboard";
    
    public function __construct() 
    {
        parent::__construct();
        $this->addVisibilityStrategy("OwnerVisibility");
    }

    /**
     * This overrides the default retrieve function setting the default to encode to false
     */
    function retrieve($id='-1', $encode=false,$deleted=true)
    {
        return parent::retrieve($id, false, $deleted);
    }

    /**
     * This function fetches an array of dashboards for the current user
     */
    public function getDashboardsForUser( User $user, $options = array() )
    {
        $order = !empty($options['order_by']) ? $options['order_by'] : 'date_entered desc';
        $from = "assigned_user_id = '".$this->db->quote($user->id)."' and dashboard_module ='".$this->db->quote($options['dashboard_module'])."'";
        if (!empty($options['view'])) {
            $from .= " and view ='".$this->db->quote($options['view'])."'";
        }
        $offset = !empty($options['offset']) ? (int)$options['offset'] : 0;
        $limit = !empty($options['limit']) ? (int)$options['limit'] : -1;
        $result = $this->get_list($order,$from,$offset,$limit,-1,0);
        $nextOffset = (count($result['list']) > 0 && count($result['list']) ==  $limit) ? ($offset + $limit) : -1;
        return array('records'=>$result['list'], 'next_offset'=>$nextOffset);
    }

    /**
     * This overrides the default save function setting assigned_user_id
     * @see SugarBean::save()
     */
    function save($check_notify = FALSE)
    {
        $this->assigned_user_id = $GLOBALS['current_user']->id;
        // never send assignment notifications for dashboards
        return parent::save(false);
    }
}
