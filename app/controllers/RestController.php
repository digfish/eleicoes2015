<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RestController
 *
 * @author fc22273
 */
class RestController extends BaseController {
    
    public function formatResponse($results) {
        
        $format = 'json';
        if (Request::header('Accept') == 'application/xml') {
            $format = 'xml';
        }
        
         if ($format == 'xml') {
            return Response::xml($results);
        } else {
            return Util::prettyJson($results);
        }
    }
    
}
