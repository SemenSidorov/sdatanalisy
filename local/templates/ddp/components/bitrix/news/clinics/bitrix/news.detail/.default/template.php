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


//print_r('/local/templates/ddp/_html/Result/Scripts/map-points.js');
//$APPLICATION->AddHeadScript('https://api-maps.yandex.ru/2.1/?apikey='.YANDEX_API_KEY.'&lang=ru_RU');
$IBLOCK_ID_ANALYZES = 2;
$IBLOCK_ID_SERVICES = 3;
$IBLOCK_ID_DOCTORS = 4;
$IBLOCK_ID_COST_ANALYZES=8;
$IBLOCK_ID_COST_SERVICES=9;
//получим последний непустой элемент разбивки url по разделителю "/":
$sections = explode('/', $APPLICATION->GetCurPage());
$sections = array_filter(
  $sections,
  function($el){ return !empty($el);}
);
$last_el = end($sections);
$show_404 = true;
$arFilter = Array("IBLOCK_ID"=>5, "ACTIVE"=>"Y", "CODE"=>$last_el);
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

function name_sort($x, $y) {
return strcasecmp($x['имя'], $y['имя']);
}
$city=Regions::getCurRegion();
$ob_city = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>1, "ACTIVE"=>"Y", "ID"=>$city), false, Array("ID", "NAME", "CODE"), false);
$city = $ob_city->Fetch();


?>
<div class="clinics-detail">
	<div class="clinics-detail__body">
		<div class="clinics-detail__contact">
			<div class="clinics-detail__address"><?= $arResult["PROPERTIES"]["ADDRESS"]["VALUE"] ?></div>
			<a class="clinics-detail__phone" href="tel:<?= $arResult["PROPERTIES"]["PHONE"]["VALUE"] ?>"><?= $arResult["PROPERTIES"]["PHONE"]["VALUE"] ?></a>
		</div>
		<a class="clinics-detail__add-favourites js-add-favorites" href="#" data-id="<?= $arResult['ID'] ?>">
			<span class="clinics-detail__add-favourites__ico"><svg width="20" height="19" xmlns="http://www.w3.org/2000/svg">
					<path class="star" d="M14.55 16.262l-.87-5.066 3.682-3.588-5.087-.74L10 2.26 7.725 6.869l-5.087.74 3.681 3.587-.869 5.066L10 13.87l4.55 2.392z" stroke="#ffffff" stroke-width="2" fill="none" fill-rule="evenodd" /></svg></span>
			<span class="clinics-detail__add-favourites__text">Добавить клинику в избранное</span>
			<span class="clinics-detail__add-favourites__text" style="display: none">Убрать клинику из избранного</span>
		</a>
	</div>
	<div class="clinics-detail__info">
		<??>
		<?if(isset($arResult["PROPERTIES"]["PROMOTIONS"]["VALUE"][0]) && !empty($arResult["PROPERTIES"]["PROMOTIONS"]["VALUE"][0])){
	$promo = CIBlockElement::GetByID($arResult["PROPERTIES"]["PROMOTIONS"]["VALUE"][0]);
	$promo = $promo->GetNext();
	/*$promo_prop = CIBlockElement::GetProperty(7, $arResult["PROPERTIES"]["PROMOTIONS"]["VALUE"][0], array(), array());
	while($prop = $prop->GetNext()){
		$promo["PROPERTIES"][$prop["CODE"]] = $prop;
	}*/

	if(isset($promo["DETAIL_TEXT"]) && !empty($promo["DETAIL_TEXT"]) && isset($promo["PREVIEW_TEXT"]) && !empty($promo["PREVIEW_TEXT"])){
		$str = $promo["PREVIEW_TEXT"];
		$str2 = $promo["DETAIL_TEXT"];
	}else{
		if(isset($promo["DETAIL_TEXT"]) && !empty($promo["DETAIL_TEXT"])){
			$text = $promo["DETAIL_TEXT"];
		}elseif(isset($promo["PREVIEW_TEXT"]) && !empty($promo["PREVIEW_TEXT"])){
			$text = $promo["PREVIEW_TEXT"];
		}else{
			$text = "";
		}
		if(strlen($text) > 200){
			$exp = explode(' ', $text);
			$str = $exp[0];
			$str2 = '';
			for($i=1; $i<count($exp); $i++){
				if(strlen($str) + strlen($exp[$i]) < 200){
					$str .= $exp[$i].' ';
				}else{
					$str2 .= $exp[$i].' ';
				}
			}
			$str .= '...';
		}else{
			$str = $text;
		}
	}
?>
		<div class="clinics-detail__text">
			<?= $str ?>
		</div>
		
		<?}?>
	</div>
</div>
<div class="clinics-nav">
	<div class="clinics-nav__inner">
		<a class="clinics-nav__item" href="#about">О клинике</a>
		<a class="clinics-nav__item" href="#analyzes">Анализы</a>
		<a class="clinics-nav__item" href="#services">Услуги</a>
		<a class="clinics-nav__item" href="#doctors">Врачи клиники</a>
		<a class="clinics-nav__item" href="#event_clinic">Акции</a>
		<a class="clinics-nav__item" href="#equipment">Оборудование</a>
		<a class="clinics-nav__item" href="#licenses">Лицензии</a>
		<a class="clinics-nav__item" href="#contacts">Контакты</a>
	</div>
</div>
<div id="about" class="clinics__description">
	<h2 class="middle__h2">О клинике</h2>
	<div class="clinics-about js-hide">
	
		<?
	if(isset($arResult["DETAIL_PICTURE"]["SRC"]) && !empty($arResult["DETAIL_PICTURE"]["SRC"])){
		$img = $arResult["DETAIL_PICTURE"]["SRC"];
	}elseif(isset($arResult["PREVIEW_PICTURE"]["SRC"]) && !empty($arResult["PREVIEW_PICTURE"]["SRC"])){
		$img = $arResult["PREVIEW_PICTURE"]["SRC"];
	}else{ $img = ""; }
	//print_r($arResult["PROPERTIES"]["PICTURE_CLINIC"]);
	?>
	
	
	<div class="clinics-about__img"><img src="<?=$img?>" alt="<?=$arResult["NAME"]?>"></div>
		
	<?
	if($arResult["DISPLAY_PROPERTIES"]["PICTURE_CLINIC"]["DISPLAY_VALUE"])
	{
		?>
		
		<?$ob_picture_clinic = CIBlockElement::GetProperty($arResult['IBLOCK_ID'], $arResult['ID'], "sort", "asc", array("CODE" => "PICTURE_CLINIC"));
            while($picture_clinic = $ob_picture_clinic->GetNext())
            {	

             $image_value = $picture_clinic['VALUE'];
            $file = CFile::GetFileArray($image_value);
             $image_SRC = $file['SRC'];
             $image_description = $ob_equipment["DESCRIPTION"];
	
?>
		<div class="clinics-about__img"><img src="<?=$image_SRC?>" alt="<?=$image_description?>"></div>
		
	<?}?>
	
	
	<?}?>
	<div class="clinics-about__body">
	
		
			<?
	if(isset($arResult["DETAIL_TEXT"]) && !empty($arResult["DETAIL_TEXT"])){
		$text = $arResult["DETAIL_TEXT"];
	}elseif(isset($arResult["PREVIEW_TEXT"]) && !empty($arResult["PREVIEW_TEXT"])){
		$text = $arResult["PREVIEW_TEXT"];
	}else{
		$text = "";
	}
	if(strpos($text, "</p>") !== false){
		$exp = explode('</p>', $text);
		$str = $exp[0];
		$str2 = '';
		for($i=1; $i<count($exp); $i++){
			if(strlen($str) + strlen($exp[$i]) < 800){
				$str .= $exp[$i]."</p>";
			}else{
				$str2 .= $exp[$i]."</p>";
			}
		}
	}else{
		if(strlen($text) > 900){
			$exp = explode(' ', $text);
			$str = $exp[0];
			$str2 = '';
			for($i=1; $i<count($exp); $i++){
				if(strlen($str) + strlen($exp[$i]) < 800){
					$str .= $exp[$i].' ';
				}else{
					$str2 .= $exp[$i].' ';
				}
			}
			$str .= '...';
		}else{
			$str = $text;
		}
	}
?>

			<?if(isset($str) && !empty($str)){
		echo $str;
	}
	if(isset($str2) && !empty($str2)){
	?>
			<div class="js-hide__block" style="display: none">
				<?= $str2 ?>
			</div>
			<?}?>
		</div>
		<?if(isset($str2) && !empty($str2)){?>
		<a class="clinics-about__btn js-hide__btn" href="#">
			<span>Развернуть</span>
			<span style="display: none">Скрыть</span>
		</a>
		<?}?>
	</div>
</div>
<div id="analyzes" class="clinics__description">
	<h2 class="middle__h2">Анализы</h2>
	<div class="clinics__search-line search-line">
		<input class="js-search-in-accordion search-line__field" type="text" autocomplete="off" placeholder="Введите название анализа">
		<input type="button" class="search-line__btn" value="">
	</div>

	<?
$cost_prop = array();//элементы блока цена с ценой анализа
//$fin_prop = array();//свойства цены анализов
$analyzis_prop = array();// элементы блока анализы с разделом
$section_analyzes = array(); //разделы блока анализы
$final_prop = array(); //массив анализов с ценой, акцией
$analysis_cost = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $IBLOCK_ID_COST_ANALYZES,  "PROPERTY_38" => $arResult["ID"]), false, false, array("ID", "NAME", "CODE", "PROPERTY_ANALYSIS", "PROPERTY_PRICE", "PROPERTY_*"));
while($ob_analysis_cost = $analysis_cost->Fetch())
{
	
	$cost_prop[] = $ob_analysis_cost;
	}
//	print_r($cost_prop);
		$i=0;
		foreach($cost_prop as $value)
		{
			$analyzes = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $IBLOCK_ID_ANALYZES, "ID" => $value["PROPERTY_ANALYSIS_VALUE"]), false, false, array("ID", "NAME", "CODE", "IBLOCK_SECTION_ID", "DETAIL_TEXT", "DETAIL_PAGE_URL"));
			$ob_analyzes = $analyzes->GetNext();
			$analyzis_prop[]= $ob_analyzes;
			$event["EVENT_ID"] = $value["PROPERTY_59"];
			$new_prop["COST_ID"]=$value["ID"];
			$final_prop[]=array_merge($analyzis_prop[$i], $new_prop, $event);
		$i++;
		}
		$final_prop = array_unique($final_prop, SORT_REGULAR);
		foreach($analyzis_prop as $prop)
		{$rsSection = \Bitrix\Iblock\SectionTable::getList(array('filter' => array('IBLOCK_ID' => $IBLOCK_ID_ANALYZES, 'ID'=>$prop["IBLOCK_SECTION_ID"]), 'select' =>  array('ID','CODE','NAME'),)); //корневые разделы
		$obSection= $rsSection->Fetch();
		$section_analyzes[]= $obSection;
		}
		$section_analyzes = array_unique($section_analyzes, SORT_REGULAR);
			foreach($section_analyzes as $section)
		{
	?>
	<div class="accordion">
		<div class="accordion__item">
			<div class="accordion__title"><?= $section["NAME"] ?></div>
			<div class="accordion__body">
				<div class="accordion__list">
					<?
				$j=1;
				foreach($final_prop as $analyz)
				{
					
				 if($analyz["IBLOCK_SECTION_ID"]==$section["ID"])
				{	
			$fin = CIBlockElement::GetProperty($IBLOCK_ID_COST_ANALYZES, $analyz["COST_ID"], "sort", "asc", array("CODE" => "PRICE"));
                          $final = $fin->Fetch();
						  
				?>
					<div class="accordion__list-item">
						<div class="accordion__list-item-title"><a data-fancybox data-src="#analysis-info-<?= $j ?>" href="javascript:;"><?= $analyz["NAME"] ?></a></div>
						<?
							//print_r($analyz["CODE"]);
							
						  if($analyz["EVENT_ID"]==3)
						  { 
						   $event_price = CIBlockElement::GetProperty($IBLOCK_ID_COST_ANALYZES, $analyz["COST_ID"], "sort", "asc", array("CODE" => "EVENT_PRICE"));
                          $event_price = $event_price->Fetch();
						  //print_r($analyz["CODE"]);
								?>
						<div class="accordion__list-item-price price">АКЦИЯ</div>
						<div class="accordion__list-item-price price vent">от <span class="price__num"><?= $event_price["VALUE"] ?></span> <span class="price__rub">₽</span>
							<div class="accordion__list-item-price price">от <span class="price__old_num"><s><?= $final["VALUE"] ?></s></span><span class="price__rub">₽</span>
							</div>
						</div>
						<?}
						  elseif(!empty($final["VALUE"]))
						  {?>
						<div class="accordion__list-item-price price">от <span class="price__num"><?= $final["VALUE"] ?></span> <span class="price__rub">₽</span></div>
						<?}
						else{}
						
						
						
						  ?>
						<a class="accordion__list-item-btn btn btn--secondary" data-fancybox data-src="#registration-popup-analyzes-<?= $j ?>" href="javascript:;">Записаться</a>
<div id="registration-popup-analyzes-<?= $j ?>" class="clinics__find-time-popup popup" style="display: none">
				<div class="popup__title">Записаться на прием</div>
	<form class="form form--center" action="" method="GET">
					<div class="form__item">
						<input class="form__field" type="text" name="form_text_1-<?=$i?>" placeholder="Ваше имя и фамилия">
						
					</div>
					<div class="form__item">
						<input class="form__field" type="email" name="form_email_2-<?=$i?>" placeholder="Почта для обратной связи">
					</div>
					<div class="form__item">
						<input class="form__field" type="tel" name="form_text_3-<?=$i?>" data-mask="+7-000-000-00-00" placeholder="Телефон для обратной связи">
					</div>
				<?/*	<div class="form__item">
	<input placeholder="Доктор" type="hidden" class="form__field" name="form_text_4-<?=$i?>" value="<?=$doc["NAME"]?>" size="0">	
	</div>
	<div class="form__item">
	<input placeholder="Клиника" type="hidden" class="form__field" name="form_text_5-<?=$i?>" value="<?=$arResult["PROPERTIES"]["ADDRESS"]["VALUE"]?>" size="0">		
	</div>*/	?>
					<div class="form__footer">
			<input class="btn btn--secondary" type="submit" value="Записаться" name="web_form_submit-<?=$j?>" id="web_form_submit_id<?=$j?>">
		
						
					</div>
				</form>
				</div>
						<div id="analysis-info-<?= $j ?>" class="analysis__popup popup" style="display: none">
						    <div class="popup__title">Информация об исследовании</div>
							<div class="popup__text"><?= $analyz["DETAIL_TEXT"] ?></div>
							<a class="btn" href="<?= $analyz["DETAIL_PAGE_URL"] ?>">Подробнее</a>
						</div>
					</div>
					<?}
				$j++;
			}?>
				</div>
			</div>
		</div>
	</div>

	<?
} 			    //}
               // }
            //}
?>


</div>

<?  //} ?>
<div id="services" class="clinics__description">
	<h2 class="middle__h2">Услуги</h2>
	<div class="clinics__search-line search-line">
		<input id="search-clinic-services" class="js-search-in-accordion search-line__field" type="text" autocomplete="off" placeholder="Введите название услуги">
		<input type="button" class="search-line__btn" value="">
	</div>
	<?
$cost_prop = array();//элементы блока цена с ценой анализа
//$fin_prop = array();//свойства цены анализов
$service_prop = array();// элементы блока анализы с разделом
$section_service = array(); //разделы блока анализы
$final_prop = array(); //массив анализов с ценой, акцией
$service_cost = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $IBLOCK_ID_COST_SERVICES,  "PROPERTY_40" => $arResult["ID"]), false, false, array("ID", "NAME", "PROPERTY_SERVICES", "PROPERTY_PRICE", "PROPERTY_*"));
while($ob_service_cost = $service_cost->Fetch())
{
	
	$cost_prop[] = $ob_service_cost;
	}
		$i=0;
		foreach($cost_prop as $value)
		{
			$services = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $IBLOCK_ID_SERVICES, "ID" => $value["PROPERTY_SERVICES_VALUE"]), false, false, array("ID", "NAME", "CODE", "IBLOCK_SECTION_ID", "IBLOCK_ID", "DETAIL_PAGE_URL"));
			$ob_services = $services->GetNext();
			$service_prop[]= $ob_services;
			$event["EVENT_ID"] = $value["PROPERTY_61"];
			$new_prop["COST_ID"]=$value["ID"];
			$final_prop[]=array_merge($service_prop[$i], $new_prop, $event);
		$i++;
		}
		foreach($service_prop as $prop)
		{$rsSection = \Bitrix\Iblock\SectionTable::getList(array('filter' => array('IBLOCK_ID' => $IBLOCK_ID_SERVICES, 'ID'=>$prop["IBLOCK_SECTION_ID"]), 'select' =>  array('ID','CODE','NAME'),)); //корневые разделы
		$obSection= $rsSection->Fetch();
		$section_service[]= $obSection;
		}
		$section_service = array_unique($section_service, SORT_REGULAR);
			foreach($section_service as $section)
		{
	?>
	<div class="accordion">
		<div class="accordion__item">
			<div class="accordion__title"><?= $section["NAME"] ?></div>
			<div class="accordion__body">
				<div class="accordion__list">
					<?
					$j=1;
				foreach($final_prop as $service)
				{
				 if($service["IBLOCK_SECTION_ID"]==$section["ID"])
				{	
				?>
					<div class="accordion__list-item">
						<div class="accordion__list-item-title"> <a href="<?= $service["DETAIL_PAGE_URL"] ?>"><?= $service["NAME"] ?></a></div>
						<?
							$fin = CIBlockElement::GetProperty($IBLOCK_ID_COST_SERVICES, $service["COST_ID"], "sort", "asc", array("CODE" => "PRICE"));
                          $final = $fin->Fetch();
						  if($service["EVENT_ID"]==5)
						  { 
						   $event_price = CIBlockElement::GetProperty($IBLOCK_ID_COST_SERVICES, $service["COST_ID"], "sort", "asc", array("CODE" => "EVENT_PRICE"));
                          $event_price = $event_price->Fetch();
								?>

						<div class="accordion__list-item-price price">АКЦИЯ</div>
						<div class="accordion__list-item-price price vent">от <span class="price__num"><?= $event_price["VALUE"] ?></span> <span class="price__rub">₽</span>
							<div class="accordion__list-item-price price">от <span class="price__num_old"><s><?= $final["VALUE"] ?></s></span><span class="price__rub">₽</span>
							</div>
						</div>
						<?}
						  elseif(!empty($final["VALUE"]))
						  {?>
						<div class="accordion__list-item-price price">от <span class="price__num"><?= $final["VALUE"] ?></span> <span class="price__rub">₽</span></div>
						<?}
						
						else{}
						?>


						<a class="accordion__list-item-btn btn btn--secondary" data-fancybox data-src="#registration-popup-services-<?= $j ?>" href="javascript:;">Записаться</a>
						<div id="registration-popup-services-<?= $j ?>" class="clinics__find-time-popup popup" style="display: none">
				<div class="popup__title">Записаться на прием</div>
	<form class="form form--center" action="" method="GET">
					<div class="form__item">
						<input class="form__field" type="text" name="form_text_1-<?=$i?>" placeholder="Ваше имя и фамилия">
						
					</div>
					<div class="form__item">
						<input class="form__field" type="email" name="form_email_2-<?=$i?>" placeholder="Почта для обратной связи">
					</div>
					<div class="form__item">
						<input class="form__field" type="tel" name="form_text_3-<?=$i?>" data-mask="+7-000-000-00-00" placeholder="Телефон для обратной связи">
					</div>
				<?/*	<div class="form__item">
	<input placeholder="Доктор" type="hidden" class="form__field" name="form_text_4-<?=$i?>" value="<?=$doc["NAME"]?>" size="0">	
	</div>
	<div class="form__item">
	<input placeholder="Клиника" type="hidden" class="form__field" name="form_text_5-<?=$i?>" value="<?=$arResult["PROPERTIES"]["ADDRESS"]["VALUE"]?>" size="0">		
	</div>*/	?>
					<div class="form__footer">
			<input class="btn btn--secondary" type="submit" value="Записаться" name="web_form_submit-<?=$j?>" id="web_form_submit_id<?=$j?>">
		
						
					</div>
				</form>
				</div>
					</div>
					<?  }
								$j++;
			}?>

				</div>
			</div>
		</div>
	</div>
	<?
} 			    //}
               // }
            //}
?>

	<script>
		
	
		$('#sorting__select_option').on('change', function(){
  if ($(this).val() == 2) {
   //var sortByNameBtn = document.getElementById('sorting__select_option');
$('.doctors__list').html($( ".doctors__list-item" ).get().reverse());
 
  }
  if ($(this).val() == 1){
	  $('.doctors__list').html($( ".doctors__list-item" ).get().reverse());
  }
})
	</script>
</div>





<div id="doctors" class="clinics__description">
	<div class="title">
		<div class="title__left">
			<h2 class="middle__h2">Врачи клиники</h2>
		</div>
		<div class="title__right">
			<div class="sorting no-js">
				<select class="sorting__select js-sorting" name="" id="sorting__select_option">
					<option value="1">Все врачи</option>
					<option value="2">Все врачи от А до Я</option>
				</select>
			</div>
		</div>
	</div>
	<div class="doctors__list">
		<?
//$doc_id = array();
	//print_r($arResult["PROPERTIES"]["DOCTORS"]["VALUE"]);
	//$doc_id[] = $arResult["PROPERTIES"]["DOCTORS"]["VALUE"];
//print_r($arResult["PROPERTIES"]["DOCTORS"]["VALUE"]);
?>
		<?
		$i=1;
		$ar_doctors = array();
		$ar_doctors_id = array();
		global $ar_fin;
		 $ar_fin=array();
		
		foreach ($arResult["PROPERTIES"]["DOCTORS"]["VALUE"] as $doc)
{
		$ob_doctors = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>$IBLOCK_ID_DOCTORS, "ID"=>$doc), false, array("ID", "NAME", "IBLOCK_ID", "CODE"), false);
	$doctors = $ob_doctors->GetNext();
	$ar_doctors["NAME"]=$doctors["NAME"];
	$ar_doctors_id["ID"] = $doctors["ID"];	
		$ar_fin[] = array_merge($ar_doctors,$ar_doctors_id);
		
}

rsort($ar_fin, name_sort($x,$y));
foreach ($ar_fin as $doc)
{
	$ob_doctors = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>$IBLOCK_ID_DOCTORS, "ID"=>$doc["ID"]), false, array(), false);
	$doctors = $ob_doctors->GetNext();
	$ob_section = CIBlockSection::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>$IBLOCK_ID_DOCTORS, "ID"=>$doctors["IBLOCK_SECTION_ID"]), false, array("ID", "NAME", "CODE"), false);
	$section = $ob_section->Fetch();
	$ob_spec = CIBlockElement::GetProperty($IBLOCK_ID_DOCTORS, $doctors["ID"], array("SORT"=>"ASC"), array("CODE"=>"CATEGORY"));
	$spec = $ob_spec->Fetch();
	$ob_exp = CIBlockElement::GetProperty($IBLOCK_ID_DOCTORS, $doctors["ID"], array("SORT"=>"ASC"), array("CODE"=>"EXPERIENCE"));
	$exp = $ob_exp->Fetch();
	$ob_cost_doc = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID" => 12,  "PROPERTY_DOC" => $doc), false, false, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "CODE", "NAME", "PROPERTY_*", "DETAIL_PAGE_URL"));
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
	?>
		<div class="doctors__list-item">
			<div class="doctors__list-item-body">
				<div class="doctors__list-item-photo">
					<?if(isset($doctors["PREVIEW_PICTURE"]["SRC"]) && !empty($doctors["PREVIEW_PICTURE"]["SRC"])){?>
					<img src="<?= $doctors["PREVIEW_PICTURE"]["SRC"] ?>" alt="" width="140" height="140">
					<?}?>
				</div>
				<div class="doctors__list-item-content">
					<div class="doctors__list-item-specialty"><?= $spec["VALUE"] ?></div>
					<div class="doctors__list-item-name"><a href="<?= $doctors["DETAIL_PAGE_URL"] ?>"><?= $doc["NAME"] ?></a></div>
					<ul class="doctors__list-item-description">
						<li><?= $section["NAME"] ?></li>
						<li><?= $spec["VALUE"] ?></li>
						<li>Стаж <?= $exp["VALUE"] ?>
							<?if($exp["VALUE"]==1):?>год</li>
						<?elseif($exp["VALUE"]==2 || $exp["VALUE"]==3 || $exp["VALUE"]==4):?>года</li>
						<?else:?>лет</li>
						<?endif;?>
					</ul>
				</div>
			</div>
			<div class="doctors__list-item-col">
				<div class="doctors__list-item-col-title">Адрес клиники</div>
				<div class="doctors__list-item-city"><?= $city["NAME"] ?></div>
				<div class="doctors__list-item-address"><a href="<?= $doctors["DETAIL_PAGE_URL"] ?>"><?= $arResult["PROPERTIES"]["ADDRESS"]["VALUE"] ?></a></div>
			</div>
			<div class="doctors__list-item-col">
			
				<?
		if($price != 0){
		if($event == 7){
		
		?>
		
			<div class="doctors__list-item-price-box">
				<div class="doctors__list-item-col-title">Стоимость приема</div>
<span class="price__num"><?= $event_price ?></span> <span class="price__rub">₽</span>
					<span class="price__old_num"><?= $price ?> ₽</span> <span class="price__rub"></span>
			</div>
			
				<?}
		else{?>
			<div class="doctors__list-item-price-box">
				<div class="doctors__list-item-col-title">Стоимость приема</div>

					<span class="price__num"><?= $price ?></span> <span class="price__rub">₽</span>
			</div>
			<?}}
		elseif(empty($price)){
		if($event==7)
		{
		?>
		
			<div class="doctors__list-item-price-box">
				<div class="doctors__list-item-col-title">Стоимость приема</div>

					<span class="price__num"><?= $event_price ?></span> <span class="price__rub">₽</span>
			</div>
			
		<?
		}
		else{
		}}?>
			
				<a class="doctors__list-item-btn btn btn--secondary" data-fancybox data-src="#registration-popup-<?=$i?>" href="javascript:;">Записаться на прием</a>
			<div id="registration-popup-<?=$i?>" class="clinics__find-time-popup popup" style="display: none">
				<div class="popup__title">Записаться на прием</div>
	<form class="form form--center" action="" method="GET">
					<div class="form__item">
						<input class="form__field" type="text" name="form_text_1-<?=$i?>" placeholder="Ваше имя и фамилия">
						
					</div>
					<div class="form__item">
						<input class="form__field" type="email" name="form_email_2-<?=$i?>" placeholder="Почта для обратной связи">
					</div>
					<div class="form__item">
						<input class="form__field" type="tel" name="form_text_3-<?=$i?>" data-mask="+7-000-000-00-00" placeholder="Телефон для обратной связи">
					</div>
					<div class="form__item">
	<input placeholder="Доктор" type="hidden" class="form__field" name="form_text_4-<?=$i?>" value="<?=$doc["NAME"]?>" size="0">		
	</div>
	<div class="form__item">
	<input placeholder="Клиника" type="hidden" class="form__field" name="form_text_5-<?=$i?>" value="<?=$arResult["PROPERTIES"]["ADDRESS"]["VALUE"]?>" size="0">		
	</div>
					<div class="form__footer">
			<input class="btn btn--secondary" type="submit" value="Записаться" name="web_form_submit-<?=$i?>" id="web_form_submit_id<?=$i?>">
		
						
					</div>
				</form>
				</div>
				
				
				
			
			<?
						if(!empty($_GET['web_form_submit-'.$i]))
	{$name = $_GET['form_text_1-'.$i]; 
$email = $_GET['form_email_2-'.$i];
$phone = $_GET['form_text_3-'.$i];
$doctor = $_GET['form_text_4-'.$i];
$clinic = $_GET['form_text_5-'.$i];
//print_r($clinic);
if(!empty($name) && !empty($email) && !empty($phone) && !empty($doctor) && !empty($clinic))
{
	$ob_id = CIBLockElement::GetList(array("ID"=>"DESC"), array("IBLOCK_ID"=>11),  array("ID", "NAME", "CODE", "IBLOCK_ID"), array("nTopCount"=>1));
	$id=$ob_id->Fetch();
	if($id["ID"])
	{	$id["ID"]=$id["ID"]+1;
	$name_zayavka = "Заявка №".$id["ID"]." на врача ".$doctor;
	//print_r($name_zayavka);
	//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/local/templates/ddp/components/bitrix/form.result.new/modal/ar_props.txt", print_r($name_zayavka, true), FILE_APPEND);
	//Получение символьного кода путём транслитерации наименования элемента
$arTranslitParams = array("replace_space"=>"-","replace_other"=>"-"); // Указываем на какой символ заменять пробел, на какой символ заменять все остальные символы отличные от букв и цифр.
$code = Cutil::translit(strtolower($name_zayavka),"ru",$arTranslitParams); // функцией strtolower - преобразуем все Заглавные буквы в Названии элемента в строчные буквы. Cutil::translit - транслитерирует русское наименование элемента.
	$ob_proverka = CIBLockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>11, "NAME"=>$name_zayavka, "CODE"=>$code),  array("ID", "NAME", "CODE", "IBLOCK_ID"), false);
	$proverka=$ob_proverka->Fetch();
	if(!$proverka){
	$name_zavka = "Заявка на врача ".$doctor;
	 $el = new CIBlockElement;  
	 $fields = array(
            'IBLOCK_ID' => 11,
            'NAME' => $name_zayavka,
            'ACTIVE' => "Y",
            'CODE' => $code,
			'PROPERTY_VALUES'=>array(
                 'CLIENT' => $name,
			     'EMAIL'=>$email,
			     'PHONE'=>$phone,
                 'DOC'=>$doctor,
				 'CLINIC'=>$clinic)
      );
	//  print_r($fields);
	  $rs_el=$el->Add($fields);
	  if($rs_el){
		  
		 // CBitrixComponent::clearComponentCache('bitrix:news');
		 // ClearResultCache();
		   //$this->AbortResultCache();
	  }
	}
	}
}
	}
						?>
			</div>
		</div>
		<?$i++;
}
?>

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
	<script>
	//изменяем класс акций, если их меньше трех, для нормального отображения
	var slider;
	 slider = $('.services-slider__item').length
	
	if(slider==1){
		document.getElementById("analyzes-slider js-analyzes-slider services").className = "analyzes-slider";
	}
	else if(slider==2){
		document.getElementById("analyzes-slider js-analyzes-slider services").className = "analyzes-slider";
		
	}
	</script>
	<script>
	var sections = $('.clinics__description')
  , nav = $('.clinics-nav__inner')
  , nav_height = nav.outerHeight();

$(window).on('scroll', function () {
  var cur_pos = $(this).scrollTop();
  
  sections.each(function() {
    var top = $(this).offset().top - nav_height,
        bottom = top + $(this).outerHeight();
    
    if (cur_pos >= top && cur_pos <= bottom) {
      nav.find('a').removeClass('active');
      sections.removeClass('active');
      
      $(this).addClass('active');
      nav.find('a[href="#'+$(this).attr('id')+'"]').addClass('active');
    }
  });
});

nav.find('a').on('click', function () {
  var $el = $(this)
    , id = $el.attr('href');
  
  $('html, body').animate({
    scrollTop: $(id).offset().top - nav_height
  }, 500);
  
  return false;
});
	</script>
	<div id="event_clinic" class="clinics__description">
		<h2 class="middle__h2">Акции</h2>
		<h3 class="middle__h3">Анализы</h3>
		<div class="analyzes-slider js-analyzes-slider" id="analyzes-slider js-analyzes-slider">
		
			<?$i=1;
		$cost_prop = array();//элементы блока цена с ценой анализа
//$fin_prop = array();//свойства цены анализов
$analyzis_prop = array();// элементы блока анализы с разделом
$section_analyzes = array(); //разделы блока анализы
$final_prop = array(); //массив анализов с ценой, акцией
$analysis_cost = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $IBLOCK_ID_COST_ANALYZES,  "PROPERTY_CLINIC" => $arResult["ID"]), false, false, array("ID", "NAME", "CODE", "PROPERTY_ANALYSIS", "PROPERTY_PRICE", "PROPERTY_*"));
while($ob_analysis_cost = $analysis_cost->Fetch())
{
	
	$cost_prop[] = $ob_analysis_cost;
	}
		$i=0;
		foreach($cost_prop as $value)
		{
			$analyzes = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $IBLOCK_ID_ANALYZES, "ID" => $value["PROPERTY_ANALYSIS_VALUE"]), false, false, array("ID", "NAME", "CODE", "IBLOCK_SECTION_ID", "DETAIL_TEXT", "IBLOCK_ID", "DETAIL_PAGE_URL"));
			$ob_analyzes = $analyzes->GetNext();
			$analyzis_prop[]= $ob_analyzes;
			$event["EVENT_ID"] = $value["PROPERTY_59"];
			$new_prop["COST_ID"]=$value["ID"];
			$final_prop[]=array_merge($analyzis_prop[$i], $new_prop, $event);
		$i++;
		}
		
		$i=1;
		foreach($final_prop as $analyz)
		{
			$ob_section = CIBlockSection::GetList(array('SORT'=>'ASC'), array('IBLOCK_ID'=> $IBLOCK_ID_ANALYZES, 'ID'=> $analyz["IBLOCK_SECTION_ID"], false, array("ID", "NAME", "CODE"), false));
			$section = $ob_section-> Fetch();
			$fin = CIBlockElement::GetProperty($IBLOCK_ID_COST_ANALYZES, $analyz["COST_ID"], "sort", "asc", array("CODE" => "PRICE"));
                          $final = $fin->Fetch();
						  if($analyz["EVENT_ID"]==3)
						  { 
						   $event_price = CIBlockElement::GetProperty($IBLOCK_ID_COST_ANALYZES, $analyz["COST_ID"], "sort", "asc", array("CODE" => "EVENT_PRICE"));
                          $event_price = $event_price->Fetch();
						  $event_description = CIBlockElement::GetProperty($IBLOCK_ID_COST_ANALYZES, $analyz["COST_ID"], "sort", "asc", array("CODE" => "EVENT_DESCRIPTION"));
                          $event_description = $event_description->Fetch();
			?>


			<div class="analyzes-slider__item">
			<div class="analyzes-slider__num">№<?=$analyz["ID"]?></div>
				<div class="analyzes-slider__title"><?= $analyz["NAME"] ?></div>
				<div class="analyzes-slider__text"><?= $analyz["DETAIL_TEXT"] ?></div>
				<div class="analyzes-slider__footer">
					<div class="analyzes-slider__price price">от <span class="price__num"><?= $event_price["VALUE"] ?></span> <span class="price__rub">₽</span>
						<span class="price__old-price">от <?= $final["VALUE"] ?> ₽</span>
					</div>
					<a data-fancybox data-src="#promotion-in-slider-<?= $i ?>" href="<?= $analyz["DETAIL_PAGE_URL"] ?>" class="analyzes-slider__more btn btn--invert">Подробнее</a>
				</div>
			</div>


			
			<?}
			
		$i++;
		}?>

		</div>
		
		<h3 class="middle__h3">Услуги</h3>
		<div class="analyzes-slider js-analyzes-slider" id="analyzes-slider js-analyzes-slider services">
		
			<?$i=1;
		$cost_prop = array();//элементы блока цена с ценой анализа
//$fin_prop = array();//свойства цены анализов
$services_prop = array();// элементы блока анализы с разделом
$section_services = array(); //разделы блока анализы
$final_prop = array(); //массив анализов с ценой, акцией
$services_cost = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $IBLOCK_ID_COST_SERVICES,  "PROPERTY_CLINIC" => $arResult["ID"]), false, false, array("ID", "NAME", "CODE", "PROPERTY_SERVICES", "PROPERTY_PRICE", "PROPERTY_*"));
while($ob_services_cost = $services_cost->Fetch())
{
	
	$cost_prop[] = $ob_services_cost;
	}
		$i=0;
		foreach($cost_prop as $value)
		{
			$services = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $IBLOCK_ID_SERVICES, "ID" => $value["PROPERTY_SERVICES_VALUE"]), false, false, array("ID", "NAME", "CODE", "IBLOCK_SECTION_ID", "DETAIL_TEXT", "IBLOCK_ID", "DETAIL_PAGE_URL"));
			$ob_services = $services->GetNext();
			$services_prop[]= $ob_services;
			$event["EVENT_ID"] = $value["PROPERTY_61"];
			$new_prop["COST_ID"]=$value["ID"];
			$final_prop[]=array_merge($services_prop[$i], $new_prop, $event);
		$i++;
		}
		
		$i=1;
		foreach($final_prop as $service)
		{
			$ob_section = CIBlockSection::GetList(array('SORT'=>'ASC'), array('IBLOCK_ID'=> $IBLOCK_ID_SERVICES, 'ID'=> $service["IBLOCK_SECTION_ID"], false, array("ID", "NAME", "CODE"), false));
			$section = $ob_section-> Fetch();
			$fin = CIBlockElement::GetProperty($IBLOCK_ID_COST_SERVICES, $service["COST_ID"], "sort", "asc", array("CODE" => "PRICE"));
                          $final = $fin->Fetch();
						  if($service["EVENT_ID"]==5)
						  { 
						   $event_price = CIBlockElement::GetProperty($IBLOCK_ID_COST_SERVICES, $service["COST_ID"], "sort", "asc", array("CODE" => "EVENT_PRICE"));
                          $event_price = $event_price->Fetch();
						  $event_description = CIBlockElement::GetProperty($IBLOCK_ID_COST_SERVICES, $service["COST_ID"], "sort", "asc", array("CODE" => "EVENT_DESCRIPTION"));
                          $event_description = $event_description->Fetch();
			?>


			<div class="services-slider__item">
			<div class="analyzes-slider__num">№<?=$service["ID"]?></div>
				<div class="analyzes-slider__title"><?= $service["NAME"] ?></div>
				<div class="analyzes-slider__text"><?= $service["DETAIL_TEXT"] ?></div>
				<div class="analyzes-slider__footer">
					<div class="analyzes-slider__price price">от <span class="price__num"><?= $event_price["VALUE"] ?></span> <span class="price__rub">₽</span>
						<span class="price__old-price">от <?= $final["VALUE"] ?> ₽</span>
					</div>
					<a data-fancybox data-src="#promotion-in-slider-<?= $i ?>" href="<?= $service["DETAIL_PAGE_URL"] ?>" class="analyzes-slider__more btn btn--invert">Подробнее</a>
				</div>
			</div>


			
			<?}
			
		$i++;
		}?>

		</div>
<?	/*Услуги*/	?>
		
		
		<?
		$cost_prop = array();//элементы блока цена с ценой анализа
//$fin_prop = array();//свойства цены анализов
$analyzis_prop = array();// элементы блока анализы с разделом
$section_analyzes = array(); //разделы блока анализы
$final_prop = array(); //массив анализов с ценой, акцией
$analysis_cost = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $IBLOCK_ID_COST_ANALYZES,  "PROPERTY_CLINIC" => $arResult["ID"]), false, false, array("ID", "NAME", "CODE", "PROPERTY_ANALYSIS", "PROPERTY_PRICE", "PROPERTY_*"));
while($ob_analysis_cost = $analysis_cost->Fetch())
{
	
	$cost_prop[] = $ob_analysis_cost;
	}
		$i=0;
		foreach($cost_prop as $value)
		{
			$analyzes = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $IBLOCK_ID_ANALYZES, "ID" => $value["PROPERTY_ANALYSIS_VALUE"]), false, false, array("ID", "NAME", "CODE", "IBLOCK_SECTION_ID", "DETAIL_TEXT", "IBLOCK_ID", "DETAIL_PAGE_URL"));
			$ob_analyzes = $analyzes->GetNext();
			$analyzis_prop[]= $ob_analyzes;
			$event["EVENT_ID"] = $value["PROPERTY_59"];
			$new_prop["COST_ID"]=$value["ID"];
			$final_prop[]=array_merge($analyzis_prop[$i], $new_prop, $event);
		$i++;
		}
		$i=1;
		foreach($final_prop as $analyz)
		{
			$fin = CIBlockElement::GetProperty($IBLOCK_ID_COST_ANALYZES, $analyz["COST_ID"], "sort", "asc", array("CODE" => "PRICE"));
                          $final = $fin->Fetch();
						  if($analyz["EVENT_ID"]==3)
						  { 
						   $event_price = CIBlockElement::GetProperty($IBLOCK_ID_COST_ANALYZES, $analyz["COST_ID"], "sort", "asc", array("CODE" => "EVENT_PRICE"));
                          $event_price = $event_price->Fetch();
						  $event_description = CIBlockElement::GetProperty($IBLOCK_ID_COST_ANALYZES, $analyz["COST_ID"], "sort", "asc", array("CODE" => "EVENT_DESCRIPTION"));
                          $event_description = $event_description->Fetch();
			?>
		<div id="promotion-in-slider-<?= $i ?>" class="promotion-popup popup" style="display: none">
			<div class="popup__title">Акция</div>
			<div class="popup__text"><?= $event_description["VALUE"] ?>
			</div>
			<div class="popup-detail__contact">
				<div class="popup-detail__address">
					<a href="<?= $analyz["DETAIL_PAGE_URL"] ?>">
						<?= $arResult["PROPERTIES"]["ADDRESS"]["VALUE"] ?>
					</a>
				</div>
				<div class="popup-detail__bottom">
					<a class="popup-detail__phone" href="tel:<?= $arResult["PROPERTIES"]["PHONE"]["VALUE"] ?>"><?= $arResult["PROPERTIES"]["PHONE"]["VALUE"] ?></a>
					<a data-fancybox data-src="#registration-in-action-popup-event-<?= $i ?>" href="javascript:;" class="btn--secondary btn">Записаться на
						прием</a>
				</div>
			</div>
		</div>
		<div id="registration-in-action-popup-event-<?= $i ?>" class="clinics__find-time-popup popup" style="display: none">
			<div class="popup__title">Записаться на прием</div>
			<form class="form form--center" action="">
				<div class="form__item">
					<input class="form__field form__field--error" type="text" placeholder="Ваше имя и фамилия">
					<span class="form__error">Обязательное поле для заполнения</span>
				</div>
				<div class="form__item">
					<input class="form__field" type="email" placeholder="Почта для обратной связи">
				</div>
				<div class="form__item">
					<input class="form__field" type="tel" data-mask="+7-000-000-00-00" placeholder="Телефон для обратной связи">
				</div>
				<div class="form__footer">
					<button class="btn btn--secondary" type="submit">Записаться</button>
				</div>
			</form>
		</div>
		<?}
		$i++;
		}?>
<?  // конец акций анализов    ?>
<?	/*Услуги*/	?>

	</div>
	
	<div id="equipment" class="clinics__description">
		<h2 class="middle__h2">Оборудование</h2>
		<?//print_r(dd($arResult["DISPLAY_PROPERTIES"]["EQUIPMENT"],false));?>
		<div class="equipment-slider js-equipment-slider">
			<?
		if($arResult["DISPLAY_PROPERTIES"]["EQUIPMENT"]["DISPLAY_VALUE"])
		{
			$equipment = CIBlockElement::GetProperty($arResult['IBLOCK_ID'], $arResult['ID'], "sort", "asc", array("CODE" => "EQUIPMENT"));
            while($ob_equipment = $equipment->GetNext())
            {	

             $image_value = $ob_equipment['VALUE'];
             $file = CFile::GetFileArray($image_value);
             $image_SRC = $file['SRC'];
             $image_description = $ob_equipment["DESCRIPTION"];
        ?>

			<div class="equipment-slider__item">
				<a class="equipment-slider__img"><img src="<?= $image_SRC ?>" alt=""></a>
				<a class="equipment-slider__title"><?= $image_description ?></a>
			</div>
			<?
		    }
		}
		?>

		</div>
	</div>
	<div id="licenses" class="clinics__description">
		<h2 class="middle__h2">Лицензии</h2>
		<div class="licenses js-licenses-slider">

			<?
			$pdf_SRC= array();
	if($arResult["DISPLAY_PROPERTIES"]["LICENSES"]["DISPLAY_VALUE"])
		{
			$licenses = CIBlockElement::GetProperty($arResult['IBLOCK_ID'], $arResult['ID'], "sort", "asc", array("CODE" => "LICENSES"));
            while($ob_licenses = $licenses->GetNext())
            {	

             $image_value = $ob_licenses['VALUE'];
             $file = CFile::GetFileArray($image_value);
             $image_SRC = $file;
			 
			 //print_r($templateFolder);
			 if($image_SRC["CONTENT_TYPE"]!="application/pdf")
			 {
	?>
			<a class="licenses__item" href="<?= $image_SRC["SRC"] ?>" data-fancybox="licenses-gallery"><img src="<?= $image_SRC["SRC"] ?>" alt=""></a>
			<?} else{?>
			
           
			<?$pdf_SRC[]=$image_SRC;/*	   <a class="licenses__item"
	href="<? echo $image_SRC['SRC']; ?>"
			title="Скачать">
			<strong>
				echo $image_SRC['ORIGINAL_NAME'];
				<span>


				</span>
			</strong>
			<i>
				//echo $image_SRC['FILE_NAME'];
			</i>
			</a> */ ?>

			<? } }
		}  
		?>
		</div>
		
		<?foreach($pdf_SRC as $pdf){?>
		
		<div class="licenses">
		<a class="licenses__item_pdf" href="<?= $pdf["SRC"] ?>" data-fancybox="licenses-gallery"><img src="<?= $pdf["SRC"] ?>" alt=""></a>
		<a class="licenses__item_title"><?= $pdf["DESCRIPTION"] ?></a>
		
		</div>
		<a class="licenses__item_title_mobile" href="<?= $pdf["SRC"] ?>"><?= $pdf["DESCRIPTION"]?></a>
		
		<?}?>
	</div>
	<div id="contacts" class="clinics__description">
		<h2 class="middle__h2">Контакты</h2>
		<div class="clinic-contact">
			<div class="clinic-contact__panel">
				<div class="clinic-contact__col">
					<div class="clinic-contact__address"><?= $arResult["PROPERTIES"]["ADDRESS"]["VALUE"] ?></div>
					<a class="clinic-contact__phone" href="tel:<?= $arResult["PROPERTIES"]["PHONE"]["VALUE"] ?>"><?= $arResult["PROPERTIES"]["PHONE"]["VALUE"] ?></a>
					<div class="clinic-contact__social social">
						<a class="social__item social__item--instagram" href="#"></a>
						<a class="social__item social__item--facebook" href="#"></a>
					</div>
				</div>
				<div class="clinic-contact__col">
					<div class="clinic-contact__mode mode mode--l">

						<?if(isset($arResult["PROPERTIES"]["WEEKDAYS"]["VALUE"]) && !empty($arResult["PROPERTIES"]["WEEKDAYS"]["VALUE"])){?>
						<div class="mode__item">
							<div class="mode__item-title">Понедельник - пятница:</div>
							<div class="mode__item-value"><?= $arResult["PROPERTIES"]["WEEKDAYS"]["VALUE"] ?></div>
						</div>
						<?}if(isset($arResult["PROPERTIES"]["SATURDAY"]["VALUE"]) && !empty($arResult["PROPERTIES"]["SATURDAY"]["VALUE"])){?>
						<div class="mode__item">
							<div class="mode__item-title">Суббота:</div>
							<div class="mode__item-value"><?= $arResult["PROPERTIES"]["SATURDAY"]["VALUE"] ?></div>
						</div>
						<?}if(isset($arResult["PROPERTIES"]["SUNDAY"]["VALUE"]) && !empty($arResult["PROPERTIES"]["SUNDAY"]["VALUE"])){?>
						<div class="mode__item">
							<div class="mode__item-title">Воскресенье:</div>
							<div class="mode__item-value"><?= $arResult["PROPERTIES"]["SUNDAY"]["VALUE"] ?></div>
						</div>
						<?}?>
					</div>
				</div>
			</div>
			
			
			
			<div id="clinic-map" class="clinic-contact__map">
				<?php
				global $hrFilter; //фильтр для детальной карты
				$hrFilter = array("ID" => $arResult["ID"]);

				//print_r($arResult["PROPERTIES"]["ADDRESS"]["VALUE"]);
				//print_r($arResult["NAME"]);
				$APPLICATION->IncludeComponent(
					"bitrix:news.list",
					"main_clinics_detail",
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
				); ?>
			</div>
		</div>
	</div>