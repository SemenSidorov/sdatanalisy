<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)) { ?>
	<nav class="footer-nav">
<?php foreach($arResult as $arItem) { ?>
        <a href="<?=$arItem["LINK"]?>" class="footer-nav__item"><?=$arItem["TEXT"]?></a>
<?php } ?>
	</nav>
<?php } ?>
