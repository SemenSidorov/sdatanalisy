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
.points__sidebar{
	visibility: hidden;
	position:absolute;
	right:0;
}
 @media (max-width: 425px){
.ymaps-2-1-77-gototech{
	display: none !important;
}
}


</style>

<div class="m-clinics" id="m-clinic">
    
        <div class="search-clinics__map points" id="search-clinics__map_points">
            <div id="mapPoints" class="points__map"></div>
            <div class="points__sidebar" id="points__sidebar_detail">
                <div class="points__list">
				<script>
                    //Неодходимо инициализировать города и районы по такой структуре. Они используются в map-points.js
                    cities = [];
                    cityAreas = [
                        { id: -1, text: "Выберите район" },
                    ];
		//var width_browser;	

		
setTimeout(function(a){
	
	width_browser = document.body.clientWidth;
	
	//alert(width_browser);
	if(width_browser<=320 ){
	//	document.getElementsById('mapPoints').setAttribute("style","right: 23px;");
	
		width_browser_proc= width_browser / 100 * 12;
		width_browser_proc = Math.floor(width_browser_proc);
		width_browser = width_browser - width_browser_proc;
		
		//document.getElementByClassName('ymaps-2-1-77-inner-panes').setAttribute("style","overflow: visible;");
		document.getElementById('search-clinics__map_points').setAttribute("style","position:absolute;width:"+width_browser+"px;height:100%;right:0;");
		document.getElementById('mapPoints').setAttribute("style","position:absolute;width:"+width_browser+"px;height:100%;right:0;");
	}
	else if(width_browser<=375 && width_browser>320){
	//	document.getElementsById('mapPoints').setAttribute("style","right: 23px;");
	width_browser_proc= width_browser / 100 * 10;
		width_browser_proc = Math.floor(width_browser_proc);
		width_browser = width_browser - width_browser_proc;
		document.getElementById('search-clinics__map_points').setAttribute("style","position:absolute;width:"+width_browser+"px;height:100%;right:0;");
		document.getElementById('mapPoints').setAttribute("style","position:absolute;width:"+width_browser+"px;height:100%;right:0;");
		
	}
	else if(width_browser<=425 && width_browser>375)
	{
		width_browser_proc = width_browser / 100 * 9;
		//width_browser_proc = Math.floor(width_browser_proc);
		width_browser = width_browser - width_browser_proc;
		document.getElementById('search-clinics__map_points').setAttribute("style","position:absolute;width:"+width_browser+"px;height:100%;right:0;");
		document.getElementById('mapPoints').setAttribute("style","position:absolute;width:"+width_browser+"px;height:100%;right:0;");
	}
	else if(width_browser<=768 && width_browser>425)
	{
		width_browser_proc = width_browser / 100 * 5;
		//width_browser_proc = Math.floor(width_browser_proc);
		width_browser = width_browser - width_browser_proc;
		document.getElementById('search-clinics__map_points').setAttribute("style","position:absolute;width:"+width_browser+"px;height:100%;right:0;");
		document.getElementById('mapPoints').setAttribute("style","position:absolute;width:"+width_browser+"px;height:100%;right:0;");
	}
	else if(width_browser<=1024 && width_browser>768)
	{
		width_browser_proc = width_browser / 100 * 3.5;
		//width_browser_proc = Math.floor(width_browser_proc);
		width_browser = width_browser - width_browser_proc;
		document.getElementById('search-clinics__map_points').setAttribute("style","position:absolute;width:"+width_browser+"px;height:100%;right:0;");
		document.getElementById('mapPoints').setAttribute("style","position:absolute;width:"+width_browser+"px;height:100%;right:0;");
	}
	else if(width_browser<=1440 && width_browser>1024)
	{
		width_browser_proc = width_browser / 100 * 18.5;
		//width_browser_proc = Math.floor(width_browser_proc);
		width_browser = width_browser - width_browser_proc;
		document.getElementById('search-clinics__map_points').setAttribute("style","position:absolute;width:100%;height:100%;right:-1px;");
		document.getElementById('mapPoints').setAttribute("style","position:absolute;width:100%;height:100%;right:0;");
	}
	else if(width_browser<=2560 && width_browser>1440){
		//var FirstVar = 133;
//var SecondVar = 50;
		//var calc = "calc("+FirstVar+"% - "+width_browser+"px)";
	//var width_browser_proc;
		width_browser_proc= width_browser / 100 * 54;
		width_browser_proc = Math.floor(width_browser_proc);
		
		width_browser = width_browser - width_browser_proc;
		document.getElementById('mapPoints').setAttribute("style","position:absolute;width:100%;height:100%;right:0;");
		document.getElementById('search-clinics__map_points').setAttribute("style","position:absolute;width:100%;height:100%;right:0;");
		//document.getElementById("search-clinics__map_points").style.width = calc;
	}
	
}, 100);

                </script>
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

                   
                </div>
            </div>
        </div>
    
</div>
<script>
		/*	//elem = document.getElementsByClassName("ymaps-2-1-77-gototech").innerHTML;
			//alert(elem);
			setTimeout(function(){ function changeLink() {
				document.getElementsByClassName("ymaps-2-1-77-gototech").className = "gototech";
      document.getElementsByClassName('ymaps-2-1-77-gototech').innerHTML="Новая ссылка";
      document.getElementsByClassName('ymaps-2-1-77-gototech').href="http://www.puzzleweb.ru";
      document.getElementsByClassName('ymaps-2-1-77-gototech').target="_blank";
    }
			}, 4000);*/
			</script>