<?php

namespace BlogProject\config;

class Session
{
    private $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function set($name, $value): void
    {
        $_SESSION[$name] = $value;
    }

    public function get($name)
    {
        if(isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }

    public function show($name)
    {
        if(isset($_SESSION[$name]))
        {
            $key = $this->get($name);
            $this->remove($name);
            return $key;
        }
    }

    public function remove($name): void
    {
        unset($_SESSION[$name]);
    }

    public function stop(): void
    {
        session_destroy();
    }

    public function start(): void
    {
        session_start();
    }
}