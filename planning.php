<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Circuits</title>
    <link rel="stylesheet" href="./styles.css" />
</head>

<body class="bg-light">




    <?php
    //ici on se connecte a la base sql
    include("../connection_database.php");


    //on met l'en-tete
    include("./en-tete.php");
    include("./menu.php");
    ?>

    <?php
    if(!isset($_GET['c'])) {
        $_GET['c']='voir';
    }

    switch ($_GET['c']) {

    case 'annulation':
        
        ?>
        <div id="corps" class="container">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col align-self-center">
        <?php

        $sql='SELECT * FROM CIRCUIT inner join RESERVATION on circuit.Id_Circuit = reservation.Id_Circuit WHERE Id_Reservation=' . $_GET['id_resa'];
        $stmt = sqlsrv_query($conn, $sql);
        $row = sqlsrv_fetch_array($stmt);
        echo 'Etes vous sur de vouloir annuler votre résevation pour le circuit : <b>'. $row['Id_Circuit'].' - '.$row['Descriptif_Circuit'] . '</b> ?';
        $sql2 ='SELECT * FROM Concerne INNER JOIN Personne ON Concerne.Id_Personne=Personne.Id_Personne WHERE Id_Reservation='. $_GET['id_resa'];
        $stmt2 = sqlsrv_query($conn, $sql2);

        echo '<br><br><b>Cette action annulera le voyage pour :</b><br>';
        while ($row = sqlsrv_fetch_array($stmt2)) {
                echo '<br>';
                echo 'Le passager : <b>' . $row['Prenom'] . ' ' . $row['Nom'] . '</b>';
             }
        echo '<br><br>';
        ?>
        <input type="button" value="Retour" onclick="self.location.href='./planning.php'">
        <input type="button" value="Annuler la réservation" onclick="self.location.href='./planning.php?c=update&id_resa=<?php echo $_GET['id_resa']?>'">
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;

    case 'update' :
        $sql='DELETE FROM Concerne WHERE Id_Reservation=' . $_GET['id_resa'] . 'DELETE FROM Reservation WHERE Id_Reservation=' . $_GET['id_resa'];
        $stmt = sqlsrv_query($conn, $sql);
        if (!$stmt) {
            die("<br>Echec d'execution de la requete : " . $sql);
        }else {
            echo '<br><br>Voyage annulé<br><br>';
            echo '<a href=./planning.php> Retour</a></td>';           
        }    
        break;


    case 'voir' :
    ?>
        <div id="corps" class="container">

            <div class="container">
                <div class="row align-items-center">
                    <div class="col align-self-center">


                        <?php

                        $sql = 'SELECT * FROM CIRCUIT inner join RESERVATION on circuit.Id_Circuit = reservation.Id_Circuit WHERE Id_Personne=' . $_SESSION['id_user'] . 'AND Circuit.Date_Depart > CURRENT_TIMESTAMP';
                        $stmt = sqlsrv_query($conn, $sql);

                        if (sqlsrv_has_rows($stmt)) {

                        ?>
                            <table class="table table-striped">
                                <tr>
                                    <td>Numéro du circuit</td>
                                    <td>Nom du circuit</td>
                                    <td>Depart</td>
                                    <td>Durée</td>
                                    <td>Nombre de places réservées</td>
                                    <td>Date de la réservation</td>

                                </tr>

                            <?php

                            while ($row = sqlsrv_fetch_array($stmt)) {
                                $str_date = $row['Date_Depart']->format('d-m-Y');
                                $str_date_reservation = $row['Date_Reservation']->format('d-m-Y');
                                echo '<tr>';
                                echo '<td>' . $row['Id_Circuit'] . '</td>';
                                echo '<td>' . $row['Descriptif_Circuit'] . '</td>';
                                echo '<td>' . $str_date . '</td>';
                                echo '<td>' . $row['Duree_Circuit'] . ' jours</td>';
                                echo '<td>' . $row['Nbr_Place_Reservation'] . '</td>';
                                echo '<td>' . $str_date_reservation . '</td>';


                                echo '<td><a href=./detail_circuit.php?id=' . $row['Id_Circuit'] . '>Détails</a></td>';
                                echo '<td><a href=./planning.php?c=annulation&id_circuit=' . $row['Id_Circuit'] . '&id_resa='. $row['Id_Reservation'].'>Annuler</a></td>';
                            }

                            echo '</tr>';
                            echo '</table>';
                        } else {
                            echo 'Vous n\'avez pas de circuits prévus';
                        }
                        ?>

                </div>
            </div>
        </div>
    </div>
    <?php 
    break;
    }
    
    ?>
    <!--On ferme le div du corps -->
</body>

</html>