<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class Catalog extends CBitrixComponent
{
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
        CModule::IncludeModule("iblock");
        $this->setFrameMode(false);

		$defaultUrlTemplates404 = array(
			"sections" => "#SECTION_CODE_PATH#",
			"section" => "#SECTION_CODE_PATH#/#SECTION_CODE#",
			"detail" => "#SECTION_CODE_PATH#/#SECTION_CODE#/#CODE#",
		);

        $engine = new CComponentEngine($this);
        if (\Bitrix\Main\Loader::includeModule('iblock'))
        {
            $engine->addGreedyPart("#SECTION_CODE_PATH#");
            $engine->addGreedyPart("#SMART_FILTER_PATH#");
            $engine->setResolveCallback(array("CIBlockFindTools", "resolveComponentEngine"));
        }

		$componentVariables = array("SECTION_CODE_PATH","SECTION_CODE", "CODE", "PAR_SECTION_CODE", "FOLDER_CODE", "NOTE_CODE", "COLLECTION_CODE");
		$variables = array();

		$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();

		if ($this->arParams["SEF_MODE"] == "Y")
		{
			$templatesUrls = CComponentEngine::makeComponentUrlTemplates($defaultUrlTemplates404, $this->arParams["SEF_URL_TEMPLATES"]);
			/*
			foreach ($templatesUrls as $url => $value)
			{
				$this->arResult["PATH_TO_".ToUpper($url)] = $this->arParams["SEF_FOLDER"].$value;
			}*/

			$variableAliases = CComponentEngine::makeComponentVariableAliases(array(), $this->arParams["VARIABLE_ALIASES"]);

			$componentPage = $engine->guessComponentPath(
                $this->arParams["SEF_FOLDER"],
                $templatesUrls,
                $variables
            );

			//print_r($variables);
			//echo $componentPage;
//pre($variables);
//die();
			CComponentEngine::initComponentVariables($componentPage, $componentVariables, $variableAliases, $variables);
			/*
            if ($componentPage == "folder") {
                $variables["SECTION_CODE"] = $variables["PAR_SECTION_CODE"];
                $this->arResult["FILTER"]["FOLDER"] = $variables["FOLDER_CODE"];
                $componentPage = "section";
                $dbFolder = CIblockElement::GetList([],["IBLOCK_ID" => 5, "CODE" => $variables["FOLDER_CODE"]], false, false, ["ID", "NAME", "PROPERTY_PHOTO"]);
                if ($arFolder = $dbFolder->GetNext()) {
                    $this->arResult["FOLDER"] = $arFolder;
                } else {
                    $this->status404();
                }
            }

            if ($variables["SECTION_CODE"]) {
                $dbSection = CIblockSection::GetList([],["IBLOCK_ID" => 1, "CODE" => $variables["SECTION_CODE"]],false, ["ID", "NAME", "DEPTH_LEVEL", "DESCRIPTION", "CODE", "PICTURE", "UF_SHORTNAME", "UF_DETAIL_NAME"]);
                if ($arSection = $dbSection->GetNext()) {
                    $this->arResult["SECTION"] = $arSection;
                } else {
                    $this->status404();
                }
            } else {
                $this->status404();
            }

            if ($componentPage == "30ml") {
                $APPLICATION->SetTitle("Коллекция 30мл");
            }


            if ($componentPage == "note") {
                $this->arResult["FILTER"]["NOTE"] = $variables["NOTE_CODE"];
                $componentPage = "section";
            }

            if ($componentPage == "collection") {
                $this->arResult["FILTER"]["COLLECTION"] = $variables["COLLECTION_CODE"];
                $componentPage = "section";
            }

            if ($componentPage == "section") {
                if ($variables["SECTION_CODE"]=="perfume")
                    $componentPage = "perfume";
            }

			$this->arResult = array_merge(
				Array(
					"SEF_FOLDER" => $this->arParams["SEF_FOLDER"],
					"URL_TEMPLATES" => $templatesUrls,
					"VARIABLES" => $variables,
					"ALIASES" => $variableAliases,
				),
				$this->$variables
);*/
		}
		//print_r($this->arParams);
		//echo $componentPage;
		$this->arResult = $variables;
		$url = explode('/', $_SERVER['REQUEST_URI']);
		$this->arResult["CODE"] = $url[count($url)-2];
        $this->includeComponentTemplate($componentPage);
		
    }
}

?>