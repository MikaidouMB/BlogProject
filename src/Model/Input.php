<?php

namespace App\Model;

class Input
{
    private $_post;
    private $_get;
    //private $_session;
    private $_server;
    private $_env;

    public function __construct()
    {
        $this->_post = $_POST;
        $this->_get = $_GET;
        //$this->_session;
        $this->_server = $_SERVER;
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

   /* public function setSession($key)
    {
        if ($key == true){
            return $this->checkGlobal($this->_session, $key);
        }
    }
*/
    public function getServer($key = null, $default = null)
    {
        return $this->checkGlobal($this->_server, $key, $default);
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
            } else {
                return $default ?: null;
            }
        }
        return $global;
    }
}
