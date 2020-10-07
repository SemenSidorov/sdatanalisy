<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "");
$APPLICATION->SetTitle("Услуги");
$APPLICATION->IncludeComponent(
	"ddp:catalog", 
	"services", 
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "Y",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "info",
		'SEF_MODE'	=>	'Y',
		'SEF_FOLDER' => '/services/',
		"TEMPLATE_CODE" => "services"
	),
	false,
	 array('HIDE_ICONS' => 'Y')
);
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>