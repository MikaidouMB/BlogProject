<?php


namespace App\services;


class Session
{
    public function set(string $string, string $string1)
    {
        if (!isset($_SESSION['count'])) {
            $_SESSION['count'] = 0;
        } else {
            $_SESSION['count']++;
        }
    }


}