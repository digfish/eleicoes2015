<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use \Eventviva\ImageResize;

/**
 * Description of NoticiaScrapper
 *
 * @author fc22273
 */
class NoticiaScrapper {

    var $apiCaller;
    var $url;

    function __construct($url) {
        $this->apiCaller = new ApiCaller();
        $this->url = $url;
    }

    function resolveUrl() {
        $resolver = new URLResolver();
        $resolved_url = $resolver->resolveURL($this->url)->getURL();
        return $resolved_url;
    }

    function grabTags() {
        $tags = $this->apiCaller->fetchTagsApi($this->url);
        return $tags;
    }

    function grabMainImage() {

        $grabber = new NewsSourceTagsGrabber();
        $mainImageUrl = $grabber->grab_main_image($this->url);
        

        if (empty($mainImageUrl)) {
            $mainImageUrl = $this->apiCaller->extractMainImage($this->url);
            
            if (empty($mainImageUrl)) {
                return NULL;
            }
        }

        $image = file_get_contents($mainImageUrl);

        // clears all the url contents after the query string
        $url_wo_query = preg_split('/\?/', $mainImageUrl)[0];

        $tokens = preg_split('/\./', $url_wo_query);

        $extension = $tokens[count($tokens) - 1];


        $filename = "image_" . md5(uniqid()) . ".$extension";


        $filepath = public_path() . '/noticias_pictures/' . $filename;

        /* if (File::isWritable($filepath) == FALSE) {
          return NULL;
          } */

        $bytesWritten = File::put($filepath, $image);

        if ($bytesWritten == 0) {
            return NULL;
        }

        $resizer = new ImageResize($filepath);
        $resizer->resizeToHeight(350);

        $file_info = pathinfo($filepath);

        $imagefile_ext = $file_info['extension'];

        $filepath_no_ext = 'noticias_pictures/' . basename($filepath, $extension);

        $resizer->save($filepath_no_ext . "thumb.350h." . $imagefile_ext);

        $resizer->resizeToWidth(360);
        $resizer->save($filepath_no_ext . "thumb.360w." . $imagefile_ext);

        return $filename;
    }

    function grabTextContents() {
        $text = $this->apiCaller->extractText($this->url);
        return $text;
    }
    
    
    function grabTitle() {
        $title = $this->apiCaller->getTitle($this->url);
        return $title;
    }

}
