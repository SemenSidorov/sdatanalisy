<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
    $APPLICATION->SetTitle($arResult["ITEM"]["NAME"]);
    $APPLICATION->AddChainItem($arResult["ITEM"]["NAME"], $arResult["ITEM"]["DETAIL_PAGE_URL"]);
	
	$item = $arResult["ITEM"];
	//print_r($arResult["ITEM"]);
$city_id = Regions::getCurRegion();
  if($item["PROPERTIES"]["CITY"]["VALUE"]!=$city_id)
  {
	@define("ERROR_404", "Y");
   CHTTP::SetStatus("404 Not Found");

  }
?>