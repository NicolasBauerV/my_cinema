<?php 
    function display_div_films($title, $duree, $annee_prod, $genre, $distrib) {
        echo '
        <div class="show-film">
            <h2>'.$title.'</h2>
            <p><strong>Durée :</strong> '.$duree.'</p>
            <p><strong>Année de production :</strong> '.$annee_prod.'</p>
            <p><strong>Genre :</strong> '.$genre.'</p>
            <p><strong>Distributeur :</strong> '.$distrib.'</p>
        </div>';
    }
?>