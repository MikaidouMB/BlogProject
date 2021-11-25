<?php


namespace App\Model;

class PostValue
{
    public static function findPostValue($key, $secondKey = false)
    {
        if ($secondKey == true)
        {
            if (isset(filter_input_array(INPUT_POST)[$key][$secondKey]))
                return filter_input_array(INPUT_POST)[$key][$secondKey];
        }
        else
        {
            if (isset(filter_input_array(INPUT_POST)[$key]))
                return filter_input_array(INPUT_POST)[$key];
        }
        return false;
    }
}