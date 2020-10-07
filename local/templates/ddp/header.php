<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
<?
$siteUrl = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'];
$curPage = $APPLICATION->GetCurPage();
$sku = explode('?', $_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">


    <meta property="og:url" content="<?=$siteUrl . $curPage?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?$APPLICATION->ShowTitle();?>">
    <meta property="og:description" content="<?$APPLICATION->ShowProperty('description');?>">
    <meta property="og:image" content="<?=$siteUrl?><?$APPLICATION->ShowProperty('OGImage', SITE_TEMPLATE_PATH.'/_html/Source/images/footer-logo.jpg');?>">


    <link rel="canonical" href="<?=$siteUrl . $sku[0]?>"/>
<link rel="icon" type="image/png" href="/favicon.ico" />


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <title><?php $APPLICATION->ShowTitle(); ?></title>

    <?php $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/_html/Result/Content/libs/libs.css'); ?>
    <?php $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/_html/Result/Content/css/main.css'); ?>

    <?php $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/_html/Result/Content/libs/libs.js'); ?>
    <?php $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/_html/Result/Scripts/init.js'); ?>

    <?php /*<script type="text/javascript" src="http://gc.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=lCPAqzssJtuCMsD8UC2qb9M72ALAFcCAJ4AeATm9siEPJeUUIGIyyuRl-fy2y1cSfnRmU9reO28F7oGQQhRPSyve1P-iXDerUuyKOyUGlEc" charset="UTF-8"></script><script src="https://api-maps.yandex.ru/2.1/?apikey=ваш API-ключ&lang=ru_RU" type="text/javascript">
    </script> */?>

    <?php $APPLICATION->ShowHead(); ?>

</head>

<body>
<?php $APPLICATION->ShowPanel(); ?>
<div class="wrapper">
    <header class="header <?if(explode('?', $_SERVER['REQUEST_URI'])[0] == '/') {?>header--main<?}?>"><!--header--main только на главной-->
        <div class="inner">
            <a class="header__logo" href="/">Сдать анализы</a>
            <div class="header__top">
                <div class="header__region no-js">
                    <?php $APPLICATION->IncludeComponent("ddp:custom.list", "header_regions", array(), false);?>
                </div>
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    ".default",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => SITE_TEMPLATE_PATH."/include/header_phone.php",
                        "COMPONENT_TEMPLATE" => ".default"
                    ),
                    false
                ); ?>
                <div class="header__search-btn-mobile"></div>
                <?php $APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	"custom", 
	array(
		"CHECK_DATES" => "N",
		"CONTAINER_ID" => "title-search",
		"INPUT_ID" => "title-search-input",
		"NUM_CATEGORIES" => "",
		"TOP_COUNT" => "",
		"ORDER" => "rank",
		"PAGE" => "/search/",
		"SHOW_INPUT" => "Y",
		"SHOW_OTHERS" => "N",
		"USE_LANGUAGE_GUESS" => "Y",
		"USE_SUGGEST" => "Y",
		"COMPONENT_TEMPLATE" => "custom",
		"CATEGORY_0_TITLE" => "",
		"CATEGORY_0" => array(
		)
	),
	false
); ?>
                <?php $APPLICATION->IncludeComponent("ddp:custom.list", "header_favorite", array(), false);?>
                <div class="header__login">
                    <a href="personal">личный кабинет</a>
                </div>
            </div>
            <div class="nav__hamburger">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="nav no-js">
                <?php
                /* телефон для мобильной версии берем из поключаемой области для десктопа */
                $phone = file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH."/include/header_phone.php");
                echo str_replace('header__phone', 'nav__phone', $phone);
                ?>
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "header",
                    array(
                        "ROOT_MENU_TYPE" => "top",
                        "MENU_CACHE_TYPE" => "Y",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "N",
                        "MENU_THEME" => "site",
                        "CACHE_SELECTED_ITEMS" => "N",
                        "MENU_CACHE_GET_VARS" => array(),
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                    ),
                    false
                ); ?>
                <div class="nav__login">
                    <a href="personal">личный кабинет</a>
                </div>
            </div>
        </div>
    </header>
    <?php if ($APPLICATION->GetCurPage() != '/') { ?>
    <div class="middle">
        <div class="inner">
            <?php $APPLICATION->IncludeComponent(
                "bitrix:breadcrumb",
                "custom",
                Array(
                    "PATH" => "",
                    "SITE_ID" => "s1",
                    "START_FROM" => "0"
                )
            ); ?>
            <div class="title header-title">
                <div class="title__left">
                    <h1 class="middle__h1"><?= $APPLICATION->ShowTitle(false); ?></h1>
                </div>
            </div>
    <?php } ?>
