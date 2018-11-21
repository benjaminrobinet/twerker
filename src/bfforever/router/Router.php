<?php

namespace bfforever\router;

use bfforever\auth\Authentication;
use bfforever\auth\AuthenticationException;

class Router extends AbstractRouter
{
    public function run()
    {
        $controllersNS = "\\twerkerapp\controller";
        $reqUrl = $this->http_req->path_info;

        if(array_key_exists($reqUrl, self::$routes)){
            try {
                $authentication = new Authentication();
                if($authentication->checkAccessRight(self::$routes[$reqUrl]['requiredLevel'])){
                    $controllerName = self::$routes[$reqUrl]['controller'];
                    $methodName = self::$routes[$reqUrl]['method'];
                } else {
                    $defaultRoute = self::$routes[self::$aliases['default']];
                    $controllerName = $defaultRoute['controller'];
                    $methodName = $defaultRoute['method'];
                }
            } catch (AuthenticationException $e) {
                die($e->getMessage());
            }
        } else {
            $defaultRoute = self::$routes[self::$aliases['default']];
            $controllerName = $defaultRoute['controller'];
            $methodName = $defaultRoute['method'];
        }

        $_controller = "$controllersNS\\$controllerName";
        $_controller = new $_controller();
        $_controller->$methodName();
    }

    /**
     * @param $alias
     * @throws \Exception
     */
    public static function executeRoute($alias)
    {
        $controllersNS = "\\twerkerapp\controller";

        $route = self::$routes[$alias];
        $controller = $route['controller'];
        $method = $route['method'];

        $_controller = "$controllersNS\\$controller";
        $_controller = new $_controller();
        $_controller->$method();
    }

    /*
    * Méthode urlFor : retourne l'URL d'une route depuis son alias
    *
    * Paramètres :
    *
    * - $route_name (String) : alias de la route
    * - $param_list (Array) optionnel : la liste des paramètres si l'URL prend
    *          de paramètre GET. Chaque paramètre est représenté sous la forme
    *          d'un tableau avec 2 entrées : le nom du paramètre et sa valeur
    *
    * Algorthme:
    *
    * - Depuis le nom du scripte et l'URL stocké dans self::$routes construire
    *   l'URL complète
    * - Si $param_list n'est pas vide
    *      - Ajouter les paramètres GET a l'URL complète
    * - retourner l'URL
    *
    */

    public function urlFor($route_name, $param_list = [])
    {
        $prefix = $this->http_req->prefix . basename($this->http_req->script_name);
        $path = self::$aliases[$route_name];

        if($param_list){
            $query = '?';
            foreach ($param_list as $param){
                $query .= $param[0] . '=' . $param[1] . '&';
            }
            $query = rtrim($query, "&");
        } else {
            return "$prefix$path";
        }

        return "$prefix$path$query";
    }

    public function setDefaultRoute($url)
    {
        self::$aliases['default'] = $url;
    }

    public function addRoute($name, $url, $ctrl, $mth, $requiredLevel)
    {
        self::$routes[$url] = ['controller' => $ctrl, 'method' => $mth, 'requiredLevel' => $requiredLevel];
        self::$aliases[$name] = $url;
    }
}