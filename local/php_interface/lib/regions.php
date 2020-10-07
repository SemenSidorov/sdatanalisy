<?php

/**
 * Class Regions
 * Работа ѝ регионами
 */
class Regions
{
    /**
     * Метод возвращает текущий регион
     * @return int ID региона
     */
    public function getCurRegion()
    {

        if (REGION_TYPE == 'DOMAIN') {
            // берем за основу поддомен
            $domain = str_replace(SITE_SERVER_NAME, '', $_SERVER['HTTP_HOST']);
            $domain = trim(str_replace(':80', '', $domain), '.');
        } else {
            // берем за основу session и get
            if (!isset($_SESSION['region'])) $_SESSION['region'] = '';
            if (isset($_POST['region'])) {
                $_SESSION['region'] = $_POST['region'];
            }
            $regions = Regions::getAllRegions();
            $domain = $regions[$_SESSION['region']]['CODE'];
        }

        $cache = new CPHPCache;
        if ($cache->StartDataCache(60 * 60 * 24, $domain, "/regions/") && CModule::IncludeModule('iblock')) {
            $filter = array("IBLOCK_ID" => IntVal(IB_REGIONS_ID), "ACTIVE" => "Y");
            if ($domain) {
                $filter['CODE'] = $domain;
            } else {
                $filter['!PROPERTY_56'] = false;
            }
            $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "IBLOCK_ID"))->GetNext();
            if (count($res)) {
                $cache->EndDataCache($res['ID']);
                return $res['ID'];
            } else {
                // если у поддомена нет региона - редирект на основной домен
                if ($domain) {
                    $cache->EndDataCache(0);
                    LocalRedirect('//' . SITE_SERVER_NAME . $_SERVER['REQUEST_URI'], true, "301 Moved permanently");
                }
            }
        } else {
            $return = $cache->GetVars();
            // если у поддомена нет региона - редирект на основной домен
            if (!$return) {
                LocalRedirect('//' . SITE_SERVER_NAME . $_SERVER['REQUEST_URI'], true, "301 Moved permanently");
            }
            return $return;
        }
    }

    /**
     * Возвращает массив с данными всех активных регионов
     * @return array
     */
    public function getAllRegions()
    {
        $cache = new CPHPCache;
        $items = array();
        if (CModule::IncludeModule('iblock')) {
            if ($cache->StartDataCache(60 * 60 * 24)) {
                $items = array();
                $res = CIBlockElement::GetList(array("SORT" => "ASC", "NAME" => "ASC"), array("IBLOCK_ID" => IntVal(IB_REGIONS_ID), "ACTIVE" => "Y"), false, false, array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_56"));
                while ($item = $res->GetNext()) {
                    $items[$item['ID']] = $item;
                }
                $cache->EndDataCache($items);
            } else {
                $items = $cache->GetVars();
            }
        }
        return $items;
    }

    /**
     * Контролируем изменение элементов инфоблока
     * @returm true/false
     */
    public function checkOnElementChange(&$arFields)
    {
        if ($arFields['IBLOCK_ID'] != IB_REGIONS_ID) return true;

        // Дефолтным может быть только один. при сохранении нового предыдущий сбраcывается
        if ($arFields['PROPERTY_VALUES'][56][array_keys($arFields['PROPERTY_VALUES'][56])[0]]["VALUE"] && CModule::IncludeModule('iblock')) {
            $res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => IntVal(IB_REGIONS_ID), "ACTIVE" => "Y", "!PROPERTY_56" => false, "!ID" => $arFields['ID']), false, false, array("ID", "IBLOCK_ID"));
            while ($item = $res->GetNext()) {
                CIBlockElement::SetPropertyValueCode($item['ID'], 46, false);
            }
        }
        return true;
    }

    /**
     * Контролируем активность регионов при добавлении/изменении/удалении клиник
     * @return true/false
     */
    public function checkOnRegion(&$arFields)
    {
        if ($arFields['IBLOCK_ID'] != IB_CLINICS_ID) return true;

        if ($arFields['PROPERTY_VALUES'][4][array_keys($arFields['PROPERTY_VALUES'][4])[0]]["VALUE"] && CModule::IncludeModule('iblock')) {
            $el = new CIBlockElement;
            $res = Clinics::getClinicsToRegion();
            if (count($res) > 0) {
                // если клиники есть - регион активен
                $el->Update($arFields['PROPERTY_VALUES'][4][array_keys($arFields['PROPERTY_VALUES'][4])[0]]["VALUE"], array("ACTIVE" => "Y"));
            } else {
                // если клиник нет - регион неактивен
                $el->Update($arFields['PROPERTY_VALUES'][4][array_keys($arFields['PROPERTY_VALUES'][4])[0]]["VALUE"], array("ACTIVE" => "N"));
            }
        }
        return true;
    }
}
