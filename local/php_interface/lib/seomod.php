<?php

/**
 * Класс для работы с SEO
 * Class SeoMod
 */
class SeoMod
{
    /**
     * Метод обработки 404 ошибок
     */
    function Check404Error()
    {
        if (
            (defined('ERROR_404') && ERROR_404 == 'Y') ||
            CHTTP::GetLastStatus() == "404 Not Found"
        ) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/404.php')) {
                global $APPLICATION;
                $APPLICATION->RestartBuffer();
                require $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/header.php';
                require $_SERVER['DOCUMENT_ROOT'] . '/404.php';
                require $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php';
            }
        }
    }
}