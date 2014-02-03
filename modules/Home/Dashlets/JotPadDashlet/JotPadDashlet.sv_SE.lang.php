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




















$defaultText = 
<<<EOQ
Welcome to Sugar 5.0<br /><br />

New features include:<br />
* Multiple homepages with customizable dashlets<br />
* Improved Dashboards and Charts<br />
* New Email Client for smoother communication<br />
* Module Builder to extend your SugarCRM deployment<br />
* Improved Sugar Studio and Access Control Features<br /><br />

For more information on getting started, please visit Sugar University.
EOQ
;


$dashletStrings['JotPadDashlet'] = array('LBL_TITLE'            => 'JotPad',
                                         'LBL_DESCRIPTION'      => 'En dashlet för dina anteckningar',
                                         'LBL_SAVING'           => 'Sparar JotPad ...',
                                         'LBL_SAVED'            => 'Sparat',
                                         'LBL_CONFIGURE_TITLE'  => 'Titel',
                                         'LBL_CONFIGURE_HEIGHT' => 'Höjd (1 - 300)',
                                         'LBL_DBLCLICK_HELP'    => 'Dubbelklicka nedan för att editera.',
                                         'LBL_DEFAULT_TEXT'     => $defaultText,
);
?>