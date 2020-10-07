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
//$city_id = Regions::getCurRegion();
$ar_clinic = array();
$city_id = Regions::getCurRegion();
$this->setFrameMode(true);

//$this->addExternalCss('/bitrix/css/main/bootstrap.css');
function AscOrderArray($array, $field)
{
    sort($array, function ($a, $b) use ($field) {
        return strnatcmp($a[$field], $b[$field]);
    });

    return $array;
}

	$arResult['ITEMS']= AscOrderArray($arResult['ITEMS'], 'ID');


?>

<div class="title">
		<div class="title__left">
			<h2 class="middle__h2"></h2>
		</div>
		<div class="title__right">
			<div class="sorting no-js">
				<select class="sorting__select js-sorting" name="" id="sorting__select_option">
					<option value="1">Все врачи</option>
					<option value="2">По имени</option>
					<option value="3">По цене</option>
					<option value="4">По стажу работы</option>
				</select>
			</div>
		</div>
	</div>


<div class="doctors__list">

	<?
	$ar_clinic = array();
	$i=1;
	foreach ($arResult['ITEMS'] as $item)
	{
		$this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		//print_r($item);
		$ob_cost_doc = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID" => 12,  "PROPERTY_DOC" => $item["ID"]), false, false, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "CODE", "NAME", "PROPERTY_*", "DETAIL_PAGE_URL"));
$cost_doc = $ob_cost_doc->GetNext();
	$clinics = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID" => 5, "PROPERTY_4"=>$city_id, "PROPERTY_5" => $item["ID"]), false, false, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "CODE", "NAME", "PROPERTY_*", "DETAIL_PAGE_URL"));
$clinic = $clinics->GetNext();
$ar_clinic[]=$clinic;
//print_r($clinic["DETAIL_PAGE_URL"]);
$props = CIBlockElement::GetProperty($clinic["IBLOCK_ID"], $clinic["ID"], array("SORT"=>"ASC"), array());
while($prop = $props->GetNext()){
	if($prop["MULTIPLE"] == "Y")
		$clinic["PROPERTIES"][$prop["CODE"]][] = $prop;
	else
	$clinic["PROPERTIES"][$prop["CODE"]] = $prop;
}
//print_r($cost_doc["ID"]);
$city = CIBlockElement::GetByID($clinic["PROPERTIES"]["CITY"]["VALUE"]);
$city = $city->GetNext();
if($city["ID"]==$city_id)
{	
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
	$ob_doctors = CIBLockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>4, "ID"=>$item["ID"]), false, array("ID", "NAME", "CODE", "PREVIEW_PICTURE", "DETAIL_PICTURE"));
	$doctors = $ob_doctors->Fetch();
$img_prev = CFile::GetPath($doctors["PREVIEW_PICTURE"]);
$img_det = CFile::GetPath($doctors["DETAIL_PICTURE"]);
//print_r($img);
if(!empty($img_prev))
	$img = $img_prev;
elseif(!empty($img_det))
	$img = $img_det;
else
	$img = "";
?>
	<div class="doctors__list-item">
	    <a href="<?= $item["DETAIL_PAGE_URL"] ?>" class="doctors__list-link"></a>
		<div class="doctors__list-item-body">
			<div class="doctors__list-item-photo">
				<??>
				<img src="<?= $img ?>" alt="" width="140" height="140">
				<??>
			</div>
			<div class="doctors__list-item-content">
				<div class="doctors__list-item-specialty"><?= $item["PROPERTIES"]["SPECIALIZATION"]["VALUE"] ?></div>
				<div class="doctors__list-item-id" style="visibility:hidden;"><?= $item["ID"] ?></div>
				<div class="doctors__list-item-name"><a class="doctors__list-item-name-a" href="<?= $item["DETAIL_PAGE_URL"] ?>"><?= $item["NAME"] ?></a></div>
				<ul class="doctors__list-item-description">
					<li><?= $item["PROPERTIES"]["CATEGORY"]["VALUE"] ?></li>
					<li>Стаж <?= $item["PROPERTIES"]["EXPERIENCE"]["VALUE"] ?> <?if($item["PROPERTIES"]["EXPERIENCE"]["VALUE"]==1):?>год</li><?elseif($item["PROPERTIES"]["EXPERIENCE"]["VALUE"]==2 || $item["PROPERTIES"]["EXPERIENCE"]["VALUE"]==3 || $item["PROPERTIES"]["EXPERIENCE"]["VALUE"]==4):?>года</li><?else:?>лет</li><?endif;?></li>
				</ul>
			</div>
		</div>
		<?


?>
		<div class="doctors__list-item-col">
			<div class="doctors__list-item-col-title">Адрес клиники</div>
			<div class="doctors__list-item-city"><?= $city["NAME"] ?></div>
			<div class="doctors__list-item-address"><a href="<?=$clinic["DETAIL_PAGE_URL"]?>"><?= $clinic["PROPERTIES"]["ADDRESS"]["VALUE"] ?></a></div>
		</div>
		
		<div class="doctors__list-item-col2">
		
		<?
		if($price != 0){
		if($event == 7){
		
		?>
		<div class="doctors__list-item-price-box">
				<div class="doctors__list-item-col-title">Стоимость приема</div>
				<div class="doctors__list-item-price price">
				<span class="price__num"><?= $event_price ?></span> <span class="price__rub">₽</span>
					<span class="price__old_num"><?= $price ?> ₽</span> <span class="price__rub"></span>
				</div>
			</div>
			
			
			
			
			
		<?}
		else{?>
		
		<div class="doctors__list-item-price-box">
				<div class="doctors__list-item-col-title">Стоимость приема</div>
				<div class="doctors__list-item-price price">
					<span class="price__num"><?= $price ?></span> <span class="price__rub">₽</span>
				</div>
			</div>
		
		
		
		
		<?}}
		elseif(empty($price)){
		if($event==7)
		{
		?>
		<div class="doctors__list-item-price-box">
				<div class="doctors__list-item-col-title">Стоимость приема</div>
				<div class="doctors__list-item-price price">
					<span class="price__num"><?= $event_price ?></span> <span class="price__rub">₽</span>
				</div>
			</div>
			
		<?
		}
		else{?>
		<div class="doctors__list-item-price-box">
				<div class="doctors__list-item-col-title"></div>
				<div class="doctors__list-item-price price">
					<span class="price__num"></span> <span class="price__rub"></span>
				</div>
			</div>
		
		
		
		<?}}?>
			<a class="doctors__list-item-btn btn btn--secondary" data-fancybox data-src="#registration-popup-<?=$i?>" href="javascript:;">Записаться на прием</a>
			<div id="registration-popup-<?=$i?>" class="clinics__find-time-popup popup" style="display: none">
				<div class="popup__title">Записаться на прием</div>
				
				
				<form class="form form--center" action="" method="GET">
					<div class="form__item">
						<input class="form__field form__field--error" type="text" name="form_text_1-<?=$i?>" placeholder="Ваше имя и фамилия">
						<span class="form__error">Обязательное поле для заполнения</span>
					</div>
					<div class="form__item">
						<input class="form__field" type="email" name="form_email_2-<?=$i?>" placeholder="Почта для обратной связи">
					</div>
					<div class="form__item">
						<input class="form__field" type="tel" name="form_text_3-<?=$i?>" data-mask="+7-000-000-00-00" placeholder="Телефон для обратной связи">
					</div>
					<div class="form__item">
	<input placeholder="Доктор" type="hidden" class="form__field" name="form_text_4-<?=$i?>" value="<?=$item["NAME"]?>" size="0">		
	</div>
	<div class="form__item">
	<input placeholder="Клиника" type="hidden" class="form__field" name="form_text_5-<?=$i?>" value="<?=$clinic["PROPERTIES"]["ADDRESS"]["VALUE"]?>" size="0">		
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
//print_r($doctor);
if(!empty($name) && !empty($email) && !empty($phone) && !empty($doctor) && !empty($clinic))
{
	$ob_id = CIBLockElement::GetList(array("ID"=>"DESC"), array("IBLOCK_ID"=>11),  array("ID", "NAME", "CODE", "IBLOCK_ID"), array("nTopCount"=>1));
	$id=$ob_id->Fetch();
	if($id["ID"])
	{	$id["ID"]=$id["ID"]+1;
	$name_zayavka = "Заявка №".$id["ID"]." на врача ".$doctor;
	//print_r($name_zayavka);
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/local/templates/ddp/components/bitrix/form.result.new/modal/ar_props.txt", print_r($name_zayavka, true), FILE_APPEND);
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
	  $rs_el=$el->Add($fields);
	  if($rs_el){
		  
		  
	  }
	}
	}
}
	}
						?>
		</div>
	</div>
<?
$i++;
}}?>
	<button class="doctors__list-more" id="doctors__list-more-click">Показать все</button>
</div>
<style>
.clinic-contact__map
{
	position:relative
}
</style>
<div class="m-clinics__title">Поиск медицинских центров</div>
<div id="clinic-map" class="clinic-contact__map">
<?
global $hrFilter_doc; //фильтр для детальной карты
				$hrFilter_doc = array("ID" => $ar_clinic["ID"]);

$APPLICATION->IncludeComponent(
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
						"FILTER_NAME" => "hrFilter_doc",
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
<script>
	  //функция сортировки по id врача, по умолчанию
	 function sortListId(sortType) 
	{
		 //выбираем врачем 
        let items = document.querySelector('.doctors__list');
	//делаем два цикла для прогона по каждому элементу
         for (let i = 0; i < items.children.length - 1; i++) 
		{
		//если выбираемые a  не существуют, либо равны нулю, то переходим на следующую итерацию
	         if(!!!items.children[i].querySelector('.doctors__list-item-id') || items.children[i].querySelector('.doctors__list-item-id').innerHTML==null)
		    {
	        continue;
            }
			var value1 = items.children[i].querySelector('.doctors__list-item-id').innerHTML;
	//если выбираемые a  не существуют, либо равны нулю, то переходим на следующую итерацию
                 for (let j = i; j < items.children.length; j++) 
		        {
	                if(!!!items.children[j].querySelector('.doctors__list-item-id') || items.children[j].querySelector('.doctors__list-item-id').innerHTML==null )
		           {
	                  continue;
                    }
				var value2 = items.children[j].querySelector('.doctors__list-item-id').innerHTML;
				//console.log(value1 > value2);
				//	console.log(items.children[j].querySelector('.doctors__list-item-name-a').innerHTML);
	//сравниваем имена врачей
                         if (+value1 > +value2) 
						{
                  //создаем массив, меняющий местами два элемента, если условие выполняется
                          let replacedNode = items.replaceChild(items.children[j], items.children[i]);
				//передаем два параметра другой функции
                          insertAfter(replacedNode, items.children[i]);
                        }
                } 
        }
    }	
	 
	 
	 
	 //функция сортировки по имени врача
	 function sortListName(sortType) 
	{
		 //выбираем врачем 
        let items = document.querySelector('.doctors__list');
	//делаем два цикла для прогона по каждому элементу
         for (let i = 0; i < items.children.length - 1; i++) 
		{
		//если выбираемые a  не существуют, либо равны нулю, то переходим на следующую итерацию
	         if(!!!items.children[i].querySelector('.doctors__list-item-name-a') || items.children[i].querySelector('.doctors__list-item-name-a').innerHTML==null)
		    {
	        continue;
            }
			var value1 = items.children[i].querySelector('.doctors__list-item-name-a').innerHTML;
	//если выбираемые a  не существуют, либо равны нулю, то переходим на следующую итерацию
                 for (let j = i; j < items.children.length; j++) 
		        {
	                if(!!!items.children[j].querySelector('.doctors__list-item-name-a') || items.children[j].querySelector('.doctors__list-item-name-a').innerHTML==null )
		           {
	                  continue;
                    }
				var value2 = items.children[j].querySelector('.doctors__list-item-name-a').innerHTML;
				//console.log(value1 > value2);
				//	console.log(items.children[j].querySelector('.doctors__list-item-name-a').innerHTML);
	//сравниваем имена врачей
                         if (value1 > value2) 
						{
                  //создаем массив, меняющий местами два элемента, если условие выполняется
                          let replacedNode = items.replaceChild(items.children[j], items.children[i]);
				//передаем два параметра другой функции
                          insertAfter(replacedNode, items.children[i]);
                        }
                } 
        }
    }	



	//функция сортировки по цене врача
	 function sortListPrice(sortType) 
	{
		 //выбираем врачем 
        let items = document.querySelector('.doctors__list');
	//делаем два цикла для прогона по каждому элементу
         for (let i = 0; i < items.children.length - 1; i++) 
		{
		//если выбираемые span  не существуют, либо равны нулю, то переходим на следующую итерацию
	          if(!!!items.children[i].querySelector('.price__num') || items.children[i].querySelector('.price__num').innerHTML==null)
		    {
	          continue;
            }
	//если выбираемые span  не существуют, либо равны нулю, то переходим на следующую итерацию
                 for (let j = i; j < items.children.length; j++) 
		        {
	                 if(!!!items.children[j].querySelector('.price__num') || items.children[j].querySelector('.price__num').innerHTML==null )
		            {
	                  continue;
                    }
	//сравниваем цены врачей
                         if (+items.children[i].querySelector('.price__num').innerHTML > +items.children[j].querySelector('.price__num').innerHTML) 
						{
                  //создаем массив, меняющий местами два элемента, если условие выполняется
                          let replacedNode = items.replaceChild(items.children[j], items.children[i]);
				//передаем два параметра другой функции
                          insertAfter(replacedNode, items.children[i]);
                        }
                } 
        }
    }	
	
	 //функция сортировки по стажу врача
	 function sortListExperience(sortType) 
	{
		 //выбираем врачем 
        let items = document.querySelector('.doctors__list');
	//делаем два цикла для прогона по каждому элементу
         for (let i = 0; i < items.children.length - 1; i++) 
		{
		//если выбираемые li  не существуют, либо равны нулю, то переходим на следующую итерацию
	          if(!!!items.children[i].querySelector('.doctors__list-item-description') )
		    {
			  continue;  
            }
			//выбираем все li элементы
			 let arr_i = items.children[i].querySelector('.doctors__list-item-description').getElementsByTagName("li");
			 // убираем из li все лишнее, кроме числа
			var value1 = parseInt(arr_i[1].innerHTML.match(/\d+/));
			if(value1==null)
					{
						continue;
					}
	//если выбираемые li  не существуют, либо равны нулю, то переходим на следующую итерацию
                 for (let j = i; j < items.children.length; j++) 
		        {
	                 if(!!!items.children[j].querySelector('.doctors__list-item-description'))
		            {
	                  continue;
                    }
					let arr_j = items.children[j].querySelector('.doctors__list-item-description').getElementsByTagName("li");
			var value2 = parseInt(arr_j[1].innerHTML.match(/\d+/));
					if(value2==null)
					{
						continue;
					}
	//сравниваем стаж врачей
                         if (+value1 < +value2) 
						{
                  //создаем массив, меняющий местами два элемента, если условие выполняется
                          let replacedNode = items.replaceChild(items.children[j], items.children[i]);
				//передаем два параметра другой функции
                          insertAfter(replacedNode, items.children[i]);
                        }
                } 
        }
    }	
	
	
	//конечная функция ,принимающая параметры сортировки и перезаписывающая элементы в нужном порядке
	                         function insertAfter(elem, refElem) 
							{
                              return refElem.parentNode.insertBefore(elem, refElem.nextSibling);
                            }
	
	
	
	
	
	//сортировка по нажатию на всплывающий список
		$('#sorting__select_option').on('change', function(){
		// по имени врача	
  if ($(this).val() == 2) {
     sortListName();
  }
  // по ид врачам, основной
  if ($(this).val() == 1){
	  sortListId();
  }
  //по цене
  if ($(this).val() == 3){
	 sortListPrice();
  }
   //по стажу работы
  if ($(this).val() == 4){
	 sortListExperience();
  }
})
	</script>
<script>
var countelem;
countelem = $(".doctors__list-item").length;
//console.log(item);
if(countelem<=5)
{
	$('#doctors__list-more-click').css("display","none");
}
else{
	$('#doctors__list-more-click').css("display","inline-block");
}
let menuOpen = 0;
//скрываем врачей, если их больше трех
	$('.doctors__list-item:gt(2)').hide(); 
	//при нажатии на кнопку показываем
	$('.doctors__list-more').click(function(b)
 {
	 if(menuOpen == 0) {
	 $('#doctors__list-more-click').html('Скрыть все');
	  $('.doctors__list-item:gt(2)').show(400); // Для показа  
	  menuOpen = 1;
	 }
	 else if(menuOpen == 1) {
		 $('.doctors__list-item:gt(2)').hide(400);
		  $('#doctors__list-more-click').html('Показать все');
    menuOpen = 0;
	 }
 });
 </script>