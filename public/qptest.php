<?php

$html = file_get_contents("http://pt.wikipedia.org/wiki/Lista_de_partidos_pol%C3%ADticos_em_Portugal");

$a_nodes = qp($html,"a");

var_dump($a_nodes);
