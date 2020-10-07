<?
function ServicesEventAgentFunction()      
{
	
	CModule::IncludeModule("iblock");
	
	$ar_serv = array();
    $ob_service = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>9), false, array(), false);
	while($service = $ob_service->Fetch())
    {	
		$ar_serv[] = $service;
	}

	foreach($ar_serv as $item)
	{
		//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/lib/ar_props.txt", print_r($item["NAME"], true), FILE_APPEND);
		$an_event = CIBlockElement::GetProperty($item["IBLOCK_ID"], $item["ID"], array(), array("CODE" => "EVENT"));
		$an_event = $an_event->GetNext();
		$an_data_begin = CIBlockElement::GetProperty($item["IBLOCK_ID"], $item["ID"], array(), array("CODE" => "DATE_EVENT_BEGIN"));
		$an_data_begin = $an_data_begin->GetNext();
		$an_data_after = CIBlockElement::GetProperty($item["IBLOCK_ID"], $item["ID"], array(), array("CODE" => "DATE_EVENT_AFTER"));
		$an_data_after = $an_data_after->GetNext();
		$date = date("d.m.Y H:i:s");
		if($an_event["VALUE"]==5) // ���� ������� �����
		{
			if($an_data_begin["VALUE"]<$date && $an_data_after["VALUE"]<$date) // ���� ������� ���� ������ ��� �����, �� ������� �����
			{
				 CIBlockElement::SetPropertyValues($item["ID"], $item["IBLOCK_ID"], 0, 'EVENT');
			}
			elseif($an_data_begin["VALUE"]>$date && $an_data_after["VALUE"]>$date) // ���� ������� ���� ������ ��� �����, �� ������� �����
			{
				 CIBlockElement::SetPropertyValues($item["ID"], $item["IBLOCK_ID"], 0, 'EVENT');	
			}
		elseif(empty($an_data_begin["VALUE"]) && empty($an_data_after["VALUE"])) // ���� ���� �� �������, �� ������ �� ������
			{
				 
			}
		}
		else{
			if($an_data_begin["VALUE"]<$date && $an_data_after["VALUE"]>$date) // ������ �����, ���� ����� �������		 
			{
				 $PROPERTY_CODE = "EVENT";
				 $value = 5;
				CIBlockElement::SetPropertyValuesEx($item["ID"], $item["IBLOCK_ID"], array($PROPERTY_CODE => $value));
			}
			if($an_data_begin["VALUE"]<$date && empty($an_data_after["VALUE"])) // ������ �����, ���� �� ������� ��������� ����� 		 
			{
				 $PROPERTY_CODE = "EVENT";
				 $value = 5;
				CIBlockElement::SetPropertyValuesEx($item["ID"], $item["IBLOCK_ID"], array($PROPERTY_CODE => $value));
			}
		}
	}
   return "ServicesEventAgentFunction();";
}
?>