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
        {{ HTML::style('backoffice/packages/bootstrap/dist/css/bootstrap.min.css') }}
        

        <!-- MetisMenu CSS -->
         {{ HTML::style('backoffice/packages/metisMenu/dist/metisMenu.min.css') }}
        

        <!-- DataTables CSS -->
        {{ HTML::style("backoffice/packages/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css") }}       

        <!-- DataTables Responsive CSS -->
        {{ HTML::style("backoffice/packages/datatables-responsive/css/dataTables.responsive.css")  }}

        <!-- Custom CSS -->
        {{ HTML::style("backoffice/css/sb-admin-2.css")  }}

        <!-- Custom Fonts -->
        {{ HTML::style("backoffice/packages/font-awesome/css/font-awesome.min.css")  }}

        <!-- Data tablesx TableTools -->
        {{ HTML::style("backoffice/packages/tabletools-2.2/css/dataTables.tableTools.css")  }} 
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
                                <a href="{{ url('admin') }}"><i class="fa fa-home fa-fw"></i> Home</a>
                            </li>
                            <li>
                                <a href="{{ url('admin/noticias') }}"><i class="fa fa-newspaper-o fa-fw"></i> Noticias</a>
                            </li>
                            <li>
                                <a href="{{ url('admin/tags') }}"><i class="fa fa-tags fa-fw"></i> Tags</a>
                            </li>
                            <li>
                                <a href="{{ url('admin/console') }}"><i class="fa fa-desktop fa-fw"></i> Consola</a>
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
                            @section('contents')
                            Bem-vindo ao painel de administração do Eleições 2015. Clique numa opção do menu esquerdo para continuar.
                            @show
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
        {{ HTML::script("backoffice/packages/jquery/dist/jquery.min.js")  }}

        <!-- Bootstrap Core JavaScript -->
        {{ HTML::script("backoffice/packages/bootstrap/dist/js/bootstrap.min.js")  }}

        <!-- Metis Menu Plugin JavaScript -->
        {{ HTML::script("backoffice/packages/metisMenu/dist/metisMenu.min.js")  }}

        <!-- DataTables JavaScript -->
        {{ HTML::script("backoffice/packages/datatables/media/js/jquery.dataTables.min.js")  }}
        {{ HTML::script("backoffice/packages/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js")  }}

        <!-- Custom Theme JavaScript -->
        {{ HTML::script("backoffice/js/sb-admin-2.js")  }}

        {{ HTML::script("backoffice/packages/tabletools-2.2/js/dataTables.tableTools.js")  }}

        {{ HTML::script("js/my.js")  }}
        
        {{ HTML::script("backoffice/packages/datatables-plugins/scroller/dataTables.scroller.js")  }}        

       @section('scripting')
       @show

    </body>

</html>
