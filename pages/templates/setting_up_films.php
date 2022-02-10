<?php

function check_filters($req, $bdd, &$nb_films) {
    if (isset($_GET['search'])) {
        display_films_from_bdd($req, $bdd, $nb_films);
    } elseif (isset($_GET['filtres'])) {
        display_films_filtered($req, $bdd, $_GET['filtres'], $nb_films);
    } else {
        display_films_from_bdd($req, $bdd, $nb_films);
    }
}

function display_films_from_bdd($req, $bdd, &$nb_films) {
    while ($donnees = $req->fetch()) {
        
        // Select id_genre to display the movie_genre
        $req_genre_id = $bdd ->prepare('SELECT id_genre FROM movie_genre WHERE id_movie = ?');
        $req_genre_id->execute(array($donnees['id']));
        $genre_id = $req_genre_id->fetchColumn();

        $req_genre = $bdd ->prepare('SELECT name from genre where id = ?');
        $req_genre->execute(array($genre_id));
        $genre = $req_genre->fetchColumn();

        $req_distrib_id = $bdd ->prepare('SELECT name FROM distributor WHERE id = ?');
        $req_distrib_id->execute(array($donnees['id_distributor']));
        $distrib = $req_distrib_id->fetchColumn();
        if (empty($distrib)) {
            $distrib = 'unknown';
        }
        display_div_films($donnees['title'], $donnees['duration'], $donnees['release_date'], $genre, $distrib);
        $nb_films++;
    }
}

function display_films_filtered($req, $bdd, $filtres, &$nb_films) {
    if ($filtres == 'genre') {
        while ($donnees = $req->fetch()) {
            $req_distrib_id = $bdd ->prepare('SELECT name FROM distributor WHERE id = ?');
            $req_distrib_id->execute(array($donnees['id_distributor']));
            $distrib = $req_distrib_id->fetchColumn();
            if (empty($distrib)) {
                $distrib = 'unknown';
            }
            display_div_films($donnees['title'], $donnees['duration'], $donnees['release_date'], $filtres, $distrib);
            $nb_films++;
        }
    } elseif ($filtres == 'distrib') {
        while ($donnees = $req->fetch()) {
            $req_genre_id = $bdd ->prepare('SELECT id_genre FROM movie_genre WHERE id_movie = ?');
            $req_genre_id->execute(array($donnees['id']));
            $genre_id = $req_genre_id->fetchColumn();
    
            $req_genre = $bdd ->prepare('SELECT name from genre where id = ?');
            $req_genre->execute(array($genre_id));
            $genre = $req_genre->fetchColumn();

            if (empty($distrib)) {
                $distrib = 'unknown';
            }
            display_div_films($donnees['title'], $donnees['duration'], $donnees['release_date'], $genre, $filtres);
            $nb_films++;
        }
    }
}