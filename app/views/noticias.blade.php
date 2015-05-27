@extends('master')

@section('content')			

        <script type="text/javascript">
            _noticias = null;

            function delete_noticia_api(noticia_id) {
                $.ajax({
                    type: 'DELETE',
                    url: "http://eleicoes2015.my.to/api/noticia/" + noticia_id,
                    success: function (noticia) {
                        console.log('Deleted noticia', noticia);
                    }
                });
            }
            jQuery(function () {



                last_noticias_pos = 4;
                $destaque_node = $('.destaque');
                jQuery.get('api/noticia',
                        function (noticias) {

                            // carrega o painel principal das noticias

                            //onsole.log(noticias);

                            // cria os arrais principais
                            destaque_principal = noticias[0];
                            count = noticias.length;
                            destaques = noticias.slice(1, 4);
                            //console.log(destaque_principal);
                            //console.log(destaques);
                            //console.log(noticias);
                            _noticias = noticias;
                            // preenche os campos do destaque pruncipal
                            $('#destaque-principal .destaque-titulo').html(destaque_principal.titulo);
                            $('#destaque-principal .destaque-descricao').html(destaque_principal.descricao);
                            $('#destaque-principal .destaque-fonte').html(destaque_principal.fonte);
                            $('#destaque-principal .destaque-imagem').attr('src', destaque_principal.imagem_destaque_principal_url);
                            $('#destaque-principal .destaque-data').html(destaque_principal.data);

                            $('#destaque-principal .link-destaque').attr("href", destaque_principal.final_url);
                            $('#destaque-principal .link-destaque').attr("target", '_blank');
                            $.each(destaque_principal.tags, function (i, tag) {

                                $('#destaque-principal .destaque-tags').append("<span class='tag label label-success'>" + tag.nome + "</span");
                            });

                            // grab the only destaque_node on the page and remove it...

                            console.log($destaque_node);
                            $destaque_node.remove();

                            i = 0;
                            // now that we removed the 'destaque' node, we're gonna clone for each of the destaques:
                            $.each(destaques, function (i, destaque) {
                                $new_destaque_node = $destaque_node.clone().appendTo('.destaques').attr('id', 'destaque' + i);
                                console.log(i, destaque, $new_destaque_node);
                                $('.destaque-titulo', $new_destaque_node).html(destaque.titulo);
                                $('.destaque-imagem', $new_destaque_node).attr('src', destaque.imagem_destaque_url);
                                $('.destaque-descricao', $new_destaque_node).html(destaque.descricao);
                                $('.destaque-fonte', $new_destaque_node).html(destaque.fonte);
                                $('.destaque-data', $new_destaque_node).html(destaque.data);
                                $('.destaque-url', $new_destaque_node).attr('href', destaque.final_url);

                                $.each(destaque.tags, function (i, tag) {
                                    $('.destaque-tags', $new_destaque_node).append("<span class='tag label label-success'>" + tag.nome + "</span");
                                });


                                $('a.destaque-remove', $new_destaque_node).on('click', function (evt) {
                                    evt.preventDefault();
                                    delete_noticia_api(destaque.id);
                                    $(this).parents('.destaque').remove();
                                });

                            })
                        });

                lastScrollPos = 0;

                counter = 0;

                // grab new noticias as we scroll down....
                $(window).scroll(function (evt) {
                    var currScrollPos = $(this).scrollTop();
                    console.log("SCROLL VALS:", currScrollPos, lastScrollPos);
                    if (currScrollPos > lastScrollPos && counter % 50 == 0) {
                        novos_destaques = _noticias.slice(last_noticias_pos, last_noticias_pos + 3);
                        // now that we removed the 'destaque' node, we're gonna clone for each of the destaques:
                        $.each(novos_destaques, function (i, destaque) {
                            $new_destaque_node = $destaque_node.clone().appendTo('.destaques').attr('id', 'destaque' + last_noticias_pos);
                            console.log(i, destaque, $new_destaque_node);
                            $('.destaque-titulo', $new_destaque_node).html(destaque.titulo);
                            $('.destaque-imagem', $new_destaque_node).attr('src', destaque.imagem_destaque_url);
                            $('.destaque-descricao', $new_destaque_node).html(destaque.descricao);
                            $('.destaque-fonte', $new_destaque_node).html(destaque.fonte);
                            $('.destaque-data', $new_destaque_node).html(destaque.data);
                            $('.destaque-url', $new_destaque_node).attr('href', destaque.final_url);
                            $('#')
                            $.each(destaque.tags, function (i, tag) {
                                $('.destaque-tags', $new_destaque_node).append("<span class='tag label label-success'>" + tag.nome + "</span");
                            });

                            $('a.destaque-remove', $new_destaque_node).on('click', function (evt) {
                                evt.preventDefault();
                                delete_noticia_api(destaque.id);
                                $(this).parents('.destaque').remove();
                            });
                        })

                        last_noticias_pos += 3;

                    } else {
                        console.log("UP!");
                    }
                    //$destaque_node.clone().appendTo('.destaques').attr('id', 'destaque' + i);
                    counter++;
                    lastScrollPos = currScrollPos;
                });

            });
        </script>


            <!-- Heading Row -->
            <div class="row" id="destaque-principal" class="not�cia">
                <div class="col-md-8">
                    <a class="link-destaque" href=""><img class="img-responsive img-rounded destaque-imagem" src="" alt=""></a>
                </div>
                <!-- /.col-md-8 -->
                <div class="col-md-4">
                    <a class="link-destaque"><h1 class="destaque-t�tulo"></h1></a>
                    <p class="destaque-descricao"></p>
                    <p class="destaque-tags"></p>
                    <p>Fonte: <span class="destaque-fonte"></span></p>
                    <p>Data: <span class="destaque-data"></span> </p>
                    <a class="btn btn-primary btn-lg link-destaque"  href="" target="_blank">Ver notícia</a>
                </div>
                <!-- /.col-md-4 -->
            </div>
            <!-- /.row -->

            <hr>

            <!-- Content Row -->
            <div class="row destaques">
                <div class="col-md-4 destaque">
                    <img src="" class="destaque-imagem" />
                    <h2 class="destaque-titulo"></h2>
                    <p class="destaque-descricao"></p>
                    <p class="destaque-tags"></p>
                    <p>Fonte: <span class="destaque-fonte"> </span></p>
                    <p>Data: <span class="destaque-data"> </span></p>
                    <p><a class="btn destaque-remove" ><span class="glyphicon  glyphicon-remove"></span> Not&iacute;cia n&atilde;o relevante <a></p>
                                <a class="btn btn-default destaque-url" href="" target="_blank">Ver mais</a>
                                </div>
                                <!-- /.col-md-4 -->
                                </div>
                                <!-- /.row -->

                                <!-- Footer -->
                                <footer>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>Copyright &copy; Elei&ccedil;&otilde;es2015.My.To</p>
                                        </div>
                                    </div>
                                </footer>


@stop

