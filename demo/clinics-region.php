
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "");
//$APPLICATION->SetTitle("Регионы клиник");

/*<select class="js-region" name="region" id="">
<?
$i = 0;
foreach($arResult["ITEMS"] as $item){?>
    <option value="<?=$i?>"><?=$item["NAME"]?></option>
<?}?>
</select>*/

//echo $item["NAME"];
//var_dump(Regions::getAllRegions());
$regionID = Regions::getCurRegion(); 
//echo $regionID;
$arFilter= array("IBLOCK_ID"=>1, "ID"=>$regionID);
$reg = CIBlockElement::GetList(Array(), $arFilter, false);
$obreg=$reg->Fetch();
$IBLOCK_ID_ANALYZES=2;
?>


<div class="middle">
        <div class="inner">
            <div class="breadcrumb">
                <div class="breadcrumb__item"><a href="#">Главная</a></div>
                <div class="breadcrumb__item">Клиники в Регионе "<?=$obreg["NAME"]?>"</div>
            </div>
<h1 class="middle__h1">Клиники в Регионе "<?=$obreg["NAME"]?>"</h1>
            <div class="clinics">
                <div class="clinics__description">
                    <div class="contacts-list">
<?
CModule::IncludeModule("iblock");
$ar_prop= array();
//print_r($region_prop);
//db_phone = CIBlockElement::GetProperty(5, $items["ID"], array("sort" => "asc"), Array("CODE"=>"CITY"));
//$phone = $db_phone->Fetch();



$arSelect = Array("ID", "NAME", "CODE",  "PROPERTY_4");
$arFilter= array("IBLOCK_ID"=>5, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, $arSelect);

while($ob=$res->Fetch())
{
	//$arOb = $ob->GetFields();
	$ar_prop[] =$ob;
}
$hr_prop= array();
foreach($ar_prop as $items)
{
	$propCITY=strip_tags($items["PROPERTY_4_VALUE"]);
	/*$db_enum_list = CIBlockProperty::GetPropertyEnum("CITY", Array(), Array("IBLOCK_ID"=>5, "VALUE"=>$obreg["NAME"]));
	print_r ($propCITY);
while($ar_enum_list = $db_enum_list->GetNext())
{
	$db_important_news = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>5, "PROPERTY"=>array("CITY"=>$ar_enum_list["ID"])));
  //$hr_prop[] = $db_important_news;
  print_r ($ar_enum_list);
}*/
if($propCITY==$regionID)
{
	$db_phone = CIBlockElement::GetProperty(5, $items["ID"], array("sort" => "asc"), Array("CODE"=>"PHONE"));
$phone = $db_phone->Fetch();
$db_weekdays = CIBlockElement::GetProperty(5, $items["ID"], array("sort" => "asc"), Array("CODE"=>"WEEKDAYS"));
$weekdays = $db_weekdays->Fetch();
$db_saturday = CIBlockElement::GetProperty(5, $items["ID"], array("sort" => "asc"), Array("CODE"=>"SATURDAY"));
$saturday = $db_saturday->Fetch();
$db_sunday = CIBlockElement::GetProperty(5, $items["ID"], array("sort" => "asc"), Array("CODE"=>"SUNDAY"));
$sunday = $db_sunday->Fetch();
$db_address = CIBlockElement::GetProperty(5, $items["ID"], array("sort" => "asc"), Array("CODE"=>"ADDRESS"));
$address = $db_address->Fetch();
?>

    
            
                        <div class="contacts-list__item">
                            <div class="contacts-list__item-contact">
							    <div class="contacts-list__item-name"><a href="<?="/clinics/".$items["CODE"]?>"><?=$items["NAME"];?></a></div>
                                <div class="contacts-list__item-address"><a href="<?="/clinics/".$items["CODE"]."/"?>"><?=$address["VALUE"];?></a></div>
                                <a class="contacts-list__item-phone" href="<?=$phone["VALUE"]?>"><?=$phone["VALUE"]?></a>
                            </div>
                            <div class="contacts-list__item-mode mode">
                                <div class="mode__item">
                                    <div class="mode__item-title">Пн-Пт:</div>
                                    <div class="mode__item-value"><?=$weekdays["VALUE"]?></div>
                                </div>
                                <div class="mode__item">
                                    <div class="mode__item-title">Сб:</div>
                                    <div class="mode__item-value"><?=$saturday["VALUE"]?></div>
                                </div>
								<?
								if($sunday["VALUE"]!="")
								{
								?>
								<div class="mode__item">
                                    <div class="mode__item-title">Вс:</div>
                                    <div class="mode__item-value"><?=$sunday["VALUE"]?></div>
                                </div>
								<?
								}
								?>
                            </div>
                        </div>
                   
     
<?}
}
?>
 </div>
                </div>
                
            </div>
         <h2 class="middle__h2">Вам может быть интересно</h2>
                <div class="interesting">
                    <div class="interesting__item">
                        <h3 class="middle__h3">Исследования и диагностика</h3>
                        <div class="interesting__list js-interesting-slider">
                            	
							<a class="interesting__ist-item" href="#">Коагулограмма, скрининг</a>
                          
							<a class="interesting__ist-item" href="#">TORCH-комплекс, базовый</a>
                            <a class="interesting__ist-item" href="#">Ревматологический, расширенный</a>
                        </div>
                    </div>
                    <div class="interesting__item">
                        <h3 class="middle__h3">Врачи</h3>
                        <div class="interesting__list js-interesting-slider">
                            <a class="interesting__ist-item" href="#">Аллерголог</a>
                            <a class="interesting__ist-item" href="#">Венеролог</a>
                            <a class="interesting__ist-item" href="#">Гастроэнтеролог</a>
                        </div>
                    </div>
                    <div class="interesting__item">
                        <h3 class="middle__h3">Статьи</h3>
                        <div class="articles-list">
                            <div class="articles-list__item">
                                <div class="articles-list__item-date">28.10.2020</div>
                                <a class="articles-list__item-text" href="#">Когда нужен самый точный и быстрый анализ
                                    на причину потери беременности?</a>
                            </div>
                            <div class="articles-list__item">
                                <div class="articles-list__item-date">28.10.2020</div>
                                <a class="articles-list__item-text" href="#">Какие генетические причины приводят к
                                    замершим беременностям и самопроизвольным выкидышам?</a>
                            </div>
                            <div class="articles-list__item">
                                <div class="articles-list__item-date">28.10.2020</div>
                                <a class="articles-list__item-text" href="#">Как диагностировать генетический дефект в
                                    случае регресса беременности?</a>
                            </div>
                        </div>
                    </div>
                </div>
   </div>
    </div>
    <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
