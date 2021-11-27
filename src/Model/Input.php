<?php

namespace App\Model;

class Input
{
    private $_post;
    private $_get;
    private array $_env;

    public function __construct()
    {
        $this->_post = filter_input_array(INPUT_POST);
        $this->_get = filter_input_array(INPUT_GET);
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
