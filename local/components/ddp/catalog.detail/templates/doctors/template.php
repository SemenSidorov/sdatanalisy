<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
$APPLICATION->AddHeadScript('https://api-maps.yandex.ru/2.1/?apikey='.YANDEX_API_KEY.'&lang=ru_RU');
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
//получим последний непустой элемент разбивки url по разделителю "/":
$sections = explode('/', $APPLICATION->GetCurPage());
$sections = array_filter(
  $sections,
  function($el){ return !empty($el);}
);
$last_el = end($sections);
$show_404 = true;
$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y", "CODE"=>$last_el);
$arSelect = Array("ID", "NAME");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
if($ob = $res->GetNext())
{
  $show_404 = false;
}
$res = CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);
if($ob = $res->GetNext())
{
  $show_404 = false;
}
if ($show_404) echo '404';
if(($show_404)&&(!CSite::InDir("/404.php")))
{
  @define("ERROR_404", "Y");
CHTTP::SetStatus("404 Not Found");
}
//вывод 404 страницы
$this->setFrameMode(true);
//$this->addExternalCss('/bitrix/css/main/bootstrap.css');

$item = $arResult["ITEM"];
$ob_doc_section = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$item["IBLOCK_ID"], "ACTIVE"=>"Y", "ID"=>$item["IBLOCK_SECTION_ID"]), false, false, Array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "CODE", "SECTION_PAGE_URL"));
$doc_section = $ob_doc_section->GetNext();

	$ob_cost_doc = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID" => 12,  "PROPERTY_DOC" => $item["ID"]), false, false, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "CODE", "NAME", "PROPERTY_*", "DETAIL_PAGE_URL"));
$cost_doc = $ob_cost_doc->GetNext();
$price = 0;
	$event_price = 0;
	$event = 0;
		//
		$an_event = CIBlockElement::GetProperty($cost_doc["IBLOCK_ID"], $cost_doc["ID"], array(), array("CODE" => "EVENT"));
		$an_event = $an_event->GetNext();
		$an_event_price = CIBlockElement::GetProperty($cost_doc["IBLOCK_ID"], $cost_doc["ID"], array(), array("CODE" => "EVENT_PRICE"));
		$an_event_price = $an_event_price->GetNext();
		$an_prop = CIBlockElement::GetProperty($cost_doc["IBLOCK_ID"], $cost_doc["ID"], array(), array("CODE" => "PRICE"));
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
//print_r($item["DETAIL_PICTURE"]["src"]);
?>
<?
if(!empty($item["DETAIL_PICTURE"]["src"]))
	$img = $item["DETAIL_PICTURE"]["src"];
elseif(!empty($item["PREVIEW_PICTURE"]["src"]))
	$img = $item["PREVIEW_PICTURE"]["src"];
else
	$img = "";
?>
<div class="doctors-detail">
	<div class="doctors-detail__photo"><img src="<?= $img ?>" alt=""></div>
	<div class="doctors-detail__body">
		<div class="doctors-detail__list">
			<div class="doctors-detail__list-item">
				<div class="doctors-detail__list-item-title">Специализация</div>
				<div class="doctors-detail__list-item-value"><a href="<?=$doc_section["SECTION_PAGE_URL"]?>"><?=$doc_section["NAME"]?></a></div>
			</div>
			<div class="doctors-detail__list-item">
				<div class="doctors-detail__list-item-title">Должность</div>
				<div class="doctors-detail__list-item-value"><?= $item["PROPERTIES"]["CATEGORY"]["VALUE"] ?></div>
			</div>
			<div class="doctors-detail__list-item">
				<div class="doctors-detail__list-item-title">Стаж</div>
				<div class="doctors-detail__list-item-value"><?= $item["PROPERTIES"]["EXPERIENCE"]["VALUE"] ?> <?if($item["PROPERTIES"]["EXPERIENCE"]["VALUE"]==1):?>год</li><?elseif($item["PROPERTIES"]["EXPERIENCE"]["VALUE"]==2 || $item["PROPERTIES"]["EXPERIENCE"]["VALUE"]==3 || $item["PROPERTIES"]["EXPERIENCE"]["VALUE"]==4):?>года</li><?else:?>лет</li><?endif;?></div>
			</div>
			
			<?
		if($price != 0){
		if($event == 7){
		
		?>
			<div class="doctors-detail__list-item">
                                    <div class="doctors-detail__list-item-title">Стоимость приема</div>
                                    <div class="doctors-detail__list-item-value">
                                        <span class="price__num"><?= $event_price ?> ₽</span> <span
                                            class="price__rub"></span>
											 <span class="price__old_num"><?= $price ?> ₽</span> 
                                    </div>
                                </div>
			
			
				<?}
		else{?>
				<div class="doctors-detail__list-item">
                                    <div class="doctors-detail__list-item-title">Стоимость приема</div>
                                    <div class="doctors-detail__list-item-value">
                                        <span class="price__num"><?= $price ?> ₽</span> <span
                                            class="price__rub"></span>
											
                                    </div>
                                </div>
			<?}}
		elseif(empty($price)){
		if($event==7)
		{
		?>
		
				<div class="doctors-detail__list-item">
                                    <div class="doctors-detail__list-item-title">Стоимость приема</div>
                                    <div class="doctors-detail__list-item-value">
                                        <span class="price__num"><?= $event_price ?> ₽</span> <span
                                            class="price__rub"></span>
											 
                                    </div>
                                </div>
			
		<?
		}
		else{
			
		}}?>	
			
			
		</div>
		<div class="doctors-detail__footer">
			<a class="doctors-detail__btn btn btn--secondary" data-fancybox data-src="#registration-detail-popup-form" href="javascript:;">Записаться на прием</a>
			<?
			$clinic = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 5, "PROPERTY_5_VALUE" => $item["ID"]), false, false, array());
$clinic = $clinic->GetNext();
$clinic_prop = CIBlockElement::GetProperty($clinic["IBLOCK_ID"], $clinic["ID"], array(), array());
while($prop = $clinic_prop->GetNext()){
	if($prop["MULTIPLE"] == "Y")
		$clinic["PROPERTIES"][$prop["CODE"]][] = $prop;
	else
		$clinic["PROPERTIES"][$prop["CODE"]] = $prop;
}
			
			global $doctorFilter, $clinicFilter;
			$doctorFilter = $item["NAME"];
			//print_r($item["NAME"]);
			
			$clinicFilter = $clinic["PROPERTIES"]["ADDRESS"]["VALUE"];
			?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:form.result.new", 
            "modal", 
            array(
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "CHAIN_ITEM_LINK" => "",
                "CHAIN_ITEM_TEXT" => "",
                "EDIT_URL" => "",
                "IGNORE_CUSTOM_TEMPLATE" => "N",
                "LIST_URL" => "",
                "SEF_MODE" => "N",
                "SUCCESS_URL" => "",
                "USE_EXTENDED_ERRORS" => "Y",
                "WEB_FORM_ID" => "1",
                "COMPONENT_TEMPLATE" => "modal",
                "VARIABLE_ALIASES" => array(
                    "WEB_FORM_ID" => "WEB_FORM_ID",
                    "RESULT_ID" => "RESULT_ID",
                )
            ),
            false
        );?>
		</div>
	</div>
</div>
<?

?>
<h2 class="middle__h2">Адрес клиники</h2>
<div class="clinic-contact">
	<div class="clinic-contact__panel">
		<div class="clinic-contact__col">
			<div class="clinic-contact__address"><?= $clinic["PROPERTIES"]["ADDRESS"]["VALUE"] ?></div>
			<a class="clinic-contact__phone" href="tel:<?= $clinic["PROPERTIES"]["PHONE"]["VALUE"] ?>"><?= $clinic["PROPERTIES"]["PHONE"]["VALUE"] ?></a>
		</div>
		<div class="clinic-contact__col">
			<div class="clinic-contact__mode mode mode--l">
				<?if(!empty($clinic["PROPERTIES"]["WEEKDAYS"]["VALUE"])){?>
				<div class="mode__item">
					<div class="mode__item-title">Понедельник - пятница:</div>
					<div class="mode__item-value"><?= $clinic["PROPERTIES"]["WEEKDAYS"]["VALUE"] ?></div>
				</div>
				<?}if(!empty($clinic["PROPERTIES"]["SATURDAY"]["VALUE"])){?>
				<div class="mode__item">
					<div class="mode__item-title">Суббота:</div>
					<div class="mode__item-value"><?= $clinic["PROPERTIES"]["SATURDAY"]["VALUE"] ?></div>
				</div>
				<?}if(!empty($clinic["PROPERTIES"]["SUNDAY"]["VALUE"])){?>
				<div class="mode__item">
					<div class="mode__item-title">Воскресенье:</div>
					<div class="mode__item-value"><?= $clinic["PROPERTIES"]["SUNDAY"]["VALUE"] ?></div>
				</div>
				<?}?>
			</div>
		</div>
	</div>
</div>
<div class="doctors__description">
<?if(!empty($item["DETAIL_TEXT"]) || !empty($item["PREVIEW_TEXT"])){
?>
	<h2 class="middle__h2">Информация о враче</h2>

	<?
if(!empty($item["DETAIL_TEXT"]))
	echo $item["DETAIL_TEXT"];
elseif(!empty($item["PREVIEW_TEXT"]))
	echo $item["PREVIEW_TEXT"];
}?>
</div>
	<style>.clinic-contact__map{
	position:relative;
}</style>
	 <div id="clinic-map" class="clinic-contact__map">
	<?php 
		global $hrFilter;//фильтр для детальной карты
		$hrFilter=array("ID" => $clinic["ID"]);
		$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "main_doctors_detail",
    Array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "N",
        "CACHE_TIME" => "3600",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array(
            "DETAIL_PICTURE",
            ""
        ),
        "FILTER_NAME" => "hrFilter",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => 5,
        "IBLOCK_TYPE" => "info",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "NEWS_COUNT" => "10000",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array(
            "CITY",
        ),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY2" => "NAME",
        "SORT_BY1" => "SORT",
        "SORT_ORDER1" => "ASC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N"
    )
);?>
	
	</div>
	
	


<h2 class="middle__h2">Врачи клиники</h2>
<?
$doc_id = [];
foreach($clinic["PROPERTIES"]["DOCTORS"] as $doc){
	$doc_id[] = $doc["VALUE"];
}
$GLOBALS["arrFilter"] = array("ID" => $doc_id);
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"doctors",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array("",""),
		"FILTER_NAME" => "arrFilter",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "4",
		"IBLOCK_TYPE" => "info",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array("ADDRESS","CATEGORY","SPECIALIZATION","EXPERIENCE","PRICE",""),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	)
);?>
<?
$serv_id = [];
foreach($clinic["PROPERTIES"]["SERVICES"] as $serv){
	$serv_id[] = $serv["VALUE"];
}
$GLOBALS["arrFilter"] = array("PROPERTY_DOCTOR" => $item["ID"]);
?>
<?

$cost_prop = array();//элементы блока цена с ценой анализа
//$fin_prop = array();//свойства цены анализов
$service_prop = array();// элементы блока анализы с разделом
$section_service = array(); //разделы блока анализы
$final_prop = array(); //массив анализов с ценой, акцией
$service_cost = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 9,  "PROPERTY_CLINIC" => $clinic["ID"]), false, false, array("ID", "NAME", "PROPERTY_SERVICES", "PROPERTY_PRICE", "PROPERTY_*"));
while($ob_service_cost = $service_cost->GetNext())
{
	
	$cost_prop[] = $ob_service_cost;
	
	}
		$i=0;
		foreach($cost_prop as $value)
		{
			$services = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 3, "ID" => $value["PROPERTY_SERVICES_VALUE"]), false, false, array("ID", "NAME", "CODE", "IBLOCK_SECTION_ID", "IBLOCK_ID", "DETAIL_PAGE_URL"));
			$ob_services = $services->GetNext();
			$service_prop[]= $ob_services;
			$event["EVENT_ID"] = $value["PROPERTY_61"];
			$new_prop["COST_ID"]=$value["ID"];
			$final_prop[]=array_merge($service_prop[$i], $new_prop, $event);
		$i++;
		}
		
		
		//print_r(count($final_prop));

if(count($final_prop)!=0)
{
?>

<h2 class="middle__h2">Услуги клиники</h2>
                <div class="services__list services__list--slider js-services-slider">
				
				<?foreach($final_prop as $service)
				{
					//print_r($service);?>
				
                    <div class="services__item">
                        <div class="services__item-title"><?=$service["NAME"]?></div>
						
						<?
							$fin = CIBlockElement::GetProperty(9, $service["COST_ID"], "sort", "asc", array("CODE" => "PRICE"));
                          $final = $fin->GetNext();
						  if($service["EVENT_ID"]==5)
						  { 
						   $event_price = CIBlockElement::GetProperty(9, $service["COST_ID"], "sort", "asc", array("CODE" => "EVENT_PRICE"));
                          $event_price = $event_price->GetNext();
								?>
								<div class="services__item-event">АКЦИЯ</div>
                        <div class="services__item-price price">
                             <span class="price__num">от <?=$event_price["VALUE"]?> ₽</span> <span
                                class="price__rub"></span></div>
							<div class="services__item-price price">
                             <span class="price__old_num">от <?=$final["VALUE"]?> ₽</span> <span
                                class="price__rub"></span></div>	
						  <?}
						  elseif(empty($event_price["VALUE"]) && !empty($final["VALUE"]))
						  {?>
					  <div class="services__item-price price">
                             <span class="price__num">от <?=$final["VALUE"]?> ₽</span> <span
                                class="price__rub"></span></div>
						  <?}
						  
						  else{}
						  ?>
						  
					  
                        <a class="services__item-more btn btn--secondary" href="<?=$service["DETAIL_PAGE_URL"]?>">Подробнее</a>
                    </div>
					
				<?}
?>
					
                    
                </div>
<?}?>