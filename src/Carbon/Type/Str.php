<?php
namespace Carbon\Type;
use Carbon\Type\Object\AbstractPrototype;

class Str extends AbstractPrototype
{
    const CASE_SENSITIVE   = 1;
    const CASE_INSENSITIVE = 2;
    private $string = '';
    public  $prototype;

    public function __construct($string)
    {
        $this->string = $string;
        $this->prototype = $this;
    }
    protected function getObjPrototype()
    {
        return clone $this;
    }
    public function __call($name,$args)
    {
        return $this->callMethod($name,$args,$this);
    }
    public static function parse($value)
    {
        if(is_array($value)){
            $value = implode(' ',$value);
        }
        return new self(strval($value));
    }
    public function indexOf($value , $index = 0 )
    {
        $pos = strpos($this->string,$value,$index);
         return (is_bool($pos))? -1 : $pos;
    }
    public function charAt($index)
    {
        if(isset($this->string{$index})){
            return Char::parse($this->string{$index});
        }
        return '';
    }
    public function charCodeAt($index)
    {
       $char = $this->charAt($index);
        if($char instanceof Char){
            return $char->charCode();
        }
        return '';
    }
    public function lastIndexOf($value , $index = 0 )
    {
        $pos = strrpos($this->string,$value,$index);
        return (is_bool($pos))? -1 : $pos;
    }
    public function search($search)
    {
        if($this->isRegex($search)){
            if(preg_match($search,$this->string,$match)){
                return strpos($this->string,$match[0]);
            }
            return -1;
        }
        if(preg_match(sprintf('/%s/',preg_quote($search,'/')),$this->string,$match)){
            return strpos($this->string,$match[0]);
        }
        return  -1;

    }
    public function equals($value,$strict=true)
    {
        return ($strict===true)? $this->string === $value : $this->string == $value;
    }
    public function compare($value,$sensibility = self::CASE_SENSITIVE)
    {
        return ($sensibility==self::CASE_SENSITIVE)?
             strcmp($this->string,$value) : strcasecmp($this->string,$value);
    }
    public function substrCount($search)
    {
        return substr_count($this->string , $search);
    }
    public function format($value)
    {
        $proto = $this->getObjPrototype();
        $values = func_get_args();
        if(is_array($values[0])){
          $proto->string = vsprintf($this->string , $values[0]);
          return $proto;
        }
        $proto->string = vsprintf($this->string , $values);
        return $proto;
    }
    public function replace($subStr , $replace = null,$limit = -1)
    {
        $proto = $this->getObjPrototype();
        if(is_array($subStr)){
            if(is_null($replace)) {
                $proto->string = strtr($this->string, $subStr);
            }
            if(is_string($replace) || is_array($replace)){
                $proto->string = str_replace($subStr,$replace,$this->string);
            }
            return $proto;
        }
        if($this->isRegex($subStr) && !is_null($replace)){
            if(is_callable($replace)){
                $proto->string = preg_replace_callback($subStr,$replace,$this->string,$limit);
            }
            if(is_string($replace)){
                $proto->string = preg_replace($subStr,$replace,$this->string,$limit);
            }
           return $proto;
        }

        return $proto;
    }
    public function split($delimiter , $limit = null)
    {
        if(is_int($delimiter)){
            return str_split($this->string , $delimiter);
        }
        if($this->isRegex($delimiter)){
            $limit = is_int($limit)? $limit : -1;
            return preg_split($delimiter,$this->string,$limit,PREG_SPLIT_NO_EMPTY);
        }
        return array_filter(explode($delimiter,$this->string,$limit),function($item){
            return !empty($item);
        });
    }
    public function arrayChar()
    {
        return str_split($this->string , 1);
    }

    public static function fromCharCode($number)
    {
        if(func_num_args() > 1){
            $numbers = array_filter(func_get_args(),'is_int');
            if(count($numbers) == func_num_args()){
                return self::parse( implode('',array_map(function($num){
                       return chr($num);
                     },$numbers))
                );
            }
            throw new \InvalidArgumentException("A value not's valid.Only accept int values");
            return false;
        }
        if(is_int($number)){
            return self::parse(chr($number));
        }
        throw new \InvalidArgumentException("A value not's valid.Only accept int values");
        return false;

    }
    public function  trim()
    {
        $proto = $this->getObjPrototype();
        $proto->string = trim($this->string);
        return $proto;
    }
    public function  trimLeft()
    {
        $proto = $this->getObjPrototype();
        $proto->string = ltrim($this->string);
        return $proto;
    }
    public function  trimRight()
    {
        $proto = $this->getObjPrototype();
        $proto->string = rtrim($this->string);
        return $proto;
    }
    public function  length()
    {
        return strlen($this->string);
    }
    public function prepend($str)
    {
        $this->string = sprintf('%s%s', $str , $this->string );
        return $this;
    }
    public function append($str)
    {
        $this->string = sprintf('%s%s',$this->string , $str);
        return $this;
    }
    public function match($regex)
    {
        preg_match($regex,$this->string,$matches);
        return $matches;
    }
    public function capitalize()
    {
        $proto = $this->getObjPrototype();
        $proto->string = ucfirst($this->string);
        return $proto;
    }
    public function strip($chars)
    {
        $proto = $this->getObjPrototype();
        $proto->string = str_replace($chars,'',$this->string);
        return $proto;
    }
    public function shuffle()
    {
        $proto = $this->getObjPrototype();
        $proto->string = str_shuffle($this->string);
        return $proto;
    }
    public  function  repeat($count)
    {
        $proto = $this->getObjPrototype();
        $proto->string = str_repeat($this->string , $count);
        return $proto;
    }
    public function slice($start = 0 , $end = null)
    {
        $proto = $this->getObjPrototype();
        $proto->string =  substr($this->string,$start,$end);
        return $proto;
    }
    public function startsWith($search,$sensibility = self::CASE_SENSITIVE)
    {
        $pattern = ($sensibility == self::CASE_INSENSITIVE)? "/^%s/i" : "/^%s/" ;
        return preg_match(sprintf($pattern,preg_quote($search,'/')),$this->string);
    }
    public function endsWith($search,$sensibility = self::CASE_SENSITIVE)
    {
        $pattern = ($sensibility == self::CASE_INSENSITIVE)? "/%s$/i" : "/%s$/" ;
        return preg_match(sprintf($pattern , preg_quote($search,'/')),$this->string);
    }
    public  function valueOf()
    {
        return $this->string;
    }
    public function upper()
    {
        $proto = $this->getObjPrototype();
        $proto->string =  mb_strtoupper($this->string,'utf8');
        return $proto;
    }
    public function lower()
    {
        $proto = $this->getObjPrototype();
        $proto->string =  mb_strtolower($this->string,'utf8');
        return $proto;
    }
    private function isRegex($value)
    {
        $str = $this->parse($value);
        return $str->startsWith('/') && $str->endsWith('/');
    }
    public  function __toString()
    {
        return $this->string;
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