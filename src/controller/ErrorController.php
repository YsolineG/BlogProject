<?php

namespace BlogProject\src\controller;

class ErrorController extends Controller
{
    public function errorNotFound(): void
    {
        echo 'page non trouvée';
    }

    public function errorServer(): void
    {
        echo 'problème serveur';
    }
}