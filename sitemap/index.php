<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Карта сайта");
?>
<?php
$APPLICATION->IncludeComponent(
    'ddp:sitemap',
    '',
    array(
        'MENU_TYPES' => array(
            'top',
        ),
        'I_BLOCKS' => array(6, 5, 3, 4, 2),
        'STATIC' => array(),
        'NEED_ELEMENTS' => 'Y'
    )
);
?>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>