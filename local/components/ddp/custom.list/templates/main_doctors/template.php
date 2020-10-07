<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="m-services__item m-services__item--doctors">
    <div class="m-services__item-title">Врачи</div>
    <ul class="m-services__item-detail">
        <?php foreach ($arResult['ITEMS'] as $item) { ?>
            <li class="m-services__item-detail-item"><?= $item['NAME'] ?></li>
        <?php } ?>
    </ul>
    <a href="/doctors/" class="m-services__item-more">Показать всех врачей</a>
</div>