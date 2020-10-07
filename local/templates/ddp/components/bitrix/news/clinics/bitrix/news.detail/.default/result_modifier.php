<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
	if(isset($arResult["DETAIL_PICTURE"]["SRC"]) && !empty($arResult["DETAIL_PICTURE"]["SRC"])){
		$img = $arResult["DETAIL_PICTURE"]["SRC"];
	}elseif(isset($arResult["PREVIEW_PICTURE"]["SRC"]) && !empty($arResult["PREVIEW_PICTURE"]["SRC"])){
		$img = $arResult["PREVIEW_PICTURE"]["SRC"];
    }
    
    $arResult['OGImage'] = $img;
    
    $cp = $this->__component; // объект компонента
    
    if (is_object($cp))
    {
       // добавим в arResult компонента поля
       $cp->SetResultCacheKeys(array('OGImage'));
    }
?>