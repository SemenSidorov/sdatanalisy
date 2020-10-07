<?

// если это страница редактирования элемента
if (CSite::InDir('/bitrix/admin/iblock_element_edit.php')){
CModule::IncludeModule('iblock');
$IBLOCK_ID_ANALYZES=2;
$IBLOCK_ID_COST_ANALYZES=8;
$ar_cost_analyz= array();
$page = $APPLICATION->GetCurUri(); // получаем текущую страницу с параметрами

$page = str_replace('/bitrix/admin/iblock_element_edit.php?','',$page); //убираем лишнее с урла
$page = explode('&', $page);
// работаем только с ID и IBLOCK_ID текущего элемента
$id = str_replace('ID=','', $page[2]);
$iblock_id = str_replace('IBLOCK_ID=','', $page[0]);
// проверяем, что инфоблок верный
if($iblock_id==2)
{
	//выборка привязанного элемента
$ob_cost_analyz = CIBLockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>$IBLOCK_ID_COST_ANALYZES, "PROPERTY_37_VALUE"=>$id, "ACTIVE"=>"Y"), array("ID", "NAME", "IBLOCK_ID", "CODE", "DETAIL_PAGE_URL", "IBLOCK_SECTION_ID", "IBLOCK_TYPE_ID"), false);
$cost_analyz = $ob_cost_analyz->Fetch();
// если непустой запрос, то начинаем формировать теги
if($cost_analyz){
	// выборка раздела привязанного элемента
	//$rs_cost_analyz= CIBLockSection::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>$IBLOCK_ID_COST_ANALYZES, "ID"=>$cost_analyz["IBLOCK_SECTION_ID"]), array("ID", "NAME", "IBLOCK_ID", "CODE"), false);
//$razdel_cost_analyz = $rs_cost_analyz->Fetch();

	$ar_cost_analyz[]=$cost_analyz;
	//$ar_cost_analyz_name["SECTION_NAME"]=$razdel_cost_analyz["NAME"];
	//$ar_cost_analyz_id["SECTION_ID"]=$razdel_cost_analyz["ID"];
	// добавляем в ассоциативный массив имя раздела и ид раздела
//$ar_cost_analyz[] = array_merge($ar_cost_analyz[0], $ar_cost_analyz_name, $ar_cost_analyz_id);
foreach($ar_cost_analyz as $analyz){
?>
<script type="text/javascript">
// после формирования страницы
document.addEventListener('DOMContentLoaded', function(){
// выбираем представленный класс, для дополнительных свойств 
 var el = document.querySelectorAll('[class="bx-in-group"]');
 // получаем последний элемент
last_elem = el[el.length-1];
// выбираем дочерние элементы tbody 
last = 'edit1_edit_table > tbody';
// формируем теги по иерархии админки, чтобы стили сами подхватились
let obj = document.querySelector('#'+last);
// создаем теги для отдельной линии
let background_block_tr = document.createElement('tr');
background_block_tr.classList.add('heading');
background_block_tr.id='tr_PROPERTY_PRIV_COST_ANALYZ_BACKGROUND';
obj.appendChild(background_block_tr);

let background_block_td = document.createElement('td');
background_block_td.innerHTML='Связанные элементы:';
background_block_td.setAttribute("colspan","2");
background_block_tr.appendChild(background_block_td);
//создаем тег с классом с уникальным ид
let block = document.createElement('tr');
block.classList.add('bx-in-group');
block.id='tr_PROPERTY_PRIV_COST_ANALYZ';
//создаем внутри него td для левой части
let tag_td_left = document.createElement('td');
tag_td_left.classList.add('adm-detail-content-cell-l');
tag_td_left.innerHTML ='Ссылка на цену анализа элемента:';
tag_td_left.setAttribute("style","width:40%;");
block.appendChild(tag_td_left);	
// создаем тег td для правой части
let tag_td_right = document.createElement('td');
tag_td_right.classList.add('adm-detail-content-cell-r');
tag_td_right.setAttribute("style","width:60%;");
block.appendChild(tag_td_right);
//внутри правого тега td создаем table
let table = document.createElement('table');
table.classList.add('nopadding');
table.setAttribute("style","width: 100%;cellpadding: 0;cellspasing: 0;border: 0;");
table.setAttribute("cellpadding","0");
table.setAttribute("cellspasing","0");
tag_td_right.appendChild(table);
//создаем tbody внутри table
let tbody = document.createElement('tbody');
table.appendChild(tbody);
//создаем tr внутри tbody
let tr = document.createElement('tr');
tbody.appendChild(tr);
//создаем td внутри tr
let td = document.createElement('td');
tr.appendChild(td);
//берем полученные переменные из php
var name_tag_a = '<?php echo $analyz["NAME"];?>';
var iblock_id_tag_a='<?php echo $analyz["IBLOCK_ID"];?>';
var iblock_type_tag_a='<?php echo $analyz["IBLOCK_TYPE_ID"];?>';
var id_tag_a='<?php echo $analyz["ID"];?>';
//var section_name_tag_a='<?php echo $analyz["SECTION_NAME"];?>';
//var section_id__tag_a='<?php echo $analyz["SECTION_ID"];?>';
//создаем тег a с переменными php
let tag_a = document.createElement('a');
tag_a.setAttribute('name','tr_PROPERTY_PRIV_COST_ANALYZ_NAME');
tag_a.setAttribute('href','http://sdatanalizy.dev.ddplanet.ru/bitrix/admin/iblock_element_edit.php?IBLOCK_ID='+iblock_id_tag_a+'&type='+iblock_type_tag_a+'&ID='+id_tag_a);
tag_a.setAttribute('value', '');
tag_a.setAttribute('size','30');
tag_a.innerHTML=name_tag_a;
td.appendChild(tag_a);
// создаем див с описанием элемента
let tag_info = document.createElement('div');
tag_info.setAttribute('name','tr_PROPERTY_PRIV_COST_ANALYZ_DESCRIPTION');
tag_info.setAttribute('value', '');
tag_info.setAttribute('size','30');
tag_info.setAttribute("style","display:block;position:relative;");
tag_info.innerHTML='ID элемента: '+id_tag_a+'<br>ID инфоблока: '+iblock_id_tag_a+'<br>';
td.appendChild(tag_info);
//закрываем блок
obj.appendChild(block);
})
</script>
<?
}}}}
?>