<?php

class TestController extends BaseController {

    public function testGoogleCse() {
        header('Content-Type: text/html; charset=utf-8');
        print "<PRE>";

        $results = (GoogleCse::search('PSD', array('searchType' => 'image', 'imgSize' => 'small', 'cr' => 'pt', 'num' => 3)) );

        $images = array_map(function($result) {
            return $result['link'];
        }, $results);

        array_walk($images, function($image_url) {
            echo "<IMG src='$image_url'/><br/>";
        });
    }

    public function showTest($url) {
        print "<PRE>";
        $apiCaller = new ApiCaller();
        echo "<IMG src='" . $apiCaller->extractMainImage(urldecode($url)) . "'/>";
    }

    public function oldShowTest() {

        $qb = new \Casinelli\Wikipedia\QueryBuilder;

        $qb->setFormat("php");
        $qb->setTitles("LIVRE_(partido_político)");
        $qb->setExtractsSentences(100);
        $qb->setExtractsPlainText(false);

        $response = unserialize($qb->fetch());
        $page = reset($response["query"]["pages"]);

        if (isset($page['extract'])) {

            return $page["extract"];
        } else
            var_dump($response);
    }
    
    function testGrabber() {
        $grabber = new NewsSourceTagsGrabber();
        $url = 'http://www.cmjornal.xl.pt/nacional/politica/detalhe/ferro_rodrigues_afasta_acordo_com_psdcds.html';
        $tags = $grabber->grab_tags($url);
	print "<PRE>";
        var_dump($tags);
        dd();
    }

}
