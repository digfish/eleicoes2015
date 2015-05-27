<?php

require_once 'PtQueryBuilder.php';

class Util {

    // http://news.google.com/news/url?sa=t&fd=R&ct2=pt-PT_pt&usg=AFQjCNFZO7GCrPZmzvdVJzrKOiIesw02Lg&clid=c3a7d30bb8a4878e06b80cf16b898331&ei=2gELVeCsOuixiwamlYDQCg&url=http://www.dnoticias.pt/impressa/diario/opiniao/503312-eleicoes-legislativas-2015
    static function parseGoogleNewsUrl($url) {
        $parsed = parse_url($url);
        parse_str($parsed['query'], $q_r);


        return $q_r['url'];
    }

    static function resolveUrl($unresolved_url) {
        $resolver = new URLResolver();
        $resolved_url = $resolver->resolveURL($unresolved_url)->getURL();
        return $resolved_url;
    }

    static function dateTimeIntoStr($date) {
        if ($date instanceof DateTime) {
            $date = $date->format('Y-m-d H:i:s');
        }
        return $date;
    }

    /**
     * formats properly the Json Response
     * @param type $object
     * @return type
     */
    static function prettyJson($object) {
        return Response::json($object, $status = 200, $headers = array('Content-type: application/json'), $options = JSON_PRETTY_PRINT);
    }

    static function fetchWikipediaArticle($title, $sentences) {
        $qb = new PtQueryBuilder();

        $qb->setFormat("php");
        $qb->setTitles($title);
        $qb->setExtractsSentences($sentences);
        $qb->setExtractsPlainText(false);

        $response = unserialize($qb->fetch());



        $page = reset($response["query"]["pages"]);

        if (isset($page['extract'])) {

            return $page["extract"];
        } else
            return "N/A";
    }

    static function thumb350h($image_filename) {

        if (empty($image_filename)) {
            return NULL;
        }

        $file_info = pathinfo($image_filename);

        $file_basename = preg_split('/\./', $file_info['basename'])[0];

        $image_path = '/noticias_pictures/' . $file_basename;


        $imagefile_ext = $file_info['extension'];

        return "{$image_path}.thumb.350h.$imagefile_ext";
    }

    static function thumb360w($image_filename) {

        if (empty($image_filename)) {
            return NULL;
        }

        $file_info = pathinfo($image_filename);

        $file_basename = preg_split('/\./', $file_info['basename'])[0];

        $image_path = '/noticias_pictures/' . $file_basename;

        $imagefile_ext = $file_info['extension'];

        return "{$image_path}.thumb.360w.$imagefile_ext";
    }

}
