<?php

namespace BlogProject\src\controller;

class ErrorController extends Controller
{
    public function errorNotFound()
    {
        echo 'page non trouvée';
    }

    public function errorServer()
    {
        echo 'problème serveur';
    }
}