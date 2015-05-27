<?php
/**
 * An helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace {
/**
 * Noticia
 *
 * @property integer $id 
 * @property string $fonte 
 * @property string $titulo 
 * @property string $original_url 
 * @property string $data 
 * @property string $final_url 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Tag[] $tags 
 * @method static \Illuminate\Database\Query\Builder|\Noticia whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Noticia whereFonte($value)
 * @method static \Illuminate\Database\Query\Builder|\Noticia whereTitulo($value)
 * @method static \Illuminate\Database\Query\Builder|\Noticia whereOriginalUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\Noticia whereData($value)
 * @method static \Illuminate\Database\Query\Builder|\Noticia whereFinalUrl($value)
 */
	class Noticia {}
}

namespace {
/**
 * User
 *
 */
	class User {}
}

namespace {
/**
 * Comentario
 *
 * @property integer $id 
 * @property string $conteudo 
 * @property integer $noticias_id 
 * @property integer $utilizadores_id 
 * @method static \Illuminate\Database\Query\Builder|\Comentario whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comentario whereConteudo($value)
 * @method static \Illuminate\Database\Query\Builder|\Comentario whereNoticiasId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comentario whereUtilizadoresId($value)
 */
	class Comentario {}
}

namespace {
/**
 * Teste
 *
 */
	class Teste {}
}

namespace {
/**
 * Tag
 *
 * @property integer $id 
 * @property string $nome 
 * @method static \Illuminate\Database\Query\Builder|\Tag whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Tag whereNome($value)
 */
	class Tag {}
}

namespace {
/**
 * Partido
 *
 * @property integer $id 
 * @property string $nome 
 * @property string $lider 
 * @property integer $num_militantes 
 * @property string $endereco_sede 
 * @property string $tipo 
 * @property string $historia 
 * @property string $sigla 
 * @property string $ficheiro_foto 
 * @property string $ano_fundacao 
 * @property \Carbon\Carbon $deleted_at 
 * @property string $wiki_url 
 * @method static \Illuminate\Database\Query\Builder|\Partido whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Partido whereNome($value)
 * @method static \Illuminate\Database\Query\Builder|\Partido whereLider($value)
 * @method static \Illuminate\Database\Query\Builder|\Partido whereNumMilitantes($value)
 * @method static \Illuminate\Database\Query\Builder|\Partido whereEnderecoSede($value)
 * @method static \Illuminate\Database\Query\Builder|\Partido whereTipo($value)
 * @method static \Illuminate\Database\Query\Builder|\Partido whereHistoria($value)
 * @method static \Illuminate\Database\Query\Builder|\Partido whereSigla($value)
 * @method static \Illuminate\Database\Query\Builder|\Partido whereFicheiroFoto($value)
 * @method static \Illuminate\Database\Query\Builder|\Partido whereAnoFundacao($value)
 * @method static \Illuminate\Database\Query\Builder|\Partido whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Partido whereWikiUrl($value)
 */
	class Partido {}
}

