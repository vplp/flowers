<?php
	$dom = new DOMDocument('1.0', 'utf-8');
	$dom->formatOutput = true;
	$dom->preserveWhiteSpace = false;
	$urlset = $dom->createElement('urlset');
	$urlset->setAttribute('xmlns','http://www.sitemaps.org/schemas/sitemap/0.9');
	
	foreach($ARR_pages as $row) {
		$date = date(DATE_ATOM, time());
		$url = $dom->createElement('url');
		$row_uri = $row['uri'] != '/' ? $row['uri'] : '';
		$loc = $dom->createElement('loc');
		$text = $dom->createTextNode(
			htmlentities('https://flowersvillage.ru' . '/' . $row_uri, ENT_QUOTES)
		);
		$loc->appendChild($text);
		$url->appendChild($loc);
		$lastmod = $dom->createElement('lastmod');
		$text = $dom->createTextNode($date);
		$lastmod->appendChild($text);
		$url->appendChild($lastmod);
		$priority = $dom->createElement('priority');
		$text = $dom->createTextNode('1.0');
		$priority->appendChild($text);
		$url->appendChild($priority);
		$urlset->appendChild($url);
	}
	
	foreach($ARR_categories as $row) {
		$date = date(DATE_ATOM, time());
		$url = $dom->createElement('url');
		$loc = $dom->createElement('loc');
		$text = $dom->createTextNode(
			htmlentities('https://flowersvillage.ru/catalog/' . $row['uri'], ENT_QUOTES)
		);
		$loc->appendChild($text);
		$url->appendChild($loc);
		
		$lastmod = $dom->createElement('lastmod');
		$text = $dom->createTextNode($date);
		$lastmod->appendChild($text);
		$url->appendChild($lastmod);
		
		$priority = $dom->createElement('priority');
		$text = $dom->createTextNode('0.8');
		$priority->appendChild($text);
		$url->appendChild($priority);
		
		$urlset->appendChild($url);
	}
	
	foreach($ARR_products as $row) {
		$date = date(DATE_ATOM, time());
		$url = $dom->createElement('url');
		$loc = $dom->createElement('loc');
		$text = $dom->createTextNode(
			htmlentities('https://flowersvillage.ru/catalog/' . $row['id'], ENT_QUOTES)
		);
		$loc->appendChild($text);
		$url->appendChild($loc);
		
		$lastmod = $dom->createElement('lastmod');
		$text = $dom->createTextNode($date);
		$lastmod->appendChild($text);
		$url->appendChild($lastmod);
		
		$priority = $dom->createElement('priority');
		$text = $dom->createTextNode('0.8');
		$priority->appendChild($text);
		$url->appendChild($priority);
		
		$urlset->appendChild($url);
	}
	
	$dom->appendChild($urlset);
	$dom->save(__DIR__ . '/../../../sitemap.xml');