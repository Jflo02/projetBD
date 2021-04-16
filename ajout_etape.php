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

    ?>
    <br>
    <?php
    switch ($_GET['c']) {
        case 'ajout':
            // Une fois qu'on a choisi l'étape, on choisi l'ordre, la durée et la date
            echo "</br>";
            echo "Vous etes sur le point d'ajouter une étape au circuit :";
            $sql = 'select * FROM Circuit WHERE Id_Circuit = ' . $_GET['id_circuit'];
            $stmt = sqlsrv_query($conn, $sql);
            $row = sqlsrv_fetch_array($stmt);
            echo $row['Id_Circuit'] . " - " . $row['Descriptif_Circuit'] . "</br></br>";

            // On affiche les etapes deja dans le circuit
            $sql = 'select * FROM Etape WHERE Id_Circuit =\'' . $_GET['id_circuit'] . '\'';
            $stmt = sqlsrv_query($conn, $sql);
    ?>

            <table class="table table-striped">
                <tr>
                    <td>Ordre Etape</td>
                    <td>Lieu</td>
                    <td>Ville</td>
                    <td>Pays</td>
                    <td>Date</td>
                    <td>Durée</td>
                </tr>

                <?php

                while ($row = sqlsrv_fetch_array($stmt)) {
                    $str_date = $row['Date_Etape']->format('d-m-Y');
                    echo '<tr>';
                    echo '<td>' . $row['Ordre_Etape'] . '</td>';
                    echo '<td>' . $row['Nom_Lieu'] . '</td>';
                    echo '<td>' . $row['Ville_Lieu'] . '</td>';
                    echo '<td>' . $row['Pays_Lieu'] . '</td>';
                    echo '<td>' . $str_date . '</td>';
                    echo '<td>' . $row['Duree_Etape'] . '</td>';
                }
                echo '</tr>';
                echo '</table>';
                echo '</br></br>';

                //on cherche combien d'étapes sont dans le circuit pour limiter l'ordre
                $sql = 'SELECT max(Ordre_Etape) as NbrEtape From Etape Where Id_Circuit= ' . $_GET['id_circuit'];
                $stmt = sqlsrv_query($conn, $sql);
                $row = sqlsrv_fetch_array($stmt);
                $Nbrmax = $row['NbrEtape'] + 1;
                $sql2 = "SELECT Date_Depart, dateadd(DAY, Duree_Circuit, Date_Depart) as date_fin FROM Circuit Where Id_Circuit =" . $_GET['id_circuit'];
                $result = sqlsrv_query($conn, $sql2);
                $ans = sqlsrv_fetch_array($result);
                $date_debut = $ans['Date_Depart']->format('Y-m-d');;
                $date_fin = $ans['date_fin']->format('Y-m-d');
                ?>
                <form action="./ajout_etape.php" method="get">
                    <label for="ordre">Ordre : </label>
                    <input type="number" id="ordre" name="ordre" min="1" max="<?php echo $Nbrmax ?>"><br><br>
                    <label for="duree">Durée en minute:</label>
                    <input type="number" id="duree" name="duree" min="1"><br><br>
                    <label for="date">Date :</label>
                    <input type="date" id="date" name="date" min="<?php echo $date_debut ?>" max="<?php echo $date_fin ?>" value="<?php echo $date_debut ?>"><br><br>
                    <input type="hidden" name="c" value="update">
                    <input type="hidden" name="nom" value="<?php echo $_GET['nom'] ?>">
                    <input type="hidden" name="ville" value="<?php echo $_GET['ville'] ?>">
                    <input type="hidden" name="pays" value="<?php echo $_GET['pays'] ?>">
                    <input type="hidden" name="id_circuit" value="<?php echo $_GET['id_circuit'] ?>">
                    <input type="submit" value="Envoyer">
                </form>
            <?php
            break;

        case 'update':
            //On Modifie l'ordre si necessaire 
            $sql = 'UPDATE Etape Set Ordre_Etape = Ordre_Etape +1 where Id_Circuit =' . $_GET['id_circuit'] . 'and Ordre_Etape >=' . $_GET['ordre'];
            //On enregistre l'étape
            $sql = $sql . 'INSERT INTO Etape values (\'' . $_GET['id_circuit'] . '\', \'' . $_GET['ordre'] . '\', \'' . $_GET['date'] . '\',\'' . $_GET['duree'] . '\',\'' . $_GET['nom'] . '\',\'' . $_GET['ville'] . '\',\'' . $_GET['pays'] . '\');';
            $stmt = sqlsrv_query($conn, $sql);
            if ($stmt) {
                echo 'Ajout Reussi<br>';
                echo '<td><a href=./detail_circuit.php?id=' . $_GET['id_circuit'] . '>Retour au détail du circuit</a></td>';
            } else {
                echo "Un problème est survenu : <br>";
                die(print_r(sqlsrv_errors(), true));
            }
            break;

        default:
            // On affiche la liste des étapes disponible a rajouter au circuit.
            echo "</br>";
            echo "<div class=\"container\">";
            echo "Vous etes sur le point d'ajouter une étape au circuit :";
            $sql = 'select * FROM Circuit WHERE Id_Circuit = ' . $_GET['id_circuit'];
            $stmt = sqlsrv_query($conn, $sql);
            $row = sqlsrv_fetch_array($stmt);
            echo $row['Id_Circuit'] . " - " . $row['Descriptif_Circuit'] . "</br>";
            echo "Cliquez sur l'étape que vous souhaitez ajouter au circuit ou  <a href=./lieu.php?c=create>Cliquez ici pour créer un nouveau lieu</a></br> </br>";

            echo '<br>';
            $sql = 'select * FROM Lieu';
            $stmt = sqlsrv_query($conn, $sql);
            //on fait un tableau avec une ligne par circuit avec ses infos

            ?>
                <table class="table table-striped">
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
                echo "<td><a href=./ajout_etape.php?c=ajout&nom=" . urlencode($row['Nom_Lieu']) . "&ville=" . urlencode($row['Ville_Lieu']) . "&pays=" . urlencode($row['Pays_Lieu']) . "&id_circuit=" . $_GET['id_circuit'] . ">Ajouter au circuit</a></td>";
            }
            echo '</tr>';
            echo '</div>';
            break;
    }

            ?>