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
    $sql = 'select * FROM Etape WHERE Id_Circuit =\'' . $_GET['id'] . '\'';
    $stmt = sqlsrv_query($conn, $sql);
    ?>
    <div class="container">
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
                echo '<td>' . $row['Duree_Etape'] . ' minutes' . '</td>';
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] == "Administrateur") {
                        echo '<td><a href=./modif_etape.php?c=defaut&id=' . $_GET['id'] . '&ordre=' . $row['Ordre_Etape'] . '>Modifier</a></td>';
                        echo '<td><a href=./suppr_etape.php?id=' . $_GET['id'] . '&ordre=' . $row['Ordre_Etape'] . '>Supprimer</a></td>';
                    }
                }
            }
            echo '</tr>';

            ?>
        </table>

        <?php
        $sql='Select * From Etape WHERE Id_Circuit =' . $_GET['id'];
        $stmt = sqlsrv_query($conn, $sql);
        if (sqlsrv_has_rows ($stmt)){
            $sql = 'Select *
            From (Select Circuit.Id_Circuit, Circuit.Prix_Inscription, tab.PrixVisites, Circuit.Prix_Inscription+PrixVisites as PrixTotal
            from Circuit,  (Select Etape.Id_Circuit as Id, SUM(Lieu.Prix_Visite) as PrixVisites
                            From Lieu inner join Etape on Lieu.Nom_Lieu = Etape.Nom_Lieu and Lieu.Ville_Lieu = Etape.Ville_Lieu and Lieu.Pays_Lieu= Etape.Pays_Lieu
                            Group by Etape.Id_Circuit) as tab
            Where Circuit.Id_Circuit = tab.Id) as sousreq
            Where Id_circuit=' . $_GET['id'];
            $resultat = sqlsrv_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                $row = sqlsrv_fetch_array($resultat);
                echo "Prix d'inscription : " . $row['Prix_Inscription'] . " euros. Prix visites : " . $row['PrixVisites'] . " euros. Pour un cout total de : " . $row['PrixTotal'] . " euros<br><br>";
            }
        }
        if (isset($_SESSION['type'])) {
            if ($_SESSION['type'] == "Administrateur") {
                echo '<a href=./ajout_etape.php?c=defaut&id_circuit=' . $_GET['id'] . '>Ajouter une étape</a><br><br>';
                echo '<a href=./modif_circuit.php?id=' . $_GET['id'] . '&c=read>Modifier le circuit</a><br><br>';
            }
        }
        ?>
        <a href="./liste_circuits.php?c=test">Retour a la liste des circuits</a>
    </div>
</body>

</html>