<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Eleicoes 2015 Backoffice - @yield('title')</title>

        <!-- Bootstrap Core CSS -->
        <link href="backoffice/packages/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="backoffice/packages/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link href="backoffice/packages/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="backoffice/packages/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="backoffice/css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="backoffice/packages/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- Data tablesx TableTools -->
        <link href="backoffice/packages/tabletools-2.2/css/dataTables.tableTools.css" rel="stylesheet" type="text/css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">Eleições 2015 Backoffice</a>
                </div>
                <!-- /.navbar-header -->


                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="sidebar-search">
                                <div class="input-group custom-search-form">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                                <!-- /input-group -->
                            </li>
                            <li>
                                <a href="admin"><i class="fa fa-home fa-fw"></i> Home</a>
                            </li>
                            <li>
                                <a href="noticias"><i class="fa fa-newspaper-o fa-fw"></i> Noticias</a>
                            </li>
                            <li>
                                <a href="tags"><i class="fa fa-tags fa-fw"></i> Tags</a>
                            </li>
                            
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">@yield('title')</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               @yield('main_action')
                            </div>
                            <!-- /.panel-heading -->
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
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="backoffice/packages/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="backoffice/packages/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="backoffice/packages/metisMenu/dist/metisMenu.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="backoffice/packages/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="backoffice/packages/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="backoffice/js/sb-admin-2.js"></script>

        <script src="backoffice/packages/tabletools-2.2/js/dataTables.tableTools.js" type="text/javascript"></script>

        <script src="js/my.js" type="text/javascript"></script>

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>

            dataTable = null;

            // only works if there is no more tables in the page !!!
            columnNames = $('th').map(function (i, elem) {
                return $(elem).text().toLowerCase();
            }).toArray();


            $.fn.dataTable.TableTools.defaults.aButtons = ["copy", "csv", "xls"];

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
                                        $('.dynamic_edits').keyup(function(evt) {
                                            if (evt.keyCode == 13) // enter
                                            console.log('KeyUp on dynamic form input:',evt);
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
                                        data:  JSON.stringify({ 'id': updated_data ['id'] , 'nome': updated_data['nome'] }),
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
                        "aButtons": ["edit", "delete"]
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

    </body>

</html>
