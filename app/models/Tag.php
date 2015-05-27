<?php

class Tag extends \Eloquent {
	
	protected $guarded = array();
	protected $table = "tags";
	public $timestamps = FALSE;

	protected function noticias() {
		return $this->belongsToMany('Noticia','noticias_has_tags','tags_id','noticias_id');
	}
	
	protected function getByName($tag) {
		$tags = Tag::where('nome','=',$tag)->get();
		return ($tags->count() == 0) ? FALSE: $tags;
	}
        
        protected function getNoticias() {
            
        }

}
