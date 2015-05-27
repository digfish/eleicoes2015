@extends('admin.master')

@section('title','Consola')

@section('main_action',"Registo de operações do scrapper de notícias")

@section('contents')
<div class="container">
    <div class="row">
        <div class="col-md-1">
            <button type="button" class="btn btn-success" onclick="invokeExecuteCron()">Obtém últimas notícias</button>
        </div>
    </div>
</div>
<div class="panel-body">
    <div class="well">
        <div class="span4">Última modificação:<span class="last_modification">{{ $last_modification }}</span></div>
    </div>
    <div class="col-sm-12" style='font-family: monospace'><PRE id="output">{{ $log }}</PRE></div>
</div>
<script type="text/javascript">

    function invokeExecuteCron() {
        $.get(
                "{{ url('admin/executeCron') }}",
                function (combined) {
                    $('#output').html(combined.output);
                    $('.last_modification').html(combined.last_modification);
                }
        );
    }

</script>
<!-- /.panel-body -->
@stop
