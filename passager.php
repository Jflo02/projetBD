<head>
    <meta charset="utf-8" />
    <title>Gestion clients</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>

    <?php
    //ici on se connecte a la base sql
    include("../connection_database.php");

    include('./session.php');
    //on met l'en-tete
    include("./en-tete.php");

    //on include le menu
    include("./menu.php")

    ?>


    
        <div class="container">
            <?php

            if (!isset($_GET['c'])) {
                die('erreur');
            }

            switch ($_GET['c']) {

                case "read": //affiche un enregistrement 

                    $sql = "SELECT * FROM Personne WHERE Id_Personne=" . $_GET['id_pers'];
                    $stmt = sqlsrv_query($conn, $sql);
                    if ($stmt == FALSE) {
                        die("<br>Echec d'execution de la requete : " . $sql);
                    } else {

                        while ($row = sqlsrv_fetch_array($stmt)) {
                            $str_date = $row['Date_Naissance']->format('Y-m-d');
            ?>
                            <form action="./client.php" method="get">
                                <label for="nom">Nom :</label>
                                <input type="text" id="nom_pers" name="nom_pers" value="<?php echo $row['Nom'] ?>"><br><br>

                                <label for="prenom">Prénom :</label>
                                <input type="text" id="prenom_pers" name="prenom_pers" value="<?php echo $row['Prenom'] ?>"><br><br>

                                <label for="mail">Mail :</label>
                                <input type="text" id="mail_pers" name="mail_pers" value="<?php echo $row['Personne_Mail'] ?>"><br><br>

                                <label for="DN">Date de naissance :</label>
                                <input type="date" id="DN_pers" name="DN_pers" value="<?php echo $str_date ?>"><br><br>

                                <input type="hidden" name="id_pers" value="<?php echo $row['Id_Personne'] ?>">
                                <input type="hidden" name="c" value="edit">

                                <input type="submit" value="Envoyer">
                            </form>
                    <?php
                        }
                    }
                    break;

                case "edit":

                    foreach ($_GET as $key => $Value) {
                        if (empty($Value)) {
                            die("Il manque une valeur pour " . $key);
                        }
                    }
                    $sql = "UPDATE Personne SET Nom='" . $_GET['nom_pers'] . "', Date_Naissance='" . $_GET['DN_pers'] . "', Prenom='" . $_GET['prenom_pers'] . "',Personne_Mail='" . $_GET['mail_pers'] . "' where Id_Personne=" . $_GET['id_pers'];
                    $stmt = sqlsrv_query($conn, $sql);
                    if ($stmt == FALSE) {
                        die("<br>Echec d'execution de la requete : " . $sql);
                    } else {
                        echo "Enregistrement mis à jour<br><br>";
                    }

                    echo '<a href="./passager.php?c=default">Retour à la liste des passagers</a>';

                    break;



                case "delete":

                    $sql = "DELETE FROM Concerne WHERE Id_Personne='" . $_GET['id_pers']. "'";
                    $stmt = sqlsrv_query($conn, $sql);
                    if ($stmt == FALSE) {
                        die("<br>Echec d'execution de la requete : " . $sql);
                    }
                    $sql = "DELETE FROM Passager WHERE Id_Personne='" . $_GET['id_pers']. "'";
                    $stmt = sqlsrv_query($conn, $sql);

                    if ($stmt == FALSE) {
                        die("<br>Echec d'execution de la requete : " . $sql);
                    } else {
                        echo "Passager supprimé";
                    }

                    break;

                case "create":
                    ?>
                    <form action="./passager.php" method="get">
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

                case "add":

                    $max_id = "SELECT MAX(Id_Personne) FROM Personne";
                    $max_id_result = sqlsrv_query($conn, $max_id);
                    $max_id = sqlsrv_fetch_array($max_id_result);
                    $max_id = $max_id[0] + 1;


                    $sql = "SELECT * FROM Personne where Personne_Mail='" . $_GET['mail_pers'] . "'";
                    echo $sql;
                    $resultat = sqlsrv_query($conn, $sql);
                    if ($resultat == false) {
                        die("<br>Echec d'execution de la requete : " . $sql);
                    } else {
                            if (sqlsrv_has_rows($resultat) == 1) {
                            $row = sqlsrv_fetch_array($resultat);
                
                                $sql = "INSERT INTO Passager (Id_Personne) values ('" . $row['Id_Personne'] . "')";
                                echo $sql;
                                $resultat = sqlsrv_query($conn, $sql);

                            } else {
                                $sql = "INSERT INTO Personne (Id_Personne, Nom, Prenom, Date_Naissance, Personne_Mail, Personne_MDP) values ('" . $max_id . "','" . $_GET['nom_pers'] . "','" . $_GET['prenom_pers'] . "','" . $_GET['DN_pers'] . "','" . $_GET['mail_pers'] . "','" . $_GET['mdp_pers'] . "')";
                                $resultat = sqlsrv_query($conn, $sql);
                                echo $sql;
                                echo "Ajout OK !";
                                $sql = "INSERT INTO Passager (Id_Personne) values ('" . $max_id . "')";
                                $resultat = sqlsrv_query($conn, $sql);
                                echo $sql;
                            }
                    }
                    
                    break;





                case "default":

                    $sql = 'select * FROM Passager INNER JOIN Personne on Passager.Id_Personne = Personne.Id_Personne';
                    $stmt = sqlsrv_query($conn, $sql);
                    //on fait un tableau avec une ligne par circuit avec ses infos
                    
                    ?>
                    <table class="table table-striped">
                        <tr>
                            <td>Id de la personne</td>
                            <td>Nom</td>
                            <td>Prenom</td>
                            <td>Date de naissance</td>
                            <td>Mail</td>
                        </tr>

                        <?php

                        while ($row = sqlsrv_fetch_array($stmt)) {
                            $str_date = $row['Date_Naissance']->format('d-m-Y');
                            echo '<tr>';
                            echo '<td>' . $row['Id_Personne'] . '</td>';
                            echo '<td>' . $row['Nom'] . '</td>';

                            echo '<td>' . $row['Prenom'] . '</td>';
                            echo '<td>' . $str_date . '</td>';
                            echo '<td>' . $row['Personne_Mail'] . '</td>';


                            echo '<td>' . '<a href="./passager.php?c=read&id_pers=' . $row['Id_Personne'] . '"' . '>Editer</a> </td>';
                            echo '<td>' . '<a href="./passager.php?c=delete&id_pers=' . $row['Id_Personne'] . '"' . '>Supprimer</a> </td>';
                            echo '</tr>';
                        }


                        ?>
                    </table>
            <?php

                    echo '<br><a href="./passager.php?c=create">Créer un passager</a>';

                    break;

                    break;
            } //fin du switch



            ?>



        </div>
    
  
</body>

</html>