<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "");
$APPLICATION->SetTitle("О компании");

$ob_company = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID" => 13), false, array("ID", "NAME", "CODE", "PROPERTY_96"));
$company = $ob_company->Fetch();


$text=CIBlockElement::GetProperty(13,$company["ID"], Array("SORT"=>"ASC"), Array("CODE"=>"TEXT"));
$ar_text=$text->Fetch();


?>
<div class="company-about__body">
<?=$ar_text["VALUE"]["TEXT"]?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>