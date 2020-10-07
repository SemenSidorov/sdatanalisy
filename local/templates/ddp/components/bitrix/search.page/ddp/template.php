<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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
?>
<div class="search-page">

<?php if (isset($arResult["REQUEST"]["ORIGINAL_QUERY"])) { ?>
	<div class="search-language-guess">
		<?= GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
	</div>
    <br />
<?php } ?>

	<div class="search-result">
	<?php if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false) { ?>
	<?php } elseif ($arResult["ERROR_CODE"]!=0) { ?>
		<p><?=GetMessage("CT_BSP_ERROR")?></p>
		<?ShowError($arResult["ERROR_TEXT"]);?>
		<p><?=GetMessage("CT_BSP_CORRECT_AND_CONTINUE")?></p>
		<br /><br />
		<p><?=GetMessage("CT_BSP_SINTAX")?><br /><b><?=GetMessage("CT_BSP_LOGIC")?></b></p>
		<table border="0" cellpadding="5">
			<tr>
				<td align="center" valign="top"><?=GetMessage("CT_BSP_OPERATOR")?></td><td valign="top"><?=GetMessage("CT_BSP_SYNONIM")?></td>
				<td><?=GetMessage("CT_BSP_DESCRIPTION")?></td>
			</tr>
			<tr>
				<td align="center" valign="top"><?=GetMessage("CT_BSP_AND")?></td><td valign="top">and, &amp;, +</td>
				<td><?=GetMessage("CT_BSP_AND_ALT")?></td>
			</tr>
			<tr>
				<td align="center" valign="top"><?=GetMessage("CT_BSP_OR")?></td><td valign="top">or, |</td>
				<td><?=GetMessage("CT_BSP_OR_ALT")?></td>
			</tr>
			<tr>
				<td align="center" valign="top"><?=GetMessage("CT_BSP_NOT")?></td><td valign="top">not, ~</td>
				<td><?=GetMessage("CT_BSP_NOT_ALT")?></td>
			</tr>
			<tr>
				<td align="center" valign="top">( )</td>
				<td valign="top">&nbsp;</td>
				<td><?=GetMessage("CT_BSP_BRACKETS_ALT")?></td>
			</tr>
		</table>
	<?php } elseif(count($arResult["SEARCH"])>0) { ?>
        <div class="search-result__info info">
            <div class="info__body">По вашему запросу «<?=$arResult['REQUEST']['QUERY']?>» найдено <strong><?= $arResult["NAV_RESULT"]->NavRecordCount ?> результатов.</strong>
            </div>
        </div>
		<?/*if($arParams["DISPLAY_TOP_PAGER"] != "N") echo $arResult["NAV_STRING"]*/?>
		<?php
            foreach ($arResult['IBS'] as $ib_key => $ib) {
                if (isset($arResult["SEARCH"][$ib_key])) {
        ?>
        <div class="search-result__item">
            <div class="search-result__item-title"><?= $ib ?> <span>(<?= count($arResult["SEARCH"][$ib_key])?>)</span></div>
            <div class="search-result__item-body">
                <?php
                    switch ($ib_key) {
                        case IB_ARTICLES_ID:
                ?>
                <div class="articles-list">
                    <?php foreach ($arResult["SEARCH"][$ib_key] as $item ) { ?>
                        <div class="articles-list__item search-result__item-element">
                            <div class="articles-list__item-date"><?= $item['DATE_CHANGE']?></div>
                            <h3><a class="articles-list__item-text" href="<?= $item['URL'] ?>"><?=$item['TITLE_FORMATED']?></a></h3>
                            <?php if ($item['BODY_FORMATED']) { ?>
                                <p class=""><?=$item['BODY_FORMATED']?></p>
                            <? } ?>
                        </div>
                    <?php } ?>
                </div>
                <?php
                            break;
                        case IB_ANALYZES_ID:
                        case IB_SERVICES_ID:
                ?>
                <div class="services__list">
                     <?php foreach ($arResult["SEARCH"][$ib_key] as $item ) { ?>
                            <div class="services__item search-result__item-element">
                                <div class="services__item-title"><?=$item['TITLE_FORMATED']?></div>
                                <div class="services__item-price price">от <span class="price__num"><?= $item['PRICE'] ?></span> <span class="price__rub">₽</span></div>
                                <a class="services__item-more btn" href="<?= $item['URL'] ?>">Подробнее</a>
                            </div>
                     <?php } ?>
                </div>
                <?php
                            break;
                        case IB_DOCTORS_ID:
                ?>
                <div class="doctors__list">
                    <?php foreach ($arResult["SEARCH"][$ib_key] as $item ) { ?>
                        <?php if ($item["DETAIL_PICTURE"]) $renderImage = CFile::ResizeImageGet($item["DETAIL_PICTURE"], Array("width" => '140', "height" => '140')); ?>
                        <div class="doctors__list-item search-result__item-element">
                                    <div class="doctors__list-item-body">
                                        <div class="doctors__list-item-photo"><img src="<?= ($item["DETAIL_PICTURE"]? $renderImage['src'] : '') ?>" alt="" width="140" height="140"></div>
                                        <div class="doctors__list-item-content">
                                            <div class="doctors__list-item-specialty"><span class="search-result__marker"><?= $item['SECTION'] ?></span></div>
                                            <div class="doctors__list-item-name"><a href="doctors-detail.html"><?= $item['NAME'] ?></a></div>
                                            <ul class="doctors__list-item-description">
                                                <li><?= $item['PROPERTY_CATEGORY_VALUE'] ?></li>
                                                <li>Стаж <?= $item['PROPERTY_EXPERIENCE_VALUE'] ?> лет</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="doctors__list-item-col">
                                        <div class="doctors__list-item-col-title">Адрес клиники</div>
                                        <div class="doctors__list-item-city"><?= $item['CLINIC']['CITY'] ?></div>
                                        <div class="doctors__list-item-address"><a href="/clinics/<?= $item['CLINIC']['CODE'] ?>/"><?= $item['CLINIC']['PROPERTY_ADDRESS_VALUE'] ?>Москва, 2-й Тверской-Ямской пер., 10</a></div>
                                    </div>
                                    <div class="doctors__list-item-col">
                                        <div class="doctors__list-item-price-box">
                                            <div class="doctors__list-item-col-title">Стоимость приема</div>
                                            <div class="doctors__list-item-price price">
                                                <span class="price__num"><?= $item['PROPERTY_PRICE_VALUE'] ?></span> <span class="price__rub">₽</span>
                                            </div>
                                        </div>
                                        <a class="doctors__list-item-btn btn btn--secondary" data-fancybox="" data-src="#registration-popup" href="javascript:;">Записаться на прием</a>
                                        <div id="registration-popup" class="clinics__find-time-popup popup" style="display: none">
                                            <div class="popup__title">Записаться на прием</div>
                                            <form class="form form--center" action="">
                                                <div class="form__item">
                                                    <input class="form__field form__field--error" type="text" placeholder="Ваше имя и фамилия">
                                                    <span class="form__error">Обязательное поле для заполнения</span>
                                                </div>
                                                <div class="form__item">
                                                    <input class="form__field" type="email" placeholder="Почта для обратной связи">
                                                </div>
                                                <div class="form__item">
                                                    <input class="form__field" type="tel" data-mask="+7-000-000-00-00" placeholder="Телефон для обратной связи" autocomplete="off" maxlength="16">
                                                </div>
                                                <div class="form__footer">
                                                    <button class="btn btn--secondary" type="submit">Записаться</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                        </div>
                    <?php } ?>
                </div>
                <?php
                            break;
                    }
                ?>
            </div>
            <a class="search-result__item-btn" href="#" style="display: none;">Показать все</a>
        </div>
        <?php
                }
            }
?>



		<?/*if($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"]*/?>
		<?/*if($arParams["SHOW_ORDER_BY"] != "N"):?>
			<div class="search-sorting"><label><?echo GetMessage("CT_BSP_ORDER")?>:</label>&nbsp;
			<?if($arResult["REQUEST"]["HOW"]=="d"):?>
				<a href="<?=$arResult["URL"]?>&amp;how=r"><?=GetMessage("CT_BSP_ORDER_BY_RANK")?></a>&nbsp;<b><?=GetMessage("CT_BSP_ORDER_BY_DATE")?></b>
			<?else:?>
				<b><?=GetMessage("CT_BSP_ORDER_BY_RANK")?></b>&nbsp;<a href="<?=$arResult["URL"]?>&amp;how=d"><?=GetMessage("CT_BSP_ORDER_BY_DATE")?></a>
			<?endif;?>
			</div>
		<?endif;*/?>
	<?php } else { ?>
		<?ShowNote(GetMessage("CT_BSP_NOTHING_TO_FOUND"));?>
	<?php } ?>

	</div>
</div>