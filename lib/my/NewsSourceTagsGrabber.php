<?php

use Masterminds\HTML5;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewsSourceTagsGrabber
 *
 * @author sam
 */
class NewsSourceTagsGrabber {

    var $qp;
    var $html5;
    var $dom;
    var $sites = array(
        'observador.pt' => 'observador_pt',
        'expresso.sapo.pt' => 'expresso_sapo_pt',
        'www.publico.pt' => 'publico_pt',
        'www.dn.pt' => 'dn_pt',
        'www.legislativas2015.pt' => 'legislativas2015_pt',
        'www.cmjornal.xl.pt' => 'www_cmjornal_xl_pt'
    );
    var $html; // holds the HTML content to be parsed

    function __construct() {
        $this->html5 = new HTML5();
    }

    function grab_tags($url) {

        $this->dom = $this->html5->loadHTML(file_get_contents($url));
        $this->qp = qp($this->dom);
        $host = parse_url($url, PHP_URL_HOST);
        if (array_key_exists($host, $this->sites)) {
            $function_name = $this->sites[$host] . '_tags';

            if (method_exists($this, $function_name)) {
                $matches = call_user_func(array($this, $function_name), NULL)->get();
                return array_map(function($match) {
                    return $match->textContent;
                }, $matches);
            } else
                return NULL;
        } else
            return NULL;
    }

    function grab_main_image($url) {

        $this->dom = $this->html5->loadHTML(file_get_contents($url));
        $this->qp = qp($this->dom);
        $host = parse_url($url, PHP_URL_HOST);
        if (array_key_exists($host, $this->sites)) {
            $function_name = $this->sites[$host] . '_image';

            if (method_exists($this, $function_name)) {
                $src = call_user_func(array($this, $function_name), NULL);
                return $src;
            } else
                return NULL;
        } else
            return NULL;
    }

    function observador_pt_tags() {
        return $this->grabTextContent('.tags li');
    }

    function legislativas2015_pt_tags() {
        return $this->grabTextContent('.tags a');
    }

    function observador_pt_image() {
        return $this->getTagAttribute('#main.row img.resrc:first', 'data-src');
    }

    function expresso_sapo_pt_tags() {
        return $this->grabTextContent('.keywordsList li a');
    }

    function publico_pt_tags() {
        return $this->grabTextContent('.tag-list a');
    }

    function dn_pt_tags() {
        return $this->grabTextContent('.tags-p a');
    }

    function jornaldenegocios_pt_tags() {
        return qp($this->dom)->xpath("//a[@class='tags']");
    }
    
    function www_cmjornal_xl_pt_tags() {
        return $this->grabTextContent('.mioloNoticiaFooterItens a');
    }

    function grabTextContent($selector) {
        return qp($this->dom, $selector)->map(function($i, $elem) {
                    return qp($elem)->text();
                });
    }

    function getTagAttribute($selector, $attr_name) {

        $ret = qp($this->dom, $selector)->attr($attr_name);
        return $ret;
    }

}
