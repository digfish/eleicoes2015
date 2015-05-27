<?php

$feed_url = 'http://www.legislativas2015.pt/feed';

$feed_contents = file_get_contents($feed_url);

$cleaned = str_replace('<head/>','',$feed_contents);

echo $cleaned;

