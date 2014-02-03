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
 * Description:  Defines the Catalan language pack for the base application. 

 * Source: SugarCRM 5.2.0
 * Contributor(s): Ramón Feliu (ramon@slay.es).
 ********************************************************************************/

$defaultText = 
<<<EOQ
Benvingut a Sugar 5.2<br /><br />

Les noves característiques inclouen:<br />

Faci clic a <b>El Meu Compte</b> per establir les seves preferencies.<br />
Faci clic a l´icono amb un <b>Interrogant</b> per accedir a la pàgina d´Ajuda de cada mòdul.<br /><br />

Per a més informació sobre com introduir-se a Sugar, si us plau, visiti Sugar University.
EOQ
;

$dashletStrings['JotPadDashlet'] = array('LBL_TITLE'            => 'JotPad',
                                         'LBL_DESCRIPTION'      => 'Un dashlet per guardar les seves notes',
                                         'LBL_SAVING'           => 'Guardant JotPad ...',
                                         'LBL_SAVED'            => 'Guardat',
                                         'LBL_CONFIGURE_TITLE'  => 'Títol',
                                         'LBL_CONFIGURE_HEIGHT' => 'Altura (1 - 300)',
                                         'LBL_DBLCLICK_HELP'    => 'Faci doble clic abaix per Editar.',
                                         'LBL_DEFAULT_TEXT'     => $defaultText, 
);
 
