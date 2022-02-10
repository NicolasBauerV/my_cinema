<?php
session_start();
    require_once '../connection_deconnection/connection_bdd.php';
    $bdd = connectBdd();

    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        //Hash password
        $password = 'ucAi8Nc'.md5($password.'ueziBi&@,ç');

        // Selectionner le nom d'utilisateur
        $request = $bdd -> prepare('SELECT * FROM user WHERE email = ?');
        $request -> execute(array($email));

        // Récupération des données
        while ($user = $request->fetch()){
            // Connexion session
            if ($password === $user['password']) {
                $_SESSION['connect']  = 1;
                $_SESSION['email'] = $user['email'];
                header('location: ./customer_access_pages/customer_main.php', true, 302);
                exit();
            }
        }
        header('location: ../pages/connexion.php?error=1');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../ressources/styles/connexion.css">
    <title>Connexion</title>
</head>
<body>
    <header>
        <?php 
            include './templates/nav-bar.php';
        ?>
    </header>

    <main>
        <div class="form">
            <form action="../pages/connexion.php" method="post">
                <h2>Se connecter</h2>
                <?php
                    if (isset($_GET['error'])) {
                        echo '<p class="error">Nom d\'utilisateur ou mot de passe incorrect !</p>';
                    }
                ?>
                <label for="email">
                    <span>Email :</span>
                    <input type="email" name="email" id="email" placeholder="email@domain.com">
                </label>

                <label for="password">
                    <span>Password :</span>
                    <input type="password" name="password" id="password" placeholder="Password">
                </label>

                <button type="submit">Valider</button>
                <span><a href="./inscription.php">Vous ne possédez pas de compte ?</a></span>
            </form>
        </div>
    </main>
</body>
</html>