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
$city = Regions::getCurRegion();

$ar_section_doctor = array();
$ar_doctor = array();
$ar_clinic = array();
$ob_clinics = CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>5, "ACTIVE"=>"Y", "PROPERTY_4"=>$city ),  Array("ID", "NAME", "CODE", "PROPERTY_4", "PROPERTY_5" ),   false);
while($clinics = $ob_clinics->GetNext())
//
{
$ar_clinic[]=$clinics;
	
}
foreach($ar_clinic as $clinic)
{
	$ob_doctors = CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y", "ID"=>$clinic["PROPERTY_5_VALUE"] ),  Array("ID", "IBLOCK_SECTION_ID", "IBLOCK_ID", "NAME", "CODE" ),   false);
	while($doctors = $ob_doctors->GetNext())
	{
		$ar_doctor[]=$doctors;
		//print_r($doctors);
	}
}
foreach($ar_doctor as $doctor)
{
	$rs_doctors = CIBlockSection::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>4, "ID"=>$doctor["IBLOCK_SECTION_ID"]), false, Array("ID", "NAME", "CODE", "SECTION_PAGE_URL"),  false);
		while($s_doctors = $rs_doctors->GetNext())
		{
			$ar_section_doctor[]=$s_doctors;
		}
}

?>
<div class="search js-hide">
	<div class="search__line">
		<input id="search-by-type" class="search__line-field" type="text" autocomplete="off"
			   placeholder="Введите специализацию врача">
		<input type="button" class="search__line-btn" value="">
	</div>
	<div class="search__result js-hide__desktop-insert">
<?
$ar_section_doctor = array_unique($ar_section_doctor, SORT_REGULAR);

$i = 0;
if(count($ar_section_doctor)==0){
	@define("ERROR_404", "Y");
    CHTTP::SetStatus("404 Not Found");
}
foreach ($ar_section_doctor as &$arSection)
{
	
	//$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
	//$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
	if($i < 5){?>
		<div class="search__result-item"><a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a></div>
	<?}elseif($i == 5){?>
		<div class="js-hide__block-mobile">
			<div class="search__result-item"><a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a></div>
	<?}elseif($i < 15){?>
			<div class="search__result-item"><a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a></div>
	<?}elseif($i == 15){?>
		</div>
	</div>
	<div class="js-hide__block" style="display: none">
		<div class="search__result js-hide__mobile-insert">
			<div class="search__result-item"><a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a></div>
	<?}elseif($i >= 15){?>
			<div class="search__result-item"><a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a></div>
	<?}?>
<?}?>
		</div>
	</div>
<?if($i >= 15){?>
	<a class="search__more js-hide__btn" href="#">
		<span class="show">Показать все</span>
		<span class="hide" style="display: none">Скрыть</span>
	</a>
<?}?>
<?
$ob_default_text = CIBlockElement::GetProperty(1, $city, array(), array("CODE"=>"DEFAULT_TEXT_REGION"));
$default_text= $ob_default_text->Fetch();
?>
<?if(!empty($default_text["VALUE"])):?>
<div class="services__description">
<p class="middle__text"><?=$default_text["VALUE"]?>
</p>
</div>
<?else:?>
<div class="services__description">
<p class="middle__text"><?=$default_text["DEFAULT_VALUE"]?>
</p>
</div>
<?endif;?>

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
			0 => "DETAIL_PICTURE",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "5",
		"IBLOCK_TYPE" => "info",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"NEWS_COUNT" => "10000",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "CATEGORY",
			2 => "EXPERIENCE",
			3 => "PRICE",
			4 => "CITY",
			5 => "",
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
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "main_clinics_list",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"MESSAGE_404" => ""
	),
	false
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
</div>