<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<select class="js-region" name="" id="" data-type="<?= REGION_TYPE ?>" data-domain="<?= SITE_SERVER_NAME ?>">
    <?php foreach ($arResult["ITEMS"] as $item) { ?>
        <option value="<?= (REGION_TYPE != 'DOMAIN' ? $item["ID"] : ($item['PROPERTY_56_VALUE'] ? '0' : $item["CODE"])) ?>" <?= ($arResult["SELECT"] == $item['ID'] ? ' selected' : '') ?>><?= $item["NAME"] ?></option>
    <?php } ?>
</select>