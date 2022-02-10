<?php

include '../display_members/members.php';

function search_member($bdd, $name, $filtres, $limit) {
    $fullname = check_fullname($name);
    switch($filtres) {
        case 'nom':
            $req  = $bdd->prepare('SELECT * from user where lastname LIKE "'.$name.'%" limit '.$limit.'');
            $req->execute();
            return $req;
            break;

        case 'prenom':
            $req  = $bdd->prepare('SELECT * from user where firstname LIKE "'.$name.'%" limit '.$limit.'');
            $req->execute();
            return $req;
            break;

        default:
            $req  = $bdd->prepare('SELECT * from user where lastname = ? AND firstname = ? limit '.$limit.'');
            $req->execute(array($fullname[0], $fullname[1]));
            return $req;
            break;
    }
}

function search_all_members($bdd, $limit) {
    $req  = $bdd->prepare('SELECT * from user limit '.$limit.'');
    $req->execute();
    return $req;
}

function get_subscription_member($bdd, $id) {
    $req = $bdd->prepare('SELECT id_subscription from membership where id_user = ?');
    $req->execute(array($id));
    $id_abo = $req->fetchColumn();
    $req = $bdd->prepare('SELECT name from subscription WHERE id = ?');
    $req->execute(array($id_abo));
    $subscription = $req->fetchColumn();
    if (!$subscription) {
        return 'unknown';
    } else {
        return $subscription;
    }
    
}

function check_fullname($name) {
    $last_name  = substr($name, 0, strpos($name, " "));
    $first_name = substr($name, (strpos($name, " ") +1), strlen($name));
    return array($last_name, $first_name);
}

function display_members_from_bdd($req, $bdd, &$nb_members) {
    while ($donnees = $req->fetch()) {
        display_div_members($donnees['lastname'], $donnees['firstname'], get_subscription_member($bdd, $donnees['id']), $donnees['birthdate'], $donnees['email'], $donnees['zipcode'], $donnees['city'], $donnees['country'], $donnees['id']);
        $nb_members++;
    }
}