<?php
/**
 * Created by PhpStorm.
 * User: everson
 * Date: 13/12/15
 * Time: 21:34
 */

namespace Carbon\Type;


class IntNum extends AbstractNumeric
{
    protected $converter = 'intval';
    public static function parse($value)
    {
        if(is_bool($value)){
            $value = ($value)? 1 : 0 ;
        }
        return new self(intval($value));
    }
    public function initialize($value)
    {
        if($this->validate(array($value))){
            $this->value = call_user_func($this->converter,$value);
        }
    }
    protected  function validate(array $values)
    {
        $filtered = array_filter($values ,'is_int');

        if(count($filtered) != count($values)){
            throw new \ErrorException("Value not's valid.Only accept int values");
            return false;
        }
        return  count($filtered) == count($values);
    }


}