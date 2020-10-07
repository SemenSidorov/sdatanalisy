<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
    $APPLICATION->SetTitle($arResult["ITEM"]["NAME"]);
    $APPLICATION->AddChainItem($arResult["ITEM"]["NAME"], $arResult["ITEM"]["DETAIL_PAGE_URL"]);
    $APPLICATION->SetPageProperty("OGImage", $arResult["ITEM"]["DETAIL_PICTURE"]["src"]);
	/*     Продублируем загрузку карты, чтобы она не кешировалась                  */
$APPLICATION->AddHeadScript('https://api-maps.yandex.ru/2.1/?apikey='.YANDEX_API_KEY.'&lang=ru_RU');
$APPLICATION->AddHeadScript('/local/templates/ddp/_html/Result/Scripts/map-points.js');

	$city_id = Regions::getCurRegion();
	$item = $arResult["ITEM"];
	$clinics = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID" => 5, "ACTIVE"=>"Y", "PROPERTY_5_VALUE" => $item["ID"]), false, false, array("IBLOCK_ID", "ID", "NAME", "CODE"));
	$clinic = $clinics->Fetch();
	$prop_city = CIBlockElement::GetProperty($clinic["IBLOCK_ID"], $clinic["ID"], array("SORT"=>"ASC"), array("CODE"=>"CITY"));
	$proper_city = $prop_city->Fetch();
	//print_r($proper_city["VALUE"]);
		if($proper_city["VALUE"]!=$city_id)
		{
			
			///@define("ERROR_404", "Y");
           // CHTTP::SetStatus("404 Not Found");
		}
?>