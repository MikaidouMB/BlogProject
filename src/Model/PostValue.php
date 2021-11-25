<?php


namespace App\Model;


class PostValue
{
    private $_POST;

    public function get_POST ($key  = null)
    {
        if (null !==  $key)  {
            return (isset ($this ->_POST["$key"])) ? $this -> _POST ["$key"]  :  null ;
        } else {
            return $this->_POST;
        }
    }
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