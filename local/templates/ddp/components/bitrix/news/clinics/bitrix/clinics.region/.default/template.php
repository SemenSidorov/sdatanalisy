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
$this->setFrameMode(true);
?>
<div class="clinics__description">
	<div class="contacts-list">
<?foreach($arResult["ITEMS"] as $item){
	$props = [];
	foreach($item["DISPLAY_PROPERTIES"] as $arProperty){
		$props[$arProperty["CODE"]] = $arProperty["DISPLAY_VALUE"];
	}
	$item["PROPERTIES"] = $props;
?>
		<div class="contacts-list__item">
			<div class="contacts-list__item-contact">
				<div class="contacts-list__item-address"><a href="<?=$item["DETAIL_PAGE_URL"]?>"><?=$item["PROPERTIES"]["ADDRESS"]?></a></div>
				<a class="contacts-list__item-phone" href="tel:<?=$item["PROPERTIES"]["PHONE"]?>"><?=$item["PROPERTIES"]["PHONE"]?></a>
			</div>
			<div class="contacts-list__item-mode mode">
	<?if(isset($item["PROPERTIES"]["PHONE"]) && !empty($item["PROPERTIES"]["WEEKDAYS"])){?>
				<div class="mode__item">
					<div class="mode__item-title">Пн-Пт:</div>
					<div class="mode__item-value"><?=$item["PROPERTIES"]["WEEKDAYS"]?></div>
				</div>
	<?}if(isset($item["PROPERTIES"]["PHONE"]) && !empty($item["PROPERTIES"]["SATURDAY"])){?>
				<div class="mode__item">
					<div class="mode__item-title">Сб:</div>
					<div class="mode__item-value"><?=$item["PROPERTIES"]["SATURDAY"]?></div>
				</div>
	<?}if(isset($item["PROPERTIES"]["PHONE"]) && !empty($item["PROPERTIES"]["SUNDAY"])){?>
				<div class="mode__item">
					<div class="mode__item-title">Вс:</div>
					<div class="mode__item-value"><?=$item["PROPERTIES"]["SUNDAY"]?></div>
				</div>
	<?}?>
			</div>
		</div>
<?}?>
	</div>
</div>