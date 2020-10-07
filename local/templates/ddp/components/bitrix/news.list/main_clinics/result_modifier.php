<?php
$APPLICATION->AddHeadScript('https://api-maps.yandex.ru/2.1/?apikey='.YANDEX_API_KEY.'&lang=ru_RU');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/_html/Result/Scripts/map-points.js');

$arResult['REGIONS'] = Regions::getAllRegions();

foreach ($arResult['ITEMS'] as $key => $item) {
    $arResult['ITEMS'][$key]['IMG'] = CFile::ResizeImageGet($item['DETAIL_PICTURE']['ID'], array("width" => 100, "height" => 100), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 75 );
}