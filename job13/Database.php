<?php

class Database
{
    public static function dbConnexion(): PDO
    {
        $host = 'localhost';
        $dbName = 'draft-shop';
        $username = 'anais';
        $password = '';
        $dbConn = new PDO(
            "mysql:host=$host;dbname=$dbName",
            $username,
            $password
        );
        $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConn;
    }
}
