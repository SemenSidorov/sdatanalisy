<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="m-services__item m-services__item--analysis">
    <div class="m-services__item-title">Анализы</div>
    <ul class="m-services__item-detail">
        <?php foreach ($arResult['ITEMS'] as $item) { ?>
            <li class="m-services__item-detail-item"><?= $item['NAME'] ?></li>
        <?php } ?>
    </ul>
    <a href="/analyzes/" class="m-services__item-more">Показать все анализы</a>
</div>