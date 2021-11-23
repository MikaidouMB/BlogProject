<?php


namespace App\Model;


class PostValue
{
    public static function findPostValue($key, $secondKey = false)
    {
        if ($secondKey == true)
        {
            if (isset($_POST[$key][$secondKey]))
                return $_POST[$key][$secondKey];
        }
        else
        {
            if (isset($_POST[$key]))
                return $_POST[$key];
        }
        return false;
    }
}