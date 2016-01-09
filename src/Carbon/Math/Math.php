<?php

namespace Carbon\Math;


use Carbon\Type\AbstractNumeric;
use Carbon\Type\FloatNum;
use Carbon\Type\IntNum;

class Math
{
    const E      = 2.718;
    const PI     = 3.1415926535898;
    const LOG_10 = 2.303;
    const LOG_2  =  0.693;

    public static function ceil(float $number):IntNum
    {
        return IntNum::parse(ceil($number));
    }
    public static function floor(float $number):IntNum
    {
        return IntNum::parse(floor($number));
    }
    public static function round(float $number):IntNum
    {
        return IntNum::parse(round($number));
    }

    public static function mod(float $dividend, float $divisor)
    {
        return fmod($dividend,$divisor);
    }
    public static function max(...$values)
    {
      if(is_array($values[0])){
          return max($values[0]);
      }
        return max($values);
    }
    public static function min(...$values)
    {
        if(is_array($values[0])){
            return max($values[0]);
        }
        return max($values);
    }
    public static function  abs($number):AbstractNumeric
    {
        $abs = abs($number);
        if(is_int($abs)){
           return IntNum::parse($abs);
        }
        return FloatNum::parse($abs);
    }
    public static function pow($base , $exp):FloatNum
    {
       return FloatNum::parse(pow($base,$exp));
    }
    public function sqrt($number):FloatNum
    {
        return FloatNum::parse(sqrt($number));
    }
    public static function tan(float $number):FloatNum
    {
        return FloatNum::parse(tan($number));
    }
    public static function  cos(float $number):FloatNum
    {
      return FloatNum::parse(cos($number));
    }
    public static function  sin(float $number):FloatNum
    {
        return FloatNum::parse(sin($number));
    }

}