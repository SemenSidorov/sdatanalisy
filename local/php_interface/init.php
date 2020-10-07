<?php

/**
 * Инфоблоки
 */
define('IB_REGIONS_ID', 1);
define('IB_ANALYZES_ID', 2);
define('IB_ANALYZES_DATA_ID', 8);
define('IB_SERVICES_ID', 3);
define('IB_SERVICES_DATA_ID', 9);
define('IB_DOCTORS_ID', 4);
define('IB_CLINICS_ID', 5);
define('IB_ARTICLES_ID', 6);

//define('REGION_TYPE', 'REQUEST');
define('REGION_TYPE', 'DOMAIN');
define('FAVORITES_MAX_COUNT', 2);
define('YANDEX_API_KEY', '724323bb-3ea6-4e34-9d90-265e26da76a1');

\Bitrix\Main\Loader::registerAutoLoadClasses(null, array(
    'Regions'   => '/local/php_interface/lib/regions.php',
    'Clinics'   => '/local/php_interface/lib/clinics.php',
    'Services'   => '/local/php_interface/lib/services.php',
    'Analyzes'  => '/local/php_interface/lib/analyzes.php',
    'Doctors'  => '/local/php_interface/lib/doctors.php',
    'Favorites' => '/local/php_interface/lib/favorites.php',
    'SeoMod'    => '/local/php_interface/lib/seomod.php'
));

// сохраняем в куки "избранное"
Favorites::cookiesFavorite();

// контролируем уникальность дефолтного региона
AddEventHandler('iblock', 'OnBeforeIBlockElementAdd', array('Regions', 'checkOnElementChange'));
AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate', array('Regions', 'checkOnElementChange'));

// контролируем активность регионов при изменении клиник
AddEventHandler('iblock', 'OnAfterIBlockElementAdd', array('Regions', 'checkOnRegion'));
AddEventHandler('iblock', 'OnAfterIBlockElementUpdate', array('Regions', 'checkOnRegion'));
AddEventHandler('iblock', 'OnAfterIBlockElementDelete', array('Regions', 'checkOnRegion'));

// контролируем актуальность координат клиники
AddEventHandler('iblock', 'OnBeforeIBlockElementAdd', array('Clinics', 'setClinicCoord'));
AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate', array('Clinics', 'setClinicCoord'));

// отлавливаем и обрабатываем 404 ошибки
AddEventHandler('main', 'OnEpilog', array('SeoMod', 'Check404Error'));


if (!function_exists('dd')) {
   function dd($data, $die = true)
   {
      global $USER;
      if (!$USER->IsAdmin()) {
         return;
      }
      $debug = debug_backtrace();
      echo "<p><b>file:</b> " . $debug[0]['file'] . "\r\n</p>";
      echo "<p><b>line:</b> " . $debug[0]['line'] . "\r\n</p>";
      echo "<p><b>data:</b>\r\n</p>";
      echo '<pre>';
      var_dump($data);
      echo '</pre>';
      if ($die) {
         die;
      }
   }
}

if (!function_exists('dd_log')) {
   function dd_log($data)
   {
      if (!defined('LOG_FILENAME')) define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"] . "/dd_log.txt");
      ob_start();
      var_dump($data);
      AddMessage2Log(ob_get_clean());
   }
}

/**
 * Сортировка массива по названию элеменетов
 */
if (!function_exists('my_array_sort')) {
    function my_array_sort($a, $b)
    {
        if ($a['NAME'] == $b['NAME']) {
            return 0;
        }
        return ($a['NAME'] < $b['NAME']) ? -1 : 1;
    }
}

/*  Подключаем агентов, проверяющего время действия скидки                          */
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/analyzes_event.php"))
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/analyzes_event.php");
}

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/services_event.php"))
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/services_event.php");
}