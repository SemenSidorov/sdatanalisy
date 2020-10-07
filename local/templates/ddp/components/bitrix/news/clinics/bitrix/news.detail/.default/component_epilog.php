<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
/*     Продублируем загрузку карты, чтобы она не кешировалась                  */
$APPLICATION->AddHeadScript('https://api-maps.yandex.ru/2.1/?apikey='.YANDEX_API_KEY.'&lang=ru_RU');
$APPLICATION->AddHeadScript('/local/templates/ddp/_html/Result/Scripts/map-points.js');
/*                                                                           */
    $APPLICATION->SetPageProperty("OGImage", $arResult["OGImage"]);
	
	$IBLOCK_ID_ANALYZES = 2;
$IBLOCK_ID_SERVICES = 3;
$IBLOCK_ID_DOCTORS = 4;
$IBLOCK_ID_COST_ANALYZES=8;
$IBLOCK_ID_COST_SERVICES=9;
	//  Для формы докторов ,чтобы не кешировалась  //
	
	
	//                                            //
	
	
	$city=Regions::getCurRegion();
$ob_city = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>1, "ACTIVE"=>"Y", "ID"=>$city), false, Array("ID", "NAME", "CODE"), false);
$city = $ob_city->Fetch();
//$ob_clinics = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>5, "ACTIVE"=>"Y", "ID"=>$arResult["ID"]), false, Array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_*"), false);
//$clinics = $ob_clinics->Fetch();
//print_r($clinics);
$property_city = CIBlockElement::GetProperty(5, $arResult["ID"], array("sort" => "asc"), array("CODE"=>"CITY"));
$prop_city=$property_city->Fetch();
//print_r($city["ID"]);
//print_r($prop_city["VALUE"]);
if($prop_city["VALUE"]!=$city["ID"])
{
	// CBitrixComponent::clearComponentCache('news');
	 //$staticHtmlCache = \Bitrix\Main\Data\StaticHtmlCache::getInstance();
//$staticHtmlCache->deleteAll();
	@define("ERROR_404", "Y");
CHTTP::SetStatus("404 Not Found");
}
?>
<!--test_div<?//print_r($arResult);?>-->