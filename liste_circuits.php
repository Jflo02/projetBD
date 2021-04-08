<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Circuits</title>
    <link rel="stylesheet" href="./styles.css" />
</head>

<body class="bg-light">




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
                $sql = 'SELECT (Nbr_Place_Totale - isnull(Place_Reserve,0)) as Nbr_Place_Restante
            From Circuit left join (Select Id_Circuit, sum(Nbr_Place_Reservation) as Place_Reserve
            from Reservation
            group by Id_Circuit) as tab on Circuit.Id_Circuit = tab.Id_Circuit
            Where Circuit.Id_Circuit=' . $_GET['id'];
                $stmt = sqlsrv_query($conn, $sql);
                $row = sqlsrv_fetch_array($stmt);
                $Nbrmax = $row['Nbr_Place_Restante'];
                echo "il reste " . $Nbrmax . " places disponibles";
        ?>
                <form action="./liste_circuits.php?" method="get">

                    <label for="number">Nombre de Place à reserver(vous y compris):</label>
                    <input type="number" id="Nbr_Place_Reservation" name="Nbr_Place_Reservation" min="1" max="<?php echo $Nbrmax ?>"><br><br>
                    <input type="hidden" name="c" value="passa">
                    <?php
                    echo '<input type="hidden" name="id" value=' . $_GET['id'] . '>';
                    ?>

                    <input type="submit" value="Envoyer">
                </form>

                <?php

                break;



            case 'passa':
                $passa = $_GET['Nbr_Place_Reservation'];
                if ($passa == 0) {
                    echo "Tu n'as pas de passager. Tu peux continuer";
                    echo '<form action="./liste_circuits.php?c=add&id=' . $_GET['id'] . '" method="get"><button type="submit">Continuer</button></form>';
                } else {
                    for ($j = 1; $j <= $passa; $j++) {
                ?>
                        <form action="./liste_circuits.php" method="get">

                            <label for="text">Prénom du passager <?php echo $j ?> :</label>
                            <input type="text" id="prenom_passager<?php echo $j ?>" name="prenom_passager<?php echo $j ?>"><br><br>

                            <label for="text">Nom du passager <?php echo $j ?> :</label>
                            <input type="text" id="nom_passager<?php echo $j ?>" name="nom_passager<?php echo $j ?>"><br><br>

                            <label for="text">Mail du passager <?php echo $j ?> :</label>
                            <input type="text" id="mail_passager<?php echo $j ?>" name="mail_passager<?php echo $j ?>"><br><br>

                            <label for="date">Date de Naissance du passager <?php echo $j ?> :</label>
                            <input type="date" id="Naissance_passager<?php echo $j ?>" name="Naissance_passager<?php echo $j ?>"><br><br>
                        <?php

                    }
                    echo '<input type="hidden" name="id" value=' . $_GET['id'] . '>';
                    echo '<input type="hidden" name="Nbr_place" value=' . $_GET['Nbr_Place_Reservation'] . '>';
                        ?>

                        <input type="hidden" name="c" value="add">
                        <input type="hidden" name="nbr_passa" value="<?php echo $j ?>">

                    <?php
                    //echo '<input type="hidden" name="id" value="'.$_GET['id'].'">';
                    echo '<input type="submit" value="Continuer">';
                }
                break;



            case 'add':
                //permet de calculer l'id
                $max_id = "SELECT MAX(Id_Reservation) FROM Reservation";
                $max_id_result = sqlsrv_query($conn, $max_id);
                $max_id = sqlsrv_fetch_array($max_id_result);
                $max_id = $max_id[0] + 1;
                //permet de définir la date de la réservation
                $Date_Reservation = date('d.m.y');

                $sql = "INSERT INTO Reservation (Id_Reservation ,Date_Reservation, Id_Personne, Id_Circuit, Nbr_Place_Reservation) values
                ('" . $max_id . "','" . $Date_Reservation . "','" . $_SESSION['id_user'] . "','" . $_GET['id'] . "','" . $_GET['Nbr_place'] . "')";
                $resultat = sqlsrv_query($conn, $sql);
                if ($resultat == FALSE) {
                    die("<br>Echec d'execution de la requete : " . $sql);
                } else {
                    echo "Votre Réservation a bien été prise en compte";
                    //vérifie si elle se trouve dans la BD
                    for ($i = 1; $i < $_GET['nbr_passa']; $i++) {
                        $mail_passager = 'mail_passager' . strval($i);
                        $sql = "SELECT * FROM Personne where Personne_Mail='" . $_GET["$mail_passager"] . "'";
                        $resultat_personne = sqlsrv_query($conn, $sql);
                        if ($resultat_personne == false) {
                            die("<br>Echec d'execution de la requete : " . $sql);
                        } else {
                            if ($resultat_personne) {
                                    $row = sqlsrv_has_rows($resultat_personne);
                                    if ($row === TRUE) {
                                        $row = sqlsrv_fetch_array($resultat_personne);
                                        echo "<br></br>";
                                        echo "Réservation a bien été prise";
                                        echo "<br></br>";
                                        $sql = "SELECT * FROM Passager where Id_Personne='" . $row['Id_Personne'] . "'";//si la personne est dans les passagers
                                        $resultat = sqlsrv_query($conn, $sql);
                                        if ($resultat) {//si elle l'est:
                                            $row = sqlsrv_has_rows($resultat);
                                            if ($row === TRUE) {
                                                $sql = "SELECT * FROM Personne where Personne_Mail='" . $_GET["$mail_passager"] . "'";
                                                    $resultat= sqlsrv_query($conn, $sql);
                                                    $row = sqlsrv_fetch_array($resultat);
                                                    
                                                    $sql = "INSERT INTO Concerne (Id_Personne ,Id_Reservation ,EtatReservation ,DateAnnulation) values ('" . $row['Id_Personne'] . "','" . $max_id . "','1',NULL) ";
                                                    echo $sql;
                                                    $resultat = sqlsrv_query($conn, $sql);
                                                if ($resultat == false) {
                                                die("<br>Echec d'execution de la requete : " . $sql);}
                                            } else {//si elle est pas en passager
                                                echo "lalalalal";

                                                $sql = "SELECT * FROM Personne where Personne_Mail='" . $_GET["$mail_passager"] . "'";
                                                $resultat= sqlsrv_query($conn, $sql);
                                                $row = sqlsrv_fetch_array($resultat);
                                                echo $resultat;

                                                $sql = "INSERT INTO Passager (Id_Personne) values ('" . $row['Id_Personne'] . "')";
                                                echo $sql;
                                                $resultat = sqlsrv_query($conn, $sql);
                                                $sql = "INSERT INTO Concerne (Id_Personne ,Id_Reservation ,EtatReservation ,DateAnnulation) values ('" . $row['Id_Personne'] . "','" . $max_id . "','1',NULL) ";
                                                echo $sql;
                                                $resultat = sqlsrv_query($conn, $sql);
                                                if ($resultat == false) {
                                                die("<br>Echec d'execution de la requete : " . $sql);

                                                }
                                }
                                }

                                    
                                } else {//si la personne n'est pas ds la table personne
                                    echo "<br></br>";
                                    $max_id_pers = "SELECT MAX(Id_Personne) FROM Personne";
                                    $max_id_result_pers = sqlsrv_query($conn, $max_id_pers);
                                    $max_id_pers = sqlsrv_fetch_array($max_id_result_pers);
                                    $max_id_pers = $max_id_pers[0] + 1;
                                    $cars = "azertyiopqsdfghjklmwxcvbn0123456789";
                                    $mdp = '' . strval($max_id_pers);
                                    $long = strlen($cars);
                                    srand((float)microtime() * 1000000);
                                    //Initialise le générateur de nombres aléatoires
                                    for ($s = 0; $s < 8; $s++) {
                                        $mdp = $mdp . substr($cars, rand(0, $long - 1), 1);
                                    }
                                    $indicegetprenom = 'prenom_passager' . strval($i);
                                    $indicegetnom = 'nom_passager' . strval($i);
                                    $indicegetmail = 'mail_passager' . strval($i);
                                    $indicegetnaissance = 'Naissance_passager' . strval($i);
                                    echo "<br></br>";
                                    echo "le passager " . $_GET[$indicegetprenom] . " " . $_GET["$indicegetnom"] . " n'est pas enregistré dans notre base de donnée, le mot de passe par défaut sera " . $mdp;
                                    echo "<br></br>";
                                    $sql = "INSERT INTO Personne (Id_Personne, Nom, Prenom, Date_Naissance, Personne_MDP, Personne_Mail) values ('" . $max_id_pers . "','" . $_GET[$indicegetprenom] . "','" . $_GET[$indicegetnom] . "','" . $_GET[$indicegetnaissance] . "','" . $mdp . "','" . $_GET[$indicegetmail] . "')";
                                    $resultat = sqlsrv_query($conn, $sql);
                                    if ($resultat == false) {
                                        die("<br>Echec d'execution de la requete : " . $sql);
                                    }
                                    $sql = "INSERT INTO Passager (Id_Personne) values ('" . $max_id_pers . "')";
                                    $resultat = sqlsrv_query($conn, $sql);
                                    if ($resultat == false) {
                                        die("<br>Echec d'execution de la requete : " . $sql);
                                    }

                                    $sql = "INSERT INTO Concerne (Id_Personne ,Id_Reservation ,EtatReservation ,DateAnnulation) values ('" . $max_id_pers . "','" . $max_id . "','1',NULL) ";
                                    $resultat = sqlsrv_query($conn, $sql);
                                    if ($resultat == false) {
                                    die("<br>Echec d'execution de la requete : " . $sql);

                                    }
                                }
                                }
                            }
                        }
                    }
                break;

            default:
                include("./recherche.php");
                echo '<br>';
                echo '<br>';
                echo '<br>';
                
                $sql = 'Select Circuit.Id_Circuit, Circuit.Descriptif_Circuit, Circuit.Date_Depart, Circuit.Duree_Circuit, (Nbr_Place_Totale - isnull(Place_Reserve,0)) as Nbr_Place_Restante, Circuit.Prix_Inscription
                From Circuit left join (Select Id_Circuit, sum(Nbr_Place_Reservation) as Place_Reserve
                from Reservation
                group by Id_Circuit) as tab on Circuit.Id_Circuit = tab.Id_Circuit';
                $stmt = sqlsrv_query($conn, $sql);

                //on fait un tableau avec une ligne par circuit avec ses infos

                    ?>
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col align-self-center">
                                <table class="table table-striped">
                                    <tr>
                                        <td>Numéro du circuit</td>
                                        <td>Nom du circuit</td>
                                        <td>Depart</td>
                                        <td>Durée</td>
                                        <td>Nombre de place restante</td>
                                        <td>Prix</td>
                                    </tr>

                            <?php

                            while ($row = sqlsrv_fetch_array($stmt)) {
                                $str_date = $row['Date_Depart']->format('d-m-Y');
                                echo '<tr>';
                                echo '<td>' . $row['Id_Circuit'] . '</td>';
                                echo '<td>' . $row['Descriptif_Circuit'] . '</td>';
                                echo '<td>' . $str_date . '</td>';
                                echo '<td>' . $row['Duree_Circuit'] . '</td>';
                                echo '<td>' . $row['Nbr_Place_Restante'] . '</td>';
                                echo '<td>' . $row['Prix_Inscription'] . '</td>';
                                if ($row['Nbr_Place_Restante'] == 0) {
                                    echo "<td>plus de place disponible</td>";
                                } else {
                                    if (isset($_SESSION['type'])) {
                                        echo '<td><a href=./liste_circuits.php?c=res&id=' . $row['Id_Circuit'] . '>réserver</a></td>';
                                    }
                                }
                                echo '<td><a href=./detail_circuit.php?id=' . $row['Id_Circuit'] . '>Voir</a></td>';
                            }
                    }
                    echo '</tr>';



                            ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php

                    ?>



    </div>

    <!--On ferme le div du corps -->
</body>

</html>