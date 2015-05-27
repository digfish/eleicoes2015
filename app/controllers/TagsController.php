<?php

class TagsController extends BaseController {


	public function getIndexTags() {
		return View::make('tags/index')->with('tags',Tag::all());
	}
	
	public function getShowTag($tag_id) {
                $tag = Tag::find($tag_id);
		return View::make('tags/show')->with('tag',$tag);
		
	}
}
