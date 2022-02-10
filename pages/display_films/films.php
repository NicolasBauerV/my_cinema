<?php

function getFilms($name, $filtres, $limit, $bdd) {
    if (!empty($name) && !empty($limit)) {
        if ($limit == '0') {
            $limit = '1';
        }
        $filtres = htmlspecialchars($filtres);
        $name = htmlspecialchars($name);
        if (!empty($filtres)) {
            switch ($filtres) {
                case 'genre':
                    $req  = $bdd->prepare('SELECT id from genre where name = ?');
                    $req->execute(array($name));
                    $id_genre = $req->fetchColumn();
                    $req = $bdd->prepare('
                        SELECT * FROM movie
                        LEFT JOIN movie_genre ON movie.id = movie_genre.id_movie 
                        WHERE id_genre = ?
                        LIMIT '.$limit.'
                        ');
                    $req->execute(array($id_genre));
                    return $req;
                    break;

                case 'distrib': 
                    $req  = $bdd->prepare('SELECT id from distributor WHERE name = ?');
                    $req->execute(array($name));
                    $id_distrib = $req->fetchColumn();
                    $req  = $bdd->prepare('SELECT * from movie WHERE id_distributor = ? limit '.$limit.'');
                    $req->execute(array($id_distrib));
                    return $req;
                    break;
            }
        } else {
            $req  = $bdd->prepare("SELECT * from movie WHERE title LIKE '%$name%' limit ".$limit."");
            $req->execute(array($name));
            return $req;
        }
    } else {
        $req = $bdd->prepare('SELECT * FROM movie LIMIT 5');
        $req->execute();
        return $req;
    }
}