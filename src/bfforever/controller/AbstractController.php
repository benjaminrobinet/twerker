<?php

namespace bfforever\controller;

abstract class AbstractController {

    /* Attribut pour stocker l'objet HttpRequest */
    protected $request=null;

    /*
     * Constructeur :
     *
     * Créé une instance de la classe HttpRequest et la stocke dans l'attribut
     *    $request
     *
     */

    public function forward($controller, $action){
        $caller = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1)[0];
        $caller = new \ReflectionClass(get_class($caller['object']));
        $path = $caller->getNamespaceName() . '\\' . $controller;
        $callable = new $path;
        $callable->$action();
    }

    public function __construct(){
        $this->request = new \bfforever\utils\HttpRequest() ;
    }

}


