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

    include('./session.php');
    //on met l'en-tete
    include("./en-tete.php");

    include("./menu.php");

    switch ($_GET['c']) {


        case 'read':

            $sql = 'SELECT * FROM Circuit WHERE Id_Circuit=' . $_GET['id'];
                    $resultat = sqlsrv_query($conn, $sql);
                    if ($resultat == FALSE) {
                        die("<br>Echec d'execution de la requete : " . $sql);
                    } else {
                        $row = sqlsrv_fetch_array($resultat);
                    ?>
            <form action="./modif_circuit.php" method="get">
                    <label for="desc">Descriptif :</label>
                    <input type="text" id="desc" name="desc" required="required" value="<?php echo $row['Descriptif_Circuit'] ?>"><br><br>

                    <label for="date_depart">Date:</label>
                    <input type="date" id="date_depart" name="date_depart" required="required"><br><br>

                    <label for="ville_depart">Ville de Depart :</label>
                    <input type="text" id="ville_depart" name="ville_depart" required="required" value="<?php echo $row['Ville_Depart'] ?>"><br><br>

                    <label for="pays_depart">Pays de Depart :</label>
                    <input type="text" id="pays_depart" name="pays_depart" required="required" value="<?php echo $row['Pays_Depart'] ?>"><br><br>

                    <label for="ville_arrivee">Ville d'arrivée :</label>
                    <input type="text" id="ville_arrivee" name="ville_arrivee" required="required" value="<?php echo $row['Ville_Arrivee'] ?>"><br><br>

                    <label for="pays_arrivee">Pays d'arrivée :</label>
                    <input type="text" id="pays_arrivee" name="pays_arrivee" required="required" value="<?php echo $row['Pays_Arrivee'] ?>"><br><br>

                    <label for="duree">Duree en jour :</label>
                    <input type="number" id="duree" name="duree" min="1" required="required" value="<?php echo $row['Duree_Circuit'] ?>"><br><br>

                    <label for="place">Nombre de place totale :</label>
                    <input type="number" id="place" name="place" min="1" required="required" value="<?php echo $row['Nbr_Place_Totale'] ?>"><br><br>

                    <label for="prix">Prix :</label>
                    <input type="number" id="prix" name="prix" min="0" required="required" value="<?php echo $row['Prix_Inscription'] ?>"><br><br>

                    <input type="hidden" name="c" value="update">
                    <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                    <input type="submit" value="Envoyer">
                </form>
            <?php
            break;
                    }
        case 'update':
            $sql='UPDATE Circuit
            SET Descriptif_Circuit = \'' . $_GET['desc'] . '\', Date_Depart = \'' . $_GET['date_depart'] . '\', Ville_Depart = \'' . $_GET['ville_depart'] . '\', Ville_Arrivee = \'' . $_GET['ville_arrivee'] . '\', Pays_Depart=\'' . $_GET['pays_depart'] . '\', Pays_Arrivee=\'' . $_GET['pays_arrivee'] . '\', Duree_Circuit= ' . $_GET['duree'] . ', Nbr_Place_Totale = ' . $_GET['place'] . ', Prix_Inscription = ' . $_GET['prix'] . '
            Where Id_Circuit='. $_GET['id'];
            $stmt = sqlsrv_query($conn, $sql);
            if ($stmt) {
                echo 'Modification reussie<br>';
                echo '<td><a href=./detail_circuit.php?id='.$_GET['id'].'>Retour au détail du circuit</a></td>';
            }else{
                echo "Un problème est survenu : <br>";
                die ( print_r(sqlsrv_errors(), true));
            }
            break;



    }
    

    ?>