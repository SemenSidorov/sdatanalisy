<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$ElementID = $APPLICATION->IncludeComponent(
	"ddp:catalog.detail",
	$arParams["TEMPLATE_CODE"],
	Array(
        'SEF_MODE'	=>	'Y',
		'SEF_FOLDER' => '/doctors/',
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_CODE" => $arResult["SECTION_CODE"],
		"ELEMENT_CODE" => $arResult["CODE"]
	),
	$component
);?>