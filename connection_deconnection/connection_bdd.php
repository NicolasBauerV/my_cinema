<?php

function connectBdd() {
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root',
            'root');
    } catch (Exception $e) {
        die('Erreur: '. $e->getMessage());
    }
    return $bdd;
}