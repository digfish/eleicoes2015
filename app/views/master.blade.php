<?php ?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <style type="text/css">

            tfnewsearch{
                float:right;
                padding:20px;
            }
            .tftextinput2{
                margin: 0;
                padding: 5px 15px;
                font-family: Arial, Helvetica, sans-serif;
                font-size:14px;
                color:#666;
                border:1px solid #0076a3; border-right:0px;
                border-top-left-radius: 5px 5px;
                border-bottom-left-radius: 5px 5px;
            }
            .tfbutton2 {
                margin: 0;
                padding: 5px 7px;
                font-family: Arial, Helvetica, sans-serif;
                font-size:14px;
                font-weight:bold;
                outline: none;
                cursor: pointer;
                text-align: center;
                text-decoration: none;
                color: #ffffff;
                border: solid 1px #0076a3; border-right:0px;
                background: #0095cd;
                background: -webkit-gradient(linear, left top, left bottom, from(#00adee), to(#0078a5));
                background: -moz-linear-gradient(top,  #00adee,  #0078a5);
                border-top-right-radius: 5px 5px;
                border-bottom-right-radius: 5px 5px;
            }
            .tfbutton2:hover {
                text-decoration: none;
                background: #007ead;
                background: -webkit-gradient(linear, left top, left bottom, from(#0095cc), to(#00678e));
                background: -moz-linear-gradient(top,  #0095cc,  #00678e);
            }
            /* Fixes submit button height problem in Firefox */
            .tfbutton2::-moz-focus-inner {
                border: 0;
            }
            .tfclear{
                clear:both;
            }
        </style>


        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Eleições 2015</title>

        {{-- HTML::style('tooltipster/css/tooltipster.css') --}}

        <!-- Bootstrap Core CSS -->
        {{ HTML::style('css/bootstrap.min.css') }}
        <!-- Custom CSS -->
        {{ HTML::style('css/small-business.css') }}
        <style type="text/css">

        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- jQuery -->
        {{ HTML::script('js/jquery.js' , array('type' => 'text/javascript'))}}
        
        <script type="text/javascript">
            
            $(function() {
                $('#search').click(function(evt) {
                        $(this).val('');
                    
                });
            })
        
        </script>


    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="">
            <div class="container" style="">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">
			<!--img src='logo_transparente.png' alt='logotipo' title='Brand' style='height:48px' /-->
                        	{{  HTML::image('logo_transparente.png', 'Brand',array('style' => 'height:48px')) }}
                    </a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">

                    <ul class="nav navbar-nav">
                        <li>
                            <a href='<?php echo URL::route('getListNoticias')?>'>Notícias</a>
                        </li>
                        <li>
                            <a href='<?php echo URL::route('getIndexPartidos')?>'>Partidos</a>
                        </li>
                        <li>
                            <a href="<?php echo URL::route('getIndexTags')?>">Tags</a>
                        </li>
                        <li style="padding-top: 0px; margin-top: 8px; padding-left: 15px">
		                    {{ Form::open( array('route' => 'anyNoticiasSearch','id' => 'header_search') )}}
		                    <input type="text" name="search" id="search" class="tftextinput2" size="21" maxlength="120" value="Pesquisar por Noticias"><input type="submit" value=">" class="tfbutton2">
		                    {{ Form::close() }}
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <!-- Page Content -->
        <div class="container" style="">
            @yield('content')
        </div>
        <!-- /.container -->


<!-- Bootstrap Core JavaScript -->
{{ HTML::script('js/bootstrap.min.js' , array('type' => 'text/javascript'))}}

{{ HTML::script('tooltipster/js/jquery.tooltipster.min.js',array("type" => 'text/javascript')) }}
</body>
</html>

