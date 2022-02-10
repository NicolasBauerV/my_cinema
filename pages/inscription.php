<?php
    require '../connection_deconnection/connection_bdd.php';
    $bdd = connectBdd();
    if (
        !empty($_POST['firstname']) &&!empty($_POST['lastname']) 
        && !empty($_POST['email']) && !empty($_POST['birthdate']) 
        && !empty($_POST['address']) && !empty($_POST['zipcode']) 
        && !empty($_POST['city']) && !empty($_POST['country'])
        && !empty($_POST['password']) && !empty($_POST['confirm_pass'])
        ) {
        $firstname    = htmlspecialchars($_POST['firstname']);
        $lastname     = htmlspecialchars($_POST['lastname']);
        $email        = htmlspecialchars($_POST['email']);
        $birthdate    = htmlspecialchars($_POST['birthdate']);
        $address      = htmlspecialchars($_POST['address']);
        $zipcode      = htmlspecialchars($_POST['zipcode']);
        $city         = htmlspecialchars($_POST['city']);
        $country      = htmlspecialchars($_POST['country']);
        $password     = htmlspecialchars($_POST['password']);
        $pass_confirm = htmlspecialchars($_POST['confirm_pass']);

        //Password does not match
        if ($password != $pass_confirm) {
            header('location: ./inscription.php?error=1');
            exit();
        }

        //Check if email exists
        $req = $bdd->prepare('SELECT * FROM user WHERE email = ?');
        $req->execute(array($email));
        while ($user_check = $req->fetch()) {
            if ($user_check['email'] == $email) {
                header('location: ./inscription.php?error=2');
                exit();
            }
        }

        // Hash password
        $password = 'ucAi8Nc'.md5($password.'ueziBi&@,ç');

        //Send Request
        $req = $bdd->prepare('INSERT INTO user(email, firstname, lastname, birthdate, address, zipcode, city, country, password, admin) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $req->execute(array($email, $firstname, $lastname, $birthdate, $address, $zipcode, $city, $country, $password, 0));

        header('location: ../pages/inscription.php?success=1', true);
        exit();

    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../ressources/styles/inscription.css">
    <title>Inscription</title>
</head>
<body>
    <header>
        <?php 
            include './templates/nav-bar.php';
        ?>
    </header>

    <main>
        <div class="form">
            <form action="./inscription.php" method="POST">
                <h2>S'inscrire</h2>
                <?php 
                    if (isset($_GET['success'])) {
                        echo '<a href="./connexion.php" id="created">Veuillez vous connecter</a>';
                    } elseif (isset($_GET['error'])) {
                        if ($_GET['error'] == 1) {
                            echo '<p class="error">Mot de passes différents.</p>';
                        } elseif ($_GET['error'] == 2) {
                            echo '<p class="error">Nom d\'utilisateur indisponible.</p>';
                        }
                    }
                ?>
                <label for="firstname">
                    <span>Firstname :</span>
                    <input type="text" name="firstname" id="firstname" placeholder="Firstname...." required>
                </label>

                <label for="lastname">
                    <span>Lastname :</span>
                    <input type="text" name="lastname" id="lastname" placeholder="Lastname..." required>
                </label>

                <label for="email">
                    <span>Email :</span>
                    <input type="email" name="email" id="email" placeholder="email@domaine.com" required>
                </label>

                <label for="birthdate">
                    <span>Birthdate :</span>
                    <input type="datetime-local" name="birthdate" id="birthdate" required>
                </label>

                <label for="address">
                    <span>Address :</span>
                    <input type="text" name="address" id="address" placeholder="Your Address" required>
                </label>

                <label for="city">
                    <span>City :</span>
                    <input type="text" name="city" id="city" placeholder="Your City" required>
                </label>

                <label for="zipcode">
                    <span>Zipcode :</span>
                    <input type="text" name="zipcode" id="zipcode" placeholder="Zipcode" required>
                </label>

                <label for="country">
                    <span>Country :</span>
                    <select name="country" id="country" required>
                        <option value="">---Select country---</option>
                        <option value="France">France</option>
                        <option value="Germany">Germany</option>
                        <option value="Spain">Spain</option>
                        <option value="England">England</option>
                    </select>
                </label>

                <label for="password">
                    <span>Password :</span>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </label>

                <label for="confirm_pass">
                    <span>Confirm Password :</span>
                    <input type="password" name="confirm_pass" id="confirm_pass" placeholder="Confirm your password" required>
                </label>

                <button type="submit">Valider</button>
                <?php 
                    if (empty($_GET['success'])) {
                        echo '<span><a href="./connexion.php">Vous avez déjà un compte ?</a></span>';
                    }
                ?>
            </form>
        </div>
    </main>
</body>
</html>