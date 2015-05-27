<?php

class NoticiasController extends BaseController {

    var $api;

    public function __construct() {
        $this->api = new ApiCaller();
    }

    public function index() {

        $api_url = URL::action('NoticiasRestController@index');

        $search_term = Input::get('search');
        if (!empty($search_term)) {
            $api_url .= '?' . http_build_query(array('term' => $search_term)) ;
        } else {
            
        }

        return View::make('noticias/index')
                        ->with('api_url', $api_url);

//        $noticias = Noticia::latest('data')->limit(4)->get();
//        return View::make('noticias/index')
//                        ->with('noticia_principal', $noticias[0])
//                        ->with('destaques', $noticias->slice(1, 3));
//
//        $noticias = Noticia::orderBy('data', 'desc')->paginate(15);
//        return View::make('noticias/index')->with('noticias', $noticias)
//                        ->with('erros', array());
    }

    private function resolveUrl($unresolved_url) {
        $resolver = new URLResolver();
        $resolved_url = $resolver->resolveURL($unresolved_url)->getURL();
        return $resolved_url;
    }

    private function dateTimeIntoStr($date) {
        if ($date instanceof DateTime) {
            $date = $date->format('Y-m-d H:i:s');
        }
        return $date;
    }

    public function getNoticiasFromSource($source) {
        $noticias = Noticia::where('fonte', '=', $source)
                ->orderBy('data', 'desc')
                ->paginate(15);
        return View::make('noticias')->with('noticias', $noticias)
                        ->with('erros', array());
    }

    public function addFromGoogle() {

        echo __METHOD__ . "\n";

        $url = "http://news.google.pt/news?pz=1&cf=all&ned=pt&hl=pt&output=rss&q=legislativas%202015%20portugal%20OR%20elei%C3%A7%C3%B5es%20legislativas%20OR%20psd%20OR%20ps%20OR%20pcp%20OR%20cds%20OR%20be";
        $feed = RSS::feed($url);
        $noticias = array();
        //var_dump($feed);
        $erros = array();

        foreach ($feed->articles() as $item) {
            //echo $item->pubDate;
//			dd($resolved_url);
            $corr_descricao = str_replace('<nobr>', '', $item->description);
            $corr_descricao = str_replace('</nobr>', '', $corr_descricao);

            //$resolved_url = $item->link;
            //echo "{$item->link} => $resolved_url<BR>";
            $extractedUrl = Util::parseGoogleNewsUrl($item->link);
            $return = Noticia::getByUrl($extractedUrl);
//			dd($return);
            if ($return === FALSE) {

                $noticia = new Noticia();
                $noticia->titulo = $item->title;
                $noticia->fonte = "Google News";
                $noticia->data = DateTime::createFromFormat('D, d M Y G:i:s e', $item->pubDate); //Mon, 09 Mar 2015 02:09:40 

                $noticia->final_url = $extractedUrl;
                $noticia->original_url = $item->link;
                $scrapper = new NoticiaScrapper($noticia->final_url);

                $noticia->descricao = mb_convert_encoding(qp($corr_descricao, '.lh font:nth-of-type(2)')->text(), "ISO-8859-1", "UTF-8");

                $noticia->image_url = $scrapper->grabMainImage();

                $noticia->data = $this->dateTimeIntoStr($noticia->data);

                $noticia->save();

                $this->getTags($noticia->id);



                $noticias[] = $noticia;
            } else {
                $erros[] = "{$item->title} : . Esta noticia já se encontra gravada!";
            }
        }


        echo "-- NOTICIAS--\n";
        var_dump($noticias);
        echo "-- ERROS --\n";
        var_dump($erros);
    }

    public function addFromTwitter() {

        echo __METHOD__ . "\n";

        $erros = array();
        $noticias = array();

        ini_set('max_execution_time', 300);
        $settings = array(
            'consumer_key' => "xxx",
            'consumer_secret' => "xxx",
            'oauth_access_token' => "xxx",
            'oauth_access_token_secret' => "xxx"
        );
        $twitter = new TwitterAPIExchange($settings);
        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $jsonResponse = $twitter->setGetfield("?q=legislativas")
                ->buildOauth($url, 'GET')
                ->performRequest();
        $response = json_decode($jsonResponse);
        //print_r($response);
        //echo($jsonResponse);
        $tweets_with_links = array();

        $out = '';
        //print "<PRE>";
        //dd($response);
        if (empty($response->statuses)) {
            return NULL;
        }
        foreach ($response->statuses as $tweet) {
            $url = NULL;
            
            if (!empty($tweet->entities->urls)) {
                $url = $tweet->entities->urls[0]->expanded_url;
            }
            
            if (!empty($url)) {
                $tweets_with_links[] = array(
                    'titulo' => $tweet->text,
                    //'descricao' => $tweet->text,
                    'original_url' => $url,
                    'data' => DateTime::createFromFormat('D M d G:i:s P Y', $tweet->created_at), //Fri Mar 13 23:56:23 +0000 2015
                    'fonte' => 'Twitter'
                );
            }
            //print_r($tweet->entities);
        }

        foreach ($tweets_with_links as $tweet) {
            //print_r($tweet);
	    $tweet['final_url'] = Util::resolveUrl($tweet['original_url']);
            if (Noticia::getByOriginalUrl($tweet['final_url']) === FALSE) {

                
                $language = $this->api->getLanguage($tweet['final_url']);
                if ($language != 'portuguese') {
                    //echo "Not portuguese!";
                    continue;
                }
                $scrapper = new NoticiaScrapper($tweet['final_url']);
                //$tweet['image_url'] = $this->fetchImage($tweet['final_url']);
                $tweet['image_url'] = $scrapper->grabMainImage();
                $tweet['descricao'] = $scrapper->grabTextContents();

                $noticia = Noticia::create($tweet);
                $this->getTags($noticia->id);
                $tweet['id'] = -1; // <- workaround
                $tweet['data'] = $this->dateTimeIntoStr($tweet['data']);
                $noticias[] = (object) $tweet;
            } else {
                $erros[] = "O tweet '{$tweet['titulo']}' já foi gravado!";
            }
        }
        echo " -- NOTICIAS --\n ";
        var_dump($noticias);
        echo " -- ERROS -- ";
        var_dump($erros);
    }

    function addFromEleicoes2015() {

        echo __METHOD__ . "\n";

        $url = "http://eleicoes2015.my.to/cleaner.php";
        try {
            $feed = RSS::feed($url);
        } catch (Exception $ex) {
            App::abort(403, "Some strange error happenned when trying to fetch the feed from legislativas2015.pt !");
            return;
        }

        //dd($feed);
        $noticias = array();

        $erros = array();
        foreach ($feed->articles() as $item) {

            $return = Noticia::getByUrl($item->link);
            if ($return === FALSE) {
                $noticia = new Noticia();
                $noticia->titulo = $item->title;
                $noticia->fonte = "legislativas2015.pt";
                $noticia->data = DateTime::createFromFormat('D, d M Y G:i:s e', $item->pubDate); //Mon, 09 Mar 2015 02:09:40 GMT
                $noticia->original_url = $item->link;
                $scrapper = new NoticiaScrapper($item->link);
                $noticia->final_url = $noticia->original_url;
                $noticia->descricao = $item->description;


                $noticia->image_url = $scrapper->grabMainImage();

                $noticia->save();

                $noticia->data = $this->dateTimeIntoStr($noticia->data);

                $this->getTags($noticia->id);

                $noticias[] = $noticia;
            } else {
                $erros[] = "{$item->title} : . Esta noticia já se encontra gravada!";
            }
        }

        echo "-- NOTICIAS --\n";
        var_dump($noticias);
        echo "-- ERROS --\n";
        var_dump($erros);
    }

    function searchForNoticias() {
        $search = Input::get('search');
        $noticias = Noticia::where('titulo', 'like', "%$search%")->paginate(15);

        return View::make('noticias')->with('noticias', $noticias)->with('erros', array());
        ;
    }

    public function fetchImage($noticia_url) {
        return $this->api->extractMainImage($noticia_url);
    }

    /**
      adiciona tags a uma noticia
     */
    public function getTags($noticia_id) {
        $noticia = Noticia::find($noticia_id);

        $grabber = new NewsSourceTagsGrabber();

        $tags = NULL;

        if (($tags = $grabber->grab_tags($noticia->final_url)) == NULL) {
            $tags = $this->api->fetchTagsApi($noticia->final_url);
        }

        //$tags = $this->api->fetchTagsApi($noticia->final_url);


        $tag_ids = array();



        foreach ($tags as $tag) {
            $tag = trim($tag);
            $tag_on_db = Tag::getByName($tag);
            //dd($tag_on_db);
            if ($tag_on_db == FALSE) {
                //print "nova tag: $tag";
                $new_tag = Tag::create(array('nome' => $tag));
                //var_dump($new_tag);
                $tag_ids [] = $new_tag->id;
            } else {

                //print "tag existente: $tag \n";
                //var_dump($tag_on_db->toArray()[0]);
                $tag_ids[] = $tag_on_db->map(function($tag) {
                            return $tag['id'];
                        })->toArray();
            }
        }

        $tag_ids = array_flatten($tag_ids);
        //print "TAG_IDS:";
        //var_dump($tag_ids);


        if (count($tag_ids) > 0) {
            $noticia->associateTags($tag_ids);
        }

        return View::make('noticias_tags')->with('tags', $tags);
    }

    public function getTagsAjax() {
        $noticia = Noticia::find(Input::get('id'));
        //$url = 'http://www.dnoticias.pt/impressa/diario/opiniao/503312-eleicoes-legislativas-2015';
        //$noticia = Noticia::getByUrl($url);
        //$noticia = Noticia::find(58);

        $tags = $noticia->getTags();

        $tags = array_map(function($tag) {
            return $tag['nome'];
        }, $tags);

        //Log::info(__METHOD__, array('Tags', $tags));
        //$tags = $this->fetchTagsApi($url);
        return Response::make(implode($tags, '<br>'));
    }

    /* 	private function fetchTagsApi($url) {
      $api = new AlchemyAPI();
      $tags = array();
      $response = $api->keywords('url',$url,array('outputMode' => 'json'));

      if ( !empty($response['keywords'])) {
      $tags = array_map(function($tag) {return $tag['text'];}, $response['keywords'] );
      }
      return $tags;
      }

      public function apiSearch() {

      $json = Input::Json();

      var_dump(Input::Json());
      $results = array();

      if (array_key_exists('source',$json)) {
      $source = $json['source'];
      $results = Noticia::where('fonte','=',$source)->get();
      } else if (array_key_exists('term',$json)) {
      $term = $json['term'];
      $results = Noticia::where('titulo','like',"%$term%")->get();

      }

      //print_r(DB::getQueryLog());
      return Response::Json($results);
      }
     */
}
