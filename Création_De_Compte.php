<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Expires" content="0">
</head>

<body>
<?php
if (isset($_POST['mdp_user'])) {
    //ici on se connecte a la base sql
    $serverName = "LAPTOP-KDJMM0LM\SQLEXPRESS";
    $connectionInfo = array("Database" => "ProjetBD");
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if ($conn) {
        echo 'connection réussie<br>';
    }

    echo 'Si tu veux créer un compte c est bien ici';

    
    if (!isset($_GET['c'])) {
        die();
    }

    switch ($_GET['c']) {

        case 'add':
            foreach ($_GET as $key => $Value) {
                if (empty($Value)) {
                    die("Il manque une valeur pour " . $key);
                }
            }
            $sql = "INSERT INTO etudiants (nom_etu, prenom_etu, mail_etu, mdp_etu) values ('" . $_GET['nom_etu'] . "','" . $_GET['prenom_etu'] . "','" . $_GET['mail_etu'] . "','" . $_GET['pwd_etu'] . "')";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Ajout OK !";
            }
            break;
        
        default:
        ?>
        <form action="./Créeation_De_Compte.php" method="post">
            <label for="nom">nom :</label>
            <input type="text" id="nom_cli" name="nom_cli"><br><br>
        
            <label for="prenom">prenom :</label>
            <input type="text" id="prenom_cli" name="prenom_cli"><br><br>
        
            <label for="nom">login :</label>
            <input type="text" id="login_cli" name="login_cli"><br><br>
        
            <label for="password">Mot de passe :</label>
            <input type="password" id="mdp_cli" name="mdp_cli"><br><br>
            <input type="hidden" name="c" value="add">
            <input type="submit" value="Envoyer">
        </form>
        <?php
            break;
}
?>


</body>
</html>