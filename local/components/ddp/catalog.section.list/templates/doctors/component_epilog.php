<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
/*     Продублируем загрузку карты, чтобы она не кешировалась                  */
$APPLICATION->AddHeadScript('https://api-maps.yandex.ru/2.1/?apikey='.YANDEX_API_KEY.'&lang=ru_RU');
$APPLICATION->AddHeadScript('/local/templates/ddp/_html/Result/Scripts/map-points.js');
/*                                                                           */
    ?>