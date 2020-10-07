<?php
/*
include_once(__DIR__.'/elementwithdescription.php');
// Добавим обработчик события и добавим наш пользовательский класс
AddEventHandler("iblock", "OnIBlockPropertyBuildList", array("CIBlockPropertyElementListPlus", "GetUserTypeDescription"));


AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("CIBLockHandlerUpdate", "OnBeforeIBlockElementUpdateHandler"));

class CIBLockHandlerUpdate
{


	function OnBeforeIBlockElementUpdateHandler($arFields)
	{
		
		
		
			//include($_SERVER["DOCUMENT_ROOT"]."/test_site/include/multiexplode.php");
		$ar_props = array();
		$obe = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID'], array('sort' => 'asc'), array('NAME'=>'Цена'));
		while($value = $obe->Fetch())
		{
			//file_put_contents($_SERVER["DOCUMENT_ROOT"]."tip_poverkhnosti.txt", print_r($value, true), FILE_APPEND);
	        
	          $ar_props[]=$value; //свойства с именем битрикс
		}
		    
		
	           foreach($ar_props as $item)
			   {	  
		            //$composition = multiexplode(array('&', ',', '|', '.', ' ', ';', ':', '/'), $arFields["PROPERTY_VALUES"][$ar_props["ID"]][$ar_props["PROPERTY_VALUE_ID"]]["VALUE"]);
					//  CIBlockElement::SetPropertyValuesEx($arFields["ID"], $arFields["IBLOCK_ID"], array("composition" => array('del'=>'Y')));
		            //$count= count($composition);
	                $property = CIBlockProperty::GetByID("COST", $arFields["IBLOCK_ID"])->Fetch();
                    //file_put_contents($_SERVER["DOCUMENT_ROOT"]."db_props.txt", print_r($db_props], true), FILE_APPEND);
					file_put_contents($_SERVER["DOCUMENT_ROOT"]."property.txt", print_r($property, true), FILE_APPEND);
					 $ar_enum_list = CIBlockProperty::GetPropertyEnum("COST", array("SORT" => "asc"), array("IBLOCK_ID" => $arFields["IBLOCK_ID"]))->Fetch();
	            file_put_contents($_SERVER["DOCUMENT_ROOT"]."ar_enum.txt", print_r($items["VALUE"], true), FILE_APPEND);
            }
			//
 
	}
	
	
}*/

  /*                     Анализы        */
class CIBlockPropertyElementListAnalyzes
{
   function GetUserTypeDescription()
   {
      return array(
         "PROPERTY_TYPE"      => "E",
         "USER_TYPE"         => "EListAnalyzes",
         "DESCRIPTION"      => "Привязка к элементам в виде списка (цена анализа)",
         "GetPropertyFieldHtml"   => array("CIBlockPropertyElementListAnalyzes","GetPropertyFieldHtml"),
		 "ConvertToDB" => array("CIBlockPropertyElementListAnalyzes", "ConvertToDB"),
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
            "IBLOCK_ID"=> $arProperty["LINK_IBLOCK_ID"],
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
      $html = '<select name="'.$strHTMLControlName["VALUE"].'"">
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
      $analyz = CIBlockElement::GetProperty(2, $value["VALUE"], array('sort' => 'asc'), array('CODE'=>'ANALYZES_COST', 'PROPERTY_TYPE'=>'S'));
	  $value_cost_analyz = $analyz->Fetch();
	  $property = CIBlockProperty::GetByID("COST_ANALYZES", 5)->Fetch();
	  $arAdd = Array(
   "NAME" => "Цена анализа",
   "ACTIVE" => "Y",
   "SORT" => $value_cost_analyz["SORT"],
   "CODE" => "COST_ANALYZES",
   "PROPERTY_TYPE" => "S",
   "IBLOCK_ID" => 5,
   "MULTIPLE" => "Y",
   //"VALUE"    => $value_cost_analyz["VALUE"],
);
$arValues = array(
  0 => array("VALUE"=>$value_cost_analyz["VALUE"], "DESCRIPTION"=>"описание значения") 
);  

       if(!$property)
				{	
                 $ibp = new CIBlockProperty;
                 $property = $ibp->Add($arAdd);
				 
			    }
				CIBlockElement::SetPropertyValueCode(10, "COST_ANALYZES", $arValues);
	  //$uslugi = CIBlockElement::GetProperty(3, $value["VALUE"], array('sort' => 'asc'), array('CODE'=>'USLUGI_COST', 'PROPERTY_TYPE'=>'S'));
	  //$value_cost_uslugi = $uslugi->Fetch();
	  $html .= ' <span id="sp_'.md5($strHTMLControlName["VALUE"]).'_'.$key.'"></span>';
	  $html .= ' <span id="sp_'.md5($strHTMLControlName["VALUE"]).'_'.$key.'">Цена:</span>';
	  $html .= '<input type="text" id="DESCR_'.$varName.'" name="'.$varName.'" value="'.$value_cost_analyz["VALUE"].'" />';
	  $html .= ' <span id="sp_'.md5($strHTMLControlName["VALUE"]).'_'.$key.'">руб.</span>';
	  $html .= ' <span id="sp_'.md5($strHTMLControlName["VALUE"]).'_'.$key.'"></span>';
	  
      return  $html;
   }
   function ConvertToDB($arProperty, $value){
	/*  $value["VALUE"] = intval($value["VALUE"]);
		if($value["VALUE"] <= 0)
			$value["VALUE"] = "";*/
		return $value;
   }
}
/*                     Услуги                                    */
class CIBlockPropertyElementListUslugi
{
   function GetUserTypeDescription()
   {
      return array(
         "PROPERTY_TYPE"      => "E",
         "USER_TYPE"         => "EListUslugi",
         "DESCRIPTION"      => "Привязка к элементам в виде списка (цена услуги)",
         "GetPropertyFieldHtml"   => array("CIBlockPropertyElementListUslugi","GetPropertyFieldHtml"),
		 "ConvertToDB" => array("CIBlockPropertyElementListUslugi", "ConvertToDB"),
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
            "IBLOCK_ID"=> $arProperty["LINK_IBLOCK_ID"],
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
      $html = '<select name="'.$strHTMLControlName["VALUE"].'"">
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
      //$analyz = CIBlockElement::GetProperty(2, $value["VALUE"], array('sort' => 'asc'), array('CODE'=>'ANALYZES_COST', 'PROPERTY_TYPE'=>'S'));
	 // $value_cost_analyz = $analyz->Fetch();
	  $uslugi = CIBlockElement::GetProperty(3, $value["VALUE"], array('sort' => 'asc'), array('CODE'=>'USLUGI_COST', 'PROPERTY_TYPE'=>'S'));
	  $value_cost_uslugi = $uslugi->Fetch();
	  $html .= ' <span id="sp_'.md5($strHTMLControlName["VALUE"]).'_'.$key.'"></span>';
	  $html .= ' <span id="sp_'.md5($strHTMLControlName["VALUE"]).'_'.$key.'">Цена:</span>';
	  $html .= '<input type="text" id="DESCR_'.$varName.'" name="'.$varName.'" value="'.$value_cost_uslugi["VALUE"].'" />';
	  $html .= ' <span id="sp_'.md5($strHTMLControlName["VALUE"]).'_'.$key.'">руб.</span>';
	  $html .= ' <span id="sp_'.md5($strHTMLControlName["VALUE"]).'_'.$key.'"></span>';
	  
      return  $html;
   }
   function ConvertToDB($arProperty, $value){
	/*  $value["VALUE"] = intval($value["VALUE"]);
		if($value["VALUE"] <= 0)
			$value["VALUE"] = "";*/
		return $value;
   }
}

AddEventHandler("iblock", "OnIBlockPropertyBuildList", array("CIBlockPropertyElementListUslugi", "GetUserTypeDescription"));
AddEventHandler("iblock", "OnIBlockPropertyBuildList", array("CIBlockPropertyElementListAnalyzes", "GetUserTypeDescription"));

?>