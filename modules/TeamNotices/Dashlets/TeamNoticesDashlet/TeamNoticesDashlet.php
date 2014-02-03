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


require_once('include/Dashlets/Dashlet.php');

class TeamNoticesDashlet extends Dashlet
{
    public $isRefreshable = true;
    public $hasScript     = true;

    public function __construct($id)
    {
        parent::Dashlet($id);
        $this->title = translate('LBL_MODULE_NAME', 'TeamNotices');
    }

    public function displayScript()
    {
    }

    public function display()
    {
        $data = array();


        $ss = new Sugar_Smarty();


        $focus = BeanFactory::getBean('TeamNotices');

        $today = db_convert("'".TimeDate::getInstance()->nowDbDate()."'", 'date');
        $query = $focus->create_new_list_query("date_start",$focus->table_name.".date_start <= $today and ".$focus->table_name.".date_end >= $today and ".$focus->table_name.'.status=\'Visible\'');

        if ( $result = $focus->db->query($query) )
            while ( $row = $focus->db->fetchByAssoc($result) )
                $data[] = $row;

        $ss->assign("data", $data);

        return parent::display() . $ss->fetch('modules/TeamNotices/Dashlets/TeamNoticesDashlet/TeamNoticesDashlet.tpl');
    }
}
