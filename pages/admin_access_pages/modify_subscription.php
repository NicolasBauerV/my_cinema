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

    require '../display_members/display_subscription.php';
    require '../display_subscribed_members/display_members_subs.php';
    modify_subs($bdd, $_GET['abo_options'], $_GET['modify_sub']);
    del_sub($bdd, $_GET['del_sub']);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../ressources/styles/subscription.css">
    <title>Modifier un abonnement</title>
</head>
<body>
    <script src="../../ressources/scripts/subscriptions.js" defer></script>
    <header>
        <?php 
            include '../templates/nav-bar_admin.php';
        ?>
    </header>


    <!-- Main -->
    <main>
        <div class="container">
            <div class="row">
                <div id="header">
                    <h2>Abonnements des clients</h2>
                    <?php 
                        if (isset($_GET['success'])) {
                            echo "<p id=\"success\">Modification apporté à client <span>id: ".$_GET['id_client']."</span></p>";
                        }
                    ?>
                </div>
                <?php 
                    if (isset($_GET['success'])) {
                        echo "
                        <div id=\"go-back\">
                            <button id=\"return_btn\" onclick=\"viewAllSubs(this)\">Voir tout les abonnements</button>
                        </div>";
                    }
                ?>

            </div>
            <div class="array-container">
                <table border id="sub_table">
                    <thead>
                        <tr>
                            <th>Id Client</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Abonnement</th>
                            <th>Date d'abonnement</th>
                            <th>Duree d'abonnement</th>
                            <th>Id Abonnement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            display_members_subs($bdd, $req, $_GET['id_client']);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="child">
            <h2>Gérer un abonnement</h2>
            <div class="previous">
                <p class="p-display">             
                <p class="p-display">
                <p class="p-display">
                <p class="p-display">
            </div>
            <div class="manage">
                <form action="./modify_subscription.php" method="get" id="form_modify">
                    <h3>Modifier un abonnement</h3>
                    <label for="abo_type">
                        <select name="abo_options" id="abo_type" required>
                            <option value="">---Choisissez un abonnement---</option>
                            <option value="1">VIP</option>
                            <option value="2">GOLD</option>
                            <option value="3">Classic</option>
                            <option value="4">Pass Day</option>
                        </select>
                    </label>
                    <!-- Modify Data -->
                    <button type="submit" class="modify">Modifier</button>
                </form>
                <form action="./modify_subscription.php" method="get" id="form_del">
                    <button type="submit" class="delete">Supprimer</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>