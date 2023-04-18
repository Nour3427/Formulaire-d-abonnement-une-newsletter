<?php
use App\Model\SubscriberModel;

require 'config.php';
require("src/Core/Database.php");
require("src/Core/AbstractModel.php");
require("src/Model/SubscriberModel.php");


$filename = $argv[1];
$i = 0;


/**
 * On vérifie que le fichier existe bien. S'il n'existe pas on affiche simplement un message d'erreur
 */
if (!file_exists($filename)) {
    echo "Erreur : fichier '$filename' introuvable";
    exit; // On arrête l'exécution du script
}

/**
 * Si on arrive là c'est que le fichier existe bien, on va l'ouvrir en lecture
 * grâce à la fonction fopen()
 */
$file = fopen($filename, "r");

$subscriberModel = new SubscriberModel();
/**  s
 * On se connecte à la base de données avec PDO et on prépare la requête d'insertion
 */
// $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASSWORD);
// $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// $pdoStatement = $pdo->prepare('INSERT INTO subscribers (firstname, lastname, email, created) VALUES (?,?,?,?)');

/**
 * Ensuite on va lire chaque ligne du fichier CSV avec la fonction fgetcsv()
 * tant qu'il y a des lignes à lire. S'il n'y a plus de nouvelle ligne, fgetcsv() retourne false.
 */
while ($row = fgetcsv($file)) {

    /**
     * $row représente une ligne du fichier CSV, les données sont récupérées dans un tableau
     * La première colone est le nom du produit
     * La deuxième colone est son prix sous forme d'une chaîne de caractères
     */
    $firstname = $row[0];
    $lastname = $row[1];
    $email = $row[2];
    $created = new DateTime();
    $newDate = $created->format('Y-m-d H-i-s');



    /**
     * Traitement du prix : 
     * - on supprime le signe €
     * - on remplace la virgule par un point
     * - on convertit la chaîne de caractères en nombre
     */
    $firstname = ucwords(strtolower($firstname), " -");
    $lastname = ucwords(strtolower($lastname), " -");
    $email = strtolower($email);
    $email = str_replace(" ", "", $email);

    if ($subscriberModel->mailExists($email) == false) {
        $subscriberModel->addSubscriber($email, $firstname, $lastname);
        $i += 1;
    } else {
        echo "Cette adresse $email existe déjà.\n";
    }


    /**
     * On enregistre ensuite le produit dans la base de données en exécutant la requête préparée plus haut
     */
}

echo $i . " emails insérés dans la base de données .\n";
echo 'Import terminé!';
