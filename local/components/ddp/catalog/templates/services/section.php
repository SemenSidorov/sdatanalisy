<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeComponent(
	"ddp:catalog.section",
	$arParams["TEMPLATE_CODE"],
	Array(
        'SEF_MODE'	=>	'Y',
		'SEF_FOLDER' => '/services/',
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => 3,
		"SECTION_CODE" => $arResult["SECTION_CODE"],
    "ADD_SECTIONS_CHAIN" => "Y"
	),
	$component
);?>