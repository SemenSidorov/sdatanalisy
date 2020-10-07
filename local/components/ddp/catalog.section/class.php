<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Iblock\Component\ElementList;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Error;
use \Bitrix\Catalog;

if (!\Bitrix\Main\Loader::includeModule('iblock')) {
    ShowError(Loc::getMessage('IBLOCK_MODULE_NOT_INSTALLED'));
    return;
}
Loc::loadMessages(__FILE__);


class CatalogSectionComponent extends ElementList
{
    protected $sortOptions = [];
    protected $sortDefault = "name";
    protected $arSkip = [];

    /**
     * @param $arOrder
     * @param $arFilter
     * @return array
     */
    private function getList($arFilter)
    {

        $result = [];

		$folders = CIBlockElement::GetList(array(), $arFilter, false, false, array());
	
		while($folder = $folders->GetNext()){

			$props = CIBlockElement::GetProperty($folder["IBLOCK_ID"], $folder["ID"], array(), array());
			$arProps = [];
			while($prop = $props->GetNext()){
				if($prop["MULTIPLE"] == "Y")
					$arProps[$prop["CODE"]][] = $prop;
				else
					$arProps[$prop["CODE"]] = $prop;
			}
			$folder["PROPERTIES"] = $arProps;
            $result["ITEMS"][$folder["ID"]] = $folder;
            
        }

        return $result;
    }
    
    private function getClinic($arFilter)
    {

        $result = [];

        if(isset($_GET["CLINIC"]) && !empty($_GET["CLINIC"])){
            $folder = CIBlockElement::GetById($_GET["CLINIC"]);
            $folder = $folder->GetNext();
			$props = CIBlockElement::GetProperty($folder["IBLOCK_ID"], $folder["ID"], array(), array());
			$arProps = [];
			while($prop = $props->GetNext()){
				if($prop["MULTIPLE"] == "Y")
					$arProps[$prop["LINK_IBLOCK_ID"]][] = $prop;
				else
					$arProps[$prop["LINK_IBLOCK_ID"]] = $prop;
			}
			$folder["PROPERTIES"] = $arProps;
            $result["ITEMS"][$folder["ID"]] = $folder;
        }else{

            $city = Regions::getCurRegion();

            $folders = CIBlockElement::GetList(array(), array("PROPERTY_CITY" => $city), false, false, array());
        
            while($folder = $folders->GetNext()){

                $props = CIBlockElement::GetProperty($folder["IBLOCK_ID"], $folder["ID"], array(), array());
                $arProps = [];
                while($prop = $props->GetNext()){
                    if($prop["MULTIPLE"] == "Y")
                        $arProps[$prop["LINK_IBLOCK_ID"]][] = $prop;
                    else
                        $arProps[$prop["LINK_IBLOCK_ID"]] = $prop;
                }
                $folder["PROPERTIES"] = $arProps;
                $result["ITEMS"][$folder["ID"]] = $folder;
                
            }
        }

        ?><?

        return $result;
    }

    public function getAction()
    {
        return $this->action;
    }

    private function status404()
    {
        Bitrix\Iblock\Component\Tools::process404(
            '',
            true,
            true,
            true,
            false
        );
        die();
    }

    public function executeComponent()
    {
        global $APPLICATION;

        //echo $this->arParams;
        
        if(isset($_GET["CLINIC"]) && !empty($_GET["CLINIC"])){
            $clinic = $this->getClinic(array('FILTER' => $this->arParams));
            $ids = [];
            foreach($clinic["ITEMS"] as $items){
                foreach($items["PROPERTIES"][$this->arParams["IBLOCK_ID"]] as $item){
                    $ids[] = $item["VALUE"];
                }
            }
            if(isset($this->arParams["SECTION_CODE"])){
                $this->arResult = $this->getList(array('IBLOCK_ID' => $this->arParams["IBLOCK_ID"], 'SECTION_CODE' => $this->arParams["SECTION_CODE"], 'ID' => $ids));
                $title = CIBlockSection::GetList(array(), array("CODE" => $this->arParams["SECTION_CODE"]), false, array(), false);
                $title = $title->GetNext();
                $this->arResult["title"] = $title["NAME"];
                $this->arResult["link"] = "/doctors/".$this->arParams["SECTION_CODE"]."/";
            }else{
                $this->arResult = $this->getList(array('IBLOCK_ID' => $this->arParams["IBLOCK_ID"], 'ID' => $ids));
                $this->arResult["title"] = "Врачи";
                $this->arResult["link"] = "/doctors/";
            }
        }elseif(isset($this->arParams["SECTION_CODE"])){
        	$this->arResult = $this->getList(array('IBLOCK_ID' => $this->arParams["IBLOCK_ID"], 'SECTION_CODE' => $this->arParams["SECTION_CODE"], 'ID' => $this->arParams["ELEMENTS_ID"]));
            $title = CIBlockSection::GetList(array(), array("CODE" => $this->arParams["SECTION_CODE"]), false, array(), false);
            $title = $title->GetNext();
            $this->arResult["title"] = $title["NAME"];
            $this->arResult["link"] = "/doctors/".$this->arParams["SECTION_CODE"]."/";
        }else{
            $this->arResult = $this->getList(array('IBLOCK_ID' => $this->arParams["IBLOCK_ID"], 'ID' => $this->arParams["ELEMENTS_ID"]));
            $this->arResult["title"] = "Врачи";
            $this->arResult["link"] = "/doctors/";
        }

		$this->includeComponentTemplate();	
	}    
}