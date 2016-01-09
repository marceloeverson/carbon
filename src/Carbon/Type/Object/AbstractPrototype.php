<?php

namespace Carbon\Type\Object;

abstract class AbstractPrototype
{
    protected $prototypes = array();
    public $prototype;
    abstract public function __call($name , $args);
    abstract public function __get($name);
    abstract public function __set($name , $value);

    final protected function set($name , $value)
    {
       $this->prototypes[$name] = $value;
    }
    final protected function get($name)
    {
        if(array_key_exists($name , $this->prototypes)){
            return $this->prototypes[$name];
        }
        throw new \ErrorException("The prototype $name not found");
    }
    final protected function callMethod($name , $args , $scope)
    {
        if(is_callable($this->prototypes[$name])){
            $method = \Closure::bind($this->prototypes[$name],$scope);
            return call_user_func_array($method,$args);
        }
        throw new \ErrorException("The method $name not found");
    }

}