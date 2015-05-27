@extends('master')
@section('content')
<style type="text/css">

    .partido-emblema > img {
        min-height: 48px;
        max-height: 48px;

    }
    
    
</style>
<script type="text/javascript">
    $(function() {
        $.get('{{ URL::action("PartidoRestController@index") }}', function(partidos) {
            console.log(partidos);
            $(partidos).each(function(i, partido) {
                $('.table').append(
                        "<tr><td class='partido-emblema'><img src='" + partido.ficheiro_foto + "'>" + 
                        "</td><td class='partido-descricao'><a href='partidos/" + partido.id + "'>"  +
                                partido.nome + " (" + partido.sigla + ")</a> </td></tr>"
                 );
            });
        });
    });
    
</script>

<h2>Partidos</h2>
<table class='table table-striped table-responsive table-hover'>
</table>
@stop
