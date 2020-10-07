<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
    $APPLICATION->SetTitle($arResult["title"]);
    $APPLICATION->AddChainItem($arResult["title"], $arResult["link"]);
	
	$city_id = Regions::getCurRegion();
	$ob_analyzes = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID" => 3, "PROPERTY_CITY" => $city_id), false, false, array("IBLOCK_ID", "ID", "NAME", "CODE"));
	$analyzes = $ob_analyzes->Fetch();
	$ob_city = CIBLockElement::GetProperty($analyzes["IBLOCK_ID"], $analyzes["ID"], "SORT" , "ASC", array("CODE"=>"CITY"));
	$prop_city = $ob_city->Fetch();
	if($prop_city["VALUE"]!=$city_id)
  {
	@define("ERROR_404", "Y");
    CHTTP::SetStatus("404 Not Found");

  }
	
?>