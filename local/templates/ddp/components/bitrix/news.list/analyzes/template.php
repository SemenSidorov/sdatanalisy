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
$city_id = Regions::getCurRegion();
$this->setFrameMode(true);
foreach ($arResult['ITEMS'] as $item){
	
	
}
// $this->addExternalCss('/bitrix/css/main/bootstrap.css');
//print_r(count($arResult['ITEMS']));
if(count($arResult['ITEMS'])!=0)
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
<h2 class="middle__h2">Другие анализы раздела <?=$section["NAME"]?></h2>
<div class="services__list services__list--slider js-services-slider">
	<?foreach ($arResult['ITEMS'] as $item){?>
	<?
	$ob_city = CIBlockElement::GetProperty(2, $item["ID"], array(), array("CODE"=>"CITIES"));
	$city=$ob_city->Fetch();
	$ob_section = CIBlockSection::GetList(array(), array("IBLOCK_ID" => 2, "ID" => $item["IBLOCK_SECTION_ID"]), false, false, array("ID", "NAME", "CODE"));
	$section = $ob_section->Fetch();
	$ob_analyzes_cost = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 8, "PROPERTY_ANALYSIS" => $item["ID"]), false, false, array());
	$analyzes_cost=$ob_analyzes_cost->Fetch();
	$ob_event = CIBlockElement::GetProperty(8, $analyzes_cost["ID"], array(), array("CODE"=>"EVENT"));
	$event=$ob_event->Fetch();
	$ob_event_price = CIBlockElement::GetProperty(8, $analyzes_cost["ID"], array(), array("CODE"=>"EVENT_PRICE"));
	$event_price=$ob_event_price->Fetch();
	$ob_price = CIBlockElement::GetProperty(8, $analyzes_cost["ID"], array(), array("CODE"=>"PRICE"));
	$price=$ob_price->Fetch();
	if($price["VALUE"]!=0 && $city_id==$city["VALUE"]){
		
?>
						  <div class="services__item">
		<div class="services__item-title"><?= $item["NAME"] ?></div>
						 <?if($event["VALUE"]==3):?> 
						
						  <div class="services__item-price price">
						 
				 <span class="price__num">от <?=$event_price["VALUE"]?> ₽</span> <span class="price__rub"></span>	
  <span class="price__old_num">от <?=$price["VALUE"]?> ₽</span> <span class="price__rub"></span>				
		<a class="services__item-more btn btn--secondary" href="<?=$item["DETAIL_PAGE_URL"]?>">Подробнее</a>
					</div>	 
						  <?
						elseif($event["VALUE"]!=3):?>
	 <div class="services__item-price price">
	от <span class="price__num"><?=$price["VALUE"]?></span> <span class="price__rub">₽</span>
		<a class="services__item-more btn btn--secondary" href="<?=$item["DETAIL_PAGE_URL"]?>">Подробнее</a>
		</div>
						<?endif;?>
	
		
	</div>
	<?}
	elseif(empty($price["VALUE"]) && $city_id==$city["VALUE"])
	{?>
		
		<div class="services__item">
		<div class="services__item-title"><?= $item["NAME"] ?></div>
						 <?if($event["VALUE"]==3):?> 
						
						  <div class="services__item-price price">
						 
				 <span class="price__num">от <?=$event_price["VALUE"]?> ₽</span> <span class="price__rub"></span>	
 			
		<a class="services__item-more btn btn--secondary" href="<?=$item["DETAIL_PAGE_URL"]?>">Подробнее</a>
					</div>	 
						  <?
						elseif($event["VALUE"]!=3):?>
	 <div class="services__item-price price">
	
		<a class="services__item-more btn btn--secondary" href="<?=$item["DETAIL_PAGE_URL"]?>">Подробнее</a>
		</div>
						<?endif;?>
		</div>
		
	<?}
	}
}?>
	
	
</div>