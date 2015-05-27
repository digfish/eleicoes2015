<?php

class TagsRestController extends RestController {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    /**
      SELECT COUNT(noticias_has_tags.tags_id), tags.nome AS count_tags FROM noticias_has_tags JOIN tags ON tags.id = noticias_has_tags.tags_id GROUP by noticias_has_tags.tags_id ORDER BY tags.nome ASC, count_tags DESC
     */
    public function index() {

        $q = Input::all();

        $tags = array();


        if (array_key_exists('term', $q)) {
            $term = $q['term'];
            $tags = DB::table("noticias_has_tags")
                    ->select(DB::raw("COUNT(noticias_has_tags.tags_id) AS count, tags.nome, tags.id "))
                    ->join("tags", "tags.id", "=", "noticias_has_tags.tags_id")
                    ->where("tags.nome", 'like', "%$term%")
                    ->groupBy("noticias_has_tags.tags_id")
                    ->orderBy("count", "DESC")
                    ->orderBy("tags.nome", "ASC")
                    ->get();
        } else {
            $tags = DB::table("noticias_has_tags")
                    ->select(DB::raw("COUNT(noticias_has_tags.tags_id) AS count, tags.nome, tags.id "))
                    ->join("tags", "tags.id", "=", "noticias_has_tags.tags_id")
                    ->groupBy("noticias_has_tags.tags_id")
                    ->orderBy("count", "DESC")
                    ->orderBy("tags.nome", "ASC")
                    ->get();
        }



        if (array_key_exists('page', $q) && array_key_exists('qty', $q)) {
            $tags = array_slice($tags, ($q['page'] - 1) * $q['qty'], $q['qty'], TRUE);
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
     *
     * @return Response
     */
    public function store() {

        $tag_input = Input::Json();



        $nova_tag = Tag::create(
                        $tag_input->all()
        );

        return parent::formatResponse($nova_tag);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        # dd("PARA!");
        $tag = DB::table("noticias_has_tags")
                ->select(DB::raw("count(*) AS count, tags.nome,tags.id"))
                ->join("tags", "id", '=', "noticias_has_tags.tags_id")
                ->where('tags.id', '=', $id)
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

        $tag_input = Input::Json();

        $tag = Tag::updateOrCreate(array('id' => $id), $tag_input->all());

        return parent::formatResponse($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $tag = Tag::find($id);

        if (empty($tag)) {
            $tag = NULL;
        } else {
            $tag->delete();
            DB::table('noticias_has_tags')->where('tags_id','=',$id)->delete();
        }

        return parent::formatResponse($tag);
    }

}
