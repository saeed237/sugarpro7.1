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
  'ERR_DELETE_RECORD' => 'Um número de registo deve ser especificado para eliminar a venda.',
  'LBL_ACCOUNT_ID' => 'ID Entidade',
  'LBL_ACCOUNT_NAME' => 'Nome da Entidade:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
  'LBL_AMOUNT' => 'Valor:',
  'LBL_AMOUNT_USDOLLAR' => 'Valor em USD:',
  'LBL_ASSIGNED_TO_ID' => 'Atribuído a',
  'LBL_ASSIGNED_TO_NAME' => 'Atribuído a:',
  'LBL_CAMPAIGN' => 'Campanha:',
  'LBL_CLOSED_WON_SALES' => 'Vendas Fechadas Ganhas',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
  'LBL_CREATED_ID' => 'ID Criado por',
  'LBL_CURRENCY' => 'Moeda:',
  'LBL_CURRENCY_ID' => 'ID Moeda',
  'LBL_CURRENCY_NAME' => 'Nome da Moeda',
  'LBL_CURRENCY_SYMBOL' => 'Símbolo da Moeda',
  'LBL_DATE_CLOSED' => 'Data de Fecho Esperada:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Venda',
  'LBL_DESCRIPTION' => 'Descrição:',
  'LBL_DUPLICATE' => 'Venda Possivelmente Duplicada',
  'LBL_EDIT_BUTTON' => 'Editar',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Histórico',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Leads',
  'LBL_LEAD_SOURCE' => 'Origem da Lead:',
  'LBL_LIST_ACCOUNT_NAME' => 'Nome da Entidade',
  'LBL_LIST_AMOUNT' => 'Valor',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Utilizador',
  'LBL_LIST_DATE_CLOSED' => 'Fechar',
  'LBL_LIST_FORM_TITLE' => 'Lista de Venda',
  'LBL_LIST_SALE_NAME' => 'Nome',
  'LBL_LIST_SALE_STAGE' => 'Fase da Venda',
  'LBL_MODIFIED_ID' => 'ID Modificado por',
  'LBL_MODIFIED_NAME' => 'Nome de Utilizador Modificado por',
  'LBL_MODULE_NAME' => 'Venda',
  'LBL_MODULE_TITLE' => 'Venda: Ecrã Principal',
  'LBL_MY_CLOSED_SALES' => 'As Minhas Vendas Fechadas',
  'LBL_NAME' => 'Nome da Venda',
  'LBL_NEW_FORM_TITLE' => 'Criar Venda',
  'LBL_NEXT_STEP' => 'Próximo Passo:',
  'LBL_PROBABILITY' => 'Probabilidade (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projectos',
  'LBL_RAW_AMOUNT' => 'Valor Bruto',
  'LBL_REMOVE' => 'Remover',
  'LBL_SALE' => 'Venda:',
  'LBL_SALES_STAGE' => 'Fase da Venda:',
  'LBL_SALE_INFORMATION' => 'Informação de Venda',
  'LBL_SALE_NAME' => 'Nome da Venda:',
  'LBL_SEARCH_FORM_TITLE' => 'Pesquisa de Venda',
  'LBL_TEAM_ID' => 'ID Equipa',
  'LBL_TOP_SALES' => 'A Minha Maior Venda em Aberto',
  'LBL_TOTAL_SALES' => 'Vendas Totais',
  'LBL_TYPE' => 'Tipo:',
  'LBL_VIEW_FORM_TITLE' => 'Ver Venda',
  'LNK_NEW_SALE' => 'Criar Venda',
  'LNK_SALE_LIST' => 'Venda',
  'MSG_DUPLICATE' => 'O registo de Venda que está prestes a criar pode ser um duplicado de um registo de venda já existente. Os registos de Venda contendo nomes semelhantes estão listados abaixo. <br>Clique em Gravar para continuar a criar esta nova Venda, ou clique em Cancelar para voltar ao módulo sem criar a venda.',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Tem a certeza que pretende remover este contacto da venda?',
  'SALE_REMOVE_PROJECT_CONFIRM' => 'Tem a certeza que pretende remover esta venda do projecto?',
  'UPDATE' => 'Venda - Actualização de Moeda',
  'UPDATE_BUGFOUND_COUNT' => 'Bugs Encontrados:',
  'UPDATE_BUG_COUNT' => 'Bugs Encontrados Alvo de Tentativa de Resolução:',
  'UPDATE_COUNT' => 'Registos Actualizados:',
  'UPDATE_CREATE_CURRENCY' => 'Criando Nova Moeda:',
  'UPDATE_DOLLARAMOUNTS' => 'Actualizar Valores em U.S. Dollar',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Actualiza os valores em U.S. Dollar para vendas baseados nas taxas de câmbio actuais. Este valor é utilizado para calcular Gráficos e Listas de Valores de Moeda.',
  'UPDATE_DONE' => 'Concluído',
  'UPDATE_FAIL' => 'Não foi possível actualizar -',
  'UPDATE_FIX' => 'Corrigir Valores',
  'UPDATE_FIX_TXT' => 'Tenta corrigir quaisquer valores inválidos criando um decimal válido a partir do valor actual. Qualquer valor alterado é registado no campo amount_backup da base de dados. Se executar esta tarefa e encontrar erros, não volte a executá-la sem restaurar a partir do backup, pois pode substituir o backup com novos dados inválidos.',
  'UPDATE_INCLUDE_CLOSE' => 'Incluir Registos Fechados',
  'UPDATE_MERGE' => 'Fundir Moedas',
  'UPDATE_MERGE_TXT' => 'Fundir múltiplas moedas numa única moeda. Se houver múltiplos registos para a mesma moeda, irá fundi-los num só. Isto irá fundir igualmente as moedas para todos os outros módulos.',
  'UPDATE_NULL_VALUE' => 'Valor é NULO definindo-o para 0 -',
  'UPDATE_RESTORE' => 'Restaurar Valores',
  'UPDATE_RESTORE_COUNT' => 'Valores de Registo Restaurados:',
  'UPDATE_RESTORE_TXT' => 'Restaura valores a partir dos backups criados durante a correcção.',
  'UPDATE_VERIFY' => 'Verificar Valores',
  'UPDATE_VERIFY_CURAMOUNT' => 'Valor Actual:',
  'UPDATE_VERIFY_FAIL' => 'Falha na Verificação de Registo:',
  'UPDATE_VERIFY_FIX' => 'Correcção actual daria',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Novo Valor:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Nova Moeda:',
  'UPDATE_VERIFY_TXT' => 'Verifica se os valores de vendas são números decimais válidos com apenas caracteres numéricos (0-9) e decimais (.)',
);

