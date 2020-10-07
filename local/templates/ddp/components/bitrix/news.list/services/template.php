<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 *
 *  _________________________________________________________________________
 * |	Attention!
 * |	The following comments are for system use
 * |	and are required for the component to work correctly in ajax mode:
 * |	<!-- items-container -->
 * |	<!-- pagination-container -->
 * |	<!-- component-end -->
 */
//$ob_section = CIBlockSection::GetList(array(), array("IBLOCK_ID" => 3, "ID" => $arResult["ITEMS"]["IBLOCK_SECTION_ID"]), false, false, array("ID", "NAME", "CODE"));
//	$section = $ob_section->Fetch();
$city_id = Regions::getCurRegion();
$this->setFrameMode(true);
//$this->addExternalCss('/bitrix/css/main/bootstrap.css');
foreach ($arResult['ITEMS'] as $item){
	$ob_city = CIBlockElement::GetProperty(3, $item["ID"], array(), array("CODE"=>"CITY"));
	$city=$ob_city->Fetch();
	//print_r($city_id);
}
// $this->addExternalCss('/bitrix/css/main/bootstrap.css');
//print_r(count($arResult['ITEMS']));
if(count($arResult['ITEMS'])!=0 )
{
?>
<style>
	.price__old_num {
    margin-top: -7px;
    
    text-decoration: line-through;
    font-weight: normal;
    font-size: 16px;
    line-height: 19px;
    color: #778990;
}
.price__num{
	margin-top: -7px;
	font-size: 22px;
}
	</style>
<h2 class="middle__h2">Другие услуги раздела</h2>
<div class="services__list services__list--slider js-services-slider">
	<?$i=0;
	foreach ($arResult["ITEMS"] as $item){?>
	<?
	//print_r(dd($item["IBLOCK_SECTION_ID"],false));
	//$ob_service = CIBlockSection::GetList(array(), array("IBLOCK_ID" => 3, "ID" => $item["ID"]), false, false, array("ID", "NAME", "CODE", "IBLOCK_ID", "DETAIL_PAGE_URL"));
	//$service = $ob_service->GetNext();
	$ob_section = CIBlockSection::GetList(array(), array("IBLOCK_ID" => 3, "ID" => $item["IBLOCK_SECTION_ID"]), false, false, array("ID", "NAME", "CODE"));
	$section = $ob_section->Fetch();
	$ob_services_cost = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 9, "PROPERTY_SERVICES" => $item["ID"]), false, false, array());
	$services_cost=$ob_services_cost->Fetch();
	$ob_event = CIBlockElement::GetProperty(9, $services_cost["ID"], array(), array("CODE"=>"EVENT"));
	$event=$ob_event->Fetch();
	$ob_event_price = CIBlockElement::GetProperty(9, $services_cost["ID"], array(), array("CODE"=>"EVENT_PRICE"));
	$event_price=$ob_event_price->Fetch();
	$ob_price = CIBlockElement::GetProperty(9, $services_cost["ID"], array(), array("CODE"=>"PRICE"));
	$price=$ob_price->Fetch();
	if($price["VALUE"]!=0 && $city_id==$city["VALUE"]){
?>
						  <div class="services__item">
		<div class="services__item-title"><?= $item["NAME"] ?></div>
						 <?if($event["VALUE"]==5):?> 
						
						  <div class="services__item-price price">
						 
				 <span class="price__num">от <?=$event_price["VALUE"]?> ₽</span> <span class="price__rub"></span>	
  <span class="price__old_num">от <?=$price["VALUE"]?> ₽</s></span> <span class="price__rub"></span>				
		<a class="services__item-more btn btn--secondary" href="<?=$item["DETAIL_PAGE_URL"]?>">Подробнее</a>
					</div>	 
						  <?
						elseif($event["VALUE"]!=5):?>
	 <div class="services__item-price price">
	<span class="price__num">от <?=$price["VALUE"]?> ₽</span> <span class="price__rub"></span>
		<a class="services__item-more btn btn--secondary" href="<?=$item["DETAIL_PAGE_URL"]?>">Подробнее</a>
		</div>
						<?endif;?>
	
		
	</div>
	<?}
	elseif(empty($price["VALUE"]) && $city_id==$city["VALUE"])
	{?>
		
		<div class="services__item">
		<div class="services__item-title"><?= $item["NAME"] ?></div>
						 <?if($event["VALUE"]==5):?> 
						
						  <div class="services__item-price price">
						 
				 <span class="price__num">от <?=$event_price["VALUE"]?> ₽</span> <span class="price__rub"></span>	
 			
		<a class="services__item-more btn btn--secondary" href="<?=$item["DETAIL_PAGE_URL"]?>">Подробнее</a>
					</div>	 
						  <?
						elseif($event["VALUE"]!=5):?>
	 <div class="services__item-price price">
	
		<a class="services__item-more btn btn--secondary" href="<?=$item["DETAIL_PAGE_URL"]?>">Подробнее</a>
		</div>
						<?endif;?>
		</div>
		
	<?}
	
	}
}?>

	
</div>