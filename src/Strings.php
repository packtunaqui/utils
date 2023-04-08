<?php
/**
 *  Author     : EstevanTn
 *  Email      : tunaqui@outlook.es
 *  Repository : https://github.com/EstevanTn
 *
 *  This file Strings.phpp is part of the Utils project.
 *  Created at: 2018/01/11
 *  Updated at: 2023/04/08
 **/

namespace Tunaqui\Utils;


class Strings
{
    /**
     * Format a string using wildcards
     * @param string $string
     * @param mixed $args
     */
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

    /**
     * Format friendly strings
     * @param string $string
     */
    public static function slug($string) {
        $characters = array(
            "Á" => "A", "Ç" => "c", "É" => "e", "Í" => "i", "Ñ" => "n", "Ó" => "o", "Ú" => "u",
            "á" => "a", "ç" => "c", "é" => "e", "í" => "i", "ñ" => "n", "ó" => "o", "ú" => "u",
            "à" => "a", "è" => "e", "ì" => "i", "ò" => "o", "ù" => "u"
        );

        $string = strtr($string, $characters);
        $string = strtolower(trim($string));
        $string = preg_replace("/[^a-z0-9-]/", "-", $string);
        $string = preg_replace("/-+/", "-", $string);

        if(substr($string, strlen($string) - 1, strlen($string)) === "-") {
            $string = substr($string, 0, strlen($string) - 1);
        }

        return $string;
    }

    /**
     * Generate a random string
     * @param int $length
     */
    public static function random($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
