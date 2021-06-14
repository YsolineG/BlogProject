<?php

abstract class Database
{
    const DB_HOST = 'mysql:host=localhost;dbname=blog_project';
    const DB_USER = 'root';

    private $connection;

    private function checkConnection()
    {
         if($this->connection === null) {
             return $this->getConnection();
         }
         return $this->connection;
     }

     private function getConnection()
     {
         try {
             $this->connection = new PDO(self::DB_HOST, self::DB_USER);
             $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             return $this->connection;
         } catch (Exception $errorConnection) {
             die ('Erreur de connexion:' . $errorConnection->getMessage());
         }
     }

     protected function createQuery($sql, $parameters = null)
     {
         if ($parameters) {
             $result = $this->checkConnection()->prepare($sql);
             $result->setFetchMode(PDO::FETCH_CLASS, static::class);
             $result->execute($parameters);
             return $result;
         }
         $result = $this->checkConnection()->query($sql);
         $result->setFetchMode(PDO::FETCH_CLASS, static::class);
         return $result;
     }
}