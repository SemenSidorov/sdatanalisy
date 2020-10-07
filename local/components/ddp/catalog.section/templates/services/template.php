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

$this->setFrameMode(true);
$Section_prop=array();
$Element_prop=array();
//print_r($arResult["title"]);
$city = Regions::getCurRegion();
$rsSection = CIBlockSection::GetList(array(), array("IBLOCK_ID" => 3, "NAME"=>$arResult["title"]), false, false, array());
while($arSection=$rsSection->Fetch())
{
//	print_r(dd($arSection,false));
	$Section_prop[]=$arSection;
	}
//$this->addExternalCss('/bitrix/css/main/bootstrap.css');
?>
<div class="analyzes__list">
	<?
	
foreach($Section_prop as $arSection)
{	
$rsElement = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 3, "IBLOCK_SECTION_ID" => $arSection["ID"], "PROPERTY_CITY"=>$city),  false, array());
while($arElement=$rsElement->Fetch())
{
	$Element_prop[]=$arElement;
}
//print_r(count($Element_prop));
if(count($Element_prop)==0)
{
	@define("ERROR_404", "Y");
    CHTTP::SetStatus("404 Not Found");
}
foreach ($Element_prop as $item)
	{?>
	<?
	$item["DETAIL_PAGE_URL"] = "/services/".$arSection["CODE"]."/".$item["CODE"]."/";
	
	$clinics = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 5, "PROPERTY_CITY" => $city), false, false, array());
	
	$clinic = $clinics->GetNext();

	
	$services = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 9, "PROPERTY_39" => $item["ID"], "PROPERTY_40" => $clinic["ID"]),false, array());
	$price = 0;
	$event_price = 0;
	$event = 0;
	while($ar_services = $services->GetNext()){
		//
		$an_event = CIBlockElement::GetProperty($ar_services["IBLOCK_ID"], $ar_services["ID"], array(), array("CODE" => "EVENT"));
		$an_event = $an_event->GetNext();
		$an_event_price = CIBlockElement::GetProperty($ar_services["IBLOCK_ID"], $ar_services["ID"], array(), array("CODE" => "EVENT_PRICE"));
		$an_event_price = $an_event_price->GetNext();
		$an_prop = CIBlockElement::GetProperty($ar_services["IBLOCK_ID"], $ar_services["ID"], array(), array("CODE" => "PRICE"));
		$an_prop = $an_prop->GetNext();
		if($price === 0){
			$price = $an_prop["VALUE"];
			$event_price = $an_event_price["VALUE"];
			$event = $an_event["VALUE"];
		}elseif($an_prop["VALUE"] < $price){
			$price = $an_prop["VALUE"];
			$event_price = $an_event_price["VALUE"];
			$event = $an_event["VALUE"];
		}
	}
	if($price != 0){
?>
	<div class="analyzes__list-item">
		<div class="analyzes__list-item-body">
			<div class="analyzes__list-item-num">№<?= $item["ID"] ?></div>
			<div class="analyzes__list-item-title"><a href="<?= $item["DETAIL_PAGE_URL"] ?>"><?= $item["NAME"] ?></a></div>
			<?if(isset($item["PREVIEW_TEXT"]) && !empty($item["PREVIEW_TEXT"])){?>
			<div class="analyzes__list-item-text"><?= $item["PREVIEW_TEXT"] ?></div>
			<?}elseif(isset($item["DETAIL_TEXT"]) && !empty($item["DETAIL_TEXT"])){?>
			<div class="analyzes__list-item-text"><?= $item["DETAIL_TEXT"] ?></div>
			<?}?>
		</div>
		<?if($event==5):?>
		<div class="analyzes__list-item-price price"><span class="price__num">от <?=$event_price?> ₽</span> <span class="price__rub"></span></div>
		<div class="analyzes__list-item-price price"><span class="price__old_num">от <?=$price?> ₽</span> <span class="price__rub"></span></div>
		
		<??>
		<?else:?>
		<div class="analyzes__list-item-price price"><span class="price__num">от <?=$price?> ₽</span> <span class="price__rub"></span></div>
		<?endif;?>
	</div>
	<?}
	elseif(empty($price)){?>
		
		<div class="analyzes__list-item">
		<div class="analyzes__list-item-body">
			<div class="analyzes__list-item-num">№<?= $item["ID"] ?></div>
			<div class="analyzes__list-item-title"><a href="<?= $item["DETAIL_PAGE_URL"] ?>"><?= $item["NAME"] ?></a></div>
			<?if(isset($item["PREVIEW_TEXT"]) && !empty($item["PREVIEW_TEXT"])){?>
			<div class="analyzes__list-item-text"><?= $item["PREVIEW_TEXT"] ?></div>
			<?}elseif(isset($item["DETAIL_TEXT"]) && !empty($item["DETAIL_TEXT"])){?>
			<div class="analyzes__list-item-text"><?= $item["DETAIL_TEXT"] ?></div>
			<?}?>
		</div>
		<?if($event==5):?>
		<div class="analyzes__list-item-price price"> <span class="price__num">от <?=$event_price?> ₽</span> <span class="price__rub"></span></div>
		
		
		<??>
		<?else:?>
		
		<?endif;?>
	</div>
		
	<?}
	}}?>
	<button class="analyzes__list-more" id="analyzes__list-more-click">Показать все</button>
</div>
<script>
var countelem;
countelem = $(".analyzes__list-item").length;
//console.log(item);
if(countelem<=3)
{
	$('#analyzes__list-more-click').css("display","none");
}
else{
	$('#analyzes__list-more-click').css("display","inline-block");
}
let menuOpen = 0;
//скрываем врачей, если их больше трех
	$('.analyzes__list-item:gt(2)').hide(); 
	//при нажатии на кнопку показываем
	$('.analyzes__list-more').click(function(b)
 {
	 if(menuOpen == 0) {
	 $('#analyzes__list-more-click').html('Скрыть все');
	  $('.analyzes__list-item:gt(2)').show(400); // Для показа  
	  menuOpen = 1;
	 }
	 else if(menuOpen == 1) {
		 $('.analyzes__list-item:gt(2)').hide(400);
		  $('#analyzes__list-more-click').html('Показать все');
    menuOpen = 0;
	 }
 });
 </script>
<style>
.analyzes__list-more {
    
	padding: 0 28px;
   
	margin-left: 500px;
    height: 40px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    display: inline-block;
    text-decoration: none;
    color: #1875C9;
    font-size: 14px;
    line-height: 40px;
	left:30px;
    border: 2px solid #BEEAC6;
    border-radius: 26.5px;
    background-color: #FFFFFF;
    -webkit-box-shadow: 0 2px 10px 0 rgba(222, 222, 222, 0.5);
    box-shadow: 0 2px 10px 0 rgba(222, 222, 222, 0.5);
    -webkit-transition: all 0.2s ease-in;
    transition: all 0.2s ease-in;
}
.analyzes__list-more:hover {
    -webkit-box-shadow: 0 2px 20px 0 #cecece;
    box-shadow: 0 2px 20px 0 #cecece;
}
button {
    appearance: button;
    -webkit-writing-mode: horizontal-tb !important;
    text-rendering: auto;
    color: -internal-light-dark(buttontext, rgb(170, 170, 170));
    letter-spacing: normal;
    word-spacing: normal;
    text-transform: none;
    text-indent: 0px;
    text-shadow: none;
    text-align: center;
    align-items: flex-start;
    cursor: default;
    background-color: -internal-light-dark(rgb(239, 239, 239), rgb(74, 74, 74));
    box-sizing: border-box;
    margin: 0em;
    font: 400 13.3333px Arial;
    padding: 1px 6px;
    border-width: 2px;
    border-style: outset;
    border-color: -internal-light-dark(rgb(118, 118, 118), rgb(195, 195, 195));
    border-image: initial;
}
</style>