<?php
	ini_set('display_errors', 1);
	error_reporting(E_ERROR);

	class CreateIndex extends SiteMap
	{
		private $urls = array();

		public function setUrl($params)
		{
			if ($params) {
				foreach ($params as $key => $value) {
					$this->urls[$key] = $value;
				}
			}
		}

		public function writeIndex($path)
		{
			$document = $this->createXML('sitemapindex');
			$xml = $document['xml'];
			$index = $document['index'];
			foreach ($this->urls as $code => $url) {
				$sitemap = $this->createElement($xml, $index, 'sitemap');
				$this->createNodes($sitemap, $xml, $url);
			}
			$xml->save($_SERVER['DOCUMENT_ROOT'] . $path);
		}
	}