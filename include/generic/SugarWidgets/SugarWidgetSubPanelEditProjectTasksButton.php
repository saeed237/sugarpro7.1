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




class SugarWidgetSubPanelEditProjectTasksButton extends SugarWidgetSubPanelTopButton
{
    public function getDisplayName()
    {
        return $GLOBALS['mod_strings']['LBL_VIEW_GANTT_TITLE'];
    }

    public function getWidgetId()
    {
        return 'project_task_submit_button';
    }
	//widget_data is the collection of attributes associated with the button in the layout_defs file.
	function display(&$widget_data)
	{
		global $mod_strings;

		$title = $mod_strings['LBL_VIEW_GANTT_TITLE'];
		$value = $this->getDisplayName();
		$module_name = 'Project';
		$id = $widget_data['focus']->id;

		return '<form action="index.php" method="Post">'
			. '<input type="hidden" name="module" value="Project"> '
			. '<input type="hidden" name="action" value="EditGridView"> '
			. '<input type="hidden" name="return_module" value="Project" /> '
			. '<input type="hidden" name="return_action" value="DetailView" /> '
			. '<input type="hidden" name="project_id" value="' .$id . '" /> '
			. '<input type="hidden" name="return_id" value="' .$id . '" /> '
			. '<input type="hidden" name="record" value="' . $id .'" /> '
			. '<input type="submit" name="EditProjectTasks" '
			. ' class="button"'
            . ' id="' . $this->getWidgetId() . '"'
			. ' title="' . $title . '"'
			. ' value="' . $value . '" />'
			. '</form>';
	}
}
?>
