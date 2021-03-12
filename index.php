<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Ma page projet BD</title>
</head>

<body>

    <?php
    //ici on se connecte a la base sql
    $serverName = "DESKTOP-GUBKKB7";
    $connectionInfo = array("Database" => "ProjetBD");
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if ($conn) {
        echo 'connection réussie<br>';
    }


    echo 'La liste des circuits<br>';
    $sql = 'select * FROM Lieu ';
    $stmt = sqlsrv_query($conn, $sql);




    if (sqlsrv_fetch($stmt) === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $name = sqlsrv_get_field($stmt, 0);
    echo "$name: ";

    $comment = sqlsrv_get_field($stmt, 1);
    echo $comment;


    echo '<br>debut de la page<br>'

    ?>

    <p>
        <a href='./index.php?p=c '>Connexion client</a>
        <br>
        <a href='./index.php?p=cr '>Création compte client</a>
        <br>
        <a href='./index.php?p=a '>Connexion administrateur</a>
    </p>

    <?php

    if (isset($_GET["p"])) { //si la variable p est set
        switch ($_GET["p"]) {
            case "c": //si c'est un client, on lui dmd de se connecter
                echo 'ici on va se connecter si on est client';
    ?>
                <form action="./index.php" method="get">
                    <label for="nom">login :</label>
                    <input type="text" id="login_cli" name="login_cli"><br><br>

                    <label for="password">Mot de passe :</label>
                    <input type="password" id="mdp_cli" name="mdp_cli"><br><br>

                    <input type="hidden" name="p" value="c">

                    <input type="submit" value="Envoyer">

                </form>
            <?php
                break;

            case "cr": //si il veut se créer un compte
                echo 'ici on va se connecter si on est client';
                ?>
                <form action="./index.php" method="get">
                <label for="nom">nom :</label>
                <input type="text" id="nom_cli" name="nom_cli"><br><br>
            
                <label for="prenom">prenom :</label>
                <input type="text" id="prenom_cli" name="prenom_cli"><br><br>
            
                <label for="nom">login :</label>
                <input type="text" id="login_cli" name="login_cli"><br><br>
            
                <label for="password">Mot de passe :</label>
                <input type="password" id="mdp_cli" name="mdp_cli"><br><br>
            
                <input type="submit" value="Envoyer">
            
            </form>

            <?php
                break;
            case "a": //si c'est un administrateur, on lui dmd de se connecter
                echo 'ici on va se connecter si on est administrateur';
            ?>
                <form action="./index.php" method="get">
                    <label for="nom">login :</label>
                    <input type="text" id="login_admin" name="login_admin"><br><br>

                    <label for="password">Mot de passe :</label>
                    <input type="password" id="mdp_admin" name="mdp_amdin"><br><br>

                    <input type="hidden" name="p" value="a">

                    <input type="submit" value="Envoyer">

                </form>
    <?php
                break;
        }
    }
    ?>




</body>

</html>