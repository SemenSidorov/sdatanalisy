<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$return = array('succes'=>false);

if (!isset($_REQUEST['ob'])) $_REQUEST['ob'] = '';
if (!isset($_REQUEST['fun'])) $_REQUEST['fun'] = '';

switch ($_REQUEST['ob']) {

    case 'favorites':
        switch ($_REQUEST['fun']) {

            case 'add':
                if (!isset($_REQUEST['id'])) $_REQUEST['id'] = 0;
                if ($_REQUEST['id']) {
                    if (Favorites::addFavoriteClinic($_REQUEST['id']) && CModule::IncludeModule('iblock')) {
                        $return['succes'] = true;
                        $filter = array(
                            "IBLOCK_ID" => IntVal(IB_CLINICS_ID),
                            "ACTIVE" => "Y",
                            "ID" => $_REQUEST['id'],
                        );
                        $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "NAME", "CODE", "PROPERTY_23"));
                        while ($item = $res->GetNext()) {
                            $return['item'] = array(
                                'id'        => $item['ID'],
                                'link'      => '/clinics/'.$item['CODE'].'/',
                                'adress'    => $item['PROPERTY_23_VALUE'],
                            );
                        }
                    }
                }
                break;

            case 'del':
                if (!isset($_REQUEST['id'])) $_REQUEST['id'] = 0;
                if ($_REQUEST['id']) {
                    if (Favorites::delFavoriteClinic($_REQUEST['id'])) {
                        $return['succes'] = true;
                    }
                }
                break;
        }
        break;

    case 'analyz':
        switch ($_REQUEST['fun']) {

            case 'search':
                if (!isset($_REQUEST['text'])) $_REQUEST['text'] = '';
                if ($_REQUEST['text']  && CModule::IncludeModule('iblock')) {
                    $filter = array(
                        "IBLOCK_ID" => IntVal(IB_ANALYZES_ID),
                        "ACTIVE" => "Y",
                        "?NAME" => $_REQUEST['text'],
                    );
                    // ищем пять разделов
                    $res = CIBlockSection::GetList(array(), $filter, false, false, array("ID", "NAME", "CODE"), array('nTopCount'=>5));
                    while ($item = $res->GetNext()) {
                        $return['items'][] = array(
                            'id'        => $item['ID'],
                            'link'      => '/analyzes/'.$item['CODE'].'/',
                            'name'      => $item['NAME'],
                        );
                    }
                    // ищем пять элементов
                    $res = CIBlockElement::GetList(array(), $filter, false, false, array("ID", "NAME", "CODE", "IBLOCK_SECTION_ID"), array('nTopCount'=>5));
                    while ($item = $res->GetNext()) {
                        $section = CIBlockSection::GetByID($item['IBLOCK_SECTION_ID'])->GetNext();
                        $return['items'][] = array(
                            'id'        => $item['ID'],
                            'link'      => '/analyzes/'.$section['CODE'].'/'.$item['CODE'].'/',
                            'name'      => $item['NAME'],
                        );
                    }
                    if (isset($return['items'])) $return['succes'] = true;
                }
                break;
        }
        break;
}

echo json_encode($return);