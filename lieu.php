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


        case 'create';
        ?>
        <br><br>
        <br><br>
        <form action="./lieu.php" method="get">
                            <label for="nom">Nom lieu :</label>
                            <input type="text" id="nom" name="nom" ><br><br>
                            <label for="ville">Ville  :</label>
                            <input type="text" id="ville" name="ville"><br><br>
                            <label for="text">Pays :</label>
                            <input type="text" id="pays" name="pays"><br><br>
                            <label for="text">Descriptif :</label>
                            <textarea id="Descriptif" name="Descriptif" rows="5" cols="33"></textarea><br><br>
                            <label for="text">Prix :</label>
                            <input type="text" id="prix" name="prix"><br><br>
                            <input type="hidden" name="c" value="add">
                            <input type="submit" value="Envoyer">
                        </form>
    <?php


            break;

        case 'add':
            foreach ($_GET as $key => $Value) {
                if (empty($Value)) {
                    die("Il manque une valeur pour " . $key);
                }
            }
            $sql = "INSERT INTO Lieu (Nom_Lieu, Ville_Lieu, Pays_Lieu, Descriptif_Lieu, Prix_Visite) values ('" . $_GET['nom'] . "','" . $_GET['ville'] . "','" . $_GET['pays'] . "','" . $_GET['Descriptif'] ."','" . $_GET['prix']."')";
            $resultat = sqlsrv_query($conn, $sql);
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
                    } else {
                        $row = sqlsrv_fetch_array($resultat);
                    ?>
                    
                         <br><br>
                        <form action="./lieu.php" method="get">
                            <label for="nom">Nom lieu :</label>
                            <input type="text" id="nom" name="nom" value="<?php echo $row['Nom_Lieu'] ?>"><br><br>
                            <label for="ville">Ville  :</label>
                            <input type="text" id="ville" name="ville" value="<?php echo $row['Ville_Lieu'] ?>"><br><br>
                            <label for="text">Pays :</label>
                            <input type="text" id="pays" name="pays" value="<?php echo $row['Pays_Lieu'] ?>"><br><br>
                            <label for="text">Descriptif :</label>
                            <textarea id="Descriptif" name="Descriptif" rows="5" cols="33"><?php echo $row['Descriptif_Lieu'] ?> </textarea><br><br>
                            <label for="text">Prix :</label>
                            <input type="text" id="prix" name="prix" value="<?php echo $row['Prix_Visite'] ?>"><br><br>
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
                $sql = "UPDATE Lieu SET Nom_Lieu='" . $_GET['nom'] . "', Ville_Lieu='" . $_GET['ville'] . "',Pays_Lieu='" . $_GET['pays'] . "',Descriptif_Lieu='" . $_GET['Descriptif'] . "',Prix_Visite='" . $_GET['prix'] . "' where Nom_Lieu='" . $_GET['nom']."' and Ville_Lieu='". $_GET['ville']."' and Pays_Lieu='". $_GET['pays']."'";
                $resultat = sqlsrv_query($conn, $sql);
                if ($resultat == FALSE) {
                    die("<br>Echec d'execution de la requete : " . $sql);
                } else {
                    echo "Enregistrement mis à jour";
                    echo '<br>';
                    echo '<a href="./lieu.php?c=default">Retour à la liste des Lieux</a>';
                }


                break;

        case "del": //supprime un enregistrement
            $sql = 'SELECT * from etape where \'' . $_GET['ville'] . '\' = etape.ville_lieu and \'' . $_GET['pays'] . '\' = etape.pays_lieu and \''. $_GET['nom'] .'\' =Etape.Nom_Lieu';
            $resultat = sqlsrv_query($conn, $sql);
                    if ($resultat == FALSE) {
                        die("<br>Echec d'execution de la requete : " . $sql);
                    } else {
                        if ($resultat){
                        $row = sqlsrv_has_rows($resultat);
                            if ($row=== TRUE) {
                                $row = sqlsrv_fetch_array($resultat);
                                echo "Non le lieu est encore dans le circuit" . $row['Id_Circuit'];
                                echo '<a href=./detail_circuit.php?id='.$row['Id_Circuit'].'>Vous pouvez aller dans le détail de ce circuit pour le supprimer</a>';
                            } else {
                            $sql="DELETE FROM Lieu where Nom_Lieu='". $_GET['nom']."' and Ville_Lieu='".$_GET['ville']. "' and Pays_Lieu='". $_GET['pays'] . "'";
                            $resultat = sqlsrv_query($conn, $sql);
                            echo "c'est supprimé!";
                            }
                        }
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
                echo "<br><a href='./lieu.php?c=create'>Ajouter un Lieu</a>";
                while ($row = sqlsrv_fetch_array($stmt)) {
                    echo '<tr>';
                    echo '<td>' . $row['Nom_Lieu'] . '</td>';
                    echo '<td>' . $row['Ville_Lieu'] . '</td>';
                    echo '<td>' . $row['Pays_Lieu'] . '</td>';
                    echo '<td>' . $row['Descriptif_Lieu'] . '</td>';
                    echo '<td>' . $row['Prix_Visite'] . '</td>';
                    echo "<td><a href=./lieu.php?c=read&nom=". urlencode($row['Nom_Lieu']) . "&ville=". urlencode($row['Ville_Lieu']) ."&pays=". urlencode($row['Pays_Lieu']) .">éditer</a></td>";
                    echo "<td><a href=./lieu.php?c=del&nom=". urlencode($row['Nom_Lieu']) . "&ville=". urlencode($row['Ville_Lieu']) ."&pays=". urlencode($row['Pays_Lieu']) .">supprimer</a></td>";
                                                        }
            
                                                    echo '</tr>';
                                                
            break;
                    }
            ?>


</div>
    <!--On ferme le div du corps -->
</body>

</html>