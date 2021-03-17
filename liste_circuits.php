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
                <form action="./liste_circuits.php?id=" method="get">

                <label for="number">Nombre de Passager:</label>
                <input type="nombre" id="Nbr_Place_Reservation" name="Nbr_Place_Reservation"><br><br>
                <input type="hidden" name="c" value="passa">
    <?php
                echo '<input type="hidden" name="id" value='.$_GET['id'].'>';
    ?>
    
        
                <input type="submit" value="Envoyer">
            </form>

        <?php
                
                break;
            case 'passa':
                $formulaire=1;
                $passa=$_GET['Nbr_Place_Reservation'];
                if ($passa==0){
                    echo "Tu n'as pas de passager.";                    
                } else {
                    while ($passa>=$formulaire){
    ?>
                <form action="./liste_circuits.php?" method="get">

                <label for="text">Prénom du passager :</label>
                    <input type="text" id="prenom_passager" name="prenom_passager"><br><br>
                    <input type="hidden" name="c" value="passager">
                    

    <?php
                $formulaire++;
                    }
                }
                //sinon mettre un questionnaire tant que passa>=nrb_place alors mettre un questionnaire

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
                ('" . $max_id . "','" . $Date_Reservation . "','" . $_SESSION['id_user'] . "','" . $_GET['Id_Circuit'] . "','" . $_GET['Nbr_Place_Reservation'] . "')";
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
                    <td>Numéro du circuit</td>
                    <td>Nom du circuit</td>
                    <td>Depart</td>
                    <td>Durée</td>
                    <td>Nombre de place restante</td>
                </tr>

                <?php

                while ($row = sqlsrv_fetch_array($stmt)) {
                    $str_date = $row['Date_Depart']->format('d-m-Y');
                    echo '<tr>';
                    echo '<td>' . $row['Id_Circuit'] . '</td>';
                    echo '<td>' . $row['Descriptif_Circuit'] . '</td>';
                    echo '<td>' . $str_date . '</td>';
                    echo '<td>' . $row['Duree_Circuit'] . '</td>';
                    echo '<td>' . $row['Nbr_Place_Totale'] . '</td>';
                    echo '<td><a href=./liste_circuits.php?c=res&id='.$row['Id_Circuit'].'>réserver</a></td>';
                    echo '<td><a href=./detail_circuit.php?id='.$row['Id_Circuit'].'>Voir</a></td>';
                                                        }
                                                    }
                                                    echo '</tr>';



                                                ?>
            </table>
            <?php

        ?>



    </div>
    <!--On ferme le div du corps -->
</body>

</html>