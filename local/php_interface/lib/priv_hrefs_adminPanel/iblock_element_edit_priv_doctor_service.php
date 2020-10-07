  

<?
/*   скрипт добавления в административной панели ссылки для множественного свойства привязка к элементу                                                        */
// если это страница редактирования элемента
if (CSite::InDir('/bitrix/admin/iblock_element_edit.php')){
$IBLOCK_ID_SERVICE=3;
$IBLOCK_ID_DOCTOR=4;
$ar_service= array();
$page = $APPLICATION->GetCurUri(); // получаем текущую страницу с параметрами
$pages = $APPLICATION->GetCurPage(); // получаем текущую страницу с параметрами
$page = str_replace('/bitrix/admin/iblock_element_edit.php?','',$page); //убираем лишнее с урла
$page = explode('&', $page);
// работаем только с ID и IBLOCK_ID текущего элемента
$id = str_replace('ID=','', $page[2]);
$iblock_id = str_replace('IBLOCK_ID=','', $page[0]);
// проверяем, что инфоблок верный
if($iblock_id==4)
{
	//выборка привязанного элемента
	$ob_doctor = CIBLockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>$IBLOCK_ID_DOCTOR, "ID"=>$id, "ACTIVE"=>"Y"), array("ID", "NAME", "IBLOCK_ID", "CODE", "DETAIL_PAGE_URL", "IBLOCK_SECTION_ID", "IBLOCK_TYPE_ID", "PROPERTY_3"), false);
while($doctor = $ob_doctor->Fetch())
{
$ob_service = CIBLockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>$IBLOCK_ID_SERVICE, "ID"=>$doctor["PROPERTY_3_VALUE"], "ACTIVE"=>"Y"), array("ID", "NAME", "IBLOCK_ID", "CODE", "DETAIL_PAGE_URL", "IBLOCK_SECTION_ID", "IBLOCK_TYPE_ID"), false);
while($service = $ob_service->Fetch())
// если непустой запрос, то начинаем формировать теги
{
	$ar_service[]=$service;

}
}
?>
<script type="text/javascript">
// после формирования страницы
document.addEventListener('DOMContentLoaded', function(){
// выбираем все теги option с атрибутом value(ид привязанного элемента)
 var selected_mass = document.querySelectorAll('#tr_PROPERTY_3 > .adm-detail-content-cell-r > table > tbody > tr > td > table > tbody >  tr > td > select > option[selected]');
 //выбираем выше сформированный PHP массив
 var massiv =<?=CUtil::PhpToJSObject($ar_service)?>;
            //здесь будем хранить значение элемента
            var cache;
            //сохраним длины массивов:
            var ln1 = selected_mass.length
                ln2 = massiv.length;
	//индекс для селектора	 
var index = 1;
//теперь делаем цикл
            for (var i = 0; i < ln1; ++i)
                {
                cache = selected_mass[i]["value"];
                for (var j = 0; j < ln2; ++j)
                    {
                    if (cache == massiv[j]["ID"])
                        {
// выбираем свойство привязка к элементу и создаем внутри него тег а 
last = 'tr_PROPERTY_3 > .adm-detail-content-cell-r > table > tbody > tr > td > table > tbody > tr:nth-child('+index+') > td';
// формируем теги по иерархии админки, чтобы стили сами подхватились
let obj = document.querySelector('#'+last);
//берем полученные переменные из массива PHP
var name_tag_a = massiv[j]["NAME"];
var iblock_id_tag_a=massiv[j]["IBLOCK_ID"];
var iblock_type_tag_a=massiv[j]["IBLOCK_TYPE_ID"];
var id_tag_a=massiv[j]["ID"];;
//создаем тег a с переменными php
let tag_a = document.createElement('a');
tag_a.setAttribute('name','tr_PROPERTY_PRIV_DOCTOR_SERVICE_'+index+'');
tag_a.setAttribute('href','http://sdatanalizy.dev.ddplanet.ru/bitrix/admin/iblock_element_edit.php?IBLOCK_ID='+iblock_id_tag_a+'&type='+iblock_type_tag_a+'&ID='+cache);
tag_a.setAttribute('value', massiv[j]["ID"]);
tag_a.setAttribute('size','30');
tag_a.setAttribute('style','padding-left:10px;');
tag_a.innerHTML=name_tag_a;
obj.appendChild(tag_a);
}}
index++;
}

})
</script>
<?

}}
?>