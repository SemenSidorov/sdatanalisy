<?/*  Подключаем скрипт, для вывода привязанного элемента в редактировании элемента                         */
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib//priv_hrefs_adminPanel/iblock_element_edit_yet_analyz.php"))
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_yet_analyz.php");
}

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_yet_service.php"))
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_yet_service.php");
}

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_yet_doctor.php"))
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_yet_doctor.php");
}
/*                   */

/*       ссылка напротив привязки к элементам                                  */
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_priv_region.php"))
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_priv_region.php");
}

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_priv_cost_analyz.php"))
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_priv_cost_analyz.php");
}

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_priv_cost_service.php"))
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_priv_cost_service.php");
}

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_priv_clinic_doctor.php"))
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_priv_clinic_doctor.php");
}

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_priv_clinic_region.php"))
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_priv_clinic_region.php");
}

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_priv_doctor_service.php"))
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_priv_doctor_service.php");
}
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_priv_cost_doctors.php"))
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/priv_hrefs_adminPanel/iblock_element_edit_priv_cost_doctors.php");
}
?>