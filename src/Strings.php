<?php
/**
 *  Author     : EstevanTn
 *  Email      : tunaqui@outlook.es
 *  Repository : https://github.com/EstevanTn
 *
 *  This file Strings.phpp is part of the Utils project.
 *  Created at: 2018/01/11
 **/

namespace Tunaqui\Utils;


class Strings
{
    public static function placeholder($string, ...$args) {
        $args = array_slice(func_get_args(), 1);
        if(func_num_args()==2) {
            if (is_object($args[0])) {
                $args = get_object_vars($args[0]);
            } else if(is_array($args[0])) {
                $args = $args[0];
            } else {
                $args = [$args[0]];
            }
        }
        foreach ($args as $key => $value){
            $string = str_replace("{".strtoupper($key)."}", $value, $string);
        }
        return $string;
    }

}