<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//$APPLICATION->SetPageProperty("description", "");
$APPLICATION->SetTitle("Врачи");

?><div class="doctors">
	 <?$APPLICATION->IncludeComponent(
	"ddp:catalog",
	"",
	Array(
		"IBLOCK_ID" => 4,
		"SEF_FOLDER" => "/doctors/",
		"SEF_MODE" => "Y",
		"TEMPLATE_CODE" => "doctors"
	),
false,
Array(
	'HIDE_ICONS' => 'Y'
)
);?>
</div>
 &nbsp;<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>