<?php

/**
 * Класс для работы с клиниками
 * Class Clinics
 */
class Clinics
{
    /**
     * Метод возвращает ID активных клиник для региона
     * @return array
     */
    public function getClinicsToRegion()
    {
        $return = array();
        $region = Regions::getCurRegion();
        $cache = new CPHPCache;
        if ($cache->StartDataCache(60 * 60 * 24, 'items_ids_'.$region, "/clinics/") && CModule::IncludeModule('iblock')) {
            $filter =  Array(
                "IBLOCK_ID"=>IntVal(IB_CLINICS_ID),
                "ACTIVE"=>"Y",
                "PROPERTY_CITY.ID"=>$region,
            );
            $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "IBLOCK_ID"));
            while ($item = $res->GetNext()) {
                $return[] = $item['ID'];
            }
        } else {
            $return = $cache->GetVars();
        }
        return $return;
    }

    /**
     * Метод возвращает клиники региона
     * @return array
     */
    public function getItemsToRegion()
    {
        $return = array();
        $region = Regions::getCurRegion();
        $cache = new CPHPCache;
        if ($cache->StartDataCache(60 * 60 * 24, 'items_'.$region, "/clinics/") && CModule::IncludeModule('iblock')) {
            $filter = array(
                "IBLOCK_ID" => IntVal(IB_CLINICS_ID),
                "ACTIVE" => "Y",
                "PROPERTY_CITY.ID" => $region,
            );
            $res = CIBlockElement::GetList(array("NAME"=>"ASC"), $filter, false, false, array('ID', 'IBLOCK_ID', 'NAME', 'DETAIL_PAGE_URL'));
            while ($item = $res->GetNext()) {
                $return[] = $item;
            }
            $cache->EndDataCache($return);
        } else {
            $return = $cache->GetVars();
        }
        return $return;
    }

    /**
     * Метод получает координаты клиники при ее создани/редактировании
     */
    public function setClinicCoord(&$arFields)
    {
        if ($arFields['IBLOCK_ID'] != IB_CLINICS_ID) return true;

        $addr = trim($arFields['PROPERTY_VALUES'][23][array_keys($arFields['PROPERTY_VALUES'][23])[0]]["VALUE"]);
        if ($addr && CModule::IncludeModule('iblock')) {
            $set = true;

            // если адрес не изменился - не обновляем координаты
            if ($arFields['ID']) {
                $res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => IntVal(IB_CLINICS_ID), "ID" => $arFields['ID']), false, false, array("ID", "IBLOCK_ID", "PROPERTY_23"))->GetNext();
                if ($addr == trim($res['PROPERTY_23_VALUE'])) {
                    $set = false;
                }
            }

            if ($set) {
                $coord = Clinics::getCoord($addr);
                if ($coord) {
                    $arFields['PROPERTY_VALUES'][65][array_keys($arFields['PROPERTY_VALUES'][65])[0]]["VALUE"] = $coord;
                }
            }
        }

        return true;
    }

    private function getCoord($addr = '')
    {
        $return = '';
        if (!$addr) return $return;

        $host = 'https://geocode-maps.yandex.ru/1.x/';
        $params = array(
            'apikey' => YANDEX_API_KEY,
            'format' => 'json',
            'geocode' => str_replace(' ', '+', $addr),
        );
        $data = json_decode(file_get_contents($host . '?' . http_build_query($params)), true);
        if (count($data['response']['GeoObjectCollection']['featureMember'])) {
            $return = $data['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
            $return = implode(', ', array_reverse(explode(' ', $return)));
        }

        return $return;
    }
}
