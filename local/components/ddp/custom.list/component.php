<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

    if (CModule::IncludeModule("iblock")) {
        $arResult = Array();
    }


    $this->IncludeComponentTemplate();