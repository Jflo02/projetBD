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

    <div id="corps" class="container">

        <div class="container">
            <div class="row align-items-center">
                <div class="col align-self-center">


                    <?php

                    $sql = 'SELECT * FROM CIRCUIT inner join RESERVATION on circuit.Id_Circuit = reservation.Id_Circuit WHERE Id_Personne=' . $_SESSION['id_user'] . 'AND Circuit.Date_Depart < CURRENT_TIMESTAMP';
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

    <!--On ferme le div du corps -->
</body>

</html>