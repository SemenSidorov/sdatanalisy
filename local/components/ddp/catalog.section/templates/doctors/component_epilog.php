<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
    $APPLICATION->SetTitle($arResult["title"]);
    $APPLICATION->AddChainItem($arResult["title"], $arResult["link"]);
	/*     Продублируем загрузку карты, чтобы она не кешировалась                  */
$APPLICATION->AddHeadScript('https://api-maps.yandex.ru/2.1/?apikey='.YANDEX_API_KEY.'&lang=ru_RU');
$APPLICATION->AddHeadScript('/local/templates/ddp/_html/Result/Scripts/map-points.js');
/* 
	
	/*$city_id = Regions::getCurRegion();
	foreach($arResult["ITEMS"] as $item)
	{
		//$doctors = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID" => 4, "ACTIVE"=>"Y", "PROPERTY_5_VALUE" => $item["ID"]), false, false, array("IBLOCK_ID", "ID", "NAME", "CODE"));
	$clinics = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID" => 5, "ACTIVE"=>"Y", "PROPERTY_5_VALUE" => $item["ID"], "PROPERTY_4_VALUE"=>$city_id), false, false, array("IBLOCK_ID", "ID", "NAME", "CODE"));
	$clinic = $clinics->Fetch();
	$prop_city = CIBlockElement::GetProperty($clinic["IBLOCK_ID"], $clinic["ID"], array("SORT"=>"ASC"), array("CODE"=>"CITY"));
	$proper_city = $prop_city->Fetch();
		if($proper_city["VALUE"]!=$city_id)
		{
			//@define("ERROR_404", "Y");
            //CHTTP::SetStatus("404 Not Found");
		}
	
	}*/
?>