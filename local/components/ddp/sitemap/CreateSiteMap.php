<?php
	ini_set('display_errors', 1);
	error_reporting(E_ERROR);
	class CreateSiteMap extends SiteMap
	{
		private $urls = array();

		public function setUrl($params)
		{
			$this->urls[] = $params;
		}

		public function write($name, $path)
		{
			$sitemapName = str_replace('/', '', $name);
			$sitemapPath = str_replace('/', '', $path);
			$document = $this->createXML('urlset');
			$xml = $document['xml'];
			$index = $document['index'];
			foreach ($this->urls as $urlItem) {
				$url = $this->createElement($xml, $index, 'url');
				$this->createNodes($url, $xml, $urlItem);
			}
			$xml->save($_SERVER['DOCUMENT_ROOT'] . '/' . $sitemapPath . '.' . $sitemapName);
		}
	}