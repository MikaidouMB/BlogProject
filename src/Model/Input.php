<?php

namespace App\Model;

class Input
{
    private $_post;
    private $_get;
    private $_env;

    public function __construct()
    {
        $this->_post = $_POST;
        $this->_get = $_GET;
        $this->_env = $_ENV;
    }

    public function post($key = null, $default = null)
    {
        return $this->checkGlobal($this->_post, $key, $default);
    }

    public function get($key = null, $default = null)
    {
        return $this->checkGlobal($this->_get, $key, $default);
    }

    public function getEnv($key = null, $default = null)
    {
        return $this->checkGlobal($this->_env, $key, $default);
    }

    public static function exitMessage()
    {
        exit();
    }

    private function checkGlobal($global, $key = null, $default = null)
    {
        if ($key) {
            if (isset($global[$key])) {
                return $global[$key];
            }
                return $default ?: null;
            }

        return $global;
    }
}
