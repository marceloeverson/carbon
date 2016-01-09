<?php
/**
 * Created by PhpStorm.
 * User: everson
 * Date: 03/01/16
 * Time: 16:31
 */

namespace Carbon\Type;


use Carbon\Type\Object\AbstractPrototype;

class Object extends AbstractPrototype
{
    public function __construct()
    {
        $this->prototype = $this;
    }
    public function create($proto)
    {
      $newObject = new self();

      if(is_array($proto)){
          $newObject->prototypes = $proto;
      }
      elseif($proto instanceof AbstractPrototype){
          $newObject = new self();
          $newObject->prototypes = $proto->prototypes;
      }
      elseif($proto instanceof \ArrayObject || $proto instanceof \stdClass){
          $newObject = new self();
          $newObject->prototypes = get_object_vars($proto);
      }
      return $newObject;
    }
    public function __call($name, $args)
    {
        return $this->callMethod($name , $args , $this);
    }
    public function __get($name)
    {
       return $this->get($name);
    }
    public function __set($name, $value)
    {
      $this->set($name , $value);
    }
}