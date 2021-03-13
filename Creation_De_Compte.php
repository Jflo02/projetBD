<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Expires" content="0">
</head>

<body>
<?php
    include("../connection_database.php");


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
            $sql = "INSERT INTO Personne (Id_Personne ,Nom, Prenom, Date_Naissance, Personne_MDP, Personne_Mail) values ('" . $_GET['Id_Personne'] . "','" . $_GET['nom_cli'] . "','" . $_GET['prenom_cli'] . "','" . $_GET['Date_naissance'] . "','" . $_GET['pwd_etu'] . "','" . $_GET['Personne_Mail'] . "')";
            $resultat = sqlsrv_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Ajout OK !";
            }
            break;
        
        default:
        ?>
        <form action="./Creation_De_Compte.php" method="get">
            <label for="nom">nom:</label>
            <input type="text" id="nom_cli" name="nom_cli"><br><br>
        
            <label for="prenom">prenom:</label>
            <input type="text" id="prenom_cli" name="prenom_cli"><br><br>

            <label for="Date_Naissance">Date_Naissance:</label>
            <input type="text" id="Date_naissance" name="Date_naissance"><br><br>
        
            <label for="password">Mot de passe :</label>
            <input type="password" id="mdp_cli" name="mdp_cli"><br><br>

            <label for="Personne_Mail">Mail:</label>
            <input type="text" id="Personne_Mail" name="Personne_Mail"><br><br>

            <label for="Id_Personne">Id:</label>
            <input type="text" id="Id_Personne" name="Id_Personne"><br><br>

            <input type="hidden" name="c" value="add">
            <input type="submit" value="Envoyer">
        </form>
        <?php
            break;
}
?>


</body>
</html>