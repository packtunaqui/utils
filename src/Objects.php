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

/**
 * Class Objects
 * @package Tunaqui\Utils
 */
class Objects
{
    /**
     * Extract attributes object in array.
     * @param object|array $object
     * @return array
     */
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

    /**
     * Array attributes to object class ArrayObject.
     * @param array $attributes
     * @return ArrayObject
     */
    public static function fromArray(array $attributes) {
        $object = new ArrayObject();
        foreach ($attributes as $key => $val) {
            $object[$key] = $val;
        }
        return $object;
    }

    /**
     * Undocumented function
     *
     * @param string $content
     * @return void
     */
    public static function fromString(string $content)
    {
        $arr = \json_decode($content, JSON_PRETTY_PRINT);
        $arr = attrToArray($arr);
        return fromArray($arr);
    }
}