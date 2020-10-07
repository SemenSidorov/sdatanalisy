<?php

/**
 * Класс для работы с докторами
 * Class Analyzes
 */
class Doctors
{

    /**
     * Метод возвращает доктора для текущего региона
     * @param int ID доктора
     * @return array
     */
    public function getDoctorToRegion($id = 0)
    {
        $return = array();
        if (!$id) return $return;

        $region = Regions::getCurRegion();
        $cache = new CPHPCache;
        if ($cache->StartDataCache(60 * 60 * 24, 'item_' . $id . '_' . $region, "/doctors/") && CModule::IncludeModule('iblock')) {
            $filter = array("IBLOCK_ID" => IntVal(IB_CLINICS_ID), "ACTIVE" => "Y", "ID" => Clinics::getClinicsToRegion());
            $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_DOCTORS", "PROPERTY_ADDRESS"));
            $items = array();
            $clinics = array();
            while ($item = $res->GetNext()) {
                if (count($item['PROPERTY_DOCTORS_VALUE'])) {
                    foreach ($item['PROPERTY_DOCTORS_VALUE'] as $elem) {
                        $items[(int)$elem] = (int)$elem;
                        $clinics[(int)$elem] = $item;
                    }
                }
            }
            if (!array_search($id, $items)) return $return;
            $regions = Regions::getAllRegions();
            $filter = array("IBLOCK_ID" => IntVal(IB_DOCTORS_ID), "ACTIVE" => "Y", "ID" => $id);
            $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "IBLOCK_ID", "SECTION_ID", "NAME", "CODE", "DETAIL_PICTURE", "PROPERTY_PRICE", "PROPERTY_EXPERIENCE", "PROPERTY_CATEGORY"));
            while ($item = $res->GetNext()) {
                $section = CIBlockSection::GetByID($item['SECTION_ID'])->GetNext();
                $item['SECTION'] = $section['NAME'];
                $item['IMG'] = '';
                if ($item['DETAIL_PICTURE']) {
                    $item['IMG'] = CFile::GetPath($item["DETAIL_PICTURE"]);
                }
                $item['URL'] = '/doctors/' . $section['CODE'] . '/' . $item['CODE'] . '/';
                $item['CLINIC'] = $clinics[$item['ID']];
                $item['CLINIC']['CITY'] = $regions[$region]['NAME'];
                $return = $item;
            }
            $cache->EndDataCache($return);
        } else {
            $return = $cache->GetVars();
        }
        return $return;
    }

    /**
     * Возвращает докторов из раздела для текущего региона
     * @param int ID раздела доктора
     * @return array
     */
    public function getDoctorsSectionToRegion($id = false)
    {
        $return = array();

        $region = Regions::getCurRegion();
        $cache = new CPHPCache;
        if ($cache->StartDataCache(60 * 60 * 24, 'items_section_'.$id.'_'.$region, "/doctors/") && CModule::IncludeModule('iblock')) {
            $section = array();
            $filter = array("IBLOCK_ID" => IntVal(IB_CLINICS_ID), "ACTIVE" => "Y", "ID" => Clinics::getClinicsToRegion());
            $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_DOCTORS", "PROPERTY_ADDRESS"));
            $items = array();
            $clinics = array();
            while ($item = $res->GetNext()) {
                if (count($item['PROPERTY_DOCTORS_VALUE'])) {
                    foreach ($item['PROPERTY_DOCTORS_VALUE'] as $elem) {
                        $clinics[(int)$elem] = $item;
                        $items[(int)$elem] = (int)$elem;
                    }
                }
            }
            $regions = Regions::getAllRegions();
            $filter = array("IBLOCK_ID" => IntVal(IB_DOCTORS_ID), "ACTIVE" => "Y", "ID" => $items);
            if ($id !== false) {
                $filter['SECTION_ID'] = $id;
                $filter['INCLUDE_SUBSECTIONS'] = "Y";
            }
            $res = CIBlockElement::GetList(array("NAME"=>"ASC"), $filter, false, false, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "CODE", "DETAIL_PAGE_URL", "DETAIL_PICTURE", "PROPERTY_PRICE", "PROPERTY_EXPERIENCE", "PROPERTY_CATEGORY"));
            while ($item = $res->GetNext()) {
                if (!isset($section[$item['IBLOCK_SECTION_ID']])) {
                    $section[$item['IBLOCK_SECTION_ID']] = CIBlockSection::GetByID($id)->GetNext();
                }
                $item['SECTION'] = $section[$item['IBLOCK_SECTION_ID']]['NAME'];
                $item['IMG'] = '';
                if ($item['DETAIL_PICTURE']) {
                    $item['IMG'] = CFile::GetPath($item["DETAIL_PICTURE"]);
                }
//                $item['URL'] = '/doctors/' . $section['CODE'] . '/' . $item['CODE'] . '/';
                $item['URL'] = $item['DETAIL_PAGE_URL'];
                $item['CLINIC'] = $clinics[$item['ID']];
                $item['CLINIC']['CITY'] = $regions[$region]['NAME'];
                $return[] = $item;
            }
            $cache->EndDataCache($return);
        } else {
            $return = $cache->GetVars();
        }
        return $return;
    }

    /**
     * Возвращает разделы для текущего региона
     * @param int ID раздела доктора
     * @return array
     */
    public function getSectionsToRegion($id = false)
    {
        $return = array();

        $region = Regions::getCurRegion();
        $cache = new CPHPCache;
        if ($cache->StartDataCache(60 * 60 * 24, 'section_' . $id . '_' . $region, "/doctors/") && CModule::IncludeModule('iblock')) {
            $filter = array("IBLOCK_ID" => IntVal(IB_CLINICS_ID), "ACTIVE" => "Y", "ID" => Clinics::getClinicsToRegion());
            $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_DOCTORS", "PROPERTY_ADDRESS"));
            $items = array();
            $clinics = array();
            while ($item = $res->GetNext()) {
                if (count($item['PROPERTY_DOCTORS_VALUE'])) {
                    foreach ($item['PROPERTY_DOCTORS_VALUE'] as $elem) {
                        $clinics[(int)$elem] = $item;
                        $items[(int)$elem] = (int)$elem;
                    }
                }
            }
            $filter = array("IBLOCK_ID" => IntVal(IB_DOCTORS_ID), "ACTIVE" => "Y", "ID" => $items);
            if ($id !== false) {
                $filter['SECTION_ID'] = $id;
                $filter['INCLUDE_SUBSECTIONS'] = "Y";
            }
            $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "CODE", "DETAIL_PICTURE", "PROPERTY_PRICE", "PROPERTY_EXPERIENCE", "PROPERTY_CATEGORY"));
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
}
