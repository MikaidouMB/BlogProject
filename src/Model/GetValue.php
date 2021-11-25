<?php


namespace App\Model;


class GetValue
{
    public static function findGetValue($key, $secondKey = false)
    {
        if ($secondKey == true)
        {
            if (isset(filter_input_array(INPUT_GET)[$key][$secondKey]))
                return filter_input_array(INPUT_GET)[$key][$secondKey];
        }
        else
        {
            if (isset(filter_input_array(INPUT_GET)[$key]))
                return filter_input_array(INPUT_GET)[$key];
        }
        return false;
    }
    public static function exitMessage()
    {
        exit();
    }
}