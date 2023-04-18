<?php

namespace App\Core;

use PDO;

class Database
{
    /**
     * Stocke l'objet PDO
     */
    private PDO $pdo;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->pdo = $this->getConnetion();
    }

    private function getConnetion()
    {
        $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

        // Tableau d'options pour la connexion PDO
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        // Création de la connexion PDO (création d'un objet PDO)
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
        $pdo->exec('SET NAMES UTF8');
        return $pdo;
    }

    function prepareAndExecute(string $sql, array $values = [])
    {
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute($values);

        return $pdoStatement;
    }

    function getOneResult(string $sql, array $values = [])
    {
        $pdoStatement = $this->prepareAndExecute($sql, $values);
        $result = $pdoStatement->fetch();

        return $result;
    }
    function getAllResults(string $sql, array $values = [])
    {
        $pdoStatement = $this->prepareAndExecute($sql, $values);
        $results = $pdoStatement->fetchAll();

        return $results;
    }

    function getLastInsertID()
    {
        return $this->pdo->lastInsertId();
    }
}
