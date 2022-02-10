<?php

function display_members_subs($bdd, $req, $id_customer) {
    $id = 0;
    //Search id of members
    if (!isset($id_customer)) {
        $req = $bdd->prepare('SELECT * FROM membership');
        $req->execute();
    } else {
        $req = $bdd->prepare('SELECT * FROM membership WHERE id_user = ?');
        $req->execute(array($id_customer));
    }
    while ($data = $req->fetch()) {
        // Request table fiche_person
        $req_person = $bdd->prepare('SELECT * FROM user where id = ?');
        $req_person->execute(array($data['id_user']));
        $id_perso = $req_person->fetch();

        //Request table abonnement
        $req_abo = $bdd->prepare('SELECT * FROM subscription where id = ?');
        $req_abo->execute(array($data['id_subscription']));
        $id_abo = $req_abo->fetch();

        if (empty($id_abo)) {
            $id_abo = "/";
        }
        disp_subs($data['id_user'], $id_perso['firstname'], $id_perso['lastname'], $id_perso['email'], $id_abo['name'], $data['date_begin'], $id_abo['duration'], $id_abo['id'], $id);
    }   
}


function modify_subs($bdd, $sub_options, $id_customer) {
    if (!empty($sub_options) && isset($sub_options) && !empty($id_customer)) {
        $req_sub = $bdd->prepare('UPDATE membership SET id_subscription = ? WHERE id_user = ?');
        $req_sub->execute(array($sub_options, $id_customer));
        return header('Location: ./modify_subscription.php?success=1&id_client='.$id_customer.'');
    }
}

function del_sub($bdd, $id_customer) {
    if (!empty($id_customer)) {
        $req_sub = $bdd->prepare('DELETE FROM membership WHERE id_user = ?');
        $req_sub->execute(array($id_customer));
        return header('Location: ./modify_subscription.php?success=2&id_client='.$id_customer.'');
    }
}