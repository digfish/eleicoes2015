<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::get('/test/', array('uses' => "TestController@testGrabber"));

Route::get('/test_google_cse',array('uses' => 'TestController@testGoogleCse'));

Route::get('/', array('as' => 'getListNoticias', 'uses' => 'NoticiasController@index'));

Route::get('/add/noticias/google', array('as' => 'getAddNoticiasFromGoogle', 'uses' => 'NoticiasController@addFromGoogle'));

Route::get('/add/noticias/twitter', array('as' => 'getAddNoticiasFromTwitter', 'uses' => 'NoticiasController@addFromTwitter'));

Route::get('/add/noticias/legislativas2015', array('as' => 'getAddNoticiasFromEleicoes2015', 'uses' => 'NoticiasController@addFromEleicoes2015'));

Route::get('/noticias/source/{id}', array('as' => 'getNoticiasFromSource', 'uses' => 'NoticiasController@getNoticiasFromSource'));

Route::get('/noticias', array('as' => 'getListNoticias', 'uses' => 'NoticiasController@index'));

Route::get('/tags', array('as' => 'getIndexTags', 'uses' => "TagsController@getIndexTags"));

Route::get('/tag/{id}', array('as' => 'getShowTag', 'uses' => "TagsController@getShowTag"));

Route::get('/noticias/tags/{id}', array('as' => 'getTagsForNoticia', 'uses' => "NoticiasController@getTags"));

Route::get('/tagsAjax', array('as' => 'getTagsForNoticiaAjax', 'uses' => "NoticiasController@getTagsAjax"));

Route::get('partidos', array('as' => 'getIndexPartidos', 'uses' => 'PartidosController@index'));

Route::get('partidos/{id}', array('as' => 'getShowPartido', 'uses' => 'PartidosController@show'));

Route::any('/noticias/search', array('as' => 'anyNoticiasSearch', 'uses' => 'NoticiasController@index'));

Route::any('/admin',array('uses' => 'AdminController@index'));

Route::any('/admin/tags',array('uses' => 'AdminController@tags'));

Route::any('/admin/noticias',array('uses' => 'AdminController@noticias'));

Route::any('/admin/console',array('uses' => 'AdminController@console'));

Route::get('/admin/executeCron',array('uses' => 'AdminController@executeCron'));


Route::post('/api/noticia/add',array('uses' => 'NoticiasRestController@add' ) );

Route::group(array('prefix' => 'api'), function() {

    Route::resource('partido', 'PartidoRestController');
    Route::resource('noticia', 'NoticiasRestController');
    Route::resource('tag', 'TagsRestController');
    Route::resource('noticia.tag', 'NoticiasTagsRestController');
    Route::resource('tag.noticia', 'TagsNoticiasRestController');
    
});




