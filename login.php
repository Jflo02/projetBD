<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="styles.css" />
</head>

<body>


    <?php
    //on met l'en-tete
    include("./en-tete.php");


    ?>
    <div class="container">
        <div class="row">
            <div class="col">
            
                <?php



                if (isset($_POST['mdp_user'])) {
                    //ici on se connecte a la base sql
                    include("../connection_database.php");




                    $sql = 'SELECT * from Personne where Personne_Mail=\'' . $_POST["mail_user"] . '\' and Personne_MDP=\'' . $_POST["mdp_user"] . '\'';
                    $resultat = sqlsrv_query($conn, $sql);
                    if ($resultat == FALSE) {
                        die("<br>Echec d'execution de la requete : " . $sql);
                    } else {
                        if (sqlsrv_has_rows($resultat) == 1) {

                            $row = sqlsrv_fetch_array($resultat);
                            $_SESSION['id_user'] = $row['Id_Personne'];
                            $_SESSION['nom_user'] = $row['Nom'];
                            $_SESSION['prenom_user'] = $row['Prenom'];

                            //on regarde si la personne est administrateur
                            $sql = 'SELECT * FROM Administrateur where Id_Personne =' . $_SESSION['id_user'];
                            $stmt = sqlsrv_query($conn, $sql);
                            $is_lignes = sqlsrv_has_rows($stmt);
                            if ($stmt) { //si la requete est bien effectué
                                if ($is_lignes) { //si id_personne est ds administrateur
                                    $_SESSION['type'] = "Administrateur";
                                } else {
                                    $_SESSION['type'] = "Client";
                                }
                            }
                        }
                    }
                }






                if (isset($_SESSION['type'])) {

                    echo 'Hello ' . (($_SESSION['type'] == "Administrateur") ? "Administrateur " : "client ") . $_SESSION['nom_user'] . ' ' . $_SESSION['prenom_user'];
                    echo '<br><a href="./login.php?logout=1">Se deconnecter</a><br><br>';
                    echo '<br><a href="./">Aller à l\'acceuil</a><br><br>';
                }


                if (!isset($_SESSION['id_user'])) {
                ?>
                    <form action="./login.php" method="post">
                        <label for="nom">Mail :</label>
                        <input type="text" id="mail_user" name="mail_user"><br><br>
                        <label for="password">Mot de passe :</label>
                        <input type="password" id="mdp_user" name="mdp_user"><br><br>
                        <input type="submit" value="Envoyer">

                    </form>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>