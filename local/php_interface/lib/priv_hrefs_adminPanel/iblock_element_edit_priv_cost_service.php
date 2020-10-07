  

<?

// если это страница редактирования элемента
if (CSite::InDir('/bitrix/admin/iblock_element_edit.php')){
CModule::IncludeModule('iblock');
$IBLOCK_ID_SERVICES=3;
$IBLOCK_ID_COST_SERVICES=9;
$IBLOCK_ID_CLINICS=5;
//$IBLOCK_ID_REGION=1;
$ar_services= array();
$ar_clinics= array();
$page = $APPLICATION->GetCurUri(); // получаем текущую страницу с параметрами
$pages = $APPLICATION->GetCurPage(); // получаем текущую страницу с параметрами
//print_r($_SERVER['DOCUMENT_ROOT']);

$page = str_replace('/bitrix/admin/iblock_element_edit.php?','',$page); //убираем лишнее с урла
$page = explode('&', $page);
// работаем только с ID и IBLOCK_ID текущего элемента
$id = str_replace('ID=','', $page[2]);
$iblock_id = str_replace('IBLOCK_ID=','', $page[0]);
// проверяем, что инфоблок верный
if($iblock_id==9)
{
	//выборка привязанного элемента
	$ob_cost_service = CIBLockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>$IBLOCK_ID_COST_SERVICES, "ID"=>$id, "ACTIVE"=>"Y"), array("ID", "NAME", "IBLOCK_ID", "CODE", "DETAIL_PAGE_URL", "IBLOCK_SECTION_ID", "IBLOCK_TYPE_ID", "PROPERTY_39", "PROPERTY_40"), false);
$cost_service = $ob_cost_service->Fetch();

$ob_service = CIBLockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>$IBLOCK_ID_SERVICES, "ID"=>$cost_service["PROPERTY_39_VALUE"], "ACTIVE"=>"Y"), array("ID", "NAME", "IBLOCK_ID", "CODE", "DETAIL_PAGE_URL", "IBLOCK_SECTION_ID", "IBLOCK_TYPE_ID"), false);
$service = $ob_service->Fetch();

// если непустой запрос, то начинаем формировать теги

	$ar_services[]=$service;

$ob_clinic = CIBLockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>$IBLOCK_ID_CLINICS, "ID"=>$cost_service["PROPERTY_40_VALUE"], "ACTIVE"=>"Y"), array("ID", "NAME", "IBLOCK_ID", "CODE", "DETAIL_PAGE_URL", "IBLOCK_SECTION_ID", "IBLOCK_TYPE_ID"), false);
$clinic = $ob_clinic->Fetch();

$ar_clinics[]=$clinic;

foreach($ar_services as $item){
?>
<script type="text/javascript">
// после формирования страницы
document.addEventListener('DOMContentLoaded', function(){
// выбираем представленный класс, для дополнительных свойств 
 var el = document.querySelectorAll('#tr_PROPERTY_39 > .adm-detail-content-cell-r > table > tbody > tr > td > table > tbody >  tr').length;
 // получаем последний элемент
//let elems = el[el.length];


	//el.splice(1);
	//var i = index;
// выбираем дочерние элементы tbody 
last = 'tr_PROPERTY_39 > .adm-detail-content-cell-r > table > tbody > tr > td ';
// формируем теги по иерархии админки, чтобы стили сами подхватились
let obj = document.querySelector('#'+last);
console.log(obj);
// создаем тег td для правой части



//внутри правого тега td создаем table

//берем полученные переменные из php


//var result = jQuery.parseJSON( data );
//var strings = result['ar_region'];

//console.log(strings);


var name_tag_a = '<?php echo $item["NAME"];?>';
var iblock_id_tag_a='<?php echo $item["IBLOCK_ID"];?>';
var iblock_type_tag_a='<?php echo $item["IBLOCK_TYPE_ID"];?>';
var id_tag_a='<?php echo $item["ID"];?>';
//var section_name_tag_a='<?php echo $analyz["SECTION_NAME"];?>';
//var section_id__tag_a='<?php echo $analyz["SECTION_ID"];?>';
//создаем тег a с переменными php
let tag_a = document.createElement('a');
tag_a.setAttribute('name','tr_PROPERTY_PRIV_SERVICE_'+id_tag_a+'');
tag_a.setAttribute('href','http://sdatanalizy.dev.ddplanet.ru/bitrix/admin/iblock_element_edit.php?IBLOCK_ID='+iblock_id_tag_a+'&type='+iblock_type_tag_a+'&ID='+id_tag_a);
tag_a.setAttribute('value', '');
tag_a.setAttribute('size','30');
tag_a.setAttribute('style','padding-left:10px;');
tag_a.innerHTML=name_tag_a;
obj.appendChild(tag_a);

//закрываем блок
//obj.appendChild(block);
})
</script>
<?

}

foreach($ar_clinics as $item)
{
	?>
	<script type="text/javascript">
// после формирования страницы
document.addEventListener('DOMContentLoaded', function(){
// выбираем представленный класс, для дополнительных свойств 
 var el = document.querySelectorAll('#tr_PROPERTY_40 > .adm-detail-content-cell-r > table > tbody > tr > td > table > tbody >  tr').length;
 // получаем последний элемент
//let elems = el[el.length];


	//el.splice(1);
	//var i = index;
// выбираем дочерние элементы tbody 
last = 'tr_PROPERTY_40 > .adm-detail-content-cell-r > table > tbody > tr > td ';
// формируем теги по иерархии админки, чтобы стили сами подхватились
let obj = document.querySelector('#'+last);
console.log(obj);
// создаем тег td для правой части



//внутри правого тега td создаем table

//берем полученные переменные из php


//var result = jQuery.parseJSON( data );
//var strings = result['ar_region'];

//console.log(strings);


var name_tag_a = '<?php echo $item["NAME"];?>';
var iblock_id_tag_a='<?php echo $item["IBLOCK_ID"];?>';
var iblock_type_tag_a='<?php echo $item["IBLOCK_TYPE_ID"];?>';
var id_tag_a='<?php echo $item["ID"];?>';
//var section_name_tag_a='<?php echo $analyz["SECTION_NAME"];?>';
//var section_id__tag_a='<?php echo $analyz["SECTION_ID"];?>';
//создаем тег a с переменными php
let tag_a = document.createElement('a');
tag_a.setAttribute('name','tr_PROPERTY_PRIV_CLINIC_'+id_tag_a+'');
tag_a.setAttribute('href','http://sdatanalizy.dev.ddplanet.ru/bitrix/admin/iblock_element_edit.php?IBLOCK_ID='+iblock_id_tag_a+'&type='+iblock_type_tag_a+'&ID='+id_tag_a);
tag_a.setAttribute('value', '');
tag_a.setAttribute('size','30');
tag_a.setAttribute('style','padding-left:10px;');
tag_a.innerHTML=name_tag_a;
obj.appendChild(tag_a);

//закрываем блок
//obj.appendChild(block);
})
</script>
	<?
	
}



}}
?>