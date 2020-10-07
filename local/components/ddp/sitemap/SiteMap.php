<?php
	ini_set('display_errors', 1);
	error_reporting(E_ERROR);
	class SiteMap
	{
		protected $indexAttributes = array(
			'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
			'xsi:schemaLocation' => 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd',
			'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
		);

		protected $siteMapAttributes = array(
			'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
			'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
			'xsi:schemaLocation' => 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd',
		);

		protected function createXML($documentName)
		{
			$xml = new DOMDocument();
			$xml->encoding = 'utf-8';
			$index = $xml->createElement($documentName);
			foreach ($this->indexAttributes as $key => $attribute) {
				$index->setAttribute($key, $attribute);
			}
			$xml->appendChild($index);
			return array(
				'xml' => $xml,
				'index' => $index
			);
		}

		protected function createElement($xml, $index, $elementName)
		{
			return $index->appendChild($xml->createElement($elementName));
		}


		protected function createNodes($rootElement, $xml, $url)
		{
			foreach ($url as $key => $value) {
				$rootElement->appendChild($xml->createElement($key, $value));
			}
		}
	}