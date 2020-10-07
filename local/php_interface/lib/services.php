<?php
/**
 * Класс для работы с услугами
 * Class Analyzes
 */
class Services {

    /**
     * Метод возвращает минимальную цену услуги для региона
     * @param int ID услуги
     * @return int
     */
    public function getMinPriceToRegion($id = 0)
    {
        $return = 0;
        if (!$id) return $return;

        $region = Regions::getCurRegion();
        $cache = new CPHPCache;
        if ($cache->StartDataCache(60 * 60 * 24, 'item_'.$id.'_'.$region, "/services/") && CModule::IncludeModule('iblock')) {
            $filter = array("IBLOCK_ID" => IntVal(IB_SERVICES_DATA_ID), "ACTIVE" => "Y", "PROPERTY_CLINIC.ID" => Clinics::getClinicsToRegion(), "PROPERTY_SERVICES.ID" => $id);
            $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "IBLOCK_ID", "PROPERTY_PRICE", "PROPERTY_EVENT_PRICE", "PROPERTY_EVENT"));
            while ($item = $res->GetNext()) {
                if ($return > $item['PROPERTY_PRICE_VALUE'] || !$return) {
                    $return = $item['PROPERTY_PRICE_VALUE'];
                }
                if ($item['PROPERTY_EVENT_VALUE']) {
                    if ($return > $item['PROPERTY_EVENT_PRICE_VALUE'] || !$return) {
                        $return = $item['PROPERTY_EVENT_PRICE_VALUE'];
                    }
                }
            }
            $cache->EndDataCache($return);
        } else {
            $return = $cache->GetVars();
        }
        return $return;
    }

    /**
     * Возвращает минимальную цену из раздела услуг
     * @param int $id
     * @return int|mixed
     */
    public function getMinPriceSectionToRegion($id = 0)
    {
        $return = 0;
        if (!$id) return $return;

        $region = Regions::getCurRegion();
        $cache = new CPHPCache;
        if ($cache->StartDataCache(60 * 60 * 24, 'section_'.$id.'_'.$region, "/services/") && CModule::IncludeModule('iblock')) {
            $filter = array("IBLOCK_ID" => IntVal(IB_SERVICES_ID), "ACTIVE" => "Y", "SECTION_ID" => $id, "INCLUDE_SUBSECTIONS" => "Y");
            $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "IBLOCK_ID"));
            $items = array();
            while ($item = $res->GetNext()) {
                $items[] = $item['ID'];
            }
            $filter = array("IBLOCK_ID" => IntVal(IB_SERVICES_DATA_ID), "ACTIVE" => "Y", "PROPERTY_CLINIC.ID" => Clinics::getClinicsToRegion(), "PROPERTY_SERVICES.ID" => $items);
            $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "IBLOCK_ID", "PROPERTY_PRICE", "PROPERTY_EVENT_PRICE", "PROPERTY_EVENT"));
            while ($item = $res->GetNext()) {
                if ($return > $item['PROPERTY_PRICE_VALUE'] || !$return) {
                    $return = $item['PROPERTY_PRICE_VALUE'];
                }
                if ($item['PROPERTY_EVENT_VALUE']) {
                    if ($return > $item['PROPERTY_EVENT_PRICE_VALUE'] || !$return) {
                        $return = $item['PROPERTY_EVENT_PRICE_VALUE'];
                    }
                }
            }
            $cache->EndDataCache($return);
        } else {
            $return = $cache->GetVars();
        }
        return $return;
    }

    /**
     * Возвращает разделы для текущего региона
     * @param int ID раздела
     * @return array
     */
    public function getSectionsToRegion($id = false)
    {
        $return = array();

        $region = Regions::getCurRegion();
        $cache = new CPHPCache;
        if ($cache->StartDataCache(60 * 60 * 24, 'section_'.$id.'_'.$region, "/services/") && CModule::IncludeModule('iblock')) {
            $filter = array("IBLOCK_ID" => IntVal(IB_SERVICES_DATA_ID), "ACTIVE" => "Y", "PROPERTY_CLINIC.ID" => Clinics::getClinicsToRegion());
            $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "IBLOCK_ID", "PROPERTY_SERVICES"));
            $items = array();
            while ($item = $res->GetNext()) {
                $items[] = $item['PROPERTY_SERVICES_VALUE'];
            }
            $filter = array("IBLOCK_ID" => IntVal(IB_SERVICES_ID), "ACTIVE" => "Y", "ID" => $items);
            if ($id !== false) {
                $filter['SECTION_ID'] = $id;
                $filter['INCLUDE_SUBSECTIONS'] = "Y";
            }
            $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "CODE"));
            while ($item = $res->GetNext()) {
                if (!isset($return[$item['IBLOCK_SECTION_ID']])) {
                    $return[$item['IBLOCK_SECTION_ID']] = CIBlockSection::GetByID($item['IBLOCK_SECTION_ID'])->GetNext();
                }
            }
            $cache->EndDataCache($return);
        } else {
            $return = $cache->GetVars();
        }
        return $return;
    }

    /**
     * Возвращает элементы для текущего региона
     * @param int ID раздела
     * @return array
     */
    public function getItemsToRegion($id = false)
    {
        $return = array();

        $region = Regions::getCurRegion();
        $cache = new CPHPCache;
        if ($cache->StartDataCache(60 * 60 * 24, 'items_section_'.$id.'_'.$region, "/services/") && CModule::IncludeModule('iblock')) {
            $filter = array("IBLOCK_ID" => IntVal(IB_SERVICES_DATA_ID), "ACTIVE" => "Y", "PROPERTY_CLINIC.ID" => Clinics::getClinicsToRegion());
            $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "IBLOCK_ID", "PROPERTY_SERVICES"));
            $items = array();
            while ($item = $res->GetNext()) {
                $items[] = $item['PROPERTY_SERVICES_VALUE'];
            }
            $filter = array("IBLOCK_ID" => IntVal(IB_SERVICES_ID), "ACTIVE" => "Y", "GLOBAL_ACTIVE" => "Y", "ID" => $items);
            if ($id !== false) {
                $filter['SECTION_ID'] = $id;
                $filter['INCLUDE_SUBSECTIONS'] = "Y";
            }
            $res = CIBlockElement::GetList(array("NAME"=>"ASC"), $filter, false, false, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "CODE", "DETAIL_PAGE_URL"));
            while ($item = $res->GetNext()) {
                $return[] = $item;
            }
            $cache->EndDataCache($return);
        } else {
            $return = $cache->GetVars();
        }
        return $return;
    }
}