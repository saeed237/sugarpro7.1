<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

require_once 'include/SugarFields/SugarFieldHandler.php';
require_once('modules/SchedulersJobs/SchedulersJob.php');

class WebLogicHook extends SugarBean implements RunnableSchedulerJob
{
    public $id;
    public $name;
    public $module_name;
    public $request_method;
    public $url;
    public $trigger_event;

    public $table_name = 'weblogichooks';
    public $object_name = 'WebLogicHook';
    public $module_dir = 'WebLogicHooks';
    public $new_schema = true;
    public $importable = true;

    /**
     * @var $job the job object
     */
    protected $job;

    /**
     * Default Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }
        return false;
    }

    protected function getActionArray()
    {
        return array(1, $this->name, 'modules/WebLogicHooks/WebLogicHook.php', 'WebLogicHook', 'dispatchRequest', $this->id);
    }

    public function save()
    {
        $hook = $this->getActionArray();
        if (!empty($this->fetched_row)) {
            $oldhook = $hook;
            // since remove_logic_hook compares 1, 3 and 4
            $oldhook[3] = 'WebLogicHook';
            remove_logic_hook($this->module_name, $this->trigger_event, $oldhook);
        }
        parent::save();
        $hook[5] = $this->id;
        check_logic_hook_file($this->module_name, $this->trigger_event, $hook);
    }

    /**
     * Dispatch request.
     * @param SugarBean $seed a bean that fired event
     * @param string $event event name
     * @param array $arguments event arguments 
     * @param string $id web logic hook id
     */
    public function dispatchRequest(SugarBean $seed, $event, $arguments, $id)
    {
        $this->retrieve($id);
        if (empty($this->id)) {
            return;
        }

        $jobData = array(
            'url' => $this->url,
            'request_method' => $this->request_method,
            'payload' => $this->formatRequestData($seed, $event, $arguments)
        );

        $job = new SchedulersJob();
        $job->assigned_user_id = $this->created_by;
        $job->name = 'Dispatch Web Logic Hook';
        $job->status = SchedulersJob::JOB_STATUS_QUEUED;
        $job->target = 'class::' . get_class($this);
        $job->data = serialize($jobData);
        $job->save();
    }

    /**
     * This method implements setJob from RunnableSchedulerJob and sets the SchedulersJob instance for the class
     *
     * @param SchedulersJob $job the SchedulersJob instance set by the job queue
     *
     */
    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }

    /**
     * This method implements the run function of RunnableSchedulerJob and handles processing a SchedulersJob
     *
     * @param Mixed $data parameter passed in from the job_queue.data column when a SchedulerJob is run
     * @return bool true on success, false on error
     */
    public function run($data)
    {
        extract(unserialize($data));
        $payload = json_encode($payload);

        $curlHandler = curl_init();

        $options = array(
            CURLOPT_HTTPHEADER      => false,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_CONNECTTIMEOUT  => 5,
            CURLOPT_TIMEOUT         => 1,
            CURLOPT_MAXREDIRS       => 1,
            CURLOPT_USERAGENT       => 'SugarCrm',
            CURLOPT_VERBOSE         => false,
            CURLOPT_URL             => $url,
            CURLOPT_HTTPHEADER      => array(
                'Content-Type: application/json',                                                                                
                'Content-Length: ' . strlen($payload)
            ),
            CURLOPT_POSTFIELDS      => $payload,
            CURLOPT_CUSTOMREQUEST   => $request_method,
        );

        curl_setopt_array($curlHandler, $options);

        if (false === curl_exec($curlHandler)) {
            $GLOBALS['log']->error('WebLogicHook failed: ' . curl_error($curlHandler));
        }

        curl_close($curlHandler);
        $this->job->succeedJob();
        return true;
    }

    public function mark_deleted($id)
    {
        if ($this->id != $id) {
            $this->retrieve($id);
            // does not exist - no need to delete
            if (empty($this->id)) {
                return;
            }
        }
        remove_logic_hook($this->module_name, $this->trigger_event, $this->getActionArray());
        parent::mark_deleted($id);
    }

    private function formatRequestData(SugarBean $bean, $event, array $arguments)
    {
        $data = array();
        $sfh = new SugarFieldHandler();

        $arguments['bean'] =  get_class($bean);

        if (isset($bean->id)) {
            $data['id'] = $bean->id;
        }

        if (!SugarACL::moduleSupportsACL($bean->module_name) || $bean->ACLAccess('detail')) {
            $fieldList = $bean->field_defs;

            $this->ACLFilterFieldList($fieldList, array(
                'bean' => $bean
            ));

            foreach ($fieldList as $fieldName => $properties) {
                $fieldType = !empty($properties['custom_type']) ? $properties['custom_type'] : $properties['type'];
                $field = $sfh->getSugarField($fieldType);
                if ('link' !== $fieldType && !empty($field) && (isset($bean->$fieldName)  || 'relate' === $fieldType)) {
                    $field->apiFormatField($data, $bean, array(), $fieldName, $properties);
                }
            }
        }

        $arguments['data'] = $data;
        $arguments['event'] = $event;

        return $arguments;
    }

}
