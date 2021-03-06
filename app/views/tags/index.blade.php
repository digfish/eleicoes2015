@extends('master')

@section('content')

{{ HTML::style('jchartfx/jchartfx.attributes.css') }}
{{ HTML::style('jchartfx/jchartfx.palette.css') }}

<script src="jchartfx/jchartfx.system.js" type="text/javascript"></script>
<script src="jchartfx/jchartfx.coreBasic.js" type="text/javascript"></script>
<script src="jchartfx/jchartfx.coreVector.js" type="text/javascript"></script>
<script src="jchartfx/jchartfx.animation.js" type="text/javascript"></script>
<script type="text/javascript">


var chart1;
data = [];


$(function () {
    console.log(">>> DOCUMENT.READY STARTED NOW! <<< ");

    function loadChart() {
        chart1 = new cfx.Chart();
        chart1.setGallery(cfx.Gallery.Bar);
        chart1.setDataSource(data);
        chart1.getAnimations().getLoad().setEnabled(true);
        chart1.getSeries().getItem(0).getPointLabels().setVisible(true);
        var divHolder = $('#placeholder').get(0);
        chart1.create(divHolder);
    }


    $.ajaxSetup({async: false});
    $.get('{{ URL::action('TagsRestController@index') }}',
            function (tags) {
                $(tags).each(function (i, tag) {
                    row = $('<TR>');
                    cell_link = $('<TD>');
                    $("<A>").attr('href', "tag/" + tag.id).text(tag.nome).appendTo(cell_link);
                    $(row).append(cell_link);
                    $('<TD>').text(tag.count).appendTo(row);
                    $("#main-table").append(row);
                    if (i < 10) {
                        data.push({"Tag": tag.nome, "Count": tag.count});
                        //dataSet.push([tag.nome, tag.count]);
                    }
                });

                loadChart();


            });
    console.log("<<< DOCUMENT.READY FINISHED NOW! >>> ");

});

$(window).load(function (evt) {

    console.log(">>> LOAD STARTS HERE! <<< ")
});
</script>
<h2>TAGS</h2>

<div id="placeholder" style="min-height: 400px"></div>

<table id="main-table" class=' table table-striped table-responsive table-hover'>



</table>

<script type="text/javascript">

</script>
@stop

