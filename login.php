<?php
session_start(); //pour demarrer la session

// si l utilisateur clique sur se deconnecter alors on detruit la session et on efface la varible $_SESSION
if (isset($_GET['logout'])) {
    if ($_GET['logout'] == "1") {
        session_destroy();
        unset($_SESSION);
    }
}

if (isset($_POST['mdp_user'])) {
    //ici on se connecte a la base sql
    $serverName = "LAPTOP-KDJMM0LM\SQLEXPRESS";
    $connectionInfo = array("Database" => "ProjetBD");
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if ($conn) {
        echo 'connection réussie<br>';
    }


    $sql ='SELECT * from dbo.Administrateur inner join dbo.Personne ON dbo.Administrateur.Id_Personne=dbo.Personne.Id_Personne where Mot_De_Passe_Administrateur=\''. $_POST["mdp_user"] .'\' and Nom=\''.$_POST["nom_user"].'\'';
    $resultat = sqlsrv_query($conn, $sql);                                                                                     
    if ($resultat == FALSE) {
        die("<br>Echec d'execution de la requete : " . $sql);
    } else {
        if (sqlsrv_has_rows($resultat) == 1) {
            $row = sqlsrv_fetch_array($resultat);
            $_SESSION['id_user'] = $row['Id_Personne'];
            $_SESSION['nom_user'] = $row['Nom'];
            $_SESSION['prenom_user'] = $row['Prenom'];
            // $_SESSION['mail_user'] = $row['mail_prof'];
            $_SESSION['type'] = "Administrateur";
        }
    }

    $sql ='SELECT * from dbo.Client inner join dbo.Personne ON dbo.Client.Id_Personne=dbo.Personne.Id_Personne where Mot_De_Passe_Client=\''. $_POST["mdp_user"] .'\' and Nom=\''.$_POST["nom_user"].'\'';
    $resultat = sqlsrv_query($conn, $sql);                                                                                     
    if ($resultat == FALSE) {
        die("<br>Echec d'execution de la requete : " . $sql);
    } else {
        if (sqlsrv_has_rows($resultat) == 1) {
            $row = sqlsrv_fetch_array($resultat);
            $_SESSION['id_user'] = $row['Id_Personne'];
            $_SESSION['nom_user'] = $row['Nom'];
            $_SESSION['prenom_user'] = $row['Prenom'];
            // $_SESSION['mail_user'] = $row['mail_prof'];
            $_SESSION['type'] = "Client";
        }
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Expires" content="0">
</head>
<body>
<?php
    if (isset($_SESSION['type'])) {

        echo 'Hello ' . (($_SESSION['type'] == "Administrateur") ? "Administrateur" : "client") . $_SESSION['nom_user'] . ' ' . $_SESSION['prenom_user'];
        echo '<br><a href="./login.php?logout=1">Se deconnecter</a><br><br>';
    }

    ?>
<form action="./login.php" method="post">
    <label for="nom">Nom:</label>
    <input type="text" id="nom_user" name="nom_user"><br><br>
    <label for="password">Mot de passe :</label>
    <input type="password" id="mdp_user" name="mdp_user"><br><br>
    <input type="submit" value="Envoyer">

</form>
</body>
</html>
