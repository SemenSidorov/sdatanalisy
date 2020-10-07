<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (isset($_REQUEST['q'])) {
    if ($_REQUEST['q']) {
        $APPLICATION->SetTitle('Вы искали «' . $_REQUEST['q'] . '»');
    }
}

if (count($arResult["SEARCH"])) {

    // собрираем данные об инфоблоках
    $arResult['IBS'] = array();
    $res = CIBlock::GetList(Array(), Array('SITE_ID'=>SITE_ID, 'ACTIVE'=>'Y'));
    while($ar_res = $res->Fetch()) {
        $arResult['IBS'][$ar_res['ID']] = $ar_res['NAME'];
    }

    // сортируем результаты по инфоблокам
    $ar_rep = array(
        '<b>' => '<span class="search-result__marker">',
        '</b>' => '</span>'
    );
    $items = $arResult["SEARCH"];
    $arResult["SEARCH"] = array();

    foreach ($items as $item) {
        if ($item['MODULE_ID'] == 'iblock') {
            switch ($item['PARAM2']) {
                case IB_ANALYZES_ID: // анализ
                    if (preg_match('~S(\d)~', $item['ITEM_ID'], $math)) {
                        $item['PRICE'] = Analyzes::getMinPriceSectionToRegion($math[1]);
                    } else {
                        $item['PRICE'] = Analyzes::getMinPriceToRegion($item['ITEM_ID']);
                    }
                    if (!$item['PRICE']) continue; // если нет цены - не выводим в результатах поиска
                    $item['TITLE_FORMATED'] = str_replace(array_keys($ar_rep), array_values($ar_rep), $item['TITLE_FORMATED']);
                    break;
                case IB_SERVICES_ID: // анализ
                    if (preg_match('~S(\d)~', $item['ITEM_ID'], $math)) {
                        $item['PRICE'] = Services::getMinPriceSectionToRegion($math[1]);
                    } else {
                        $item['PRICE'] = Services::getMinPriceToRegion($item['ITEM_ID']);
                    }
                    if (!$item['PRICE']) continue; // если нет цены - не выводим в результатах поиска
                    $item['TITLE_FORMATED'] = str_replace(array_keys($ar_rep), array_values($ar_rep), $item['TITLE_FORMATED']);
                    break;
                case IB_DOCTORS_ID: // доктор
                    if (preg_match('~S(\d)~', $item['ITEM_ID'], $math)) {
                        $items = Doctors::getDoctorsSectionToRegion($math[1]);
                        foreach ($items as $item) {
                            $arResult["SEARCH"][$item['PARAM2']][] = $item;
                        }
                        continue;
                    } else {
                        $item = array_merge(Doctors::getDoctorToRegion($item['ITEM_ID']), $item);
                    }
                    break;
                case IB_ARTICLES_ID: // статья
                    if ($item['TITLE_FORMATED'] != $item['TITLE']) {
                        $item['BODY_FORMATED'] = '';
                    }
                    break;
            }
            $item['TITLE_FORMATED'] = str_replace(array_keys($ar_rep), array_values($ar_rep), $item['TITLE_FORMATED']);
            $item['BODY_FORMATED'] = str_replace(array_keys($ar_rep), array_values($ar_rep), $item['BODY_FORMATED']);
            $arResult["SEARCH"][$item['PARAM2']][] = $item;
        } /*else {
            $arResult["SEARCH"][0][] = $item;
        }*/
    }
//    $arResult["SEARCH"][IB_DOCTORS_ID] = Doctors::getDoctorsSectionToRegion(3);
}
