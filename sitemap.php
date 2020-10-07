<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->IncludeComponent(
    'ddp:sitemap',
    'xml',
    array(
        'MENU_TYPES' => array(
            'top',
        ),
        'I_BLOCKS' => array(6, 5, 3, 4, 2),
        'STATIC' => array(),
        'NEED_ELEMENTS' => 'Y'
    )
);
