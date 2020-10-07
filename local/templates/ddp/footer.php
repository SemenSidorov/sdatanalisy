<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
<?php if ($APPLICATION->GetCurPage() != '/') { ?>
        </div>
    </div>
<?php } ?>
    <footer class="footer">
        <div class="footer__inner">
            <div class="footer__col">
                <?php $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "footer",
                        array(
                            "ROOT_MENU_TYPE" => "top",
                            "MENU_CACHE_TYPE" => "Y",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_THEME" => "site",
                            "CACHE_SELECTED_ITEMS" => "N",
                            "MENU_CACHE_GET_VARS" => array(),
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "left",
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                        ),
                    false
                ); ?>
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    ".default",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => SITE_TEMPLATE_PATH."/include/footer-contacts.php",
                        "COMPONENT_TEMPLATE" => ".default"
                    ),
                    false
                );?>
            </div>
            <div class="footer__col">
                <div class="footer__icons">
                    <?php $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => SITE_TEMPLATE_PATH."/include/footer-social.php",
                            "COMPONENT_TEMPLATE" => ".default"
                        ),
                        false
                    ); ?>
                    <a class="footer__logo" href="/" target="_blank">Сдать анализы</a>
                </div>
            </div>
            <div class="footer__bottom">
                <div class="footer__col">
                    <div class="footer__copyright">
                        <?php $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => SITE_TEMPLATE_PATH."/include/footer_col.php",
                                "COMPONENT_TEMPLATE" => ".default"
                            ),
                            false
                        ); ?>
                    </div>
                </div>
                <div class="footer__col">
                    <div class="footer__development">
                        <a href="https://www.ddplanet.ru/" target="_blank">Создание сайта</a> — <span class="footer__development-link">DD Planet</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

</body>
</html>