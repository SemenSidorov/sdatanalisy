<?php

// для фильтра по году

    // Запрос данных и формирование массива $arResult
    $arResult['years'] = array();
    $arSelect = Array("ID", "NAME", "CODE", "IBLOCK_ID", "DATE_CREATE", "ACTIVE_FROM");
    $arFilter = Array("IBLOCK_ID"=>6, "ACTIVE"=>"Y" );
    $res = CIBlockElement::GetList(Array("ACTIVE_FROM"=>"ASC"), $arFilter, $arSelect, false);
    while($item = $res->Fetch())
    {
		
        $year = FormatDate("Y", MakeTimeStamp($item['ACTIVE_FROM'], CSite::GetDateFormat()));
        $arResult['years'][$year] = $year;
		
    }
	//print_r($arResult['years']);
    krsort($arResult['years']);
    
	


foreach ($arResult['ITEMS'] as  $key => $arItem)
{
 // дата
   $arResult["ITEMS"][$key]['DISPLAY_DATE'] = CIBlockFormatProperties::DateFormat('d f', MakeTimeStamp($arItem['ACTIVE_FROM'], CSite::GetDateFormat()));
   // время
   $arResult["ITEMS"][$key]['DISPLAY_TIME'] = CIBlockFormatProperties::DateFormat('H:i', MakeTimeStamp($arItem['ACTIVE_FROM'], CSite::GetDateFormat()));
   // год
   $arResult["ITEMS"][$key]['DISPLAY_YEAR'] = CIBlockFormatProperties::DateFormat('Y', MakeTimeStamp($arItem['ACTIVE_FROM'], CSite::GetDateFormat()));
}
//$arResult['title'] = $APPLICATION->GetTitle();
