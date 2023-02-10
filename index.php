

<?php
session_start();

// Inclusion des dépendances
require 'config.php';
require 'functions.php';

$errors = [];
$success = null;
$email = '';
$firstname = '';
$lastname = '';
$origin = '';
$interest = '';
// Si le formulaire a été soumis...
if (!empty($_POST)) {

    // On récupère les données
    $email = trim($_POST['email']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $origin = $_POST['origine'];


    // On récupère l'origine 

    if (isset($_POST['interest'])) {
        // Si c'est le cas, on les récupère
        $interest = $_POST['interest'];
    }

    // Validation 

    if (!$email) {
        $errors['email'] = "Merci d'indiquer une adresse mail";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = " adresse mail n'est pas valide ";
    } elseif (mailExists($email) == true) {
        $errors['email'] = " adresse mail existe déjà";
    }


    if (!$firstname) {
        $errors['firstname'] = "Merci d'indiquer un prénom";
    }

    if (!$lastname) {
        $errors['lastname'] = "Merci d'indiquer un nom";
    }
    if (!$origin) {
        $errors['origine'] = "Merci de choisir une origine";
    }
    if (!$interest) {
        $errors['interest'] = "Merci de cocher au moins un centre d'interêt";
    }


    // Si tout est OK (pas d'erreur)
    if (empty($errors)) {

        // Ajout de l'email dans le fichier csv
        $userID = addSubscriber($email, $firstname, $lastname, $origin);

        foreach ($interest as $i) {
            addInterestForSubscriber($userID, $i);
        }
        
        // Message de succès
        $success  = 'Merci de votre inscription';
    //     header('Location: index.php');
    //     exit;
    // }

    $_SESSION['message'] = $success;
        // Le formulaire a été soumis
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
     }
   
}
//////////////////////////////////////////////////////
// AFFICHAGE DU FORMULAIRE ///////////////////////////
//////////////////////////////////////////////////////

// Sélection de la liste des origines
$origines = getAllOrigins();
$interests = getAllInterests();



// Inclusion du template
include 'index.phtml';
