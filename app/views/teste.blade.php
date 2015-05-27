@extends('master')

@section('content')			
<h2>TESTE</h2>
<pre>
<?php

$html = file_get_contents("http://pt.wikipedia.org/wiki/Lista_de_partidos_pol%C3%ADticos_em_Portugal");


$partido_matches = array();

$nodes = qp($html,"#mw-content-text > ul")->each(function($i,$el) { 
	$sigla = qp($el)->find('b')->text();
	$nome = qp($el)->find('a')->eq(0)->text();
	 $link = qp($el)->find('a')->eq(0)->attr('href') ;
	 $html = qp($el)->html();
	 //echo $html;
	 //echo( $sigla . ':' . $nome . ' => ' . $link . "\n");
	 preg_match("/\<B\>(.*?)\<\/B\>/i",$html,$matches);
	 preg_match("/\<A\ href=(.*?) .*?>(.*?)\<\/A\>/i",$html,$matches_a);
	 var_dump($matches);
	 
	 if (count($matches) > 1) {
		$partido_matches [ $matches[1] ] = $matches_a[1] ;
	}
	var_dump($partido_matches);

});

?>
@stop

