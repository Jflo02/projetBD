<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Circuits</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>

    <?php
    //ici on se connecte a la base sql
    include("../connection_database.php");


    //on met l'en-tete
    include("./en-tete.php");


    ?>
    <table border=1>
        <tr>
            <th><a href="./">Acceuil</a></th>
            <th><a href="./liste_circuits.php">Circuits</a></th>
        </tr>
    </table>




    <div id="corps">

        <?php

        switch ($_GET['c']) {

            case 'res':
                //je demande pour cb il veut réserver
    ?>
                <form action="./liste_circuits.php" method="get">

                <label for="number">Nombre de Réservation:</label>
                <input type="nombre" id="Nbr_Place_Reservation" name="Nbr_Place_Reservation"><br><br>


                <input type="hidden" name="c" value="add">
                <input type="submit" value="Envoyer">
            </form>

        <?php
                
                break;


            case 'add':
                //permet de calculer l'id
                $max_id = "SELECT MAX(Id_Reservation) FROM Reservation";
                $max_id_result = sqlsrv_query($conn, $max_id);
                $max_id=sqlsrv_fetch_array($max_id_result);
                $max_id = $max_id[0] + 1;
                //permet de définir la date de la réservation
                $Date_Reservation=date('d.m.y');

                $sql = "INSERT INTO Réservation (Id_Reservation ,Date_Reservation, Id_Personne, Id_Circuit, Nbr_Place_Reservation) values
                ('" . $max_id . "','" . $Date_Reservation . "','" . $_GET['Id_Personne'] . "','" . $_GET['Id_Circuit'] . "','" . $_GET['Nbr_Place_Reservation'] . "')";
                $resultat = sqlsrv_query($conn, $sql);
                if ($resultat == FALSE) {
                    die("<br>Echec d'execution de la requete : " . $sql);
                } else {
                    echo "Votre Réservation a bien été prise en compte";
                    // $nbr_place="SELECT Nbr_place_Totale from Circuit where Id_Circuit=. $_GET['Id_Circuit'] .";
                    // $nbr_place_restante=$nbr_place- ". $_GET[Nombre_pers] .";
                }
                break;
    
            default:
                echo '<br>';
                $sql = 'select * FROM Circuit ';
                $stmt = sqlsrv_query($conn, $sql);
            //on fait un tableau avec une ligne par circuit avec ses infos

            ?>
            <table border=1>
                <tr>
                    <td>Nom du circuit</td>
                    <td>Depart</td>
                    <td>Durée</td>
                    <td>Nombre de place restante</td>
                </tr>

                <?php

                while ($row = sqlsrv_fetch_array($stmt)) {
                    $str_date = $row['Date_Depart']->format('Y-m-d');
                    echo '<tr>';
                    echo '<td>' . $row['Descriptif_Circuit'] . '</td>';
                    echo '<td>' . $str_date . '</td>';
                    echo '<td>' . $row['Duree_Circuit'] . '</td>';
                    echo '<td>' . $row['Nbr_Place_Totale'] . '</td>';
                    echo "<td><a href=./liste_circuits.php?c=res" . $row['Id_Circuit'] . ">réserver</a></td>";

                    if (isset($_SESSION['type'])) {
                        if ($_SESSION['type'] == "Administrateur") {
                            echo '<td>' ?> <a href="">Editer</a> <?php '</td>';
                                                        }
                                                    }
                                                    echo '</tr>';
                                                }


                                                ?>                                              
            </table>
            <?php
        }
        ?>
                                


    </div>
    <!--On ferme le div du corps -->
</body>

</html>