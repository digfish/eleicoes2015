<?php

class Partido extends \Eloquent {
	protected $fillable = array('nome','lider','num_militantes','ano_fundacao','endereco_sede','tipo','historia','sigla','ficheiro_foto');
	public $timestamps = false;
	
	
	
	use SoftDeletingTrait;
	
    protected $dates = ['deleted_at'];
	
	protected $guarded = array();
}
