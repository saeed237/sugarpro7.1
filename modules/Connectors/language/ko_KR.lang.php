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
  'ERROR_EMPTY_RECORD_ID' => '오류:기록 ID가 명시되지 않았거나 비어있습니다.',
  'ERROR_EMPTY_SOURCE_ID' => '오류:출추ID가 명시되지 않았거나 비어있습니다.',
  'ERROR_EMPTY_WRAPPER' => '오류:출처로부터 예시 덮개를 복구할수 없습니다.',
  'ERROR_NO_ADDITIONAL_DETAIL' => '오류:기록을위한 추가 세부세항이 발견되지 않았습니다.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => '오류:이 모듈에 배치된 연결기가 없습니다.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => '오류:결과에 전시할 배치할 모듈 필드가 없습니다. 시스템 관리자에 문의하십시오.',
  'ERROR_NO_FIELDS_MAPPED' => '오류:최소 하나의 연결기 필드를 배치해야합니다.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => '이 연결기를 위해 작동하는 모듈이 없습니다. 연결기 작동 페이지의 연결기의 모듈을 선택하십시오,',
  'ERROR_NO_SEARCHDEFS_MAPPED' => '오류:정의된 검색필드의 작동되는 연결기가 없습니다.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => '오류:모듈과 연결기를 위해 정의된 검색 필드가 없습니다.',
  'ERROR_NO_SOURCEDEFS_FILE' => '오류:sourcedefs.php 파일이 발견되지 않았습니다.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => '오루:어느 복구 데이타에서 명시된 출처가 없습니다.',
  'ERROR_RECORD_NOT_SELECTED' => '오류:진행하기전 목록에서 기록을 선택하십시오,',
  'LBL_ADDRCITY' => '시:',
  'LBL_ADDRCOUNTRY' => '국가:',
  'LBL_ADDRCOUNTRY_ID' => '국가ID',
  'LBL_ADDRSTATEPROV' => '도:',
  'LBL_ADD_MODULE' => '추가하기',
  'LBL_ADMINISTRATION' => '관리자 연결기',
  'LBL_ADMINISTRATION_MAIN' => '설정 연결기',
  'LBL_AVAILABLE' => '사용가능',
  'LBL_BACK' => '뒤로',
  'LBL_CLOSE' => '닫기',
  'LBL_COMPANY_ID' => '회사ID',
  'LBL_CONFIRM_CONTINUE_SAVE' => '몇몇의 필수 입력필드가 비어있습니다. 변경사항을 저장하십겠습니까?',
  'LBL_CONNECTOR' => '연결기',
  'LBL_CONNECTOR_FIELDS' => '필드 연결',
  'LBL_DATA' => '데이타',
  'LBL_DEFAULT' => '초기 설정',
  'LBL_DELETE_MAPPING_ENTRY' => '이 항목을 삭제하시겠습니까?',
  'LBL_DISABLED' => '중지',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => '검색기준에 일치하는 결과가 없습니다.',
  'LBL_ENABLED' => '작동',
  'LBL_EXTERNAL' => '외부 계정기록을 이 연결기에 새로 만들기위한 사용자 목록 작동하기',
  'LBL_EXTERNAL_SET_PROPERTIES' => '이 연결기를 사용하려면 연결기소유권 설정 페이지에서 소유권이 따로 설정 되어야합니다.',
  'LBL_FINSALES' => 'Finsales',
  'LBL_INFO_INLINE' => '정보',
  'LBL_MARKET_CAP' => '시장 상한',
  'LBL_MERGE' => '병합하기',
  'LBL_MODIFY_DISPLAY_DESC' => '각각의 연결기를 위한 작동 모듈을 선택하십시오',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => '연결기 설정: 연결기 작동',
  'LBL_MODIFY_DISPLAY_TITLE' => '연결기 작동',
  'LBL_MODIFY_MAPPING_DESC' => '어떠한 연결 데이타가 보여지고 모듈기록으로 통합될지 결정하기위한 모듈필드의 연결 필드를 배치합니다.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => '연결기 설정:연결 필드 배치',
  'LBL_MODIFY_MAPPING_TITLE' => '지도 연결 필드',
  'LBL_MODIFY_PROPERTIES_DESC' => 'URLs 과 API키를 포함한 각각의 연결기의 소유권 만들기',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => '연결기 설정: 연결기 소유권 설정',
  'LBL_MODIFY_PROPERTIES_TITLE' => '연결기 소유권 설정',
  'LBL_MODIFY_SEARCH' => '검색',
  'LBL_MODIFY_SEARCH_DESC' => '각 모듈의 데이타 검색에 사용할 연결기 필드를 선택합니다.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => '연결기 설정:연결기 검색 관리',
  'LBL_MODIFY_SEARCH_TITLE' => '연결기 검색 관리',
  'LBL_MODULE_FIELDS' => '모듈 필드',
  'LBL_MODULE_NAME' => '연결기',
  'LBL_MODULE_NAME_SINGULAR' => '연결기',
  'LBL_NO_PROPERTIES' => '이 연결기에는 구성가능한 소유권이 없습니다.',
  'LBL_PARENT_DUNS' => '상위 DUNS',
  'LBL_PREVIOUS' => '뒤로',
  'LBL_QUOTE' => '견적',
  'LBL_RECNAME' => '회사명:',
  'LBL_RESET_BUTTON_TITLE' => '재설정',
  'LBL_RESET_TO_DEFAULT' => '초기설정으로 재설정',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => '초기설정 구성을 재설정 하시겠습니까?',
  'LBL_RESULT_LIST' => '데이타 목록',
  'LBL_RUN_WIZARD' => '마법사 실행',
  'LBL_SAVE' => '저장하기',
  'LBL_SEARCHING_BUTTON_LABEL' => '검색중입니다...',
  'LBL_SHOW_IN_LISTVIEW' => '통합 목록보기에 보여주기',
  'LBL_SMART_COPY' => 'Smart Copy',
  'LBL_STEP1' => '검색 및 데이타 보기',
  'LBL_STEP2' => '기록 통합',
  'LBL_SUMMARY' => '개요',
  'LBL_TEST_SOURCE' => '연결기 테스트',
  'LBL_TEST_SOURCE_FAILED' => '테스트 실패',
  'LBL_TEST_SOURCE_RUNNING' => '테스트 실행중입니다.',
  'LBL_TEST_SOURCE_SUCCESS' => '테스트가 성공하였습니다.',
  'LBL_TITLE' => '데이타 통합',
  'LBL_ULTIMATE_PARENT_DUNS' => '최고 상위 DUNS',
);

