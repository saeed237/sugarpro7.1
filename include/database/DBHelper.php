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

/*********************************************************************************

* Description: The functionality of the abstract DBHelper class has been moved to DBManager and
* its database specific derivatives. This class is no longer used and no code should be added
* this file or reference anything in this class. The sole purpose of keeping this class as
* an empty, deprecated and final class is to cause a conflict when merging functionality or bug fixes
* from upstream projects. MERGE CONFLICTS should be resolved by inspecting DBManager and derivatives
* for similar fixes and if none exist by porting the changes from DBHelper to DBManager or its derivatives.
*
* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
* All Rights Reserved.
* Contributor(s): ______________________________________..
********************************************************************************/

/**
 * @deprecated
 * @internal
 */
final class DBHelper
{
}

?>
