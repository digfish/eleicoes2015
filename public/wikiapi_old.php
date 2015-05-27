<?php 

require "../vendor/autoload.php";
require "wikirenderer-3.1.6/WikiRenderer.lib.php";

use Mediawiki\Api\MediawikiApi;
use Mediawiki\Api\SimpleRequest;

use XPathSelector\Selector;

use Chrispecoraro\WikipediaTools\Infobox;


	
	function getFirstPageResult($what_to_search_for) {
		$api = new MediawikiApi( 'http://pt.wikipedia.org/w/api.php' );

		$queryResponse = @$api->getRequest( 
			new SimpleRequest( 'query', 
			array( 
				'list' => 'search', 
				'srwhat' => 'text',
				'srsearch' => $what_to_search_for ,
				'continue' => ''
				) ) );

		/// retrieve title from the first query result

		$first = $queryResponse['query']['search'][0];
		$title = $first['title'];
		$lastModDate = $first['timestamp'];

		return array('term' => $title, 'modifiedAt' => $lastModDate);
	}

	function scrapeInfoboxFromWikiArticle($term,$xpath_expr) {
		$base_url = "http://pt.wikipedia.org/wiki/$term";
		//echo "URL is $base_url";
		$htmlContent = $base_url;
		$xs = Selector::loadHTMLFile($base_url);

		$content = $xs->find($xpath_expr);

		return $content;
	}

	function getFromInfoBox($InfoboxHtml,$elem) {
		$xs = Selector::loadHTML($infoboxHtml);
		$xs->find('/@title');
	}

	function wikiPediaArticleJson($term) {
		//$url_call = "http://pt.wikipedia.org/w/api.php?action=query&prop=revisions&rvprop=content&format=json&titles=$term&rvsection=0&redirect=1";
		$url_call = "http://pt.wikipedia.org/w/api.php?action=query&prop=revisions&rvprop=content&format=json&titles=$term&rvsection=0&redirects";
		$json_response = file_get_contents($url_call);
		return $json_response;
	}

	



