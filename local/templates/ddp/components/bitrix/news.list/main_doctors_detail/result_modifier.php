<?php
$APPLICATION->AddHeadScript('https://api-maps.yandex.ru/2.1/?apikey='.YANDEX_API_KEY.'&lang=ru_RU');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/_html/Result/Scripts/map-points.js');

$arResult['REGIONS'] = Regions::getAllRegions();
//$city_id = Regions::getCurRegion();
//$ob_city = CIBLockElement::GetList(array('sort'=>'asc'), array('IBLOCK_ID'=>1, 'ID'=>$city_id), false, array("ID", "IBLOCK_ID", "NAME", "CODE"), false);
//$city = $ob_city->Fetch();
//print_r($city);

//$arResult['REGION']["ID"] = $city["ID"];
//$arResult['REGION']["CODE"] = $city["CODE"];
//$arResult['REGION']["NAME"] = $city["NAME"];
foreach ($arResult['ITEMS'] as $key => $item) {
    $arResult['ITEMS'][$key]['IMG'] = CFile::ResizeImageGet($item['DETAIL_PICTURE']['ID'], array("width" => 100, "height" => 100), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 75 );
}