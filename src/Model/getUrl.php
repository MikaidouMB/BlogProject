<?php


namespace App\Model;


class getUrl
{
    public static function getRoute($key, $secondKey = false)
    {
        if ($secondKey == true)
        {
            if (isset($_GET[$key][$secondKey]))
                return $_GET[$key][$secondKey];
        }
        else
        {
            if (isset($_GET[$key]))
                return $_GET[$key];
        }
        return false;
    }
}