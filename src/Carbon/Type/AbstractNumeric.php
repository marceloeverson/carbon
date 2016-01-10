<?php

namespace Carbon\Type;

use Carbon\Type\Object\AbstractPrototype;

abstract class AbstractNumeric extends AbstractPrototype implements ParsableInterface
{
    protected $value   = 0;
    protected $converter;
    public    $prototype ;

    abstract public function initialize($value);
    abstract protected function validate(array $values);

    public function __construct($value)
    {
        $this->prototype = $this;
        $this->initialize($value);
    }
    public function __call($name , $args)
    {
       return $this->callMethod($name,$args,$this);
    }
    public function __set($name , $value)
    {
       $this->set($name,$value);
    }
    public function __get($name)
    {
     return $this->get($name);
    }
    public function valueOf()
    {
        return $this->value;
    }
    public function __toString()
    {
        return strval($this->value);
    }
    public function getType()
    {
        return (is_int($this->value))? Type::INT_NUM : Type::FLOAT_NUM;
    }
}