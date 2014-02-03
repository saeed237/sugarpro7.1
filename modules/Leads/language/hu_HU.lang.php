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
  'ERR_DELETE_RECORD' => 'Adjon meg egy azonosítót az ajánlás törléséhez!',
  'LBL_ACCOUNT_DESCRIPTION' => 'Kliens leírása',
  'LBL_ACCOUNT_ID' => 'Kliensazonosító',
  'LBL_ACCOUNT_NAME' => 'Kliensnév:',
  'LBL_ACTIVITIES_COPY' => 'Feladatok másolása ide:',
  'LBL_ACTIVITIES_COPY_HELP' => 'Válassza ki azt a rekordot, amelyhez másolással hozzá kívánja rendelni az Ajánlás feladatait! Az új feladatok, hívások, találkozók és jegyzetek másolatai a kijelölt rekordhoz lesznek hozzárendelve. A rendszer az emaileket a megadott rekordhoz fogja kapcsolni.',
  'LBL_ACTIVITIES_MOVE' => 'Több feladat ehhez:',
  'LBL_ACTIVITIES_MOVE_HELP' => 'Válassza ki azt a rekordot, amelyhez hozzá kívánja rendelni az Ajánlás feladatait! A hívások, találkozók, jegyzetek és emailek mind a kijelölt rekordhoz lesznek hozzárendelve.',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Tevékenységek',
  'LBL_ADDRESS_INFORMATION' => 'Cím információ',
  'LBL_ADD_BUSINESSCARD' => 'Névjegykártya hozzáadása',
  'LBL_ALTERNATE_ADDRESS' => 'Egyéb cím:',
  'LBL_ALT_ADDRESS' => 'Egyéb cím:',
  'LBL_ALT_ADDRESS_CITY' => 'Másodlagos cím, város:',
  'LBL_ALT_ADDRESS_COUNTRY' => 'Másodlagos cím, ország:',
  'LBL_ALT_ADDRESS_POSTALCODE' => 'Másodlagos cím, irányítószám:',
  'LBL_ALT_ADDRESS_STATE' => 'Másodlagos cím, állam:',
  'LBL_ALT_ADDRESS_STREET' => 'Másodlagos cím',
  'LBL_ALT_ADDRESS_STREET_2' => 'Másodlagos cím, utca 2:',
  'LBL_ALT_ADDRESS_STREET_3' => 'Másodlagos cím, utca 3:',
  'LBL_ANY_ADDRESS' => 'Bármilyen cím:',
  'LBL_ANY_EMAIL' => 'Bármilyen email:',
  'LBL_ANY_PHONE' => 'Bármilyen telefon:',
  'LBL_ASSIGNED_TO_ID' => 'Felelős felhasználó:',
  'LBL_ASSIGNED_TO_NAME' => 'Felelős:',
  'LBL_ASSISTANT' => 'Aszisztens',
  'LBL_ASSISTANT_PHONE' => 'Aszisztens telefonja',
  'LBL_BACKTOLEADS' => 'Vissza az ajánlásokhoz',
  'LBL_BIRTHDATE' => 'Születési dátum:',
  'LBL_BUSINESSCARD' => 'Ajánlás konvertálása',
  'LBL_CAMPAIGN' => 'Kampány:',
  'LBL_CAMPAIGNS' => 'Kampányok',
  'LBL_CAMPAIGNS_SUBPANEL_TITLE' => 'Kampányok',
  'LBL_CAMPAIGN_ID' => 'Kampány azonosító',
  'LBL_CAMPAIGN_LEAD' => 'Kampányok',
  'LBL_CAMPAIGN_LIST_SUBPANEL_TITLE' => 'Kampányok',
  'LBL_CITY' => 'Város:',
  'LBL_CLICK_TO_RETURN' => 'Vissza a Portálba',
  'LBL_CONTACT' => 'Ajánlás:',
  'LBL_CONTACT_ID' => 'Kapcsolat azonosító',
  'LBL_CONTACT_INFORMATION' => 'Ajánlás áttekintése',
  'LBL_CONTACT_NAME' => 'Ajánlás neve:',
  'LBL_CONTACT_OPP_FORM_TITLE' => 'Ajánlás-lehetőség:',
  'LBL_CONTACT_ROLE' => 'Szerepkör:',
  'LBL_CONVERTED' => 'Konvertált',
  'LBL_CONVERTED_ACCOUNT' => 'Konvertált kliens:',
  'LBL_CONVERTED_CONTACT' => 'Konvertált kapcsolat:',
  'LBL_CONVERTED_OPP' => 'Konvertált lehetőség:',
  'LBL_CONVERTLEAD' => 'Ajánlás konvertálása',
  'LBL_CONVERTLEAD_BUTTON_KEY' => 'V',
  'LBL_CONVERTLEAD_TITLE' => 'Ajánlás konvertálása',
  'LBL_CONVERTLEAD_WARNING' => 'Figyelem: a konvertálni kívánt ajánlás állapota jelenleg is konvertált. Elképzelhető, hogy az ajánlásból kapcsolati vagy kliens adatokat tárolt el a rendszer. Ha így is folytatni szeretné a konvertálás folyamatát, kattintson a Mentés gombra! Az ajánláshoz való visszatéréshez nyomja meg a Mégsem gombot.',
  'LBL_CONVERTLEAD_WARNING_INTO_RECORD' => 'Lehetséges kapcsolat:',
  'LBL_CONVERT_ADD_MODULE' => 'Modul hozzáadása',
  'LBL_CONVERT_COPY' => 'Adat másolása',
  'LBL_CONVERT_DELETE' => 'Törlés',
  'LBL_CONVERT_EDIT' => 'Szerkeszt',
  'LBL_CONVERT_EDIT_LAYOUT' => 'Konvertálási felület szerkesztése',
  'LBL_CONVERT_MODULE_NAME' => 'Modul',
  'LBL_CONVERT_MODULE_NAME_SINGULAR' => 'Modul',
  'LBL_CONVERT_REQUIRED' => 'Szükséges',
  'LBL_CONVERT_SELECT' => 'Kiválasztás engedélyezése',
  'LBL_COPY_TIP' => 'Ha be van jelölve, a rendszer az ajánlásokban lévő mezőkről készít egy másolatot ugyanazzal a névvel az újonnan létrehozott rekordokban.',
  'LBL_COUNTRY' => 'Ország:',
  'LBL_CREATE' => 'Létrehoz',
  'LBL_CREATED' => 'Létrehozta',
  'LBL_CREATED_ACCOUNT' => 'Új kliens létrehozva',
  'LBL_CREATED_CALL' => 'Új hívás létrehozva',
  'LBL_CREATED_CONTACT' => 'Új kapcsolat létrehozva',
  'LBL_CREATED_ID' => 'Létrehozó azonosítója',
  'LBL_CREATED_MEETING' => 'Új találkozó létrehozva',
  'LBL_CREATED_NEW' => 'Létrehozva egy új',
  'LBL_CREATED_OPPORTUNITY' => 'Új lehetőség létrehozva',
  'LBL_CREATED_USER' => 'Felhasználó létrehozva',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Ajánlások',
  'LBL_DELETE_TIP' => 'Távolítsa el ezt a modult a konvertálási elrendezésből!',
  'LBL_DEPARTMENT' => 'Részleg:',
  'LBL_DESCRIPTION' => 'Leírás:',
  'LBL_DESCRIPTION_INFORMATION' => 'Leírás információ',
  'LBL_DO_NOT_CALL' => 'Nem hívható:',
  'LBL_DUPLICATE' => 'Hasonló ajánlások',
  'LBL_EDITLAYOUT' => 'Elrendezés szerkesztése',
  'LBL_EDIT_INLINE' => 'Szerkeszt',
  'LBL_EDIT_TIP' => 'Módosítsa a konvertálási elrendezést ebben a modulban!',
  'LBL_EMAIL_ADDRESS' => 'Email cím:',
  'LBL_EMAIL_OPT_OUT' => 'Leiratkozás:',
  'LBL_ENTERDATE' => 'Írja be a dátumot',
  'LBL_EXISTING_ACCOUNT' => 'Egy létező klienst használt',
  'LBL_EXISTING_CONTACT' => 'Egy létező kapcsolat használt',
  'LBL_EXISTING_OPPORTUNITY' => 'Egy létező lehetőséget használt',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Felelős felhasználó azonosítója',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Felelős felhasználó',
  'LBL_EXPORT_CREATED_BY' => 'Létrehozó azonosítója',
  'LBL_EXPORT_EMAIL2' => 'További email címek',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Módosító azonosítója',
  'LBL_EXPORT_PHONE_MOBILE' => 'Mobiltelefon',
  'LBL_FAX_PHONE' => 'Fax:',
  'LBL_FIRST_NAME' => 'Keresztnév:',
  'LBL_FULL_NAME' => 'Teljes név:',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Előzmények',
  'LBL_HOME_PHONE' => 'Otthoni telefon:',
  'LBL_IMPORT_VCARD' => 'vCard betöltése',
  'LBL_IMPORT_VCARDTEXT' => 'Automatikusan hozzon létre egy ajánlást vCard fájlrendszerből történő importálása során.',
  'LBL_INVALID_EMAIL' => 'Érvénytelen email:',
  'LBL_INVITEE' => 'Közvetlen jelentések',
  'LBL_LAST_NAME' => 'Vezetéknév:',
  'LBL_LEAD_SOURCE' => 'Ajánlás forrása:',
  'LBL_LEAD_SOURCE_DESCRIPTION' => 'Ajánlás forrásának leírása:',
  'LBL_LIST_ACCEPT_STATUS' => 'Elfogadás státusza',
  'LBL_LIST_ACCOUNT_NAME' => 'Kliensnév',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Felelős felhasználó',
  'LBL_LIST_CONTACT_NAME' => 'Ajánlás neve',
  'LBL_LIST_CONTACT_ROLE' => 'Szerepkör',
  'LBL_LIST_DATE_ENTERED' => 'Létrehozás dátuma',
  'LBL_LIST_EMAIL_ADDRESS' => 'Email',
  'LBL_LIST_FIRST_NAME' => 'Keresztnév',
  'LBL_LIST_FORM_TITLE' => 'Ajánláslista',
  'LBL_LIST_LAST_NAME' => 'Vezetéknév',
  'LBL_LIST_LEAD_SOURCE' => 'Ajánlás forrása',
  'LBL_LIST_LEAD_SOURCE_DESCRIPTION' => 'Ajánlás forrásának leírása',
  'LBL_LIST_MY_LEADS' => 'Saját ajánlásaim',
  'LBL_LIST_NAME' => 'Név',
  'LBL_LIST_PHONE' => 'Irodai telefon',
  'LBL_LIST_REFERED_BY' => 'Hivatkozva',
  'LBL_LIST_STATUS' => 'Állapot',
  'LBL_LIST_TITLE' => 'Beosztás',
  'LBL_LOADING' => 'Betöltés',
  'LBL_MESSAGE' => 'Kérjük, adja meg az alábbi adatokat! Az információk/kliens véglegesítéséhez szükség lesz az Ön jóváhagyására.',
  'LBL_MOBILE_PHONE' => 'Mobil:',
  'LBL_MODIFIED' => 'Módosította',
  'LBL_MODIFIED_ID' => 'Módosító azonosítója',
  'LBL_MODIFIED_USER' => 'Felhasználó módosítva',
  'LBL_MODULE_NAME' => 'Ajánlások',
  'LBL_MODULE_NAME_SINGULAR' => 'Ajánlás',
  'LBL_MODULE_TIP' => 'Modul az új rekord létrehozásához.',
  'LBL_MODULE_TITLE' => 'Ajánlások: Főoldal',
  'LBL_NAME' => 'Név:',
  'LBL_NEW_FORM_TITLE' => 'Új ajánlás',
  'LBL_NEW_PORTAL_PASSWORD' => 'Új portál jelszó:',
  'LBL_NOTICE_OLD_LEAD_CONVERT_OVERRIDE' => 'Megjegyzés: az aktuális ajánlás konvertálása-nézet egyéni mezőket tartalmaz. Amikor ezt a megjelenítést szerkeszti a Stúdióban, egyéni mezőket kell hozzáadnia. A korábbiakkal ellentétben, ezek a mezők nem fognak automatikusan megjelenni az elrendezésben.',
  'LBL_OFFICE_PHONE' => 'Irodai telefon:',
  'LBL_OPPORTUNITY_AMOUNT' => 'Lehetőség összege:',
  'LBL_OPPORTUNITY_ID' => 'Lehetőség azonosítója',
  'LBL_OPPORTUNITY_NAME' => 'Lehetőség neve:',
  'LBL_OPP_NAME' => 'Lehetőség neve:',
  'LBL_OTHER_EMAIL_ADDRESS' => 'Egyéb email:',
  'LBL_OTHER_PHONE' => 'Egyéb telefon:',
  'LBL_PHONE' => 'Telefon:',
  'LBL_PHONE_FAX' => 'Fax',
  'LBL_PHONE_HOME' => 'Otthoni telefon',
  'LBL_PHONE_MOBILE' => 'Mobiltelefon',
  'LBL_PHONE_OTHER' => 'Egyéb telefon',
  'LBL_PHONE_WORK' => 'Munkahelyi telefon',
  'LBL_PORTAL_ACTIVE' => 'Portál aktív:',
  'LBL_PORTAL_APP' => 'Portál alkalmazás',
  'LBL_PORTAL_INFORMATION' => 'Portál információ',
  'LBL_PORTAL_NAME' => 'Portál neve:',
  'LBL_PORTAL_PASSWORD_ISSET' => 'Portál jelszó beállítva:',
  'LBL_POSTAL_CODE' => 'Irányítószám:',
  'LBL_PRIMARY_ADDRESS' => 'Elsődleges cím:',
  'LBL_PRIMARY_ADDRESS_CITY' => 'Elsődleges cím, város',
  'LBL_PRIMARY_ADDRESS_COUNTRY' => 'Elsődleges cím, ország',
  'LBL_PRIMARY_ADDRESS_POSTALCODE' => 'Elsődleges cím, irányítószám',
  'LBL_PRIMARY_ADDRESS_STATE' => 'Elsődleges cím, állam',
  'LBL_PRIMARY_ADDRESS_STREET' => 'Elsődleges cím, utca',
  'LBL_PRIMARY_ADDRESS_STREET_2' => 'Elsődleges cím, utca 2',
  'LBL_PRIMARY_ADDRESS_STREET_3' => 'Elsődleges cím, utca 3',
  'LBL_PROSPECT_LIST' => 'Lehetséges vevő lista',
  'LBL_REFERED_BY' => 'Hivatkozva:',
  'LBL_REGISTRATION' => 'Regisztráció',
  'LBL_REPORTS_FROM' => 'Jelentés innen:',
  'LBL_REPORTS_TO' => 'Jelentést tesz neki:',
  'LBL_REPORTS_TO_ID' => 'Felettes azonosítója',
  'LBL_REQUIRED_TIP' => 'A kötelező modulokat létre kell hozni vagy a meglévőkből ki kell választani, mielőtt az ajánlást konvertálni lehetne.',
  'LBL_SALUTATION' => 'Megszólítás',
  'LBL_SAVED' => 'Köszönjük a regisztrációt! Fiókját hamarosan létrehozzuk és felvesszük Önnel a kapcsolatot.',
  'LBL_SEARCH_FORM_TITLE' => 'Ajánlás keresése',
  'LBL_SELECT' => 'VAGY válassza ki',
  'LBL_SELECTION_TIP' => 'A kapcsolati információkkal rendelkező modulokat az ajánlás konvertálása során ki lehet választani; azokat nem kell létrehozni.',
  'LBL_SELECT_CHECKED_BUTTON_LABEL' => 'Ellenőrzött ajánlások kiválasztása',
  'LBL_SELECT_CHECKED_BUTTON_TITLE' => 'Ellenőrzött ajánlások kiválasztása',
  'LBL_SERVER_IS_CURRENTLY_UNAVAILABLE' => 'Sajnálatos módon a szerver jelenleg nem elérhető, kérem, próbálja meg később!',
  'LBL_STATE' => 'Állam:',
  'LBL_STATUS' => 'Állapot:',
  'LBL_STATUS_DESCRIPTION' => 'Állapot leírása:',
  'LBL_STREET' => 'Utca',
  'LBL_TARGET_BUTTON_KEY' => 'T',
  'LBL_TARGET_BUTTON_LABEL' => 'Célzott',
  'LBL_TARGET_BUTTON_TITLE' => 'Célzott',
  'LBL_TARGET_OF_CAMPAIGNS' => 'Sikeres kampány',
  'LBL_THANKS_FOR_SUBMITTING_LEAD' => 'Köszönjük az ajánlat beküldését.',
  'LBL_TITLE' => 'Beosztás:',
  'LBL_VCARD' => 'vCard',
  'LBL_VIEW_FORM_TITLE' => 'Ajánlás nézet',
  'LBL_WEBSITE' => 'Honlap',
  'LNK_IMPORT_LEADS' => 'Ajánlások importálása',
  'LNK_IMPORT_VCARD' => 'Ajánlás létrehozása vCard állományból',
  'LNK_LEAD_LIST' => 'Ajánlások megtekintése',
  'LNK_LEAD_REPORTS' => 'Ajánlás jelentések megtekintése',
  'LNK_NEW_ACCOUNT' => 'Kliens létrehozása',
  'LNK_NEW_APPOINTMENT' => 'Találkozó létrehozása',
  'LNK_NEW_CALL' => 'Hívás naplózása',
  'LNK_NEW_CASE' => 'Eset létrehozása',
  'LNK_NEW_CONTACT' => 'Kapcsolat létrehozása',
  'LNK_NEW_LEAD' => 'Ajánlás létrehozása',
  'LNK_NEW_MEETING' => 'Találkozó ütemezése',
  'LNK_NEW_NOTE' => 'Jegyzet létrehozása',
  'LNK_NEW_OPPORTUNITY' => 'Lehetőség létrehozása',
  'LNK_NEW_TASK' => 'Feladat létrehozása',
  'LNK_SELECT_ACCOUNTS' => 'VAGY válasszon klienst',
  'LNK_SELECT_CONTACTS' => '<b>VAGY</b> kapcsolat kiválasztása',
  'NTC_COPY_ALTERNATE_ADDRESS' => 'Másodlagos cím másolása az elsődleges címbe',
  'NTC_COPY_PRIMARY_ADDRESS' => 'Elsődleges cím másolása a másodlagos címbe',
  'NTC_DELETE_CONFIRMATION' => 'Biztosan törölni kívánja ezt a rekordot?',
  'NTC_OPPORTUNITY_REQUIRES_ACCOUNT' => 'Ajánlás létrehozásához rendelkezni kell egy klienssel.\\n Kérem, hozzon létre egy új klienst, vagy válasszon a meglévők közül!',
  'NTC_REMOVE_CONFIRMATION' => 'Biztosan el akarja távolítani az ajánlást az esettől?',
  'NTC_REMOVE_DIRECT_REPORT_CONFIRMATION' => 'Biztosan el akarja távolítani ezt a közvetlen jelentést?',
  'db_account_name' => 'LBL_LIST_ACCOUNT_NAME',
  'db_email1' => 'LBL_LIST_EMAIL_ADDRESS',
  'db_email2' => 'LBL_LIST_EMAIL_ADDRESS',
  'db_first_name' => 'LBL_LIST_FIRST_NAME',
  'db_last_name' => 'LBL_LIST_LAST_NAME',
  'db_title' => 'LBL_LIST_TITLE',
);

