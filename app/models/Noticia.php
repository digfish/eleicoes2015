<?php

class Noticia extends \Eloquent {

    protected $guarded = array();
    protected $table = 'noticias';
    public $timestamps = false;
    protected $appends = array('imagem_destaque_principal','imagem_destaque');

    public function tags() {
        return $this->belongsToMany('Tag', 'noticias_has_tags', 'tags_id', 'noticias_id');
    }

    public function getTags() {

        $pivot_entries = DB::table('noticias_has_tags')->where('noticias_id', '=', $this->id)->get();

        $pivot_entries_ids = array_map(function($entry) {
            return $entry->tags_id;
        }, $pivot_entries);
        $tags = Tag::find($pivot_entries_ids)->toArray();



        return $tags;
    }

    public function associateTags($tag_ids) {
        $array_values = array();
        //print "<PRE>";
        //var_dump($tag_ids);
        foreach ($tag_ids as $id) {
            $array_values[] = array(
                'noticias_id' => $this->id,
                'tags_id' => $id
            );
        }
        //dd($array_values);
        foreach ($array_values as $row) {
            $exists = DB::table('noticias_has_tags')
                    ->where('noticias_id', '=', $row['noticias_id'])
                    ->where('tags_id', '=', $row['tags_id'])
                    ->get();
            //dd($exists);
            if (count($exists) == 0) {
                DB::table('noticias_has_tags')->insert($array_values);
            }
        }
    }

    protected function getByUrl($url) {
        $noticia = Noticia::with('tags')->where('final_url', '=', $url)->first();

        if (!empty($noticia)) {
            return $noticia;
        } else {
            return FALSE;
        }
    }

    protected function getByOriginalUrl($url) {
        $noticia = Noticia::where('original_url', '=', $url)->first();
        if (!empty($noticia)) {
            return $noticia;
        } else {
            return FALSE;
        }
    }

    protected function getUrl() {
        return $this->getAttribute('final_url');
    }
    
    public function getImagemDestaquePrincipalAttribute() {
        return Util::thumb350h($this->image_url);
    }

    public function getImagemDestaqueAttribute() {
        return Util::thumb360w($this->image_url);
    }
    
    public static function search($term) {
         return Noticia::where('titulo', 'like', "%$term%")
                 ->orWhere('descricao', 'like', "%$term%")
                 ->orderBy('data','desc')->get();
    }
    
    
    public function fetchTags() {
        
        $noticia_id = $this->id;

        $grabber = new NewsSourceTagsGrabber();

        $tags = NULL;

        if (($tags = $grabber->grab_tags($this->final_url)) == NULL) {
            $tags =  (new ApiCaller())->fetchTagsApi($this->final_url);
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
            $this->associateTags($tag_ids);
        }

    }

    
    /* protected function insertTags($tag_names) {


      $tag_ids = array();

      foreach ($tag_names as $tag) {
      $tag_on_db = Tag::getByName($tag);
      if ( $tag_on_db == FALSE) {
      $tag_on_db = Tag::create(array('nome' => $tag));
      $tag_ids [] = $tag_on_db->id;
      }


      }

      if ( count($tag_ids)  >0 ) {
      $this->associateTags($tag_ids);
      }

      return $tag_ids;

      } */
}
