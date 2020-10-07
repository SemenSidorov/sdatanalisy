<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$sect_doc=array();
foreach($arResult["ITEMS"] as $item){
	foreach($item["PROPERTIES"]["INTERESTING_SERVICES"]["VALUE"] as $Section_ID){
	
$rsSections = CIBlockSection::GetList(array("SORT"=>"ASC"),array('IBLOCK_ID' => 4, "ID" => $Section_Doctors["IBLOCK_SECTION_ID"]), false, array("ID", "IBLOCK_ID", "CODE", "NAME", "SECTION_PAGE_URL"), false)->GetNext();
$sect_doc[]=$rsSections;
}}
$sect_doc = array_unique($sect_doc, SORT_REGULAR);
//print_r($sect_doc);
?>
 



<div class="clinics__description">
	<div class="contacts-list">
<?foreach($arResult["ITEMS"] as $item){
	$props = [];
	foreach($item["DISPLAY_PROPERTIES"] as $arProperty){
		$props[$arProperty["CODE"]] = $arProperty["DISPLAY_VALUE"];
	}
	$item["PROPERTIES"] = $props;
?>
		<div class="contacts-list__item">
			<div class="contacts-list__item-contact">
				<div class="contacts-list__item-address"><a href="<?=$item["DETAIL_PAGE_URL"]?>"><?=$item["PROPERTIES"]["ADDRESS"]?></a></div>
				<a class="contacts-list__item-phone" href="tel:<?=$item["PROPERTIES"]["PHONE"]?>"><?=$item["PROPERTIES"]["PHONE"]?></a>
			</div>
			<div class="contacts-list__item-mode mode">
	<?if(isset($item["PROPERTIES"]["PHONE"]) && !empty($item["PROPERTIES"]["WEEKDAYS"])){?>
				<div class="mode__item">
					<div class="mode__item-title">Пн-Пт:</div>
					<div class="mode__item-value"><?=$item["PROPERTIES"]["WEEKDAYS"]?></div>
				</div>
	<?}if(isset($item["PROPERTIES"]["PHONE"]) && !empty($item["PROPERTIES"]["SATURDAY"])){?>
				<div class="mode__item">
					<div class="mode__item-title">Сб:</div>
					<div class="mode__item-value"><?=$item["PROPERTIES"]["SATURDAY"]?></div>
				</div>
	<?}if(isset($item["PROPERTIES"]["PHONE"]) && !empty($item["PROPERTIES"]["SUNDAY"])){?>
				<div class="mode__item">
					<div class="mode__item-title">Вс:</div>
					<div class="mode__item-value"><?=$item["PROPERTIES"]["SUNDAY"]?></div>
				</div>
	<?}?>
			</div>
		</div>
<?}?>
	</div>
</div>
<style>
.clinic-contact__map
{
	position:relative
}
</style>
<div class="m-clinics__title">Поиск медицинских центров</div>
<div id="clinic-map" class="clinic-contact__map">
<?$APPLICATION->IncludeComponent(
					"bitrix:news.list",
					"main_clinics_list",
					array(
						"ACTIVE_DATE_FORMAT" => "d.m.Y",
						"ADD_SECTIONS_CHAIN" => "N",
						"CACHE_FILTER" => "Y",
						"CACHE_GROUPS" => "Y",
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
						"FILTER_NAME" => "",
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
				); ?>
</div>
<style>
.middle__h2{
	padding-top:30px;
}
</style>
<h2 class="middle__h2">Вам может быть интересно</h2>
                <div class="interesting">
                    <div class="interesting__item">
                        <h3 class="middle__h3">Исследования и диагностика</h3>               
					    <h3 class="middle__h3">Анализы</h3>
					   <div class="interesting__list js-interesting-slider">
   <?
   
  $ob_section_analyzes = CIBlockSection::GetList(array("RAND"=>"ASC"), array("IBLOCK_ID"=>2, "ACTIVE"=>"Y"), false, array("ID", "IBLOCK_ID", "NAME", "CODE", "SECTION_PAGE_URL"), array("nTopCount"=>5));
	while($section_analyzes = $ob_section_analyzes->GetNext())
	// $Section_Analyzes["SECTION_PAGE_URL"]=str_replace("/doctors", "/analyzes", $Section_Analyzes["SECTION_PAGE_URL"]);
	{  //print_r($Section_Analyzes["SECTION_PAGE_URL"]);
	  ?>
							
							<a class="interesting__ist-item" href="<?=$section_analyzes["SECTION_PAGE_URL"]?>"><?=$section_analyzes["NAME"]?></a>
	<? }?>
					   </div>
						  <h3 class="middle__h3">Услуги</h3>
					   <div class="interesting__list js-interesting-slider">
							
   <?
  $ob_section_services = CIBlockSection::GetList(array("RAND"=>"ASC"), array("IBLOCK_ID"=>3, "ACTIVE"=>"Y"), false, array("ID", "IBLOCK_ID", "NAME", "CODE", "SECTION_PAGE_URL"), array("nTopCount"=>5));
	while($section_services = $ob_section_services->GetNext()) {
?>
							<a class="interesting__ist-item" href="<?=$section_services["SECTION_PAGE_URL"]?>"><?=$section_services["NAME"]?></a>
   <?}?>
                       </div>
	   
	    </div>
                    <div class="interesting__item">
                        <h3 class="middle__h3">Врачи</h3>
					       
                        <div class="interesting__list js-interesting-slider">
						
   <? $ob_section_doctors = CIBlockSection::GetList(array("RAND"=>"ASC"), array("IBLOCK_ID"=>4, "ACTIVE"=>"Y"), false, array("ID", "IBLOCK_ID", "NAME", "CODE", "SECTION_PAGE_URL"), array("nTopCount"=>5));
	while($section_doctors = $ob_section_doctors->GetNext()) {
  ?>
                            <a class="interesting__ist-item" href="<?=$section_doctors["SECTION_PAGE_URL"]?>"><?=$section_doctors["NAME"]?></a>
  <?}?>
                        </div>
                    </div>
                    <div class="interesting__item">
                        <h3 class="middle__h3">Статьи</h3>
						<div class="articles-list">
						<?
						$db_Section_News= CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), Array("IBLOCK_ID"=>6, "ACTIVE"=>"Y" ),  Array("ID", "NAME", "CODE", "DATE_ACTIVE_FROM", "DETAIL_PAGE_URL" ),   Array ("nTopCount" => 3));
                         while($Section_News=$db_Section_News->GetNext())
						 {
							 $Section_News["DETAIL_PAGE_URL"]=str_replace("#ELEMENT_CODE#", $Section_News["CODE"], $Section_News["DETAIL_PAGE_URL"]);
							 ?>
							 <div class="articles-list__item">
                                <div class="articles-list__item-date"><?=$Section_News["DATE_ACTIVE_FROM"]?></div>
                                <a class="articles-list__item-text" href="<?=$Section_News["DETAIL_PAGE_URL"]?>"><?=$Section_News["NAME"]?></a>
                            </div>
					   <?}?>
					    </div>
                    </div>
                </div>