<?php
/**
 * Created by PhpStorm.
 * User: everson
 * Date: 13/12/15
 * Time: 21:33
 */

namespace Carbon\Type;


class Num extends AbstractNumeric
{
    public static function parse($value)
    {
        if(is_bool($value)){
            $value = ($value)? 1 : 0 ;
        }
        return new self((intval($value) < floatval($value))? floatval($value) : intval($value));

    }

    public function initialize($value)
    {
        $this->converter = function($value){
           return (intval($value) < floatval($value))? floatval($value) : intval($value);
        };
        if($this->validate(array($value))){
           $this->value = call_user_func($this->converter,$value);
        }

    }
    protected  function validate(array $values)
    {
        $filtered = array_filter($values ,function($value){
            return !is_string($value) && is_numeric($value);
        });
        if(count($filtered) != count($values)){
            throw new \ErrorException("Value not's valid.Only accept numeric values");
            return false;
        }
        return  count($filtered) == count($values);
    }

}