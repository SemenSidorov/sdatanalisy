
<?php
//if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

    // наш код
$name = $_REQUEST['form_text_1']; 
$email = $_POST['form_email_2'];
$phone = $_POST['form_text_3'];
echo $name."<br />".$email."<br />".$phone;
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/local/templates/ddp/components/bitrix/form.result.new/modal/ar_props.txt", print_r($name, true), FILE_APPEND);
?>
  <div id="registration-detail-popup" class="clinics__find-time-popup popup" >
		Спасибо!Ваша заявка принята!
	</div> 
<? ?>
<?php ?>