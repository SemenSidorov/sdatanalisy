<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("���� �� �������");
?>

<?php
$APPLICATION->IncludeComponent(
    "ddp:catalog.analyzes.cost",
    ""
);
?>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>