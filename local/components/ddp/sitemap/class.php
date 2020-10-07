<?php

use Bitrix\Main\Loader;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED != true) die;

Loader::includeModule('iblock');

class SiteMap extends CBitrixComponent
{

	public function getResult()
	{
		$this->arResult['ITEMS'] = array();

        if ($this->arParams['NEED_ELEMENTS']) {
            $elements = $this->getElements();
            if (count($elements)) {
                $this->arResult['ITEMS'] = $this->mergeMenu($this->arResult['ITEMS'], $this->getElements());
            }
        }

        $blocks = $this->getIBLocks();
        if (count($blocks)) {
            $this->arResult['ITEMS'] = $this->mergeMenu($blocks, $this->arResult['ITEMS']);
        }

		$menus = $this->getMenus();
		if (count($menus)) {
			$this->arResult['ITEMS'] = $this->mergeMenu($menus, $this->arResult['ITEMS']);
		}

		$statics = $this->getStatic();
		if (count($statics)) {
			$this->arResult['ITEMS'] = $this->mergeMenu($statics, $this->arResult['ITEMS']);
		}
		return $this->arResult;
	}

	private function getStatic()
	{
		if (!$this->arParams['STATIC']) {
			return;
		}
		$result = array();
		foreach ($this->arParams['STATIC'] as $name => $link) {
			$result[] = array(
				'NAME' => $name,
				'LINK' => $link,
				'DEPTH' => count(explode('/', trim($link, '/'))),
			);
		}
		return $result;
	}

	private function getElements()
	{
		$result = array();
        foreach ($this->arParams['I_BLOCKS'] as $iBlockId) {
            $items = array();
            switch ($iBlockId) {
                case IB_ANALYZES_ID:
                    $items = Analyzes::getItemsToRegion();
                    break;
                case IB_SERVICES_ID:
                    $items = Services::getItemsToRegion();
                    break;
                case IB_DOCTORS_ID:
                    $items = Doctors::getDoctorsSectionToRegion();
                    break;
                case IB_CLINICS_ID:
                    $items = Clinics::getItemsToRegion();
                    break;
                default:
                    $obElements = CIBlocKElement::GetList(
                        array('SORT' => 'ASC'),
                        array('IBLOCK_ID' => $iBlockId, 'ACTIVE' => 'Y'),
                        false,
                        false,
                        array('ID', 'IBLOCK_ID', 'NAME', 'DETAIL_PAGE_URL')
                    );
                    while ($element = $obElements->GetNext()) {
                        $items[] = $element;
                    }
                    break;
            }
            foreach ($items as $item) {
                $result[] = array(
                    'NAME' => $item['NAME'],
                    'LINK' => $item['DETAIL_PAGE_URL'],
                    'DEPTH' => count(explode('/', trim($item['DETAIL_PAGE_URL'], '/'))),
                );
            }
        }
		return $result;
	}

	private function getIBLocks()
	{
		$result = array();
		foreach ($this->arParams['I_BLOCKS'] as $iBlockId) {
		    $items = array();
		    switch ($iBlockId) {
                case IB_ANALYZES_ID:
                    $items = Analyzes::getSectionsToRegion();
                    break;
                case IB_SERVICES_ID:
                    $items = Services::getSectionsToRegion();
                    break;
                case IB_DOCTORS_ID:
                    $items = Doctors::getSectionsToRegion();
                    break;
                default:
                    $obSections = CIBlockSection::GetTreeList(
                        array('IBLOCK_ID' => $iBlockId, 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y'),
                        array('ID', 'IBLOCK_ID', 'NAME', 'SECTION_PAGE_URL', 'DEPTH_LEVEL')
                    );
                    while ($section = $obSections->GetNext()) {
                        $items[] = $section;
                    }
            }
            foreach ($items as $item) {
                $result[] = array(
                    'NAME' => $item['NAME'],
                    'LINK' => $item['SECTION_PAGE_URL'],
                    'DEPTH' => count(explode('/', trim($item['SECTION_PAGE_URL'], '/'))),
                );
            }
		}
		return $result;
	}

	private function getMenus()
	{
		global $APPLICATION;
		$result = array();
		foreach ($this->arParams['MENU_TYPES'] as $type) {
			foreach ($APPLICATION->GetMenu($type)->arMenu as $menuItem) {
				$result[] = array(
					'NAME' => $menuItem[0],
					'LINK' => $menuItem[1],
					'DEPTH' => count(explode('/', trim($menuItem[1], '/'))),
				);
			}
		}
		return $result;
	}

    /**
     * Добавляет элементы в меню согласно вложенности
     * @param array $menu
     * @param array $items
     * @return array
     */
	private function mergeMenu($menu = array(), $items = array())
    {
        $return = array();
        if (!count($menu)) {
            $return = $items;
        } else {
            foreach ($menu as $m_item) {
                $return[] = $m_item;
                foreach ($items as $key => $item) {
                    if (isset($m_item['LINK']) && isset($item['LINK'])) {
                        if (strpos($item['LINK'], $m_item['LINK']) !== false) {
                            $return[] = $item;
                            unset($items[$key]);
                        }
                    }
                }
            }
            $return = array_merge($return, $items);
        }
	    return $return;
    }
}
