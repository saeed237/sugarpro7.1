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

	

$mod_strings = array (
  'ERR_NO_OPPS' => 'Si us plau, creï com a mínim una Oportunitat per veure els seus gràfics.',
  'LBL_ALL_OPPORTUNITIES' => 'El valor total de totes les oportunitats es',
  'LBL_CAMPAIGN_ROI_TITLE_DESC' => 'Mostra la resposta a la campanya per retorn d´inversió.',
  'LBL_CHART_ACTION' => 'Acció',
  'LBL_CHART_DCE_ACTIONS_MONTH' => 'Accions del DQE per tipus (Mes actual)',
  'LBL_CHART_LEAD_SOURCE_BY_OUTCOME' => 'Client potencial per resultats',
  'LBL_CHART_MODULES_USED_DIRECT_REPORTS_30_DAYS' => 'Mòduls Usats Per els Meus Informes Directes (Últims 30 Dies)',
  'LBL_CHART_MY_MODULES_USED_30_DAYS' => 'Mòduls utilitzats per mi (últims 30 dies)',
  'LBL_CHART_MY_PIPELINE_BY_SALES_STAGE' => 'El meu Pipeline per etapa de vendes',
  'LBL_CHART_OPPORTUNITIES_THIS_QUARTER' => 'Oportunitats del trimestre',
  'LBL_CHART_OUTCOME_BY_MONTH' => 'Resultat per Mes',
  'LBL_CHART_PIPELINE_BY_LEAD_SOURCE' => 'Pipeline per client potencial',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE' => 'Pipeline per etapa de vendes',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE_FUNNEL' => 'Pipeline de vendes Stage Funnel',
  'LBL_CHART_TYPE' => 'Tipus de Gráfic',
  'LBL_CLOSE_DATE_END' => 'Data de tancament espera - Per:',
  'LBL_CLOSE_DATE_START' => 'Data de tancament espera - De:',
  'LBL_CREATED_ON' => 'Executat per última vegada el',
  'LBL_DATE_END' => 'Data de Fi:',
  'LBL_DATE_RANGE' => 'El rang de dates és',
  'LBL_DATE_RANGE_TO' => 'a',
  'LBL_DATE_START' => 'Data d´Inici:',
  'LBL_EDIT' => 'Editar',
  'LBL_LEAD_SOURCES' => 'Presa de Contacte:',
  'LBL_LEAD_SOURCE_BY_OUTCOME' => 'Totes les oportunitats per presa de contacte per resultat',
  'LBL_LEAD_SOURCE_BY_OUTCOME_DESC' => 'Mostra les quantitats acumulades d´oportunitats per la presa de contacte seleccionada pel resultat per als usuaris seleccionats. El resultat es basa en si l´etapa de venda és Bestiar, Perdido o qualsevol altre valor.',
  'LBL_LEAD_SOURCE_FORM_DESC' => 'Mostra les quantitats acumulades d´oportunitats per la presa de contacte seleccionada pels usuaris seleccionats.',
  'LBL_LEAD_SOURCE_FORM_TITLE' => 'Totes les oportunitats per presa de contacte',
  'LBL_LEAD_SOURCE_OTHER' => 'Un altre',
  'LBL_MODULE_NAME' => 'Quadre de Comandament',
  'LBL_MODULE_NAME_SINGULAR' => 'Quadre de Comandament',
  'LBL_MODULE_TITLE' => 'Quadre de comandament: Inici',
  'LBL_MONTH_BY_OUTCOME_DESC' => 'Mostra les quantitats acumulades d´oportunitats per mes i per resultat per als usuaris seleccionades on la data estimada de tancament és dins del rang de dates éspecificades.',
  'LBL_MY_MODULES_USED_SIZE' => 'Número d´Accesos',
  'LBL_NUMBER_OF_OPPS' => 'Número d´Oportunitats',
  'LBL_OPPS_IN_LEAD_SOURCE' => 'oportunitats on la presa de contacte és',
  'LBL_OPPS_IN_STAGE' => 'amb etapa de venda',
  'LBL_OPPS_OUTCOME' => 'on el resultat és',
  'LBL_OPPS_WORTH' => 'oportunitats valorades en',
  'LBL_OPP_SIZE' => 'Valor de l´oportunitat en',
  'LBL_OPP_THOUSANDS' => 'K',
  'LBL_PIPELINE_FORM_TITLE_DESC' => 'Mostra les quantitats acumulades pels etapes de venda seleccionats per a les seves oportunitats on la data de tancament esperada és dins del rang de dates éspecificades.',
  'LBL_REFRESH' => 'Actualitzar',
  'LBL_ROLLOVER_DETAILS' => 'Mogui el cursor sobre una barra per a més detall.',
  'LBL_ROLLOVER_WEDGE_DETAILS' => 'Mogui el cursor sobre una secció per a més detall.',
  'LBL_SALES_STAGES' => 'Etapas de venda:',
  'LBL_SALES_STAGE_FORM_DESC' => 'Mostra les quantitats acumulades d´oportunitats pels etapes de venda seleccionats per als usuaris seleccionats on la data estimada de tancament és dins del rang de dates éspecificades.',
  'LBL_SALES_STAGE_FORM_TITLE' => 'Objectiu per etapa de venda',
  'LBL_TITLE' => 'Títol',
  'LBL_TOTAL_PIPELINE' => 'Total en objectiu',
  'LBL_USERS' => 'Usuaris:',
  'LBL_YEAR' => 'Any:',
  'LBL_YEAR_BY_OUTCOME' => 'Objectiu per mes per resultat',
  'LNK_NEW_ACCOUNT' => 'Nou Compte',
  'LNK_NEW_CALL' => 'Programar Trucada',
  'LNK_NEW_CASE' => 'Nou Cas',
  'LNK_NEW_CONTACT' => 'Nou Contacte',
  'LNK_NEW_ISSUE' => 'Informe d´Incidència',
  'LNK_NEW_LEAD' => 'Nou Client Potencial',
  'LNK_NEW_MEETING' => 'Programar Reunió',
  'LNK_NEW_NOTE' => 'Nova Nota o Adjunt',
  'LNK_NEW_OPPORTUNITY' => 'Nova Oportunitat',
  'LNK_NEW_QUOTE' => 'Nou Pressupost',
  'LNK_NEW_TASK' => 'Nova Tasca',
  'NTC_NO_LEGENDS' => 'Cap',
);

