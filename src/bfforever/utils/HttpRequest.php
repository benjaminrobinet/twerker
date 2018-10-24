<?php
/**
 * Created by PhpStorm.
 * User: benjaminrobinet
 * Date: 03/10/2018
 * Time: 10:37
 */

namespace bfforever\utils;

class HttpRequest extends AbstractHttpRequest
{
    public function __construct()
    {
        $this->script_name = $_SERVER['SCRIPT_FILENAME']; //Nom du script
        if(isset($_SERVER['PATH_INFO']))
            $this->path_info = $_SERVER['PATH_INFO']; //Décalarer le path_info s'il exisite sinon null
        $this->root = $_SERVER['DOCUMENT_ROOT'];
        $this->method = $_SERVER['REQUEST_METHOD']; //Methode de la requête
        $this->get = $_GET;
        $this->post = $_POST;
        $this->prefix = rtrim($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_NAME']));
    }
}