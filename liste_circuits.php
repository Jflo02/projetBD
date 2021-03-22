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

    ?>

    <div id="corps">

        <?php

        switch ($_GET['c']) {

            case 'res':
                //je demande pour cb il veut réserver
    ?>
                <form action="./liste_circuits.php?" method="get">

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
                    echo "Tu n'as pas de passager. Tu peux continuer";
                    echo '<form action="./liste_circuits.php?c=add&id='.$_GET['id'].'" method="get"><button type="submit">Continuer</button></form>';

                } else {
                    while ($passa>=$formulaire){
    ?>
                <form action="./liste_circuits.php" method="get">

                <label for="text">Prénom du passager <?php echo $formulaire?> :</label>
                    <input type="text" id="prenom_passager" name="prenom_passager"><br><br>

                <label for="text">Nom du passager <?php echo $formulaire?> :</label>
                    <input type="text" id="nom_passager" name="nom_passager"><br><br>
              
                <label for="text">Mail du passager <?php echo $formulaire?> :</label>
                    <input type="text" id="mail_passager" name="mail_passager"><br><br>
   
                <label for="date">Date de Naissance du passager <?php echo $formulaire?> :</label>
                    <input type="date" id="Naissance_passager" name="Naissance_passager"><br><br>
    <?php
                $formulaire++;
                    }
                echo '<input type="hidden" name="id" value='.$_GET['id'].'>';
                echo '<input type="hidden" name="Nbr_place" value='.$_GET['Nbr_Place_Reservation'].'>';
    ?>
                
                <input type="hidden" name="c" value="add">
                
<?php
                //echo '<input type="hidden" name="id" value="'.$_GET['id'].'">';
                echo '<input type="submit" value="Continuer">';
                }
                break;
            


            case 'add':
                //permet de calculer l'id
                $max_id = "SELECT MAX(Id_Reservation) FROM Reservation";
                $max_id_result = sqlsrv_query($conn, $max_id);
                $max_id=sqlsrv_fetch_array($max_id_result);
                $max_id = $max_id[0] + 1;
                //permet de définir la date de la réservation
                $Date_Reservation=date('d.m.y');

                $sql = "INSERT INTO Reservation (Id_Reservation ,Date_Reservation, Id_Personne, Id_Circuit, Nbr_Place_Reservation) values
                ('" . $max_id . "','" . $Date_Reservation . "','" . $_SESSION['id_user'] . "','" . $_GET['id'] . "','" . $_GET['Nbr_place'] . "')";
                $resultat = sqlsrv_query($conn, $sql);
                if ($resultat == FALSE) {
                    die("<br>Echec d'execution de la requete : " . $sql);
                } else {
                    echo "Votre Réservation a bien été prise en compte";
                    //calcul de reservation en moins
                    $nbr_place="SELECT Nbr_place_Totale from Circuit where Id_Circuit='". $_GET['id'] ."'";

                    $nbr_place_restante=intval($nbr_place)-intval($_GET['Nbr_place']);
                    
                    $sql="UPDATE Circuit SET Nbr_Place_Totale='".$nbr_place_restante."' where Id_Circuit='". $_GET['id'] ."'";
                    $resultat = sqlsrv_query($conn, $sql);


                    //vérifie si elle se trouve dans la BD

                    $sql= "SELECT Personne_Mail FROM Personne where Personne_Mail='". $_GET['mail_passager']. "'";
                    $resultat = sqlsrv_query($conn, $sql);
                    if ($resultat==false){
                        die("<br>Echec d'execution de la requete : " . $sql);
                    }
                    else{
                        if($resultat){
                            $row = sqlsrv_has_rows($resultat);
                            if ($row===TRUE) {
                                $row = sqlsrv_fetch_array($resultat);
                                echo "Réservation a bien été prise";
                                $sql= "INSERT INTO Concerne (Id_Personne ,Id_Reservation ,EtatReservation ,DateAnnulation) values ('".$row['Id_Personne']."','". $max_id."','1','NULL') ";
                            } else {
                                echo "<br></br>";
                                echo "le passager ".$_GET['prenom_passager']. " ". $_GET['nom_passager']. " n'est pas enregistré dans notre base de donnée" ;
                        }       
                    }
                }
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