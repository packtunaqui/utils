<?php
/**
 *  Author     : EstevanTn
 *  Email      : tunaqui@outlook.es
 *  Repository : https://github.com/EstevanTn
 *
 *  This file Objects.php is part of the Utils project.
 *  Created at: 2018/01/13
 **/

namespace Tunaqui\Utils;


use Tunaqui\Utils\Arrays\ArrayObject;

class Objects
{
    public static function attrToArray($object){
        if(is_array($object) || is_object($object)) {
            $result = [];
            foreach ($object as $key => $value) {
                $result[$key] = self::attrToArray($value);
            }
            return $result;
        }
        return $object;
    }

    public static function fromArray(array $attributes) {
        $object = new ArrayObject();
        foreach ($attributes as $key => $val) {
            $object[$key] = $val;
        }
        return $object;
    }
}