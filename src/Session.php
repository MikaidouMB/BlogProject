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
    public static function getMessage($key, $secondKey, $thirdKey = false)
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
    public static function setMsg($key, $secondKey, $thirdKey, $fourthKey = false): bool
    {
        if ($secondKey == true && $thirdKey == true && $fourthKey == true) {
            $_SESSION[$key][$secondKey][$thirdKey] = $fourthKey;
        }
            return false;
    }

    public static function destroyMsg()
    {
        unset($_SESSION['newsession']['message']);
    }

    public static function addMsgConn()
    {
        Session::setMsg('newsession','message','connection','Vous êtes connecté');
    }

    public static function addMsgDeco()
    {
        Session::setMsg('newsession','message','deconnection','Vous êtes déconnecté');
    }

    public static function addMsgUpdateUser()
    {
        Session::setMsg('newsession','message','update_user', 'Utilisateur mis à jour');
    }

    public static function addMsgModeration()
    {
        Session::setMsg('newsession','message','moderation', 'Commentaire en attente');
    }

    public static function addMsgValidation()
    {
        Session::setMsg('newsession','message','update_comment', 'Commentaire validé');
    }

    public static function addMsgUpdatePost()
    {
        Session::setMsg('newsession','message','article_update', 'Article modifié');
    }

    public static function addMsgCreatePost()
    {
        Session::setMsg('newsession','message','add', 'Nouvelle article publié');
    }

    public static function set($key, $value)
    {
        if ($key == true && $value == true)
        {
            $_SESSION[$key] = $value;
        }
    }

    public static function getSessionValue($key, $secondKey = false)
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

    public static function destroySession()
    {
        unset($_SESSION['newsession']);
    }
}