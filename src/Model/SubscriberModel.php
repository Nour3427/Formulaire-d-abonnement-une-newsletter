<?php

namespace App\Model;

use App\Core\AbstractModel;


class SubscriberModel extends AbstractModel{

    /**
     * 
     * Ajoute un abonné à la liste des emails
     */
    function addSubscriber(string $email, string $firstname, string $lastname, int $originId=null)
    {
        // Insertion de l'email dans la table subscribers
        $sql = 'INSERT INTO subscribers
            (email, firstname, lastname, origine_id, created) 
            VALUES (?,?,?,?, NOW())';

        $this->db->prepareAndExecute($sql, [$email, $firstname, $lastname, $originId]);

        return $this->db->getLastInsertID();
    }
    
function mailExists(string $email)
{
    // Construction du Data Source Name

    $sql = 'SELECT * FROM subscribers WHERE email=?';
    $result = $this->db->getOneResult($sql, [$email]);
    if (is_array($result) && count($result) > 0) {
        return true;
    } else {
        return false;
    }
}
}
