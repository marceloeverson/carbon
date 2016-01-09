<?php

namespace Carbon\Type;


class FloatNum extends AbstractNumeric
{
    protected $converter = 'floatval';
    protected $value     = 0.0;
    public static function parse($value)
    {
        if(is_bool($value)){
            $value = ($value)? 1.0 : 0.0 ;
        }
        return new self(floatval($value));
    }
    public function initialize($value)
    {
        if($this->validate(array($value))){
            $this->value = call_user_func($this->converter,$value);
        }
    }
    protected  function validate(array $values)
    {
        $filtered = array_filter($values ,'is_float');
        if(count($filtered) != count($values)){
            throw new \ErrorException("Value not's valid.Only accept float values");
            return false;
        }
        return  count($filtered) == count($values);
    }
}