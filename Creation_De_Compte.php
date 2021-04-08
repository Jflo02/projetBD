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
    include("./menu.php");


    

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
            $max_id = sqlsrv_fetch_array($max_id_result);
            $max_id = $max_id[0] + 1;

            $sql = "INSERT INTO Personne (Id_Personne ,Nom, Prenom, Date_Naissance, Personne_MDP, Personne_Mail) values
            ('" . $max_id . "','" . $_GET['nom_pers'] . "','" . $_GET['prenom_pers'] . "','" . $_GET['DN_pers'] . "','" . $_GET['mdp_pers'] . "','" . $_GET['mail_pers'] . "')";
            $resultat = sqlsrv_query($conn, $sql);
            if ($resultat == FALSE) { //si on peut pas ajouter

                $sql = "SELECT * FROM Personne where Personne_Mail='" . $_GET['mail_pers'] . "'";
                $resultat = sqlsrv_query($conn, $sql);

                if (sqlsrv_has_rows($resultat)) { //check si mail ds table personne

                    //le mail est dans la table personne
                    $row = sqlsrv_fetch_array($resultat);
                    $sql = "SELECT * FROM Client where Id_Personne='" . $row['Id_Personne'] . "'";
                    $resultat = sqlsrv_query($conn, $sql);

                    if (sqlsrv_has_rows($resultat)) { //si mail ds client
                        //la personne est cliente
                        $sql = "SELECT * FROM Passager where Id_Personne='" . $row['Id_Personne'] . "'";
                        $resultat = sqlsrv_query($conn, $sql);

                        if (sqlsrv_has_rows($resultat)) {
                            
                            //la pers est cliente mais pas passager -> juste mail déja utilisé
                            echo '<div class="jumbotron">Cet email est déja utilisé par un client</div>';
                        }
                    } else { //si le mail est pas dans client:

                        $sql = "SELECT * FROM Passager where Id_Personne='" . $row['Id_Personne'] . "'";
                        $resultat = sqlsrv_query($conn, $sql);

                        if (sqlsrv_has_rows($resultat)) {
                            //la personne est un passager mais pas client
                            echo '<div class="jumbotron">
                            Votre e-mail a été utilisé pour un passager d\'un circuit, nous vous invitons à
                             cliquer sur <a href="#">ce lien</a> pour recevoir par mail le mot de passe aléatoire et temporaire qui vous a été attribué,
                              sur cet e-mail vous trouverez un lien pour le modifier
                              </div>';

                            $sql = "INSERT INTO Client (Id_Personne) values
                            ('" . $row['Id_Personne'] . "')";
                            $resultat = sqlsrv_query($conn, $sql);

                            if ($resultat) {
                                echo 'Vous avez bien été promu client, vous pouvez maintenant vous connecter et réserver des voyages';
                            } else{
                                echo 'erreur lalalala';
                                print_r($resultat);
                            }
                        }
                    }
                } else { //si c'est une autre erreur
                    die("<br>Echec d'execution de la requete : " . $sql);
                }
            } else { //si on peut ajouter :

                $sql = "INSERT INTO Client (Id_Personne) values
            ('" . $max_id . "')";
                $resultat = sqlsrv_query($conn, $sql);

                if (!isset($_SESSION['id_user'])) {
                    echo "Votre compte a été créé, vous pouvez maintenant vous connecter";
                } elseif (($_SESSION['type']) == "Administrateur") {

                    echo 'Le compte client a bien été créé.';
                }
            }
            break;

        case 'add-admin':
            foreach ($_GET as $key => $Value) {
                if (empty($Value)) {
                    die("Il manque une valeur pour " . $key);
                }
            }

            //si on est deja ds la base:


            $sql = 'SELECT * FROM Personne WHERE Personne_Mail=\'' . $_GET['mail_pers'] . '\''; //la var est ok
            $stmt = sqlsrv_query($conn, $sql); //on effectue la requete
            $has_rows = sqlsrv_has_rows($stmt);

            if ($has_rows) {
                $row = sqlsrv_fetch_array($stmt);
                echo 'Cet email est déja présent dans la base<br><br>';
                echo 'Voulez vous promouvoir ' . $row['Nom'] . ' ' . $row['Prenom'] . ' en administrateur?<br><br>';

    ?>
                <form action="./Creation_De_Compte.php" method="get">
                    <input type="hidden" name="c" value="promotion">
                    <?php
                    echo '<input type="hidden" name="id" value="' . $row['Id_Personne'] . '">';
                    ?>
                    <input type="submit" value="Oui">
                </form>

                <a href="./index.php">Non retourner à l'acceuil</a>

            <?php

            } else {
                //si la personne n'est pas ds la base:

                $max_id = "SELECT MAX(Id_Personne) FROM Personne";
                $max_id_result = sqlsrv_query($conn, $max_id);
                $max_id = sqlsrv_fetch_array($max_id_result);
                $max_id = $max_id[0] + 1;

                $sql = "INSERT INTO Personne (Id_Personne ,Nom, Prenom, Date_Naissance, Personne_MDP, Personne_Mail) values
                ('" . $max_id . "','" . $_GET['nom_pers'] . "','" . $_GET['prenom_pers'] . "','" . $_GET['DN_pers'] . "','" . $_GET['mdp_pers'] . "','" . $_GET['mail_pers'] . "')";
                $resultat = sqlsrv_query($conn, $sql);
                if ($resultat == FALSE) {
                    die("<br>Echec d'execution de la requete : " . $sql);
                } else {

                    $sql = "INSERT INTO Administrateur (Id_Personne) values
                ('" . $max_id . "')";
                    $resultat = sqlsrv_query($conn, $sql);

                    $sql = "INSERT INTO Client (Id_Personne) values
                ('" . $max_id . "')";
                    $resultat = sqlsrv_query($conn, $sql);

                    echo 'Le compte Administrateur a bien été créé.';
                }
            }
            break;


        case "promotion":

            $sql = "INSERT INTO Administrateur (Id_Personne) values
                ('" . $_GET['id'] . "')";
            $resultat = sqlsrv_query($conn, $sql);

            echo 'La personne a bien été promu administrateur';


            break;


        case "admin": //créer un compte admin si on est admin
            ?>
            <form action="./Creation_De_Compte.php" method="get">
                <label for="nom">Nom:</label>
                <input type="text" id="nom_pers" name="nom_pers" required="required"><br><br>

                <label for="prenom">Prenom:</label>
                <input type="text" id="prenom_pers" name="prenom_pers" required="required"><br><br>

                <label for="Date_Naissance">Date_Naissance:</label>
                <input type="date" id="DN_pers" name="DN_pers" required="required"><br><br>

                <label for="password">Mot de passe :</label>
                <input type="password" id="mdp_pers" name="mdp_pers" minlength="8" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br><br>
                <p>8 caractères d'au moins un chiffre et une lettre majuscule et minuscule</p>
                
                <label for="Personne_Mail">Mail:</label>
                <input type="text" id="mail_pers" name="mail_pers" required="required"><br><br>

                <input type="hidden" name="c" value="add-admin">
                <input type="submit" value="Envoyer">
            </form>
        <?php
            break;





        default: //créer un compte si on est client lambda
        ?>
            <form action="./Creation_De_Compte.php" method="get">
                <label for="nom">Nom:</label>
                <input type="text" id="nom_pers" name="nom_pers" required="required"><br><br>

                <label for="prenom">Prenom:</label>
                <input type="text" id="prenom_pers" name="prenom_pers" required="required"><br><br>

                <label for="Date_Naissance">Date_Naissance:</label>
                <input type="date" id="DN_pers" name="DN_pers" required="required"><br><br>

                <label for="password">Mot de passe :</label>
                <input type="password" id="mdp_pers" name="mdp_pers" minlength="8" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br><br>
                <p>8 caractères d'au moins un chiffre et une lettre majuscule et minuscule</p>

                <label for="Personne_Mail">Mail:</label>
                <input type="text" id="mail_pers" name="mail_pers" required="required"><br><br>

                <input type="hidden" name="c" value="add">
                <input type="submit" value="Envoyer">
            </form>
    <?php
            break;
    }
    ?>


</body>

</html>