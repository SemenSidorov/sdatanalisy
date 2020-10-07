<?php
/* AddEventHandler("iblock", "OnIBlockPropertyBuildList", array("CIBlockPropertyElementListPlus", "GetUserTypeDescription"));
class CIBlockPropertyElementListPlus
{
   function GetUserTypeDescription()
   {
      return array(
         "PROPERTY_TYPE"      => "S",
         "USER_TYPE"         => "EListPlus",
         "DESCRIPTION"      => "Привязка к элементам в виде списка (цена)",
         "GetPropertyFieldHtml"   =>array("CIBlockPropertyElementListPlus","GetPropertyFieldHtml"),
		 // функция, производящая какие-либо операции над значением перед записью в БД
"ConvertToDB"    =>array(__CLASS__, "ConvertToDB"),
// функция, производящая какие-либо операции над значением после получения из БД перед выводом
"ConvertFromDB"  =>array(__CLASS__, "ConvertFromDB"),
      );
   }

   function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
   {
      static $cache = array();
      $IBLOCK_ID = $arProperty["LINK_IBLOCK_ID"];
      if (!array_key_exists($IBLOCK_ID, $cache))
      {
         $arSelect = array(
            "ID",
            "NAME",
         );
         $arFilter = array (
            "IBLOCK_ID"=> 2,
            "ACTIVE" => "Y",
           "CHECK_PERMISSIONS" => "Y",
         );
         $arOrder = array(
            "NAME" => "ASC",
            "ID" => "ASC",
         );
         $cache[$IBLOCK_ID] = array();
         $rsItems = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
         while($arItem = $rsItems->GetNext())
            $cache[$IBLOCK_ID][] = $arItem;

      }
      $varName = str_replace("VALUE", "DESCRIPTION", $strHTMLControlName["VALUE"]);
	$html =  '<input type="text" name="'.$strHTMLControlName["VALUE"].'" value="'.$value['VALUE'].'">';
	  //$html = '<input type="text" id="DESCR_'.$varName.'" name="'.$varName.'" value="'.htmlspecialcharsex($value["DESCRIPTION"]).'" />';
	  $html .= ' <span id="sp_'.md5($strHTMLControlName["VALUE"]).'_'.$key.'">'.$arItem["NAME"].'руб.</span>';
	  $html .= ' <span id="sp_'.md5($strHTMLControlName["VALUE"]).'_'.$key.'">'.$arItem["NAME"].'</span>';
      $html .= '<select name="'.$strHTMLControlName["VALUE"].'" ">
      <option value="">(не установлено)</option>';
      foreach ($cache[$IBLOCK_ID] as $arItem)
      {
         $html .= '<option value="'.$arItem["ID"].'"';
         if($value["VALUE"] == $arItem["~ID"])
            $html .= ' selected';
         $html .= '>'.$arItem["NAME"].'</option>';
      }
      $html .= '</select>';
      $html .= ' ';
     // $html .= '<input type="text" id="DESCR_'.$varName.'" name="'.$varName.'" value="'.$value["DESCRIPTION"].'" />';
      return  $html;
   }
   //сохраняем в базу
   function ConvertToDB($arProperty, $value){
	  $value["VALUE"] = intval($value["VALUE"]);
		if($value["VALUE"] <= 0)
			$value["VALUE"] = "";
		return $value;
   }
   //читаем из базы
   function ConvertFromDB($arProperty, $value){
       $value["VALUE"] = intval($value["VALUE"]);
		if($value["VALUE"] <= 0)
			$value["VALUE"] = "";
		return $value;
   }
 
   
   
}

*/




?>