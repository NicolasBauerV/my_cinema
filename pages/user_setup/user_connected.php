<?php

function check_user_connected($is_connected) {
    if ($is_connected != 1) {
        header('Location: ../connexion.php', true, 302);
        exit();
    }
}

function search_admin($bdd, $email) {
    //Check if is an admin
    $req = $bdd->prepare('SELECT admin FROM user WHERE email = ?');
    $req->execute(array($email));
    $is_admin = $req->fetchColumn();
    return $is_admin;
}
?>