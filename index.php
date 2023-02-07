<?php


// Inclusion des dépendances
require 'config.php';
require 'functions.php';

$errors = [];
$success = null;
$email = '';
$firstname = '';
$lastname = '';


// Si le formulaire a été soumis...
if (!empty($_POST)) {

    // On récupère les données
    $email = trim($_POST['email']);
    $firstname = trim($_POST['firstname']);
    $lastname= trim($_POST['lastname']);


    // On récupère l'origine
    $origineSelectionnee = $_POST['origine'];
   
    
    // $interestSelectionnee = $_POST[ $interest['interest_label']];

    

    // Validation 
    if (!$email) {
        $errors['email'] = "Merci d'indiquer une adresse mail";
    }else{
        $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

    // Tableau d'options pour la connexion PDO
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    // Création de la connexion PDO (création d'un objet PDO)
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
    $pdo->exec('SET NAMES UTF8');

    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $reqmail = $pdo->prepare("SELECT * FROM subscribers WHERE email = ?");
        $reqmail->execute(array($email));
        $mailexist = $reqmail->rowCount();
        if($mailexist > 0) {
          $errors['email']=" adresse mail existe déjà";
        }
    }else{
    $errors['email']=" adresse mail n'est pas valide ";
    }
    }



    

    if (!$firstname) {
        $errors['firstname'] = "Merci d'indiquer un prénom";
    }

    if (!$lastname) {
        $errors['lastname'] = "Merci d'indiquer un nom";
    }
  

    // Si tout est OK (pas d'erreur)
    if (empty($errors)) {

        // Ajout de l'email dans le fichier csv
        addSubscriber($email, $firstname, $lastname, $origineSelectionnee);

        // Message de succès
        $success  = 'Merci de votre inscription';
    }
}

//////////////////////////////////////////////////////
// AFFICHAGE DU FORMULAIRE ///////////////////////////
//////////////////////////////////////////////////////

// Sélection de la liste des origines
$origines = getAllOrigins();



// Inclusion du template
include 'index.phtml';
