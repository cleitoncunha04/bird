<?php
namespace Cleitoncunha\Bird\Model;

use PDO;

class ConnectionFactory
{
    public static function getConnection(): PDO
    {
        $pdo = new PDO('mysql:host=localhost;dbname=bird', 'root', 'root');

        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}