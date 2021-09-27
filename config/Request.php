<?php

namespace BlogProject\config;

class Request
{
    private $get;
    private $post;
    private $session;

    public function __construct()
    {
        $this->get = new Parameter(filter_input_array(INPUT_GET, $_GET));
        $this->post = new Parameter($_POST);
        $this->session = new Session($_SESSION);
    }

    public function getGet(): Parameter
    {
        return $this->get;
    }

    public function getPost(): Parameter
    {
        return $this->post;
    }

    public function getSession(): Session
    {
        return $this->session;
    }
}