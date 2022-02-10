<?php

function display_div_members($nom, $prenom, $sub, $ddn, $email, $cpostal, $ville, $country, $id_perso) {
    echo '
    <div class="show-film">
            <h2><span class="desc">Nom: </span>'.$nom .'<br> <span class="desc">Prénom: </span>'. $prenom.'</h2>
            <p class="resum_sub"><strong>Abonnement :</strong> <span class="sub">'.$sub.'</span></p>
            <p><strong>Date de naissance :</strong> '.$ddn.'</p>
            <p><strong>Email :</strong> '.$email.'</p>
            <p><strong>Code postal :</strong> '.$cpostal.'</p>
            <p><strong>Ville :</strong> '.$ville.'</p>
            <p><strong>Pays :</strong> '.$country.'</p>
            <p><strong>Id :</strong> '.$id_perso.'</p>
            <input type="hidden" class="id_perso" value="'.$id_perso.'">
            <input type="hidden" class="sub_client" value="'.$sub.'">
    </div>';
}