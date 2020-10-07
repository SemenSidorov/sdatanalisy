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

$ar_section_service = array();
$ar_service = array();
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
$ar_section_doctor = array_unique($ar_section_doctor, SORT_REGULAR);
	$ob_services = CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "PROPERTY_64_VALUE"=>$city ),  Array("ID", "IBLOCK_SECTION_ID", "IBLOCK_ID", "NAME", "CODE" ),   false);
	while($services = $ob_services->GetNext())
	{
		$service_cost = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 9,  "PROPERTY_SERVICES_VALUE" => $arResult["ID"]), false, false, array("ID", "NAME", "CODE", "PROPERTY_SERVICES", "PROPERTY_PRICE", "PROPERTY_*"));
		$ob_service_cost= $service_cost->GetNext();
		
$ar_service[]=$services;
		//print_r($ob_service_cost);
	}

foreach($ar_service as $service)
{
	$rs_services = CIBlockSection::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>3, "ID"=>$service["IBLOCK_SECTION_ID"]), false, Array("ID", "NAME", "CODE", "SECTION_PAGE_URL"),  false);
		while($s_services = $rs_services->GetNext())
		{
			$ar_section_service[]=$s_services;
		}
}
?>		
<div class="search js-hide">
	<div class="search__line">
		<input id="search-by-type" class="search__line-field" type="text" autocomplete="off"
				placeholder="Введите название исследования">
		<input type="button" class="search__line-btn" value="">
	</div>
	<div class="search__result js-hide__desktop-insert">
<?
$ar_section_service = array_unique($ar_section_service, SORT_REGULAR);

$i = 0;
if(count($ar_section_service)==0){
	@define("ERROR_404", "Y");
    CHTTP::SetStatus("404 Not Found");
}
foreach ($ar_section_service as &$arSection)
{
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
<?//foreach ($Section_prop_interesting as $arSection)
//{?>

<?//}?>