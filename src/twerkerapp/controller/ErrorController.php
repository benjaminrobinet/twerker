<?php
/**
 * Created by PhpStorm.
 * User: benjaminrobinet
 * Date: 16/10/2018
 * Time: 16:15
 */

namespace twerkerapp\controller;


use bfforever\controller\AbstractController;

class ErrorController extends AbstractController
{
    public function notFound(){
        http_response_code(404);
        echo "Not Found";
    }
}