<?php
    session_start();

    require '../../connection_deconnection/connection_bdd.php';
    $bdd = connectBdd();

    include '../user_setup/user_connected.php';
    check_user_connected($_SESSION['connect']);

    if (search_admin($bdd, $_SESSION['email']) != '1') {
        header('Location: ../customer_access_pages/customer_main.php', true, 302);
        exit();
    }

    require '../templates/display_members.php';
    //Search all members
    if ($_GET['all_display'] == 'on') {
        $req = search_all_members($bdd, $_GET['res_limit']);
    }

    if (!empty($_GET['search'])) {
        $req = search_member($bdd, htmlspecialchars($_GET['search']), htmlspecialchars($_GET['filtres']), $_GET['res_limit']);
    }
    $nb_members = 0;

    if (isset($_GET['id_client']) && isset($_GET['select_sub']) && ($_GET['submited'] == 1)) {
        $req = $bdd->prepare('
            SELECT id from subscription 
            WHERE name = ?
        ');
        $req ->execute(array($_GET['select_sub']));
        $id_sub = $req->fetchColumn();
        $req = $bdd ->prepare('INSERT INTO membership(id_user, id_subscription) VALUES(?, ?)');
        $req->execute(array($_GET['id_client'], $id_sub));
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../ressources/styles/search_members.css">
    <title>Rechercher un membre</title>
</head>
<body>
    <script src="../../ressources/scripts/select_members.js" defer></script>
    <header>
        <?php 
            include '../templates/nav-bar_admin.php';
        ?>
    </header>

    <!-- Main -->
    <main>
        <div class="search-bar">
            <form action="./search_member.php" method="get">
                <label for="search">
                    <span>Rechercher un membre : </span>
                    <input type="text" name="search" class="search" placeholder="Nom | prénom">
                    <select name="filtres" id="filtres">
                        <option value="">Filtres</option>
                        <option value="nom">Par Nom</option>
                        <option value="prenom">Par Prénom</option>
                    </select>
                </label>
                <br>
                <label for="all_display">
                    <span>Afficher tous les membres : </span>
                    <input type="checkbox" name="all_display" id="all_display">
                </label>
                <br>
                <label for="res_limit">
                    <span>Nombre de membre à afficher : </span>
                    <input type="number" name="res_limit" id="res_limit" min="1" value="10">
                </label>
                <button type="submit" class="search" id="btn-search">↩︎</button>
            </form>
        </div>
        <div id="section-films">
            <?php 
                if (isset($_GET['submited']) && $_GET['submited'] == 1) {
                    echo'
                        <p class="success">Le client <u>id: '.$_GET['id_client'].'</u> a obtenu son abonnement : <strong>'.$_GET['select_sub'].'</strong></p>                    
                    ';
                }
            ?>
            <h2 class="sub-title">Membres :</h2>
            <div class="container_films">
                <?php
                    display_members_from_bdd($req, $bdd, $nb_members);
                ?>
            </div>
            <h2 class="sub-title"><?php echo $nb_members > 1 ? $nb_members.' membres trouvés. ' : $nb_members.' membre trouvé'?></h2>
        </div>        
    </main>
</body>
</html>