<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();





global $clinicFilter;
global $doctorFilter;
?>
 <style>
      #zatemnenie {
        background: rgba(102, 102, 102, 0.5);
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        display: none;
      }
      #okno {
        width: 300px;
        height: 50px;
        text-align: center;
        padding: 15px;
        border: 3px solid #0000cc;
        border-radius: 10px;
        color: #0000cc;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        margin: auto;
        background: #fff;
      }
      #zatemnenie:target {display: block;}
      .close {
        display: inline-block;
        border: 1px solid #0000cc;
        color: #0000cc;
        padding: 0 12px;
        margin: 10px;
        text-decoration: none;
        background: #f2f2f2;
        font-size: 14pt;
        cursor:pointer;
      }
      .close:hover {background: #e6e6ff;}
    </style>
	 <script>
  /*$('#web_form_submit_id').on('click',function(){

 document.getElementById('registration-detail').setAttribute("style","display:block;");


  }*/
  $('#web_form_submit_id').on('click', function() {
      $.fancybox.open({
            type: 'inline',
            src: '#popup-success',
            closeExisting: true,
            afterLoad : function( instance, current ) {
                setTimeout( function() {$.fancybox.close(); },2000);
            }
        });
  });
</script>
<div id="registration-detail-popup-form" class="clinics__find-time-popup popup" style="display: none">
	<div class="popup__title"><?=$arResult["FORM_TITLE"]?></div>    
	<form class="form form--center" name="SIMPLE_FORM_1" action="" method="GET">
 
        <div class="form__item">
            <input placeholder="Ваше имя и фамилия" type="text" class="form__field" name="form_text_1" value="" size="0">
        </div>
        <div class="form__item">
            <input placeholder="Почта для обратной связи" type="email" class="form__field" name="form_email_2" value="" size="0">
        </div>
        <div class="form__item">
            <input placeholder="Телефон для обратной связи" type="tel" data-mask="+7-000-000-00-00" class="form__field" name="form_text_3" value="" size="0" autocomplete="off" maxlength="16">
        </div>
        <input placeholder="Доктор" type="hidden" class="form__field" name="form_text_4" value="<?=$doctorFilter?>" size="0">
        <input placeholder="Клиника" type="hidden" class="form__field" name="form_text_5" value="<?=$clinicFilter?>" size="0">
	    <div class="form__footer">
			<input class="btn btn--secondary" type="button" href="#" value="Записаться" name="web_form_submit" id="web_form_submit_id">
		</div>
	</form>
	<button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small" title="Close"><svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24"><path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path></svg>
	</button>
</div>
<div id="popup-success" class="popup popup--message" style="display: none">
    <div class="popup__text">
        Спасибо, ваша заявка успешно отправлена. <br>Наш специалист свяжется с вами в ближайшее
        время
    </div>
</div>
<div id="registration-detail-popup-success" class="clinics__find-time-popup popup" style="display: none">
      <div id="okno">
        Всплывающее окошко!<br>
        <a href="#" class="close">Закрыть окно</a>
      </div>
    </div>
	<?
	
	//print_r($clinicFilter);
	if(!empty($_GET['web_form_submit']))
	{$name = $_GET['form_text_1']; 
$email = $_GET['form_email_2'];
$phone = $_GET['form_text_3'];
$doctor = $_GET['form_text_4'];
$clinic = $_GET['form_text_5'];
if(!empty($name) && !empty($email) && !empty($phone) && !empty($doctor) && !empty($clinic))
{
	$ob_id = CIBLockElement::GetList(array("ID"=>"DESC"), array("IBLOCK_ID"=>11),  array("ID", "NAME", "CODE", "IBLOCK_ID"), array("nTopCount"=>1));
	$id=$ob_id->Fetch();
	if($id["ID"])
	{	$id["ID"]=$id["ID"]+1;
	$name_zayavka = "Заявка №".$id["ID"]." на врача ".$doctor;
	//Получение символьного кода путём транслитерации наименования элемента
$arTranslitParams = array("replace_space"=>"-","replace_other"=>"-"); // Указываем на какой символ заменять пробел, на какой символ заменять все остальные символы отличные от букв и цифр.
$code = Cutil::translit(strtolower($name_zayavka),"ru",$arTranslitParams); // функцией strtolower - преобразуем все Заглавные буквы в Названии элемента в строчные буквы. Cutil::translit - транслитерирует русское наименование элемента.
	$ob_proverka = CIBLockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>11, "NAME"=>$name_zayavka, "CODE"=>$code),  array("ID", "NAME", "CODE", "IBLOCK_ID"), false);
	$proverka=$ob_proverka->Fetch();
	if(!$proverka){
	
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
	  if($rs_el)
	  {?>
  
     
    
 

		<?/* <div id="registration-detail-popup-success" class="clinics__find-time-popup success" id="clinics__find-time-popup success">
		Спасибо!Ваша заявка принята!
	</div>*/ ?> 
	  <?}
	}
}
}

//echo $name."<br />".$email."<br />".$phone;
//print_r($doctor);
//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/local/templates/ddp/components/bitrix/form.result.new/modal/ar_props.txt", print_r($name, true), FILE_APPEND);
 //endif (isFormNote)
	 
	}
?>
<script>
/*$('#web_form_submit_id').on('click', function(){
 
  document.getElementById('clinics__find-time-popup success').setAttribute("style","display:inline-block;");
})*/
</script>
<style>
.clinics__find-time-popup success{
	display: none;
    padding: 68px 62px 60px 59px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    border-radius: 20px;
    background-color: #FFFFFF;
    -webkit-box-shadow: 0 10px 30px 0 rgba(133, 151, 169, 0.2);
    box-shadow: 0 10px 30px 0 rgba(133, 151, 169, 0.2);

}
</style>