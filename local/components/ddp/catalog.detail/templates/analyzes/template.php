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
//получим последний непустой элемент разбивки url по разделителю "/":
$sections = explode('/', $APPLICATION->GetCurPage());
$sections = array_filter(
  $sections,
  function($el){ return !empty($el);}
);
$last_el = end($sections);
$show_404 = true;
$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE"=>"Y", "CODE"=>$last_el);
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
$city_id = Regions::getCurRegion();
$ob_city = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 1, "ACTIVE"=>"Y", "ID" => $city_id), false, false, array("ID", "NAME", "CODE"));
$city = $ob_city -> Fetch();
$item = $arResult["ITEM"];

?>
<?
if(!empty($item["DETAIL_PICTURE"]["src"]))
	$img = $item["DETAIL_PICTURE"]["src"];
elseif(!empty($item["PREVIEW_PICTURE"]["src"]))
	$img = $item["PREVIEW_PICTURE"]["src"];
else
	$img = "";
?>
<div class="analyzes__description">
	<p class="middle__text">
		<?
		if(!empty($item["DETAIL_TEXT"]))
			echo $item["DETAIL_TEXT"];
		elseif(!empty($item["PREVIEW_TEXT"]))
			echo $item["PREVIEW_TEXT"];
		?>
	</p>
</div>

<?
	
	$proper_city = array();
	$clinics = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID" => 5, "ACTIVE"=>"Y", "PROPERTY_CITY" => $city["ID"]), false, false, array());
	$arClinics = [];
	$arIdClinics = [];
	while($clinic = $clinics->GetNext()){
		$analyzes = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID" => 8, "ACTIVE"=>"Y", "PROPERTY_ANALYSIS" => $item["ID"], "PROPERTY_CLINIC" => $clinic["ID"]), false, false, array());
		$analyzes = $analyzes->GetNext();
		$an_prop = CIBlockElement::GetProperty($analyzes["IBLOCK_ID"], $analyzes["ID"], array("SORT"=>"ASC"), array("CODE" => "PRICE"));
		
		if($an_prop = $an_prop->GetNext()){
			$clinic["PRICE"] = $an_prop["VALUE"];
		}else{
			$clinic["PRICE"] = 0;
		}
$an_prop_event = CIBlockElement::GetProperty($analyzes["IBLOCK_ID"], $analyzes["ID"], array("SORT"=>"ASC"), array("CODE" => "EVENT"));
		
		if($an_prop_event = $an_prop_event->GetNext()){
			$clinic["EVENT"] = $an_prop_event["VALUE"];
		}else{
			$clinic["EVENT"] = 0;
		}
		$an_prop_event_price = CIBlockElement::GetProperty($analyzes["IBLOCK_ID"], $analyzes["ID"], array("SORT"=>"ASC"), array("CODE" => "EVENT_PRICE"));
		
		if($an_prop_event_price = $an_prop_event_price->GetNext()){
			$clinic["EVENT_PRICE"] = $an_prop_event_price["VALUE"];
		}else{
			$clinic["EVENT_PRICE"] = 0;
		}
		$props = CIBlockElement::GetProperty($clinic["IBLOCK_ID"], $clinic["ID"], array("SORT"=>"ASC"), array("CODE" => array("ADDRESS", "PHONE", "WEEKDAYS", "SATURDAY", "SUNDAY")));
		while($prop = $props->GetNext()){
			$clinic[$prop["CODE"]] = $prop["VALUE"];
		}
		$arIdClinics[] = $clinic["ID"];
		$arClinics[$clinic["ID"]] = $clinic;
	}
?>

<div class="analyzes__description">
	<h2 class="middle__h2">Где можно сдать анализ в регионе <?=$city["NAME"]?></h2>
	<div class="contacts-list">
		<?
		//print_r($arClinics);
		
		foreach($arClinics as $clinic){
			
			?>
		<div class="contacts-list__item">
			<div class="contacts-list__item-contact">
				<div class="contacts-list__item-address"><a href="<?=$clinic["DETAIL_PAGE_URL"]?>"><?=$clinic["ADDRESS"]?></a></div>
				<a class="contacts-list__item-phone" href="tel:84953453423"><?=$clinic["PHONE"]?></a>
			</div>
			<div class="contacts-list__item-mode mode">
				<?if(isset($clinic["WEEKDAYS"]) && !empty($clinic["WEEKDAYS"])){?>
				<div class="mode__item">
					<div class="mode__item-title">Пн-Пт:</div>
					<div class="mode__item-value"><?=$clinic["WEEKDAYS"]?></div>
				</div>
				<?}?>
				<?if(isset($clinic["SATURDAY"]) && !empty($clinic["SATURDAY"])){?>
				<div class="mode__item">
					<div class="mode__item-title">Сб:</div>
					<div class="mode__item-value"><?=$clinic["SATURDAY"]?></div>
				</div>
				<?}?>
				<?if(isset($clinic["SUNDAY"]) && !empty($clinic["SUNDAY"])){?>
				<div class="mode__item">
					<div class="mode__item-title">Вс:</div>
					<div class="mode__item-value"><?=$clinic["SUNDAY"]?></div>
				</div>
				<?}?>
			</div>
			<?if($clinic["EVENT"]==3 && !empty($clinic["PRICE"])):?>
			<div class="contacts-list__item-price price"> <span class="price__num">от <?=$clinic["EVENT_PRICE"]?> ₽</span> <span class="price__rub"></span></div>
			<div class="contacts-list__item-price price"> <span class="price__old_num">от <?=$clinic["PRICE"]?> ₽</span> <span class="price__rub"></span></div>
			<?elseif($clinic["EVENT"]==3 && empty($clinic["PRICE"])):?>
			<div class="contacts-list__item-price price"><span class="price__num">от <?=$clinic["EVENT_PRICE"]?> ₽</span> <span class="price__rub"></span></div>
			<?elseif($clinic["EVENT"]!=3 && !empty($clinic["PRICE"])):?>
			<div class="contacts-list__item-price price"> <span class="price__num">от <?=$clinic["PRICE"]?> ₽</span> <span class="price__rub"></span></div>
			<?endif;?>
			<div class="contacts-list__item-col">
                <a class="contacts-list__item-btn btn btn--secondary" data-fancybox data-src="#registration-popup" href="javascript:;">Записаться</a>
                <div id="registration-popup" class="clinics__find-time-popup popup" style="display: none;">
                    <div class="popup__title">Записаться</div>
                    <form class="form form--center" action="" method="GET">
                        <div class="form__item">
                            <input class="form__field" type="text" name="" placeholder="Ваше имя и фамилия">
                        </div>
                        <div class="form__item">
                            <input class="form__field" type="email" name="" placeholder="Почта для обратной связи">
                        </div>
                        <div class="form__item">
                            <input class="form__field" type="tel" name="" data-mask="+7-000-000-00-00" placeholder="Телефон для обратной связи" autocomplete="off" maxlength="16">
                        </div>
                        <div class="form__footer">
                            <input class="btn btn--secondary" type="submit" value="Записаться" name="" id="web_form_submit_id1">
                        </div>
                    </form>
                </div>
            </div>
		</div>
		<?}?>
	</div>
</div>
<?
$ob_norma = CIBlockElement::GetProperty(2, $item["ID"], array("SORT"=>"ASC"), array("CODE" => "NORMA"));
$norma = $ob_norma->Fetch();
$ob_examination = CIBlockElement::GetProperty(2, $item["ID"], array("SORT"=>"ASC"), array("CODE" => "EXAMINATION"));
$examination = $ob_examination->Fetch();
$ob_interpretation_result = CIBlockElement::GetProperty(2, $item["ID"], array("SORT"=>"ASC"), array("CODE" => "INTERPRETATION_RESULT"));
$interpretation_result = $ob_interpretation_result->Fetch();
?>
<?if(!empty($norma["VALUE"])):?>
<div class="analyzes__description">
                    <h2 class="middle__h2">Норма</h2>
                    <div class="alert"><?=$norma["VALUE"]?></div>
</div>
<?endif;?>
<?if(!empty($examination["VALUE"])):?>
<div class="analyzes__description">
                    <h2 class="middle__h2">Подготовка к исследованию</h2>
                    <p class="middle__text"><?=$examination["VALUE"]?></p>
                </div>
				<?endif;?>
				<?if(!empty($interpretation_result["VALUE"]["TEXT"])):?>
				<div class="analyzes__description">
                    <h2 class="middle__h2">Интерпретация результата</h2>
                    <?=$interpretation_result["VALUE"]["TEXT"]?>
					</div>
					<?endif;?>
		
<?


?>
		


<div class="analyzes__description">
	<h2 class="middle__h2">Акции</h2>
	<div class="analyzes-slider js-analyzes-slider" id="analyzes-slider js-analyzes-slider">
		<?
$cost_prop = array();//элементы блока цена с ценой анализа
$analyzis_prop = array();// элементы блока анализы с разделом
$section_analyzes = array(); //разделы блока анализы
$final_prop = array(); //массив анализов с ценой, акцией
foreach($arClinics as $clinic){
$analysis_cost = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID" => 8, "ACTIVE"=>"Y", "PROPERTY_CLINIC" => $clinic["ID"]), false, false, array("ID", "NAME", "CODE", "PROPERTY_ANALYSIS", "PROPERTY_PRICE", "PROPERTY_*"));
while($ob_analysis_cost = $analysis_cost->Fetch())
{
	
	$cost_prop[] = $ob_analysis_cost;
	}
		$i=0;
		foreach($cost_prop as $value)
		{
			$analyzes = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID" => 2, "ACTIVE"=>"Y", "ID" => $value["PROPERTY_ANALYSIS_VALUE"]), false, false, array("ID", "NAME", "CODE", "IBLOCK_SECTION_ID", "DETAIL_TEXT", "DETAIL_PAGE_URL", "PROPERTY_1_VALUE"));
			$ob_analyzes = $analyzes->GetNext();
			$analyzis_prop[]= $ob_analyzes;
			$event["EVENT_ID"] = $value["PROPERTY_59"];
			$new_prop["COST_ID"]=$value["ID"];
			$final_prop[]=array_merge($analyzis_prop[$i], $new_prop, $event);
		$i++;
		}
		//print_r(count($final_prop));
		foreach($final_prop as $analyz)
		{
			$ob_section = CIBlockSection::GetList(array('SORT'=>'ASC'), array('IBLOCK_ID'=> 2, "ACTIVE"=>"Y", 'ID'=> $analyz["IBLOCK_SECTION_ID"], false, array("ID", "NAME", "CODE"), false));
			$section = $ob_section-> Fetch();
			$fin = CIBlockElement::GetProperty(8, $analyz["COST_ID"], "sort", "asc", array("CODE" => "PRICE"));
                          $final = $fin->Fetch();
						  if($analyz["EVENT_ID"]==3)
						  { 
						   $event_price = CIBlockElement::GetProperty(8, $analyz["COST_ID"], "sort", "asc", array("CODE" => "EVENT_PRICE"));
                          $event_price = $event_price->Fetch();
						  $event_description = CIBlockElement::GetProperty(8, $analyz["COST_ID"], "sort", "asc", array("CODE" => "EVENT_DESCRIPTION"));
                          $event_description = $event_description->Fetch();
			?>
		<div class="analyzes-slider__item">
			<div class="analyzes-slider__num">№<?=$analyz["ID"]?></div>
			<div class="analyzes-slider__title"><?=$analyz["NAME"]?></div>
			<div class="analyzes-slider__text"><?=$analyz["DETAIL_TEXT"]?></div>
			<div class="analyzes-slider__footer">
				<div class="analyzes-slider__price price"> <span class="price__num">от <?=$event_price["VALUE"]?> ₽</span> <span class="price__rub"></span><span class="price__old-price">от <?=$final["VALUE"]?> ₽ </span></div>
				<a href="<?=$analyz["DETAIL_PAGE_URL"]?>" class="analyzes-slider__more btn btn--invert">Подробнее</a>
			</div>
		</div>
		<?}
		}
		}?>
		
	</div>
</div>
<script>
	//изменяем класс акций, если их меньше трех, для нормального отображения
	var slider;
	 slider = $('.analyzes-slider__item').length
	
	if(slider==1){
		document.getElementById("analyzes-slider js-analyzes-slider").className = "analyzes-slider";
	}
	else if(slider==2){
		document.getElementById("analyzes-slider js-analyzes-slider").className = "analyzes-slider";
		
	}
	</script>
	<style>.analyzes-slider__item{
		
			margin-top:10px;
		}</style>
<?
$GLOBALS["arrFilter"] = array("SECTION_ID" => $item["IBLOCK_SECTION_ID"], "!ID" => $item["ID"]);
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"analyzes",
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
		"IBLOCK_ID" => $item["IBLOCK_ID"],
		"IBLOCK_TYPE" => "info",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "5",
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
		"PROPERTY_CODE" => array(""),
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
