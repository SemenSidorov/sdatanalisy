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
<div class="article__box">

	<div class="article__social">
        <a href="https://vk.com/share.php?url=<?= $APPLICATION->GetCurPage() ?>&title=<?= $arResult['NAME'] ?><? if ($arResult["PREVIEW_TEXT"]) { ?>&description=<?= $arResult["PREVIEW_TEXT"] ?><? } ?><? if ($arResult["DETAIL_PICTURE"]["SRC"]) { ?>&image=<?= $arResult["DETAIL_PICTURE"]["SRC"] ?><? } ?>&noparse=true" target="_blank">
            <div class="article__social-vk">
                <span class="article__social-vk-icon">
                    <svg width="31px" height="19px" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.8661621,18.9338775 L16.6775346,18.9338775 C16.9910085,18.8971594 17.2836922,18.7576636 17.5102797,18.5369836 C17.6767934,18.276776 17.7634602,17.9731251 17.7594954,17.6638169 C17.7594954,17.6638169 17.7230248,14.9649381 18.8536131,14.5741503 C19.9720445,14.1833624 21.4004758,17.1509078 22.9200837,18.2927412 C23.4687351,18.7896969 24.2047837,19.0235415 24.9381229,18.9338775 L28.998515,18.9399836 C28.998515,18.9399836 31.1198876,18.7629078 30.1169464,16.9371957 C30.0318484,16.7845442 29.5273386,15.5816503 27.095966,13.1086957 C24.5491033,10.5258321 24.8955739,10.9410442 27.9591033,6.47140783 C29.8251817,3.7481048 30.5728288,2.08115025 30.3418484,1.37284722 C30.1169464,0.695074495 28.7553778,0.811089647 28.7553778,0.811089647 L24.1722405,0.804983586 C23.9668294,0.790527262 23.7617365,0.837254616 23.5826327,0.93931692 C23.4027389,1.0934803 23.2647097,1.29096095 23.1814562,1.51328662 C22.7142198,2.86757446 22.1494592,4.18589692 21.4916523,5.45780177 C19.4553778,9.23745328 18.640868,9.43895328 18.3126327,9.20081692 C17.5345935,8.65737753 17.7291033,7.0026351 17.7291033,5.83027147 C17.7291033,2.1666351 18.2396915,0.634013889 16.738319,0.23711995 C16.0441138,0.0565935325 15.3274655,-0.0215676677 14.610868,0.0050896469 C12.9757699,-0.0132285349 11.595966,0.0111957075 10.8179268,0.432513889 C10.2951817,0.713392677 9.89400524,1.3301048 10.1371425,1.36674116 C10.6690068,1.42060521 11.1561616,1.6895378 11.4865543,2.11168056 C11.9545935,2.80777147 11.9424366,4.37702904 11.9424366,4.37702904 C11.9424366,4.37702904 12.2098876,8.68790783 11.3102797,9.22524116 C10.6963582,9.5916048 9.85145622,8.84055934 8.03400524,5.40895328 C7.41539596,4.19797282 6.87136646,2.9499898 6.40498563,1.67204419 C6.32346096,1.46023775 6.19451334,1.27011564 6.02812288,1.11639268 C5.82076706,0.962182103 5.58208276,0.855849662 5.32910328,0.804983586 L0.983024844,0.804983586 C0.656575377,0.809913612 0.341492775,0.926184353 0.0894954327,1.13471086 C-0.025468318,1.40501917 -0.0298357329,1.70993421 0.07733857,1.98345328 C0.07733857,1.98345328 3.47518171,10.7578624 7.32282877,15.1481199 C10.8543974,19.1720139 14.8661621,18.9338775 14.8661621,18.9338775 Z" id="vk_-_international_copy_4" stroke="none" fill="#9FC6E9"></path>
                    </svg>
                </span>
            </div>
        </a>
        <a href="https://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=<?= $APPLICATION->GetCurPage() ?>&st.comments=<?= $arResult['NAME'] ?>" target="_blank">
            <div class="article__social-ok">
                <span class="article__social-ok-icon">
                    <svg width="20px" height="32px" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.78709677,0.00652173913 C14.0088994,0.160798968 17.3227671,3.71877779 17.2209864,7.9880176 C17.1192057,12.2572574 13.6396357,15.6497375 9.4153824,15.5982556 C5.19112913,15.5467736 1.79354839,12.0704794 1.79354839,7.8 C1.87476644,3.41778619 5.45190048,-0.0698159432 9.78709677,0.00652173913 L9.78709677,0.00652173913 Z M9.78709677,4.55217391 C11.5466299,4.61539313 12.9285218,6.09755697 12.8868409,7.8768398 C12.8451601,9.65612264 11.3954149,11.0705038 9.63489377,11.0494612 C7.87437263,11.0284186 6.45806452,9.57978164 6.45806452,7.8 C6.49161602,5.97451136 7.98118399,4.52127891 9.78709677,4.55217391 L9.78709677,4.55217391 Z M9.78709677,18.0130435 C11.7077135,18.2122307 13.6384399,17.7478657 15.2645161,16.6956522 C15.2645161,16.6956522 17.7354839,14.9478261 19.3677419,17.3543478 C19.3677419,17.3543478 21.116129,21.2608696 14.5806452,21.9717391 C14.5806452,21.9717391 13.6129032,22.0630435 13.8967742,22.6304348 C14.1806452,23.1978261 18.4129032,26.8434783 18.683871,27.9065217 C18.9548387,28.9695652 19.3935484,29.2565217 18,30.5413043 C16.6064516,31.826087 15.5032258,31.5326087 13.2064516,29.223913 C10.9096774,26.9152174 9.78709677,25.923913 9.78709677,25.923913 L9.78709677,18.0130435 L9.78709677,18.0130435 Z M9.78709677,18.0130435 C7.86853396,18.2120274 5.93990964,17.7476209 4.31612903,16.6956522 C4.31612903,16.6956522 1.84516129,14.9478261 0.212903226,17.3543478 C0.212903226,17.3543478 -1.53548387,21.2608696 5,21.9717391 C5,21.9717391 5.96774194,22.0630435 5.68387097,22.6304348 C5.4,23.1978261 1.16774194,26.8434783 0.896774194,27.9065217 C0.625806452,28.9695652 0.187096774,29.2565217 1.58064516,30.5413043 C2.97419355,31.826087 4.07741935,31.5326087 6.36774194,29.223913 C8.65806452,26.9152174 9.78709677,25.923913 9.78709677,25.923913 L9.78709677,18.0130435 L9.78709677,18.0130435 Z" id="odnoklasniki_copy" fill="#9FC6E9"  stroke="none" stroke-width="1" fill-rule="evenodd"></path>
                    </svg>
                </span>
            </div>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $APPLICATION->GetCurPage() ?>" target="_blank">
            <div class="article__social-facebook">
                <span class="article__social-facebook-icon">
                    <svg width="16" height="31" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.4448,6.69983193 L10.4448,10.9593277 L15.968,10.9593277 L14.7392,16.4358223 L10.4448,16.4358223 L10.4448,30.4313085 L4.3008,30.4313085 L4.3008,16.4358223 L0,16.4358223 L0,10.9593277 L4.3008,10.9593277 L4.3008,6.69983193 C4.3008,6.69983193 3.7568,0.900072029 9.216,0 L15.968,0 L15.968,4.87433373 L12.896,4.87433373 C12.896,4.87433373 10.5344,4.81094838 10.4448,6.69983193 Z" id="faceboook_copy" stroke="none" fill="#9FC6E9"> </path>
                    </svg>
                </span>
            </div>
        </a>
        <a href="https://twitter.com/share?url=<?= $APPLICATION->GetCurPage() ?>&text=<?= $arResult['NAME'] ?>" target="_blank">
            <div class="article__social-twitter">
                <span class="article__social-twitter-icon">
                    <svg width="28px" height="24px" xmlns="http://www.w3.org/2000/svg">
                        <path d="M27.1745711,3.347519 C27.0364977,3.38781335 26.8984757,3.42532878 26.7604537,3.46027114 C25.9166657,3.67316736 25.8391056,3.39223904 26.4500073,2.77243675 C26.7235792,2.49469905 26.9653236,2.19262005 27.1752406,1.86635416 C27.6458028,1.13472604 27.2376595,0.815664746 26.4370806,1.15742056 C26.1515091,1.27933285 25.8611994,1.38987214 25.5668727,1.48842091 C24.7419855,1.76523231 23.5714253,1.34767371 22.8364068,0.881844233 C21.9084666,0.293845155 20.8538861,0 19.6723047,0 C18.0172257,0 16.6065176,0.583264621 15.4393564,1.74886755 C14.2725558,2.91508803 13.6888465,4.32513308 13.6888465,5.97853955 C13.6888465,6.20466138 13.7017732,6.43423112 13.7273175,6.66699148 C13.7692391,7.04585103 13.1306815,7.32050104 12.2689712,7.19889752 C10.4049537,6.93592927 8.63394645,6.37155101 6.95558904,5.50638031 C5.29108532,4.64846567 3.82202689,3.5688549 2.54867125,2.26749653 C1.93998407,1.64553287 1.11674484,1.69910429 0.889472106,2.53869863 C0.753304166,3.04199208 0.685580701,3.56540698 0.685580701,4.10904625 C0.685580701,5.13354175 0.926346631,6.08372686 1.40798149,6.95960155 C1.64751141,7.39548044 1.9280359,7.79008721 2.25017299,8.14316455 C2.79201221,8.73749339 2.70909603,9.08233689 1.95486779,8.87103598 C1.20094854,8.65973507 0.648448672,8.34602578 0.648448672,8.36650745 C0.648448672,8.38698913 0.648448672,8.40366266 0.648448672,8.40366266 C0.648448672,9.84705476 1.10201563,11.1153234 2.00971607,12.2072334 C2.56885953,12.8799382 3.21843829,13.3995964 3.95819483,13.7655905 C4.73827645,14.1517062 5.10166562,14.3670725 4.66545441,14.4234743 C4.40228566,14.4574904 4.13752039,14.4744727 3.87121009,14.4744727 C3.69095752,14.4744727 3.50184683,14.4662903 3.30454752,14.4496168 C2.99250457,14.4231656 2.93642027,15.072867 3.40950601,15.8029513 C3.78551287,16.3830767 4.26678723,16.8935748 4.85307158,17.3345484 C5.44939858,17.7833441 6.09207624,18.1054931 6.78007454,18.3017158 C7.61721897,18.5401369 7.78521436,18.9744719 7.03881423,19.4216723 C5.19184341,20.5290723 3.14788229,21.0826951 0.907239859,21.0826951 C0.654783262,21.0826951 0.413965831,21.0770344 0.183912053,21.0660216 C-0.215424637,21.0468265 0.0524821802,21.398257 0.823396665,21.8017152 C3.23234349,23.0624704 5.84111316,23.6923077 8.65006618,23.6923077 C10.7738019,23.6923077 12.7682709,23.3563156 14.6332154,22.6838682 C16.4974905,22.0114722 18.0907687,21.1103814 19.41202,19.9813161 C20.7332714,18.8522509 21.8726736,17.5537229 22.8298662,16.0851146 C23.7868014,14.6165579 24.499726,13.0833655 24.9693612,11.4856918 C25.4383269,9.88765788 25.6731702,8.28648482 25.6731702,6.68217262 C25.6731702,6.53761727 25.6719342,6.40783137 25.6697197,6.29353538 C25.6652906,6.07873509 26.2339102,5.49732308 26.8686568,4.90242816 C27.1551554,4.63379914 27.4284182,4.35189306 27.689424,4.05619529 C28.2651507,3.4032518 28.0101705,3.10405465 27.1745711,3.347519 Z" id="Path" stroke="none" fill="#9FC6E9"></path>
                    </svg>
                </span>
            </div>
        </a>
	</div>
<?
$date = explode(" ",$arResult["DISPLAY_DATE"]);
//print_r($date);
switch ($date[1]) { //условный оператор
    case "Январь"://ключевое слово
    $date[1]="Января";
    break;
    case "Февраль":
   $date[1]="Февраля";
    break;
    case "Март":
    $date[1]="Марта";
	break;
	 case "Апрель"://ключевое слово
    $date[1]="Апреля";
    break;
    case "Май":
    $date[1]="Мая";
    break;
	 case "Июнь"://ключевое слово
    $date[1]="Июня";
    break;
    case "Июль":
    $date[1]="Июля";
    break;
	 case "Август"://ключевое слово
    $date[1]="Августа";
    break;
    case "Сентябрь":
    $date[1]="Сентября";
    break;
	 case "Октябрь"://ключевое слово
    $date[1]="Октября";
    break;
    case "Ноябрь":
    $date[1]="Ноября";
    break;
	case "Декабрь":
    $date[1]="Декабря";
    break;
}
?>
	<div class="article__contain">
		<div class="article__list">
			<div class="article__list-item">
				<div class="articles__list-item-data"><?print_r($date[0]." ".$date[1].", ".$arResult["DISPLAY_YEAR"]." года");?></div>
				<div class="article__list-item-text">
					<?if(isset($arResult["DETAIL_TEXT"]) && !empty($arResult["DETAIL_TEXT"])){?>
						<?=$arResult["DETAIL_TEXT"]?>
					<?}elseif(isset($arResult["PREVIEW_TEXT"]) && !empty($arResult["PREVIEW_TEXT"])){?>
						<?=$arResult["PREVIEW_TEXT"]?>
					<?}?>
				</div>
			</div>
<?if(isset($arResult["DETAIL_PICTURE"]["SRC"]) && !empty($arResult["DETAIL_PICTURE"]["SRC"])){?>
			<div class="article__list-item-img">
				<img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>" >
			</div>
<?}?>
		</div>

<?if(isset($arResult["PROPERTIES"]["HTML_DOWN"]["VALUE"]["TEXT"]) && !empty($arResult["PROPERTIES"]["HTML_DOWN"]["VALUE"]["TEXT"])){?>
<?=htmlspecialcharsBack($arResult["PROPERTIES"]["HTML_DOWN"]["VALUE"]["TEXT"])?>
<?}?>

<style>
.middle__h2{
	padding-top:30px;
}
</style>
<h2 class="middle__h2">Вам может быть интересно</h2>
                <div class="interesting">
                    <div class="interesting__item">
                        <h3 class="middle__h3">Исследования и диагностика</h3>               
					    <h3 class="middle__h3">Анализы</h3>
					   <div class="interesting__list js-interesting-slider">
   <?
   
  $ob_section_analyzes = CIBlockSection::GetList(array("RAND"=>"ASC"), array("IBLOCK_ID"=>2, "ACTIVE"=>"Y"), false, array("ID", "IBLOCK_ID", "NAME", "CODE", "SECTION_PAGE_URL"), array("nTopCount"=>5));
	while($section_analyzes = $ob_section_analyzes->GetNext())
	// $Section_Analyzes["SECTION_PAGE_URL"]=str_replace("/doctors", "/analyzes", $Section_Analyzes["SECTION_PAGE_URL"]);
	{  //print_r($Section_Analyzes["SECTION_PAGE_URL"]);
	  ?>
							
							<a class="interesting__ist-item" href="<?=$section_analyzes["SECTION_PAGE_URL"]?>"><?=$section_analyzes["NAME"]?></a>
	<? }?>
					   </div>
						  <h3 class="middle__h3">Услуги</h3>
					   <div class="interesting__list js-interesting-slider">
							
   <?
  $ob_section_services = CIBlockSection::GetList(array("RAND"=>"ASC"), array("IBLOCK_ID"=>3, "ACTIVE"=>"Y"), false, array("ID", "IBLOCK_ID", "NAME", "CODE", "SECTION_PAGE_URL"), array("nTopCount"=>5));
	while($section_services = $ob_section_services->GetNext()) {
?>
							<a class="interesting__ist-item" href="<?=$section_services["SECTION_PAGE_URL"]?>"><?=$section_services["NAME"]?></a>
   <?}?>
                       </div>
	   
	    </div>
                    <div class="interesting__item">
                        <h3 class="middle__h3">Врачи</h3>
					       
                        <div class="interesting__list js-interesting-slider">
						
   <? $ob_section_doctors = CIBlockSection::GetList(array("RAND"=>"ASC"), array("IBLOCK_ID"=>4, "ACTIVE"=>"Y"), false, array("ID", "IBLOCK_ID", "NAME", "CODE", "SECTION_PAGE_URL"), array("nTopCount"=>5));
	while($section_doctors = $ob_section_doctors->GetNext()) {
  ?>
                            <a class="interesting__ist-item" href="<?=$section_doctors["SECTION_PAGE_URL"]?>"><?=$section_doctors["NAME"]?></a>
  <?}?>
                        </div>
                    </div>
                    <div class="interesting__item">
                        <h3 class="middle__h3">Статьи</h3>
						<div class="articles-list">
						<?
						$db_Section_News= CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), Array("IBLOCK_ID"=>6, "ACTIVE"=>"Y", "!ID"=>$arResult["ID"] ),  Array("ID", "NAME", "CODE", "DATE_ACTIVE_FROM", "DETAIL_PAGE_URL" ),   Array ("nTopCount" => 3));
                         while($Section_News=$db_Section_News->GetNext())
						 {
							 $Section_News["DETAIL_PAGE_URL"]=str_replace("#ELEMENT_CODE#", $Section_News["CODE"], $Section_News["DETAIL_PAGE_URL"]);
							 ?>
							 <div class="articles-list__item">
                                <div class="articles-list__item-date"><?=$Section_News["DATE_ACTIVE_FROM"]?></div>
                                <a class="articles-list__item-text" href="<?=$Section_News["DETAIL_PAGE_URL"]?>"><?=$Section_News["NAME"]?></a>
                            </div>
					   <?}?>
					    </div>
                    </div>
                </div>

</div>

