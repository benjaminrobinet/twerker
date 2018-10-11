<?php
/**
 * Created by PhpStorm.
 * User: benjaminrobinet
 * Date: 19/09/2018
 * Time: 10:04
 */

namespace bfforever\utils;

class ClassLoader
{
    private $prefix;

    public function __construct($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @param $class_name
     */
    private function loadClass($class_name){
        $file = str_replace('\\',DIRECTORY_SEPARATOR, $class_name);
        $file = $this->prefix . DIRECTORY_SEPARATOR . $file . ".php";
        if(file_exists($file)){
            /** @noinspection PhpIncludeInspection */
            require_once($file);
        }
    }

    public function register(){
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if(property_exists($this, $name)){
            return $this->$name;
        } else {
            throw new \Exception("The property " . $name . " doesn't exists");
        }
    }

    /**
     * @param $name
     * @param $value
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        if(property_exists($this, $name)){
            $this->$name = $value;
        } else {
            throw new \Exception("The property " . $name . " doesn't exists");
        }
    }
}