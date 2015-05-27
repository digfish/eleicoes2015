<?php

class PartidoRestController extends RestController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        $q = Input::all();

        $partidos = Partido::all();

        if (array_key_exists('page', $q) && array_key_exists('qty', $q)) {
            $partidos = $partidos->slice(($q['page'] - 1) * $q['qty'], $q['qty'], TRUE);
        }

        return parent::formatResponse($partidos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return Response::make('create!');
    }

    /*
      array('id' => '1','nome' => 'Movimento Alternativa Socialista','lider' => 'Gil Garcia','num_militantes' => '0','endereco_sede' => '','tipo' => 'Esquerda','historia' => '','sigla' => 'MAS','ficheiro_foto' => '','ano_fundacao' => '2000','deleted_at' => NULL),
     *


      /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store() {
        $partido_input = Input::Json();

        $novo_partido = Partido::create(
                        $partido_input->all()
        );
        return parent::formatResponse($novo_partido);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $partido = Partido::find($id);
        
        $title = str_replace('http://pt.wikipedia.org/wiki/','', urldecode( $partido->wiki_url ));
        
        $partido->historia = Util::fetchWikipediaArticle($title,10);
        
        return parent::formatResponse($partido);
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
        $partido_input = Input::Json();


//        dd($partido_input);
        $partido = Partido::updateOrCreate(array('id' => $id), $partido_input->all());

        return parent::formatResponse($partido);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $partido = Partido::find($id);

        if (empty($partido)) {
            $partido = NULL;
        } else
            $partido->delete();
        
        return parent::formatResponse($partido);
    }

}
