<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<div class="header__favorite" id="header_favorite">
    <div class="header__favorite-title">избранные клиники</div>
    <?/*<div class="header__favorite-num" v-if="items.length > 0">{{ items.length }}</div>*/?>
    <favorite-items-count v-bind:count="items.length" v-if="items.length > 0"></favorite-items-count>

    <div class="header__favorite-dropdown" v-if="items.length > 0">
        <favorite-item v-for="item in items" v-bind:key="item.id" v-bind:item="item"></favorite-item>
    </div>

    <?php/* if (count($arResult['ITEMS'])) { ?>
    <div class="header__favorite-num"><?= (count($arResult['ITEMS']) ?: '') ?></div>
    <div class="header__favorite-dropdown">
        <?php foreach ($arResult['ITEMS'] as $item) { ?>
        <div class="header__favorite-dropdown-item" data-item="<?= $item['ID'] ?>">
            <a class="header__favorite-dropdown-link" href="/clinics/<?= $item['CODE'] ?>"><?= $item['PROPERTY_23_VALUE'] ?></a>
            <a class="header__favorite-dropdown-remove" href="#"></a>
        </div>
        <?php } ?>
    </div>
    <?php } */?>
</div>

<script>
    header_favorite.items = <?= json_encode($arResult['ITEMS']) ?>;
</script>