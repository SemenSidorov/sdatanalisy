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
$APPLICATION->SetTitle("Статьи");
//print_r($arResult["NAME"]);
$this->setFrameMode(true);


$date_year=date('Y');
if(empty($_REQUEST['YEAR']))
{
	$_REQUEST['YEAR']=$date_year;
	?>
	<script>
	
            var params = new URLSearchParams(location.search.slice(1));
            params.set($(this).data('param'),$(this).val());
            window.location = location.pathname + '?' + params;
			
        
	</script>
	<?
}
//print_r($date_year);
foreach($arResult["ITEMS"] as $arItem){
//print_r($arItem["NAME"]);

}
?>
 
<div class="title articles-title">
    <div class="title__left">
        <h1 class="middle__h1"><?=$arResult["NAME"]?></h1>
    </div>
    <div class="title__right -m">
        <div class="sorting no-js">
            <select class="sorting__select js-sorting" name="" id="" data-param="YEAR">
                <?php foreach ($arResult['years'] as $item) { 
				?>
                <option value="<?= $item ?>"<?= ($_REQUEST['YEAR'] == $item ? ' selected' : '')?>><?= $item ?></option>
                <?php } ?>
                <?/*<option value="2019"<?= ($_REQUEST['YEAR'] == '2019' ? ' selected' : '')?>>2019</option>*/?>
            </select>
        </div>
    </div>
	
</div>
<script>
/*reloader = setTimeout(reload, 5000);
function reload(){
     window.location.reload();
//      window.location.replace(url);  -  редирект на любую другую страницу
};

$('body').on('action','element',function(){
      clearTimeout(reloader);  // очищаем таймаут и тем самым начинаем отсчет 5 секунд
});*/
</script>
<div class="articles__list">
<?

foreach($arResult["ITEMS"] as $arItem){
	 
	 $active_from = explode(".",$arItem['ACTIVE_FROM']);
	  $active_from_year = explode(" ",$active_from[2]);
	
//	print_r($active_from_year[0]);
	if($active_from_year[0]==$_REQUEST['YEAR'])
	{
	$date = explode(" ",$arItem['DISPLAY_DATE']);
//print_r($date);
switch ($date[1]) { //условный оператор
    case "Январь"://ключевое слово
    $date[1]="Января";
    break;
    case "Февраль":
   $date[1]="Февраля";
    break;
    case "Март":
    $date[1]="Марта";
	break;
	 case "Апрель"://ключевое слово
    $date[1]="Апреля";
    break;
    case "Май":
    $date[1]="Мая";
    break;
	 case "Июнь"://ключевое слово
    $date[1]="Июня";
    break;
    case "Июль":
    $date[1]="Июля";
    break;
	 case "Август"://ключевое слово
    $date[1]="Августа";
    break;
    case "Сентябрь":
    $date[1]="Сентября";
    break;
	 case "Октябрь"://ключевое слово
    $date[1]="Октября";
    break;
    case "Ноябрь":
    $date[1]="Ноября";
    break;
	case "Декабрь":
    $date[1]="Декабря";
    break;
}
	?>
	<div class="articles__list-item">
		<div class="articles__list-item-box">
<?if(isset($arItem["PREVIEW_PICTURE"]["SRC"]) && !empty($arItem["PREVIEW_PICTURE"]["SRC"])){?>
			<div class="articles__list-item-photo">
				<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>">
			</div>
<?}?>
			<div class="articles__list-item-content">
				<div class="articles__list-item-data"><?print_r($date[0]." ".$date[1].", ".$arItem["DISPLAY_YEAR"]." года");?></div>
				<div class="articles__list-item-name"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>
				<div class="articles__list-item-text">
					<?=$arItem["PREVIEW_TEXT"]?>
				</div>
				<a class="articles__item-more btn" href="<?=$arItem["DETAIL_PAGE_URL"]?>">Прочитать статью</a>
			</div>
		</div>
	</div>
<?}}?>
</div>
<div class="articles__pagination">
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
