<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

	<nav class="nav__list">

<?
$previousLevel = 0;
foreach($arResult as $arItem):
?>

        <a href="<?=$arItem["LINK"]?>" class="nav__item"><?=$arItem["TEXT"]?></a>


<?endforeach?>
	
	</nav>

<?endif?>