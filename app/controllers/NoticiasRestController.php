<?php

class NoticiasRestController extends RestController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {


        $query = Input::all();
        //dd($json);            
        $results = array();
        if (array_key_exists('source', $query)) {
            $source = $query['source'];
            $results = Noticia::where('fonte', '=', $source)->orderBy('data', 'desc')->get();
        } else if (array_key_exists('term', $query)) {
            $term = $query['term'];
            $results = Noticia::search($term);
        } else {
            $results = Noticia::orderBy('data', 'desc')->get();
        }

        if (array_key_exists('page', $query) && array_key_exists('qty', $query)) {
            $results = $results->slice(($query['page'] - 1) * $query['qty'], $query['qty'], TRUE);
        }

        $results->map(function($noticia) {
            $noticia->imagem_destaque_principal_url = URL::asset($noticia->imagem_destaque_principal);
            $noticia->imagem_destaque_url = URL::asset($noticia->imagem_destaque);
            $noticia->tags = $noticia->getTags();
        });

        //print_r(DB::getQueryLog());
        //return Response::Json($results);
        //return Response::json($results, $status=200, $headers=array('Content-type: application/json'), $options=JSON_PRETTY_PRINT);

        return parent::formatResponse($results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {

        #echo (Request::method() . ' ' .Request::url() . "\n");

        $noticia_input = Input::Json();

        #dd($noticia_input);

        $nova_noticia = Noticia::create(
                        $noticia_input->all()
        );

        return parent::formatResponse($nova_noticia);
    }

    public function add() {
        
        $url = Input::Json()->get('url');
       
        $resolved_url = Util::resolveUrl($url);
        $return = Noticia::getByUrl($resolved_url);
        $noticia = null;
        $erros = null;
        
        
        if ($return === FALSE) {

            $noticia = new Noticia();
            $scrapper = new NoticiaScrapper($resolved_url);            
            $noticia->titulo = $scrapper->grabTitle();
            $noticia->fonte = "manualmente";
            $noticia->descricao = substr($scrapper->grabTextContents(),0,255);
            $noticia->data = date('Y-m-d H:i:s'); 
            
            $noticia->final_url = $resolved_url;
            $noticia->original_url = $url;


            $noticia->image_url = $scrapper->grabMainImage();
            
            

            $noticia->save();

            $noticia->fetchTags();

        } else {
            $erros = " $resolved_url : Esta noticia já se encontra gravada!";
        }
        if (!empty($erros)) {
            return Response::json(array('erros' => $erros));
        } else {
            return Response::json($noticia);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $noticia = Noticia::find($id);
        return parent::formatResponse($noticia);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $noticia_input = Input::Json();


//        dd($noticia_input);
        $noticia = Noticia::updateOrCreate(array('id' => $id), $noticia_input->all());

        return parent::formatResponse($noticia);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $noticia = Noticia::find($id);

        if (empty($noticia)) {
            $noticia = NULL;
        } else {
            $noticia->delete();
            DB::table('noticias_has_tags')->where('noticias_id', '=', $id)->delete();
        }
        return parent::formatResponse($noticia);
    }

}
