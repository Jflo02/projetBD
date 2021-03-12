<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Creation de compte</title>
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


    echo 'Créer votre compte<br>';

    $sql = 'select * FROM Lieu ';
    $stmt = sqlsrv_query($conn, $sql);

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

    

    

    




</body>

</html>