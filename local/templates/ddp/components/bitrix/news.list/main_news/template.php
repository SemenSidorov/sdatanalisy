<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="m-articles">
    <div class="m-articles__title">Публикации</div>
    <div class="m-articles__list">
        <?php foreach ($arResult["ITEMS"] as $arItem) { ?>
        <div class="m-articles__item">
            <div class="m-articles__item-date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></div>
            <a class="m-articles__item-title" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
            <div class="m-articles__item-text">
                <?=$arItem["PREVIEW_TEXT"]?>
            </div>
        </div>
        <?php } ?>
    </div>
    <a class="m-articles__more btn-more" href="/articles/">Все публикации</a>
</div>
