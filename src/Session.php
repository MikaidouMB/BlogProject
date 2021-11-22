<?php


namespace App;


class Session {

    private static bool $_sessionStarted = false;

    public static function start()
    {
        if (self::$_sessionStarted == false)
        {
            session_start();
            self::$_sessionStarted = true;
        }
    }

    public static function destroy(){
            unset($_SESSION['newsession']) ;
    }
    public static function unsetMessage($message)
    {
        if (isset($_SESSION['newsession']['message'])){
            unset($_SESSION['newsession']['message']);
        }
    }
    public static function addMessage()
    {
        $_SESSION['newsession']['deconnection'] ='Vous êtes deconnecté';
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $secondKey = false)
    {
        if ($secondKey == true)
        {
            if (isset($_SESSION[$key][$secondKey]))
                return $_SESSION[$key][$secondKey];
        }
        else
        {
            if (isset($_SESSION[$key]))
                return $_SESSION[$key];
        }
         return false;
    }

    public static function display()
    {
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }


}