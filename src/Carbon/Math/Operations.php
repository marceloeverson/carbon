<?php
/**
 * Created by PhpStorm.
 * User: everson
 * Date: 09/01/16
 * Time: 21:43
 */

namespace Carbon\Math;


final class Operations
{
    protected function __construct(){}
    public static function add(...$values)
    {
        $sum = 0;
        $sum += array_sum($values);
        return $sum;
    }

    public static function mul(...$values)
    {
        $mul = 1;
        $mul *= array_product($values);
        return $mul;
    }
    public static function sub(...$values)
    {
        $sub = 0;
        $size = count($values);
        for($i=0; $i<$size; $i++){
            if($i==0){
                $sub = $values[0];
                continue;
            }
            $sub -= $values[$i];
        }
        return $sub;
    }

    public static function div(...$values)
    {
        $div = 0;
        $size = count($values);
        for($i=0; $i<$size; $i++){
            if($i==0){
                $div = $values[0];
                continue;
            }
            if($values[$i]!=0){
                $div /= $values[$i];
                continue;
            }
            throw new \ErrorException("Division by zero.Value in index $i not's accept");
            break;
        }
        return $div;
    }
}