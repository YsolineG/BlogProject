<?php

class Database
{
    const DB_HOST = 'mysql:host=localhost;dbname=blog_project';
    const DB_USER = 'root';

    public function getConnection()
    {
        try {
            $connection = new PDO(self::DB_HOST, self::DB_USER);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        } 
        catch (Exception $errorConnection)
        {
            die ('Erreur de connexion:'.$errorConnection->getMessage());
        }
    }
}