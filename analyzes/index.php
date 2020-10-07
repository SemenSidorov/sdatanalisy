<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "");
$APPLICATION->SetTitle("Анализы");
?>
<?$APPLICATION->IncludeComponent(
    'ddp:catalog',
    'analyzes',
    array(
        'IBLOCK_ID' => 2,
        'SEF_MODE'	=>	'Y',
		'SEF_FOLDER' => '/analyzes/',
		"TEMPLATE_CODE" => "analyzes"
    ),
    false,
    array('HIDE_ICONS' => 'Y')
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>