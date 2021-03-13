<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <?php
    include("../connection_database.php");

    //on met l'en-tete
    include("./en-tete.php");


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

            $max_id = "SELECT MAX(Id_Personne) FROM Personne";
            $max_id_result = sqlsrv_query($conn, $max_id);
            $max_id=sqlsrv_fetch_array($max_id_result);
            $max_id = $max_id[0] + 1;

            $sql = "INSERT INTO Personne (Id_Personne ,Nom, Prenom, Date_Naissance, Personne_MDP, Personne_Mail) values
            ('" . $max_id . "','" . $_GET['nom_pers'] . "','" . $_GET['prenom_pers'] . "','" . $_GET['DN_pers'] . "','" . $_GET['mdp_pers'] . "','" . $_GET['mail_pers'] . "')";
            $resultat = sqlsrv_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Votre compte a été créé, vous pouvez maintenant vous connecter";
                $sql = "INSERT INTO Client (Id_Personne) values
            ('" . $max_id. "')";
                $resultat = sqlsrv_query($conn, $sql);
            }
            break;

        default:
    ?>
            <form action="./Creation_De_Compte.php" method="get">
                <label for="nom">Nom:</label>
                <input type="text" id="nom_pers" name="nom_pers"><br><br>

                <label for="prenom">Prenom:</label>
                <input type="text" id="prenom_pers" name="prenom_pers"><br><br>

                <label for="Date_Naissance">Date_Naissance:</label>
                <input type="date" id="DN_pers" name="DN_pers"><br><br>

                <label for="password">Mot de passe :</label>
                <input type="password" id="mdp_pers" name="mdp_pers"><br><br>

                <label for="Personne_Mail">Mail:</label>
                <input type="text" id="mail_pers" name="mail_pers"><br><br>
<!--
                <label for="Id_Personne">Id:</label>
                <input type="text" id="Id_Personne" name="Id_Personne"><br><br>
-->
                <input type="hidden" name="c" value="add">
                <input type="submit" value="Envoyer">
            </form>
    <?php
            break;
    }
    ?>


</body>

</html>