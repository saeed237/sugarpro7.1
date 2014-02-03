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
/**
 * Assists in modifying the Metadata in places that the core cannot handle at this time.
 *
 */
class MetaDataHacks
{
    /**
     * The SugarFieldHandler
     *
     * @var SugarFieldHandler
     */
    protected $sfh;

    /**
     * Fix the ACLs for non-db fields that actually do need ACLs for
     *
     * @param  array $fieldsAcls array of fields that have ACLs
     * @return array Array of fixed ACL's
     */
    public function fixAcls(array $fieldsAcls)
    {
        return $fieldsAcls;
    }

    /**
     * Relate fields are weird.
     * We need to set the type ot what the
     * field type really is not relate.
     *
     * @param  array $fieldDefs
     * @return array $fieldDefs
     */
    public function fixRelateFields(array $fieldDefs)
    {
        if (empty($fieldDefs)) {
            return $fieldDefs;
        }

        foreach ($fieldDefs as $name => &$fieldDef) {
            if ($fieldDef['type'] == 'relate' && (substr($name, -3) == '_id')) {
                $fieldDef['type'] = 'id';
            }
        }

        return $fieldDefs;
    }

    /**
     * Cleans field def default values before returning them as a member of the
     * metadata response payload
     *
     * Bug 56505
     * Cleans default value of fields to strip out metacharacters used by the app.
     * Used initially for cleaning default multienum values.
     *
     * @param  array $fielddefs
     * @return array
     */
    public function normalizeFieldDefs(array $fieldDefs)
    {
        $this->getSugarFieldHandler();

        foreach ($fieldDefs as $name => $def) {
            if (isset($def['type'])) {
                $type = !empty($def['custom_type']) ? $def['custom_type'] : $def['type'];

                $field = $this->sfh->getSugarField($type);

                $fieldDefs[$name] = $field->getNormalizedDefs($def);
            }
        }

        return $fieldDefs;
    }

    /**
     * Gets the SugarFieldHandler object
     *
     * @return SugarFieldHandler The SugarFieldHandler
     */
    protected function getSugarFieldHandler()
    {
        if (empty($this->sfh)) {
            $this->sfh = new SugarFieldHandler;
        }

        return $this->sfh;
    }
}
