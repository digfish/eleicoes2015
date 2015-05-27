<?php

class NoticiasTagsRestController extends RestController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($noticia_id) {
        $tags = NULL;
        $noticia = Noticia::find($noticia_id);
        if ($noticia) {
            $tags = $noticia->getTags();
        }
        return parent::formatResponse($tags);
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
     * !!! TODO: a ser revisto !!!!
     * @return Response
     */
    public function store($noticia_id) {
        $noticia = Noticia::find($noticia_id);
        $tag_ids = Input::Json()->get('tags');

        //$tag_ids = array();

//        $tag_names = array_map(function($tag) {
//            return $tag['nome'];
//        }, $tags_input);

        
//        foreach ($tag_names as $tag) {
//            $tag_on_db = Tag::getByName($tag);
//            if ($tag_on_db == FALSE) {
//                $tag_on_db = Tag::create(array('nome' => $tag));
//                $tag_ids [] = $tag_on_db->id;
//            }
//        }

        if (count($tag_ids) > 0) {
                $noticia->associateTags($tag_ids);
        }



        $noticia->tags = $noticia->getTags();

        //dd($noticia);
        return parent::formatResponse($noticia);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($noticia_id, $tag_id) {
        $tag = DB::table('noticias_has_tags')
                ->where('noticias_id', '=', $noticia_id)
                ->where('tags_id', '=', $tag_id)
                ->join('tags', 'id', '=', 'noticias_has_tags.tags_id')
                ->get();

        return parent::formatResponse($tag);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($noticia_id, $tag_id) {

        $noticia = Noticia::find($noticia_id);

        $tag = NULL;

        if ($noticia) {
            $tag = DB::table('noticias_has_tags')
                    ->where('noticias_id', '=', $noticia_id)
                    ->where('tags_id', '=', $tag_id)
                    ->get();



            if (empty($tag)) {
                $tag = NULL;
            } else {

                $delete_result = DB::table('noticias_has_tags')
                        ->where('noticias_id', '=', $noticia_id)
                        ->where('tags_id', '=', $tag_id)
                        ->delete();
            }
        }

        return parent::formatResponse($tag);
    }

}
