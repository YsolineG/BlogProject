<?php

namespace BlogProject\src\DAO;

use PDO;
use Exception;

abstract class Database
{
    private $connection;

    private function checkConnection(): PDO
    {
         if($this->connection === null) {
             return $this->getConnection();
         }
         return $this->connection;
     }

     private function getConnection(): PDO
     {
         try {
             $this->connection = new PDO(DB_HOST, DB_USER);
             $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             return $this->connection;
         } catch (Exception $errorConnection) {
             die ('Erreur de connexion:' . $errorConnection->getMessage());
         }
     }

     protected function createQuery($sql, array $parameters = [])
     {
         if ($parameters) {
             $result = $this->checkConnection()->prepare($sql);
             $result->execute($parameters);
             return $result;
         }
         $result = $this->checkConnection()->query($sql);
         return $result;
     }
}