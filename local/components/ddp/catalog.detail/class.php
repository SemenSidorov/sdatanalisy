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
	
		$folder = $folders->GetNext();

		$props = CIBlockElement::GetProperty($folder["IBLOCK_ID"], $folder["ID"], array(), array());
		$arProps = [];
		while($prop = $props->GetNext()){
			$arProps[$prop["CODE"]] = $prop;
		}
		$folder["PROPERTIES"] = $arProps;
		if(!empty($folder["DETAIL_PICTURE"])){
			$img = CFile::GetByID($folder["DETAIL_PICTURE"]);
			$img = $img->GetNext();
			$img["src"] = "/upload/".$img["SUBDIR"]."/".$img["FILE_NAME"];
			$folder["DETAIL_PICTURE"] = $img;
		}
		if(!empty($folder["PREVIEW_PICTURE"])){
			$img = CFile::GetByID($folder["PREVIEW_PICTURE"]);
			$img = $img->GetNext();
			$img["src"] = "/upload/".$img["SUBDIR"]."/".$img["FILE_NAME"];
			$folder["PREVIEW_PICTURE"] = $img;
		}
		$result["ITEM"] = $folder;

        return $result;
    }

    private function addBreadcrumsItem()
    {
        $section = CIBlockSection::GetList(array(), array('IBLOCK_ID' => $this->arParams["IBLOCK_ID"], 'CODE' => $this->arParams["SECTION_CODE"]), false, array(), false);
        $section = $section->GetNext();
        global $APPLICATION;
        if ($section["ID"]) {
            $res = CIBlockSection::GetNavChain(false, $section["ID"]);
            while ($row = $res->GetNext()) {
                $APPLICATION->AddChainItem($row['NAME'], $row['SECTION_PAGE_URL']);
            }

        }
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

        $this->arResult = $this->getList(array('IBLOCK_ID' => $this->arParams["IBLOCK_ID"], 'SECTION_CODE' => $this->arParams["SECTION_CODE"], 'CODE' => $this->arParams["ELEMENT_CODE"]));

        $this->addBreadcrumsItem();

		$this->includeComponentTemplate();	
	}    
}