@extends('admin.master')

@section('title','Tags')

@section('main_action',"É possível editar e remover tags.")

@section('contents')
<div class="panel-body">
    <div class="dataTable_wrapper  col-sm-7">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nome</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                </tr>
            </tbody>

        </table>
    </div>
    <!-- /.table-responsive -->
    <div class="col-sm-6"></div>
</div>
<!-- /.panel-body -->
@stop

@section('scripting')
<script>

    dataTable = null;

    // only works if there is no more tables in the page !!!
    columnNames = $('th').map(function (i, elem) {
        return $(elem).text().toLowerCase();
    }).toArray();


    $.fn.dataTable.TableTools.defaults.aButtons = ["copy", "csv", "xls"];

    // CODE FOR ADD BUTTON !!!
    $.fn.dataTable.TableTools.buttons.add = $.extend(
            true,
            {},
            $.fn.dataTable.TableTools.buttonBase,
            {
                "sNewLine": "<br>",
                "sButtonText": "Add",
                "target": "",
                "fnClick": function (button, conf) {
                    console.log('Adiciona row!');
                    $(".dataTable tbody").prepend("<TR class='newRow' role='row'><TD></TD><TD></TD><TD></TD></TR>");
                    
                    $('.newRow').find('td').eq(1).append("<INPUT class='newTagInput' name='nome' value=''>");
                    $('.newTagInput').keyup(function (evt) {
                        if (evt.keyCode == 13) {// enter
                            console.log('KeyUp on dynamic form input:', evt);
                            newValue = $(this).prop('value');
                            $.ajax({
                                type: 'POST',
                                url: "http://eleicoes2015.my.to/api/tag",
                                data: JSON.stringify({'nome': newValue }),
                                dataType: 'json',
                                contentType: "application/json",
                                success: function (tag) {
                                    console.log("Inserted new tag:", tag);
                                    dataTable.ajax.reload();
                                }
                            });
                        }
                        
                    });
                    



                }
            }

    );
    
    // END OF CODE FOR THE 'ADD' BUTTON


    // CODE FOR THE DELETE BUTTON 
    $.fn.dataTable.TableTools.buttons.delete = $.extend(
            true,
            {},
            $.fn.dataTable.TableTools.buttonBase,
            {
                "sNewLine": "<br>",
                "sButtonText": "Delete",
                "target": "",
                "fnClick": function (button, conf) {
                    if ($('#dataTables-example tr ').hasClass('selected')) {
                        console.log("Del Button click!");
                        console.log("button", button);
                        console.log("conf", conf);
//                                console.log ("Delete",localStorage.getObject('selectedRow'));
//                                id = localStorage.getObject('selectedRow')._DT_RowIndex;
//                                row = getRowNumber(dataTable,id);
                        selRow = dataTable.$('.DTTT_selected');
                        console.log(selRow);
                        tag_id = $(selRow).find('td').get(0).textContent;


                        // delete the tag !!!
                        $.ajax({
                            type: 'DELETE',
                            url: "http://eleicoes2015.my.to/api/tag/" + tag_id,
                            success: function (tag) {
                                console.log("Deleted tag:", tag);
                                dataTable.ajax.reload();

                            }
                        });

                    }
                    //$(conf.target).html(this.fnGetTableData(conf));
                }}
    );

    // END OF CODE FOR THE DELETE BUTTON 








    // CODE FOR EDIT BUTTON !!!
    $.fn.dataTable.TableTools.buttons.edit = $.extend(
            true,
            {},
            $.fn.dataTable.TableTools.buttonBase,
            {
                "sNewLine": "<br>",
                "sButtonText": "Edit",
                "target": "",
                "fnClick": function (button, conf) {
                    if ($('#dataTables-example tr').hasClass('selected')) {
                        var $contextObj = $('#dataTables-example tr.selected');
                        var isBeingEdited = $contextObj.hasClass('editing');
                        console.log('EDITING ?', isBeingEdited);
                        if (!isBeingEdited) { //activate the inline form 
                            console.log("Edit Button click!");
                            selRow = dataTable.$('.DTTT_selected');
                            console.log(selRow);
                            $(selRow).addClass('editing');
                            tag_id = $(selRow).find('td').get(0).textContent;
                            dataTable.$(selRow).find('td', this).each(function (i, elem) {
                                console.log(i);
                                val = $(elem).text();
                                $(this).text('')
                                $(this).append("<INPUT class='dynamic_edits' name='" + columnNames[i] + "' value='" + val + "'>");
                                $('.dynamic_edits').keyup(function (evt) {
                                    if (evt.keyCode == 13) // enter
                                        console.log('KeyUp on dynamic form input:', evt);
                                });
                            });
                        } else { // send the updated data !

                            $(this).removeClass('editing');

                            updated_data = [];
                            $contextObj.find('input').each(function (i, elem) {
                                updated_data [$(elem).attr('name')] = $(elem).prop('value');
                                val = $(elem).prop('value');
                                $(elem).parent('td').text(val);
                            });
                            console.log(updated_data);
                            serialized = $(updated_data).serialize();
                            console.log("New data to send:", serialized);
                            $.ajax({
                                type: 'PUT',
                                url: "http://eleicoes2015.my.to/api/tag/" + tag_id,
                                data: JSON.stringify({'id': updated_data ['id'], 'nome': updated_data['nome']}),
                                dataType: 'json',
                                contentType: "application/json",
                                success: function (tag) {
                                    console.log("Updated:", tag);
                                    dataTable.ajax.reload();
                                }
                            });

                        }



                    }
                    //$(conf.target).html(this.fnGetTableData(conf));
                }
            }
    );
    // END OF CODE FOR EDIT BUTTON !!!





    function getRowNumber(dt, number) {
        return dt.$('tr').get(number);
    }

    $(document).ready(function () {
        dataTable = $('#dataTables-example').DataTable({
            "responsive": true,
            "order": [[2, "desc"]],
            "ajax": {
                'url': 'http://eleicoes2015.my.to/api/tag',
                'type': 'GET',
                'data': "tags",
                'dataSrc': function (tags) {

                    tableData = [];
                    $.each(tags, function (i, tag) {
                        tableData.push([tag.id, tag.nome, tag.count])
                    });
                    return tableData;
                }
            },
            "dom": 'T<"clear">lfrtip',
            tableTools: {
                "sSwfPath": "backoffice/packages/tabletools-2.2/swf/copy_csv_xls_pdf.swf",
                "sRowSelect": "os",
                "aButtons": ["add", "edit", "delete","xls","copy"]
            }

        });


        //var tableTools = new $.fn.dataTable.TableTools($dt);

//                $('#dataTables-example tbody').on('click', 'tr', function () {
//                    if ($(this).hasClass('selected')) {
//                        $(this).removeClass('selected');
//                    }
//                    else {
//                        $dt.$('tr.selected').removeClass('selected');
//                        $(this).addClass('selected');
//                    }
//                });
    });
</script>

@stop
