<?php
/**
 * Created by PhpStorm.
 * User: everson
 * Date: 13/12/15
 * Time: 21:53
 */

namespace Carbon\Type;


use Carbon\Type\Object\AbstractPrototype;

class Char extends AbstractPrototype implements ParsableInterface
{

    protected $value;

    public function __construct($value)
    {
       if($this->validate($value)){
           $this->value = $value;
           return $this;
       }
       throw new \InvalidArgumentException("Value passed not's a char");
    }
    public function validate($value)
    {
        return is_string($value) && strlen($value) == 1;
    }
    public static function parse($value)
    {
        if(is_numeric($value)){
            return new self(chr(intval($value)));
        }
        if(is_string($value)){
            return new self(substr($value ,0 , 1));
        }
        throw new \InvalidArgumentException("The value passed not's parsable");
    }

    public function __call($name, $args)
    {
       $this->callMethod($name,$args,$this);
    }

    public function __get($name)
    {
       return $this->get($name);
    }

    public function __set($name, $value)
    {
        $this->set($name , $value);
    }
    public static function fromCharCode($code)
    {
           return self::parse(chr(intval($code)));
    }
    public function charCode()
    {
        return ord($this->value);
    }
    public function valueOf()
    {
        return $this->value;
    }
    public function equals($compare)
    {
        return $this->value === $compare;
    }
    public function __toString()
    {
        return strval($this->value);
    }
}