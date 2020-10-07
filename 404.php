<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");
$APPLICATION->SetPageProperty("tags", "404 ошибка");
$APPLICATION->SetPageProperty("description", "404 ошибка");
$APPLICATION->SetPageProperty("keywords_inner", "404 ошибка");
$APPLICATION->SetPageProperty("title", "404 ошибка");
$APPLICATION->SetPageProperty("keywords", "404 ошибка");
$APPLICATION->SetPageProperty("robots", "noindex, nofollow");
?>
    <div id="error404">
        <p class="errorText">Такой страницы не существует</p>

        <?/*$APPLICATION->IncludeComponent("bitrix:menu", "", Array(
                    "ROOT_MENU_TYPE" => "top",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "N",
                    "MENU_CACHE_GET_VARS" => "",
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "left",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                ),
                    false
        );*/?>

    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>