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
//$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/libs/libs.js" );
$this->setFrameMode(true);
//$this->addExternalJS(SITE_TEMPLATE_PATH."/libs/libs.js");
//$this->addExternalJS(SITE_TEMPLATE_PATH."/Scripts/init.js");
//$this->addExternalCss('/bitrix/css/main/bootstrap.css');



?>
<div class="doctors__list">
	<?
if (!empty($arResult['ITEMS']))
{
	$i=1;
	foreach ($arResult['ITEMS'] as $item)
	{
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
		
		
		?>
	<div class="doctors__list-item" id="doctors__list-item-<?=$i?>">
		<div class="doctors__list-item-body">
			<div class="doctors__list-item-photo">
				<?if(isset($item["PREVIEW_PICTURE"]["SRC"]) && !empty($item["PREVIEW_PICTURE"]["SRC"])){?>
				<img src="<?= $item["PREVIEW_PICTURE"]["SRC"] ?>" alt="" width="140" height="140">
				<?}?>
			</div>
			<div class="doctors__list-item-content">
				<div class="doctors__list-item-specialty"><?= $item["PROPERTIES"]["SPECIALIZATION"]["VALUE"] ?></div>
				<div class="doctors__list-item-name"><a href="<?= $item["DETAIL_PAGE_URL"] ?>"><?= $item["NAME"] ?></a></div>
				<ul class="doctors__list-item-description">
					<li><?= $item["PROPERTIES"]["CATEGORY"]["VALUE"] ?></li>
					<li>Стаж <?= $item["PROPERTIES"]["EXPERIENCE"]["VALUE"] ?> <?if($item["PROPERTIES"]["EXPERIENCE"]["VALUE"]==1):?>год</li><?elseif($item["PROPERTIES"]["EXPERIENCE"]["VALUE"]==2 || $item["PROPERTIES"]["EXPERIENCE"]["VALUE"]==3 || $item["PROPERTIES"]["EXPERIENCE"]["VALUE"]==4):?>года</li><?else:?>лет</li><?endif;?></li>
				</ul>
			</div>
		</div>
		<?
$clinic = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 5, "PROPERTY_5" => $item["ID"]), false, false, array());
$clinic = $clinic->GetNext();
$props = CIBlockElement::GetProperty($clinic["IBLOCK_ID"], $clinic["ID"], array(), array());
while($prop = $props->GetNext()){
	if($prop["MULTIPLE"] == "Y")
		$clinic["PROPERTIES"][$prop["CODE"]][] = $prop;
	else
		$clinic["PROPERTIES"][$prop["CODE"]] = $prop;
}
$city = CIBlockElement::GetByID($clinic["PROPERTIES"]["CITY"]["VALUE"]);
$city = $city->GetNext();
?>

		<div class="doctors__list-item-col">
			<div class="doctors__list-item-col-title">Адрес клиники</div>
			<div class="doctors__list-item-city"><?= $city["NAME"] ?></div>
			<div class="doctors__list-item-address"><a href="<?= $clinic["DETAIL_PAGE_URL"] ?>"><?= $clinic["PROPERTIES"]["ADDRESS"]["VALUE"] ?></a></div>
		</div>
		<div class="doctors__list-item-col">
		
		
		
			<?
		if($price != 0){
		if($event == 7){
		
		?>
		<div class="doctors__list-item-price-box">
				<div class="doctors__list-item-col-title">Стоимость приема</div>
				<div class="doctors__list-item-price price">
				<span class="price__num"><?= $event_price ?></span> <span class="price__rub">₽</span>
					<span class="price__num"><s><?= $price ?></s></span> <span class="price__rub">₽</span>
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
		<?/*<div class="doctors__list-item-price-box">
				<div class="doctors__list-item-col-title">Стоимость приема</div>
				<div class="doctors__list-item-price price">
					<span class="price__num"></span> <span class="price__rub"></span>
				</div>
			</div>
		
	*/	?>
		
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
	<button class="doctors__list-more" id="doctors__list-more-click" >Показать все</button>
</div>

<script>
var countelem;
countelem = $(".doctors__list-item").length;
//console.log(item);
if(countelem<=3)
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