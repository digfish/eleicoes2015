<?php

class PartidosController extends \BaseController {

    /**
     * Display a listing of partidos
     *
     * @return Response
     */
    public function index() {
        $partidos = Partido::all();
        
        
        return View::make('partidos.index', compact('partidos'));
    }

    /**
     * Show the form for creating a new partido
     *
     * @return Response
     */
    public function create() {
        return View::make('partidos.create');
    }

    /**
     * Store a newly created partido in storage.
     *
     * @return Response
     */
    public function store() {
        $validator = Validator::make($data = Input::all(), Partido::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Partido::create($data);

        return Redirect::route('partidos.index');
    }

    /**
     * Display the specified partido.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $partido = Partido::findOrFail($id);
        
        
        $title = str_replace('http://pt.wikipedia.org/wiki/','', urldecode( $partido->wiki_url ));
        
        $partido->historia = Util::fetchWikipediaArticle($title,10);
        //Log::info($partido);

        return View::make('partidos.show', compact('partido'));
    }

    /**
     * Show the form for editing the specified partido.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $partido = Partido::find($id);

        return View::make('partidos.edit', compact('partido'));
    }

    /**
     * Update the specified partido in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $partido = Partido::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Partido::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $partido->update($data);

        return Redirect::route('partidos.index');
    }

    /**
     * Remove the specified partido from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Partido::destroy($id);

        return Redirect::route('partidos.index');
    }

}
