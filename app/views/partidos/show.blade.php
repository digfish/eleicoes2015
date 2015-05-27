
@extends('master')

@section('content')

<h1>{{ $partido->nome  }}   {{ "(" . $partido->sigla . ")" }} </h1>

<div >
    <?php
         echo "<IMG src='{$partido->ficheiro_foto}' style=' border-radius: 25px; border: 2px solid #8AC007; padding: 20px;  width: 200px; height: 150px; ' >";
?>

    <br>
<br>


    <table class='table table-striped'>    
    <?php
    foreach ($partido->getAttributes() as $attribute => $value) {
        print "<TR>";
        if ($attribute != 'id' and $attribute != 'ficheiro_foto' and $attribute != 'num_militantes' and $attribute != 'endereco_sede' 
                and $attribute != 'historia' and $attribute != 'deleted_at') {
            if ($attribute == 'ano_fundacao') {
                print "	<td>Ano de Funda&ccedil;&atilde;o :</td><td>  $value </td>";
            } 
             elseif ($attribute == 'lider') {
                print " <td>$attribute :</td><td> $value  </td> ";
            } elseif ($attribute == 'nome') {
                print "	<td>Nome :</td><td>  $value </td>";
            } elseif ($attribute == 'tipo') {
                print "	<td>Tipo :</td><td>  $value </td>";
            } elseif ($attribute == 'sigla') {
                print "	<td>Sigla :</td><td>  $value </td>";
	    } elseif ($attribute == 'wiki_url') {
		print " <td>Fonte :</td><td> <a href=$value> $value </a> </td>";
            } else {
                print "	<td>$attribute :</td><td>  $value </td>";
            }
        }
        print "</TR>";
    }
    ?>
    </table>

</div>

<p> {{$partido->historia}}</p>

@stop
