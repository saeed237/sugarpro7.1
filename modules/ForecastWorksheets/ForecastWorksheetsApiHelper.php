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

require_once('data/SugarBeanApiHelper.php');

class ForecastWorksheetsApiHelper extends SugarBeanApiHelper
{
    /**
     * Formats the bean so it is ready to be handed back to the API's client. Certian fields will get extra processing
     * to make them easier to work with from the client end.
     *
     * @param $bean SugarBean|ForecastWorksheet The bean you want formatted
     * @param $fieldList array Which fields do you want formatted and returned (leave blank for all fields)
     * @param $options array Currently no options are supported
     * @return array The bean in array format, ready for passing out the API to clients.
     */
    public function formatForApi(SugarBean $bean, array $fieldList = array(), array $options = array())
    {
        $data = parent::formatForApi($bean, $fieldList, $options);
        $data['parent_deleted'] = 0;
        if ($bean->draft == 0) {
            $sq = new SugarQuery();
            $sq->select('id');
            $sq->from(BeanFactory::getBean($bean->parent_type))->where()
                ->equals('id', $bean->parent_id);
            $beans = $sq->execute();
            if (empty($beans)) {
                $data['parent_name'] = $data['name'];
                $data['parent_deleted'] = 1;
            }
        }
        return $data;

    }
}
