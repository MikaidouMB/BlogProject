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

    public static function addMsgConn()
    {
        $_SESSION['newsession']['message']['connection'] ='Vous êtes connecté';
    }

    public static function addMsgDeco()
    {
        $_SESSION['newsession']['message']['deconnection'] ='Vous êtes deconnecté';
    }

    public static function addMsgUpdateUser()
    {
        $_SESSION['newsession']['message']['update_user'] = "Utilisateur mis à jour";
    }

    public static function addMsgModeration()
    {
        $_SESSION['newsession']['message']['moderation'] = "Commentaire en attente";
    }

    public static function addMsgValidation()
    {
        $_SESSION['newsession']['message']['update_comment'] = "Commentaire validé";
    }

    public static function addMsgUpdatePost()
    {
        $_SESSION['newsession']['message']['article_update'] = "Article modifié";
    }

    public static function addMsgCreatePost()
    {
        $_SESSION['newsession']['message']['add'] = "Nouvelle article publié";
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $secondKey = false, $thirdKey = false)
    {
        if ($secondKey == true && $thirdKey == true)
        {
            if (isset($_SESSION[$key][$secondKey][$thirdKey]))
                return $_SESSION[$key][$secondKey][$thirdKey];
        }
        else
        {
            if (isset($_SESSION[$key]))
                return $_SESSION[$key];
        }
         return false;
    }
    public static function destroyMsg()
    {
        unset($_SESSION['newsession']['message']);
    }

    public static function destroySession()
    {
        unset($_SESSION['newsession']);
    }
}