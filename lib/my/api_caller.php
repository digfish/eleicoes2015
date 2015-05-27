<?php

class ApiCaller {

    var $alchemy;

    public function __construct() {
        chdir(__DIR__ . '/../../public');
        $this->alchemy = new AlchemyAPI();
    }

    public function fetchTagsApi($url) {
        $tags = array();
        //$responseEntities = $this->alchemy->entities('url', $url, array('outputMode' => 'json'));
        $responseKeywords = $this->alchemy->keywords('url', $url, array('outputMode' => 'json'));

        $tagsEntities = array();
        /* if (!empty($responseEntities['entities'])) {
          $tagsEntities = array_map(function($entity) {
          return $entity['text'];
          }, $responseEntities['entities']);
          }

          echo "ENTITIES:";
          var_dump($tagsEntities);
         */
        $tagsKeywords = array();
        if (!empty($responseKeywords['keywords'])) {
            $tagsKeywords = array_map(function($keyword) {
                return $keyword['text'];
            }, $responseKeywords['keywords']);
        }

        //echo "KEYWORDS:";
        //var_dump($tagsKeywords);


        $tags = array_unique(array_merge($tagsEntities, $tagsKeywords));

        //dd($tags);

        return $tags;
    }

    function extractMainImage($url) {
        $response = $this->alchemy->imageExtraction('url', $url, array('extractMode' => 'always-infer'));
        
        return $response['image'];
    }

    /*   function extractMainImage($url) {
      $embedly = new Embedly\Embedly(array('key' => '4188360020833723','user_agent' => 'Mozilla/5.0 (compatible; mytestapp/1.0)'));
      $response = $embedly->extract($url);
      dd($response);
      if ( count($response->images) > 0 ) {
      return $reponse->images[0]->url;
      } else {
      return NULL;
      }
      }
     */

    function extractText($url) {
        $response = $this->alchemy->text('url', $url, NULL);
        return $response['text'];
    }
    
    function getTitle($url) {
        
        $response = $this->alchemy->title('url',$url,array('useMetadata' => FALSE));
        
        return $response['title'];
    }
    

    function getLanguage($url) {
        $response = $this->alchemy->language('url', $url, NULL);
        return $response['language'];
    }

}
