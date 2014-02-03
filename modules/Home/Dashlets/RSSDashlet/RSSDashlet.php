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

class RSSDashlet extends Dashlet
{
    protected $url = 'http://www.sugarcrm.com/crm/aggregator/rss/1';
    protected $height = '200'; // height of the pad
    protected $images_dir = 'modules/Home/Dashlets/RSSDashlet/images';

    /**
     * Constructor
     *
     * @global string current language
     * @param guid $id id for the current dashlet (assigned from Home module)
     * @param array $def options saved for this dashlet
     */
    public function __construct($id, $def)
    {
        $this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here

        if(!empty($def['height'])) // set a default height if none is set
            $this->height = $def['height'];

        if(!empty($def['url']))
            $this->url = $def['url'];

        if(!empty($def['title']))
            $this->title = $def['title'];
        else
            $this->title = $this->dashletStrings['LBL_TITLE'];

        if(isset($def['autoRefresh'])) $this->autoRefresh = $def['autoRefresh'];

        parent::Dashlet($id); // call parent constructor

        $this->isConfigurable = true; // dashlet is configurable
        $this->hasScript = false;  // dashlet has javascript attached to it
    }

    /**
     * Displays the dashlet
     *
     * @return string html to display dashlet
     */
    public function display()
    {
        $ss = new Sugar_Smarty();
        $ss->assign('saving', $this->dashletStrings['LBL_SAVING']);
        $ss->assign('saved', $this->dashletStrings['LBL_SAVED']);
        $ss->assign('id', $this->id);
        $ss->assign('height', $this->height);
        $ss->assign('rss_output', $this->getRSSOutput($this->url));
        $str = $ss->fetch('modules/Home/Dashlets/RSSDashlet/RSSDashlet.tpl');
        return parent::display($this->dashletStrings['LBL_DBLCLICK_HELP']) . $str; // return parent::display for title and such
    }

    /**
     * Displays the configuration form for the dashlet
     *
     * @return string html to display form
     */
    public function displayOptions() {
        global $app_strings, $sugar_version, $sugar_config;

        $ss = new Sugar_Smarty();
        $ss->assign('titleLbl', $this->dashletStrings['LBL_CONFIGURE_TITLE']);
        $ss->assign('heightLbl', $this->dashletStrings['LBL_CONFIGURE_HEIGHT']);
        $ss->assign('rssUrlLbl', $this->dashletStrings['LBL_CONFIGURE_RSSURL']);
        $ss->assign('saveLbl', $app_strings['LBL_SAVE_BUTTON_LABEL']);
        $ss->assign('clearLbl', $app_strings['LBL_CLEAR_BUTTON_LABEL']);
        $ss->assign('title', $this->title);
        $ss->assign('height', $this->height);
        $ss->assign('url', $this->url);
        $ss->assign('id', $this->id);
        if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}

        return parent::displayOptions() . $ss->fetch('modules/Home/Dashlets/RSSDashlet/RSSDashletOptions.tpl');
    }

    /**
     * called to filter out $_REQUEST object when the user submits the configure dropdown
     *
     * @param array $req $_REQUEST
     * @return array filtered options to save
     */
    public function saveOptions(
        array $req
        )
    {
        $options = array();
        $options['title'] = $req['title'];
        $options['url'] = $req['url'];
        $options['height'] = $req['height'];
        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];

        return $options;
    }

    protected function getRSSOutput(
        $url
        )
    {
        // suppress XML errors
        libxml_use_internal_errors(true);
        $rssdoc = simplexml_load_file($url);
        // return back the error message if the loading wasn't successful
        if (!$rssdoc)
            return $this->dashletStrings['ERR_LOADING_FEED'];

        $output = "<table class='edit view'>";
        if ( isset($rssdoc->channel) ) {
            foreach ( $rssdoc->channel as $channel ) {
                if ( isset($channel->item ) ) {
                    foreach ( $channel->item as $item ) {
                        $output .= <<<EOHTML
<tr>
<td>
    <h3><a href="{$item->link}" target="_child">{$item->title}</a></h3>
    {$item->description}
</td>
</tr>
EOHTML;
                    }
                }
            }
        }
        else {
            foreach ( $rssdoc->entry as $entry ) {
                $link = trim($entry->link);
                if ( empty($link) ) {
                    $link = $entry->link[0]['href'];
                }
                $output .= <<<EOHTML
<tr>
<td>
    <h3><a href="{$link}" target="_child">{$entry->title}</a></h3>
    {$entry->summary}
</td>
</tr>
EOHTML;
            }
        }
        $output .= "</table>";

        return $output;
    }
}
