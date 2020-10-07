<?php
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/vue.js');
// $APPLICATION->AddHeadScript('https://cdn.jsdelivr.net/npm/vue/dist/vue.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/axios.min.js');

$arResult['ITEMS'] = array();

$items = Favorites::getFavoriteClinics();
if (count($items)) {
    $filter = array(
        "IBLOCK_ID" => IntVal(IB_CLINICS_ID),
        "ACTIVE" => "Y",
        "ID" => $items,
    );
    $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "NAME", "CODE", "PROPERTY_23"));
    while ($item = $res->GetNext()) {
        $arResult['ITEMS'][] = array(
            'id'        => $item['ID'],
            'link'      => '/clinics/'.$item['CODE'].'/',
            'adress'    => $item['PROPERTY_23_VALUE'],
        );
    }
}
