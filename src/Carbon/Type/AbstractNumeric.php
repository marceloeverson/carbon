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
    public function add(...$values)
    {
        if($this->validate($values)) {
            $this->value += call_user_func($this->converter, array_sum($values));

        }
        return $this;
    }

    public function mul(...$values)
    {
        if($this->validate($values)) {
            $this->value *= call_user_func($this->converter, array_product($values));

        }
        return $this;
    }

    public function sub(...$values)
    {
        if($this->validate($values)) {
            array_walk($values, function ($num) {
                $this->value -= call_user_func($this->converter, $num);
            });

        }
        return $this;

    }

    public function div(...$values)
    {
        if($this->validate($values)) {
            array_walk($values, function ($num, $index) {
                if (intval($num) != 0) {
                    $this->value /= call_user_func($this->converter, $num);
                    $this->value  = call_user_func($this->converter, $this->value);
                    return $this->value;
                }
                throw new \ErrorException("Division by zero.Value in index $index not's accept");
            });

        }
        return $this;

    }
    public function valueOf()
    {
        return $this->value;
    }
    public function __toString()
    {
        return strval($this->value);
    }
}