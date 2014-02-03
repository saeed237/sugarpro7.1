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
  'ERR_DELETE_RECORD' => 'Trebuie sa specifici un numar de inregistrare pentru a sterge aceasta vanzare',
  'LBL_ACCOUNT_ID' => 'Cont id',
  'LBL_ACCOUNT_NAME' => 'Numele Contului',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitati',
  'LBL_AMOUNT' => 'Suma:',
  'LBL_AMOUNT_USDOLLAR' => 'Suma USD:',
  'LBL_ASSIGNED_TO_ID' => 'Atribuit catre ID',
  'LBL_ASSIGNED_TO_NAME' => 'Atrbuit lui',
  'LBL_CAMPAIGN' => 'Campanie',
  'LBL_CLOSED_WON_SALES' => 'Vanzari castigate inchise',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contacte',
  'LBL_CREATED_ID' => 'Creata de ID',
  'LBL_CURRENCY' => 'Moneda',
  'LBL_CURRENCY_ID' => 'Valabilitate Id',
  'LBL_CURRENCY_NAME' => 'Nume Moneda',
  'LBL_CURRENCY_SYMBOL' => 'Simbol Moneda',
  'LBL_DATE_CLOSED' => 'Data la care se asteapta sa se inchida',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Conturi',
  'LBL_DESCRIPTION' => 'Descriere',
  'LBL_DUPLICATE' => 'Posibil Vanzari Duplicate',
  'LBL_EDIT_BUTTON' => 'Editeaza',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Istoric',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Antete',
  'LBL_LEAD_SOURCE' => 'Sursa principala',
  'LBL_LIST_ACCOUNT_NAME' => 'Nume Cont',
  'LBL_LIST_AMOUNT' => 'Suma, valoare',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Atribuit utilizatorului',
  'LBL_LIST_DATE_CLOSED' => 'inchis',
  'LBL_LIST_FORM_TITLE' => 'Lista Vanzari',
  'LBL_LIST_SALE_NAME' => 'Nume',
  'LBL_LIST_SALE_STAGE' => 'Etapa vanzare',
  'LBL_MODIFIED_ID' => 'Modificata de ID',
  'LBL_MODIFIED_NAME' => 'Modificata de Nume',
  'LBL_MODULE_NAME' => 'Vanzari',
  'LBL_MODULE_TITLE' => 'Vanzari:Acasa',
  'LBL_MY_CLOSED_SALES' => 'Vanzarile mele inchise',
  'LBL_NAME' => 'Nume vanzari',
  'LBL_NEW_FORM_TITLE' => 'Creeaza vanzare',
  'LBL_NEXT_STEP' => 'Urmatorul Pas',
  'LBL_PROBABILITY' => 'Probabilitate (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Proiecte',
  'LBL_RAW_AMOUNT' => 'Suma Bruta',
  'LBL_REMOVE' => 'Sterge',
  'LBL_SALE' => 'Vanzari',
  'LBL_SALES_STAGE' => 'Sadiul Vanzarilor',
  'LBL_SALE_INFORMATION' => 'Informatii Vanzare',
  'LBL_SALE_NAME' => 'Nume vanzari',
  'LBL_SEARCH_FORM_TITLE' => 'Cautare Vanzari',
  'LBL_TEAM_ID' => 'Echipa ID',
  'LBL_TOP_SALES' => 'Cea mai deschisa vanzare',
  'LBL_TOTAL_SALES' => 'Total Vanzari',
  'LBL_TYPE' => 'Tip',
  'LBL_VIEW_FORM_TITLE' => 'Vedere vanzari',
  'LNK_NEW_SALE' => 'Creeaza Vanzare',
  'LNK_SALE_LIST' => 'Vanzari',
  'MSG_DUPLICATE' => 'Inregistrarea vanzarilor pe care sunteţi pe cale de a o crea ar putea fi un duplicat al unei înregistrări de vanzari care există deja. Inregistrarile contului care conţin nume similare sunt enumerate mai jos.<br />Faceţi clic pe Salvare pentru a continua crearea ascestei Vanzari noi, sau faceţi clic pe Revocare pentru a reveni la modul fără a crea Vanzarea.',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Sunteti sigur ca vreti sa stergeti acest contact din vanzare?',
  'SALE_REMOVE_PROJECT_CONFIRM' => 'Sunteti sigur ca vreti sa stergeti aceasta vazanare din proiect?',
  'UPDATE' => 'Vanzari - Actualizare Moneda',
  'UPDATE_BUGFOUND_COUNT' => 'Probleme gasite:',
  'UPDATE_BUG_COUNT' => 'Probleme gasite si incercate sa fie rezolvate',
  'UPDATE_COUNT' => 'Inregistrari actualizate',
  'UPDATE_CREATE_CURRENCY' => 'Creaza moneda noua',
  'UPDATE_DOLLARAMOUNTS' => 'Update Sume Dolari U. S.',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Actualizaţi sumele pentru dolarul american pentru vânzări pe baza ratelor actuale valutar stabilite. Această valoare este folosită pentru a calcula grafice şi Lista Vizualizare Sume valutare.',
  'UPDATE_DONE' => 'Terminat',
  'UPDATE_FAIL' => 'Nu au fost putut fi actualizate -',
  'UPDATE_FIX' => 'Sume fixe',
  'UPDATE_FIX_TXT' => 'Încercările de a rezolva orice sume incorecte, prin crearea unui zecimal valid din valoarea actuală. Orice sumă modificata este susţinuta în domeniul baza de date amount_backup . Dacă rulaţi acest anunţ şi observati probleme, nu-l rulaţi din nou fără restaurarea din backup, deoarece se poate suprascrie  cu noile date incorecte.',
  'UPDATE_INCLUDE_CLOSE' => 'Include si Inregistrarile Inchise',
  'UPDATE_MERGE' => 'Imbina monede',
  'UPDATE_MERGE_TXT' => 'Îmbina mai multe monede într-o monedă unică. Dacă există mai multe înregistrări monedă pentru aceeaşi monedă, imbina împreună. Acest lucru va imbina, de asemenea, monedele din toate celelalte module.',
  'UPDATE_NULL_VALUE' => 'Suma este NULA sabilind-o 0 -',
  'UPDATE_RESTORE' => 'Restabileste sume',
  'UPDATE_RESTORE_COUNT' => 'Inregistrari sume restaurate',
  'UPDATE_RESTORE_TXT' => 'Restabileste valoarea sumelor din valorile de rezerva create in timpul depanarii',
  'UPDATE_VERIFY' => 'Verifica sumele',
  'UPDATE_VERIFY_CURAMOUNT' => 'Cantitate suma:',
  'UPDATE_VERIFY_FAIL' => 'Verificare a inregistrarii esuata',
  'UPDATE_VERIFY_FIX' => 'Efectuand Depanare ne va da',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Suma Noua:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Moneda noua:',
  'UPDATE_VERIFY_TXT' => 'Verifică dacă valorile in suma de vânzări sunt valabile numerele zecimale  numai cu caractere numerice (0-9) şi numărul de zecimale (.)',
);

