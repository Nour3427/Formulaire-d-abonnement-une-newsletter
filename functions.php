<?php

/**
 * Récupère tous les enregistrements de la table origins
 */
function connexion()
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
function getAllOrigins()
{
    // Construction du Data Source Name

    $pdo = connexion();
    $sql = 'SELECT *
            FROM origines
            ORDER BY origine_label';

    $query = $pdo->prepare($sql);
    $query->execute();

    return $query->fetchAll();
}




function getAllInterests()
{
    // Construction du Data Source Name
    $pdo = connexion();

    $sql = 'SELECT *
            FROM interests
            ORDER BY interest_label';

    $query = $pdo->prepare($sql);
    $query->execute();

    return $query->fetchAll();
}




/**
 * Ajoute un abonné à la liste des emails
 */
function addSubscriber(string $email, string $firstname, string $lastname, int $originId)
{
    // Construction du Data Source Name
    $pdo = connexion();

    // Insertion de l'email dans la table subscribers
    $sql = 'INSERT INTO subscribers
            (email, firstname, lastname, origine_id, created) 
            VALUES (?,?,?,?, NOW())';

    $query = $pdo->prepare($sql);
    $query->execute([$email, $firstname, $lastname, $originId]);

    return $pdo->lastInsertId();
}

function addInterestForSubscriber(int $userID, int $interestID)
{
    // Construction du Data Source Name
    $pdo = connexion();
    // Insertion  dans la table subs_interest
    $sql = 'INSERT INTO subs_interest
            (subs_id, interest_id) 
            VALUES (?,?)';

    $query = $pdo->prepare($sql);
    $query->execute([$userID, $interestID]);
}




function mailExists(string $email)
{
    // Construction du Data Source Name
    $pdo = connexion();
    $sql = 'SELECT * FROM subscribers WHERE email=?';
    $query = $pdo->prepare($sql);
    $query->execute([$email]);
    //rowCount() retourne le nombre de lignes retournées par la requête
    //Si le nombre de lignes est supérieur à zéro, cela signifie que l'adresse e-mail existe déjà
    $mailexists = $query->rowCount();
    if ($mailexists > 0) {
        return true;
    } else {
        return false;
    }
}
