<?php
namespace App;

class Session
{
    private static bool $_sessionStarted = false;

    public static function start()
    {
        if (self::$_sessionStarted == false) {
            session_start();
            self::$_sessionStarted = true;
        }
    }

    public static function getMessage($key, $secondKey, $thirdKey = false)
    {
        if ($secondKey == true && $thirdKey == true) {
            if (isset($_SESSION[$key][$secondKey][$thirdKey])) {
                return $_SESSION[$key][$secondKey][$thirdKey];
            }
        }
        if (isset($_SESSION[$key])) {
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
        Session::setMsg('newsession', 'message', 'connection', 'Vous êtes connecté');
    }

    public static function addMsgDeco()
    {
        Session::setMsg('newsession', 'message', 'deconnection', 'Vous êtes déconnecté');
    }

    public static function addMsgField()
    {
        Session::setMsg('newsession', 'message', 'errorField', 'Veuillez remplir tous les champs');
    }

    public static function addMsgUpdateUser()
    {
        Session::setMsg('newsession', 'message', 'update_user', 'Utilisateur mis à jour');
    }

    public static function addMsgModeration()
    {
        Session::setMsg('newsession', 'message', 'moderation', 'Commentaire en attente');
    }

    public static function addMsgValidation()
    {
        Session::setMsg('newsession', 'message', 'update_comment', 'Commentaire validé');
    }

    public static function addMsgUpdatePost()
    {
        Session::setMsg('newsession', 'message', 'article_update', 'Article modifié');
    }

    public static function addMsgCreatePost()
    {
        Session::setMsg('newsession', 'message', 'add', 'Nouvelle article publié');
    }

    public static function set($key, $value)
    {
        if ($key == true && $value == true) {
            $_SESSION['token'] = md5(bin2hex(openssl_random_pseudo_bytes(6)));
            $_SESSION[$key] = $value;
        }
    }

    public static function getToken($key, $secondKey = false)
    {
        if ($secondKey == true) {
            if (isset($_SESSION[$key][$secondKey]['token'])) {
                return $_SESSION[$key][$secondKey]['token'];
            }
        }
    }

    public static function setSession($value): array
    {
        if ($value == true) {
            return $_SESSION;
        }
    }

    public static function getSessionValue($key, $secondKey = false)
    {
        if ($secondKey == true) {
            if (isset($_SESSION[$key][$secondKey])) {
                return $_SESSION[$key][$secondKey];
            }
        }
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }

    public static function destroySession()
    {
        unset($_SESSION['newsession']);
        unset($_SESSION['token']);
    }
}