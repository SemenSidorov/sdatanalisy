<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php

CModule::IncludeModule("iblock");
$cities = array();
$cityAreas = array();
//$arclinic = CIBLockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>5, "ID"=>10), false, Array("ID", "NAME", "CODE", "PROPERTIES"), false);
//$clinic=$arclinic->Fetch();
//$city_id = Regions::getCurRegion();
//$this->setFrameMode(true);
//print_r($arResult['ITEMS']);
?>
<style>
.m-clinics
{

	bottom:0;
    left:0;
    position:absolute;
    top:0;
   padding:0;

}
</style>
<div class="m-clinics">
   
    <div class="search-clinics">
        <div class="search-clinics__search-panel">
            <div class="search-clinics__search-panel-list">
                <div class="search-clinics__search-panel-item">
                    <input id="search-clinics-cities" type="text" placeholder="Введите название города">
                </div>
                <div class="search-clinics__search-panel-item">
                    <input id="search-clinics-addresses" type="text" placeholder="Введите адрес клиники">
                </div>
                <!-- <div class="search-clinics__search-panel-item search-clinics__search-panel-item--select">
                   <select class="js-search-clinic--select" data-placeholder="Выберите район">
                   </select>
               </div>!-->
                <script>
                    //Неодходимо инициализировать города и районы по такой структуре. Они используются в map-points.js
                    cities = [];
                    cityAreas = [
                        { id: -1, text: "Выберите район" },
                    ];
					
				
                </script>
            </div>
        </div>
        <div class="search-clinics__map points">
            <div id="mapPoints" class="points__map"></div>
            <div class="points__sidebar">
                <div class="points__list">
                    <?php foreach ($arResult['ITEMS'] as $item) { ?>
                        <?php
                        if (!isset($cities[$item['PROPERTIES']['CITY']['VALUE']])) {
                            $cities[$item['PROPERTIES']['CITY']['VALUE']] = $arResult['REGIONS'][$item['PROPERTIES']['CITY']['VALUE']]['NAME'];
                            echo '<script type="text/javascript">cities.push({ value: "'.$cities[$item['PROPERTIES']['CITY']['VALUE']].'", id: '.$item['PROPERTIES']['CITY']['VALUE'].' })</script>';
                        }
                        $coord = explode(',', str_replace(' ', '', $item['PROPERTIES']['COORD']['VALUE']));
                        ?>
                        <div class="points__item" id="point_111" data-city="<?= $item['PROPERTIES']['CITY']['VALUE'] ?>" data-area="" data-lan="<?= $coord[0] ?>" data-lon="<?= $coord[1] ?>">
                            <?php if ($item['DETAIL_PICTURE']['ID']) { ?>
                            <div class="points__item-img">
                                <img src="<?= $item['IMG']['src'] ?>" alt="">
                            </div>
                            <?php } ?>
                            <div class="points__item-header">
                                <div class="points__item-title">
                                    <a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['NAME'] ?></a>
                                </div>
                            </div>
                            <div class="points__item-description">
                                <span class="points__item-address"><?= $item['PROPERTIES']['ADDRESS']['VALUE'] ?></span>
                            </div>
                            <div class="points__item-mode">
                                Будни: <?= $item['PROPERTIES']['WEEKDAYS']['VALUE'] ?><br />
                                Суббота: <?= ($item['PROPERTIES']['SATURDAY']['VALUE']?:'выходной') ?><br />
                                Воскресенье: <?= ($item['PROPERTIES']['SUNDAY']['VALUE']?:'выходной') ?><br />
                            </div>
                        </div>
                    <?php } ?>

                    <?/*<div class="points__item" id="point_111" data-city="1" data-area="1" data-lan="55.754937" data-lon="37.653291">
                        <div class="points__item-img">
                            <img src="https://avatars.mds.yandex.net/get-tycoon/1534598/2a000001719745ab387c7f5ec5db5d9f9177/priority-headline-logo" alt="">
                        </div>
                        <div class="points__item-header">
                            <div class="points__item-title">
                                <a href="clinics-detail.html">Скандинавский Центр Здоровья</a>
                            </div>
                        </div>
                        <div class="points__item-description">
                            Медцентр, клиника, гинекологическая клиника. <span class="points__item-address">2-я Кабельная ул., 2, стр. 25, Москва </span>
                        </div>
                        <div class="points__item-mode">
                            Ежедневно: 9:00 – 21:00
                        </div>
                    </div>
                    <div class="points__item" id="point_112" data-city="1" data-area="2" data-lan="55.753216" data-lon="37.662833">
                        <div class="points__item-img">
                            <img src="https://avatars.mds.yandex.net/get-tycoon/1654178/2a0000016d97891772fb82f6477c0623784e/priority-headline-logo" alt="">
                        </div>
                        <div class="points__item-header">
                            <div class="points__item-title">
                                <a href="clinics-detail.html">МедЦентрСервис</a>
                            </div>
                        </div>
                        <div class="points__item-description">
                            Медцентр, клиника, гинекологическая клиника. <span class="points__item-address">Селивёрстов пер., 8, стр. 1, Москва</span>
                        </div>
                        <div class="points__item-mode">
                            Круглосуточно
                        </div>
                    </div>
                    <div class="points__item" id="point_123" data-city="1" data-area="1" data-lan="55.747226" data-lon="37.674885">
                        <div class="points__item-img">
                            <img src="https://avatars.mds.yandex.net/get-tycoon/474201/2a0000016a67c3fcfbe2461250d62fafd751/logo" alt="">
                        </div>
                        <div class="points__item-header">
                            <div class="points__item-title">
                                <a href="clinics-detail.html">Инновационный медицинский центр</a>
                            </div>
                        </div>
                        <div class="points__item-description">
                            Медцентр, клиника, гинекологическая клиника. <span class="points__item-address">ул. Сергия Радонежского, 7, стр. 1, Москва</span>
                        </div>
                        <div class="points__item-mode">
                            Открыто до 21:00
                        </div>
                    </div>
                    <div class="points__item" id="point_211" data-city="2" data-area="3" data-lan="59.841084" data-lon="30.408799">
                        <div class="points__item-img">
                            <img src="https://avatars.mds.yandex.net/get-tycoon/1534662/2a0000016e8cfd041bdd70b9d4ccef67793b/priority-headline-logo" alt="">
                        </div>
                        <div class="points__item-header">
                            <div class="points__item-title">
                                <a href="clinics-detail.html">СМ-Клиника</a>
                            </div>
                        </div>
                        <div class="points__item-description">
                            Медцентр, клиника, детская поликлиника. <span class="points__item-address">Дунайский просп., 47, Санкт-Петербург</span>
                        </div>
                        <div class="points__item-mode">
                            Открыто до 21:00
                        </div>
                    </div>
                    <div class="points__item" id="point_222" data-city="2" data-area="4" data-lan="59.926534" data-lon="30.327569">
                        <div class="points__item-img">
                            <img src="https://avatars.mds.yandex.net/get-tycoon/1638958/2a0000016dee9d02bc56954449cc970aa915/priority-headline-logo" alt="">
                        </div>
                        <div class="points__item-header">
                            <div class="points__item-title">
                                <a href="clinics-detail.html">Медикал Он Груп</a>
                            </div>
                        </div>
                        <div class="points__item-description">
                            Медцентр, клиника, детская поликлиника. <span class="points__item-address">наб. реки Карповки, 20, Санкт-Петербург</span>
                        </div>
                        <div class="points__item-mode">
                            Открыто до 21:00
                        </div>
                    </div>*/?>
                </div>
            </div>
        </div>
    </div>
</div>