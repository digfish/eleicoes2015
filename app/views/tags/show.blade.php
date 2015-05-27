
@extends('master')

@section('content')

<script type="text/javascript">
    /*
                    row = $('<TR>');
                cell_link = $('<TD>');
                $("<A>").attr('href',"tag/" + tag.id).text(tag.nome).appendTo(cell_link);
                $(row).append(cell_link);
                $('<TD>').text(tag.count).appendTo(row);
                $("#main-table").append(row);
*/
    $(function() {
                jQuery.get('{{ URL::action('TagsNoticiasRestController@index',array('id' => $tag->id ))}}',
                function (noticias) {
                    $(noticias).each(function(i,noticia) {
                        
                        new_tr = $('<TR>');
                        td_img =  $('<TD>').append("<IMG src='" + noticia.imagem_destaque + "'>");
                        
                        h2 = $("<H2>").append("<A href='" + noticia.final_url + "' target='_blank'>" + noticia.titulo + "</A>");
                        td_attr = $('<TD>').append(h2);
                        
                        $(new_tr).append(td_img);
                        $(new_tr).append(td_attr);
                        $("#main-table").append(new_tr);
                    });
                });

    });
    </script>
<h1> Notícias com a tag &quot;{{ $tag->nome }}&quot; </h1>

<table id="main-table" class=' table table-striped table-responsive table-hover'>



</table>

@stop
