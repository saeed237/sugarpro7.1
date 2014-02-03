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


require_once('include/ListView/ListViewSmarty.php');


class ImportListView
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var array
     */
    protected $headerColumns = array();

    /**
     * @var Sugar_Smarty
     */
    private $ss;

    /**
     * @var string
     */
    private $tableID;

    /**
     * @var Paginatable
     */
    private $dataSource;

    /**
     * @var int
     */
    private $recordsPerPage;

    /**
     * @var int
     */
    private $maxColumns;

    /**
     * Create a list view object that can display a data source which implements the Paginatable interface.
     *
     * @throws Exception
     * @param  Paginatable $dataSource
     * @param  array $params
     * @param string $tableIdentifier
     */
    public function __construct($dataSource, $params, $tableIdentifier = '')
    {
        global $sugar_config;

        $this->ss = new Sugar_Smarty();
        $this->tableID = $tableIdentifier;

        $this->dataSource = $dataSource;
        $this->headerColumns = $this->dataSource->getHeaderColumns();

        if( !isset($params['offset']) )
            throw new Exception("Missing required parameter offset for ImportListView");
        else
            $this->dataSource->setCurrentOffset($params['offset']);

        $this->recordsPerPage = isset($params['totalRecords']) ? $params['totalRecords'] : ($sugar_config['list_max_entries_per_page'] + 0);
        $this->data = $this->dataSource->loadDataSet($this->recordsPerPage)->getDataSet();
        $this->maxColumns = $this->getMaxColumnsForDataSet();
    }

    /**
     * Display the list view like table.
     *
     * @param bool $return True if we should return the content rather than echoing.
     * @return
     */
    public function display($return = FALSE)
    {
        global $app_strings,$mod_strings;

        $navStrings = array('next' => $app_strings['LNK_LIST_NEXT'],'previous' => $app_strings['LNK_LIST_PREVIOUS'],'end' => $app_strings['LNK_LIST_END'],
                            'start' => $app_strings['LNK_LIST_START'],'of' => $app_strings['LBL_LIST_OF']);
        $this->ss->assign('navStrings', $navStrings);
        $this->ss->assign('pageData', $this->generatePaginationData() );
        $this->ss->assign('tableID', $this->tableID);
        $this->ss->assign('colCount', count($this->headerColumns));
        $this->ss->assign('APP',$app_strings);
        $this->ss->assign('rowColor', array('oddListRow', 'evenListRow'));
        $this->ss->assign('displayColumns',$this->headerColumns);
        $this->ss->assign('data', $this->data);
        $this->ss->assign('maxColumns', $this->maxColumns);
        $this->ss->assign('MOD', $mod_strings);
        $contents = $this->ss->fetch('modules/Import/tpls/listview.tpl');
        if($return)
            return $contents;
        else
            echo $contents;
    }

    /**
     * For the data set that was loaded, find the max count of entries per row.
     *
     * @return int
     */
    protected function getMaxColumnsForDataSet()
    {
        $maxColumns = 0;
        foreach($this->data as $data)
        {
            if(count($data) > $maxColumns)
                $maxColumns = count($data);
        }
        return $maxColumns;
    }

    /**
     * Generate the pagination data.
     *
     * @return array
     */
    protected function generatePaginationData()
    {
        $currentOffset = $this->dataSource->getCurrentOffset();
        $totalRecordsCount = $this->dataSource->getTotalRecordCount();
        $nextOffset =  $currentOffset+ $this->recordsPerPage;
        $nextOffset = $nextOffset > $totalRecordsCount ? 0 : $nextOffset;
        $lastOffset = floor($totalRecordsCount / $this->recordsPerPage) * $this->recordsPerPage;
        $previousOffset = $currentOffset - $this->recordsPerPage;
        $offsets = array('totalCounted'=> true, 'total' => $totalRecordsCount, 'next' => $nextOffset,
                         'last' => $lastOffset, 'previous' => $previousOffset,
                         'current' => $currentOffset, 'lastOffsetOnPage' => count($this->data) + $this->dataSource->getCurrentOffset() );

        $pageData = array('offsets' => $offsets);
        return $pageData;

    }



}
