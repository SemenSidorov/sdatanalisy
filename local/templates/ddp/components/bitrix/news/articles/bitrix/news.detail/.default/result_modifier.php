<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


   // ����
   $arResult['DISPLAY_DATE'] = CIBlockFormatProperties::DateFormat('d f', MakeTimeStamp($arResult['ACTIVE_FROM'], CSite::GetDateFormat()));
   // �����
   $arResult['DISPLAY_TIME'] = CIBlockFormatProperties::DateFormat('H:i', MakeTimeStamp($arResult['ACTIVE_FROM'], CSite::GetDateFormat()));
   // ���
   $arResult['DISPLAY_YEAR'] = CIBlockFormatProperties::DateFormat('Y', MakeTimeStamp($arResult['ACTIVE_FROM'], CSite::GetDateFormat()));

?> 