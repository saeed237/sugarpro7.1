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
<b>¡Bienvenido a Sugar 5.1!</b><br /><br />

Haga clic en <b>Mi Cuenta</b> para establecer sus preferencias.<br />
Haga clic en el icono con un <b>Interrogante</b> para acceder a la página de Ayuda de cada módulo.<br /><br />

Para obtener asistencia sobre cómo comenzar, haga clic en el enlace de <b>Formación</b> para más información sobre la oferta en formación de <b>Sugar University</b>.<br />
EOQ
;

$dashletStrings['JotPadDashlet'] = array('LBL_TITLE'            => 'JotPad',
                                         'LBL_DESCRIPTION'      => 'Un dashlet para guardar sus notas',
                                         'LBL_SAVING'           => 'Guardando JotPad ...',
                                         'LBL_SAVED'            => 'Guardado',
                                         'LBL_CONFIGURE_TITLE'  => 'Título',
                                         'LBL_CONFIGURE_HEIGHT' => 'Altura (1 - 300)',
                                         'LBL_DBLCLICK_HELP'    => 'Haga doble clic abajo para Editar.',
                                         'LBL_DEFAULT_TEXT'     => $defaultText, 
);
?>