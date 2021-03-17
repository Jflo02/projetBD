<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Gestion administrateurs</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>

    <?php
    //ici on se connecte a la base sql
    include("../connection_database.php");


    //on met l'en-tete
    include("./en-tete.php");

    //on include le menu
    include("./menu.php")

    ?>


    <div id="corps">
        <?php

        if (!isset($_GET['c'])) {
            die('erreur');
        }

        switch ($_GET['c']) {

            case "read": //affiche un enregistrement 

                $sql = "SELECT * FROM Administrateur WHERE Id_Personne=" . $_GET['id_pers'];
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
                            
                            <label for="mail">Mot de passe :</label>
                            <input type="text" id="mdp_pers" name="mdp_pers" value="<?php echo $row['Personne_MDP'] ?>"><br><br>
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
                $sql = "UPDATE Administrateur SET Nom='" . $_GET['nom_pers'] . "', Date_Naissance='" . $_GET['DN_pers'] . "', Prenom='" . $_GET['prenom_pers'] . "',Personne_Mail='" . $_GET['mail_pers'] . "',Personne_MDP='" . $_GET['mdp_pers'] . "' where Id_Personne=" . $_GET['id_pers'];
                $stmt = sqlsrv_query($conn, $sql);
                if ($stmt == FALSE) {
                    die("<br>Echec d'execution de la requete : " . $sql);
                } else {
                    echo "Enregistrement mis à jour<br><br>";
                }

                echo '<a href="./Administrateur.php?c=default">Retour à la liste des clients</a>';

                break;


            
            case "delete":

                $sql = 'DELETE FROM Client WHERE Id_Personne=' . $_GET['id_pers'];;
                $stmt = sqlsrv_query($conn, $sql);
                
                    if ($stmt == FALSE) {
                        die("<br>Echec d'execution de la requete : " . $sql);
                    } else {
                        echo "Client supprimé";
                    }

                break;





            case "default":

                $sql = 'select * FROM Client INNER JOIN Personne on Client.Id_Personne = Personne.Id_Personne';
                $stmt = sqlsrv_query($conn, $sql);
                //on fait un tableau avec une ligne par circuit avec ses infos

                ?>
                <table border=1>
                    <tr>
                        <td>Id de la personne</td>
                        <td>Nom</td>
                        <td>Prenom</td>
                        <td>DN</td>
                        <td>MDP</td>
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
                        echo '<td>' . $row['Personne_MDP'] . '</td>';
                        echo '<td>' . $row['Personne_Mail'] . '</td>';


                        echo '<td>' . '<a href="./client.php?c=read&id_pers=' . $row['Id_Personne'] . '"' . '>Editer</a> </td>';
                        echo '<td>' . '<a href="./client.php?c=delete&id_pers=' . $row['Id_Personne'] . '"' . '>Supprimer</a> </td>';
                        echo '</tr>';
                    }


                    ?>
                </table>
        <?php

        echo '<br><a href="./Creation_De_Compte.php?c=test.php?c=add">Créer un client</a>';

                break;

                break;
        } //fin du switch



        ?>




    </div>
    <!--On ferme le div du corps -->
</body>

</html>