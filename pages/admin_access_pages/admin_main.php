<?php
    session_start();

    require '../../connection_deconnection/connection_bdd.php';
    $bdd = connectBdd();

    include '../user_setup/user_connected.php';
    check_user_connected($_SESSION['connect']);
    
    require_once '../display_films/films.php';
    require      '../templates/setting_up_films.php';
    include      '../templates/show_film.php';
    $req = getFilms($_GET['search'], $_GET['filtres'], $_GET['res_limit'], $bdd);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../ressources/styles/accueil.css">
    <title>Accueil</title>
</head>
<body>
    <header>
        <?php 
            include '../templates/nav-bar_admin.php';
        ?>
    </header>

    <!-- Main -->
    <main>
        <div class="search-bar">
            <form action="./admin_main.php" method="get">
                <label for="search">
                    <span>Rechercher un film : </span>
                    <input type="text" name="search" class="search" placeholder="Rechercher un film...">
                    <select name="filtres" id="filtres">
                        <option value="">Filtres</option>
                        <option value="genre">Par Genre</option>
                        <option value="distrib">Par distributeur</option>
                    </select>
                </label>
                <br>
                <label for="res_limit">
                    <span>Nombre de films à afficher : </span>
                    <input type="number" name="res_limit" id="res_limit" min="1" value="1">
                </label>
                <button type="submit" class="search" id="btn-search">↩︎</button>
            </form>
        </div>
        <div id="section-films">
        <h2 class="sub-title">Films : </h2>
            <div class="container_films">
                <?php
                    $nb_films = 0;
                    check_filters($req, $bdd, $nb_films);
                ?>
            </div>
            <h2 class="sub-title"><?php echo $nb_films > 1 ? $nb_films.' films trouvés. ' : $nb_films.' film trouvé'?></h2>
        </div>
    </main>
</body>
</html>