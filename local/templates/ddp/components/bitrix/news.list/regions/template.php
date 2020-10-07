<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<select class="js-region" name="" id="">
<?
$i = 0;
foreach($arResult["ITEMS"] as $item){?>
    <option value="<?=$i?>"><?=$item["NAME"]?></option>
<?
}
?>
</select>

