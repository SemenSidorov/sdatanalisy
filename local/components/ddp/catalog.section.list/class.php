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

		$folders = CIBlockSection::GetList(array(), array('IBLOCK_ID' => $arFilter), false, array(), false);
	
		while($folder = $folders->GetNext()){

            $result["SECTIONS"][] = $folder;
            
        }

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
        $this->arResult = $this->getList($this->arParams["IBLOCK_ID"]);

		$this->includeComponentTemplate();	
	}    
}