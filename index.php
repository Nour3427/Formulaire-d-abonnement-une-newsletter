

<?php
session_start();
require './vendor/autoload.php';
require './config.php';
// require 'functions.php';

use App\Model\InterestModel;
use App\Model\SubscriberModel;
use App\Model\OrigineModel;


$interestModel = new InterestModel();
$subscriberModel = new SubscriberModel();
$origineModel = new OrigineModel();




// Inclusion des dépendances


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
    } elseif( $subscriberModel->mailExists($email) == true) {
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
        // $userID = addSubscriber($email, $firstname, $lastname, $origin);
        $userID = $subscriberModel->addSubscriber($email, $firstname, $lastname, $origin);
        foreach ($interest as $i) {
            $interestModel->addInterestForSubscriber($userID, $i);
        }

        // Message de succès
        $success  = 'Merci de votre inscription';
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

$origines = $origineModel->getAllOrigins();
$interests =$interestModel->getAllInterests();
// echo '<pre>';
// print_r($origines);



// Inclusion du template
include './index.phtml';
