<!DOCTYPE html> 
<html>

<head>
    <meta charset="utf-8" />
    <title>Circuits</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>

    <?php //test en ayant stash
    //ici on se connecte a la base sql
    include("../connection_database.php");


    //on met l'en-tete
    include("./en-tete.php");
    include("./menu.php");
    switch ($_GET['c']) {
        case 'add':
            foreach ($_GET as $key => $Value) {
                if (empty($Value)) {
                    die("Il manque une valeur pour " . $key);
                }
            }
            $sql = "INSERT INTO Lieu (Nom_Lieu, Ville_Lieu, Pays_Lieu, Descriptif_Lieu, Prix_Visite) values ('" . $_GET['Nom_Lieu'] . "','" . $_GET['Ville_Lieu'] . "','" . $_GET['Pays_Lieu'] . "','" . $_GET['Descriptif_Lieu'] ."','" . $_GET['Prix_Visite']."')";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Ajout OK !";
            }
            break;
        

        case 'read':
            $sql = 'SELECT * FROM lieu WHERE Nom_Lieu=\'' . $_GET['nom'].'\' and Ville_Lieu=\''. $_GET['ville'].'\' and Pays_Lieu=\''. $_GET['pays'].'\'';
                    $resultat = sqlsrv_query($conn, $sql);
                    if ($resultat == FALSE) {
                        die("<br>Echec d'execution de la requete : " . $sql);
                    } elseif (sqlsrv_num_rows($resultat) == 1) {
                        $row = sqlsrv_fetch_array($resultat);
                    ?>
                        <form action="./lieu.php" method="get">
                            <label for="nom">Nom lieu :</label>
                            <input type="text" id="nom" name="nom" value="<?php echo $row['Nom_Lieu'] ?>"><br><br>
                            <label for="ville">Ville  :</label>
                            <input type="text" id="ville" name="ville" value="<?php echo $row['Ville_Lieu'] ?>"><br><br>
                            <label for="text">Pays :</label>
                            <input type="text" id="pays" name="pays" value="<?php echo $row['Pays_Lieu'] ?>"><br><br>
                            <input type="hidden" name="c" value="update">
                            <input type="submit" value="Envoyer">
                        </form>
                    <?php
                    }
            break;
        
        case "update": //modifie l'enregistrement dans la base
                foreach ($_GET as $key => $Value) {
                    if (empty($Value)) {
                        die("Il manque une valeur pour " . $key);
                    }
                }
                $sql = "UPDATE etudiants SET nom_etu='" . $_GET['nom_etu'] . "', prenom_etu='" . $_GET['prenom_etu'] . "',mail_etu='" . $_GET['mail_etu'] . "',mdp_etu='" . $_GET['mdp_etu'] . "' where id_etu=" . $_GET['id_etu'];
                $resultat = mysqli_query($conn, $sql);
                if ($resultat == FALSE) {
                    die("<br>Echec d'execution de la requete : " . $sql);
                } else {
                    echo "Enregistrement mis à jour";
                }


                break;


        default:
        echo '<br>';
                $sql = 'select * FROM Lieu';
                $stmt = sqlsrv_query($conn, $sql);
            //on fait un tableau avec une ligne par circuit avec ses infos

            ?>
            <table border=1>
                <tr>
                    <td>Nom du Lieu</td>
                    <td>Ville du Lieu</td>
                    <td>Pays du Lieu</td>
                    <td>Descriptif du Lieu</td>
                    <td>Prix de la visite</td>
                </tr>

                <?php

                while ($row = sqlsrv_fetch_array($stmt)) {
                    echo '<tr>';
                    echo '<td>' . $row['Nom_Lieu'] . '</td>';
                    echo '<td>' . $row['Ville_Lieu'] . '</td>';
                    echo '<td>' . $row['Pays_Lieu'] . '</td>';
                    echo '<td>' . $row['Descriptif_Lieu'] . '</td>';
                    echo '<td>' . $row['Prix_Visite'] . '</td>';
                    echo "<td><a href=./lieu.php?c=read&nom=" . $row['Nom_Lieu'] . "&ville=". $row['Ville_Lieu'] ."&pays=". $row['Pays_Lieu'] .">éditer</a></td>";
                                                        }
            
                                                    echo '</tr>';
                                                
            break;
                    }
            ?>


</div>
    <!--On ferme le div du corps -->
</body>

</html>