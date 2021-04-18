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
    include('./session.php');
    include("./en-tete.php");
    include("./menu.php");
    include("./recherche.php");
    ?>

    <?php
        $today = date("d-m-Y");
        if (empty($_GET['date_debut'])){
            $_GET['date_debut']=$today;
        }

        echo '<br>';

        if (!empty($_GET['date_fin'])){
            $sql = "Select *
            From (Select Circuit.Prix_Inscription, Circuit.Id_Circuit, Circuit.Descriptif_Circuit, Circuit.Date_Depart, Circuit.Duree_Circuit, (Nbr_Place_Totale - isnull(Place_Reserve,0)) as Nbr_Place_Restante, dateadd(DAY,Circuit.Duree_Circuit,Circuit.Date_Depart) as Date_Fin
                            From Circuit left join (Select Id_Circuit, sum(Nbr_Place_Reservation) as Place_Reserve
                                                    from Reservation
                                                    group by Id_Circuit) as tab on Circuit.Id_Circuit = tab.Id_Circuit) as tab2
            WHERE tab2.Date_Depart>='". $_GET['date_debut']."' and tab2.Date_Fin <='". $_GET['date_fin']."' and tab2.Nbr_Place_Restante >= ". $_GET['nombre_passa']." and tab2.Duree_Circuit <= ". $_GET['jours']." and tab2.Prix_Inscription <= ". $_GET['prix']." Order by Date_Depart";
        }else{
            $sql = "Select *
            From (Select Circuit.Prix_Inscription, Circuit.Id_Circuit, Circuit.Descriptif_Circuit, Circuit.Date_Depart, Circuit.Duree_Circuit, (Nbr_Place_Totale - isnull(Place_Reserve,0)) as Nbr_Place_Restante
                            From Circuit left join (Select Id_Circuit, sum(Nbr_Place_Reservation) as Place_Reserve
                                                    from Reservation
                                                    group by Id_Circuit) as tab on Circuit.Id_Circuit = tab.Id_Circuit) as tab2
            WHERE tab2.Date_Depart>='". $_GET['date_debut']."' and tab2.Nbr_Place_Restante >= ". $_GET['nombre_passa']." and tab2.Duree_Circuit <= ". $_GET['jours']." and tab2.Prix_Inscription <= ". $_GET['prix']." Order by Date_Depart"; 
        }

            $stmt = sqlsrv_query($conn, $sql);
        if (!sqlsrv_has_rows ($stmt)){
            echo "Votre recherche ne donne aucun résultat";
        }else{    
        //on fait un tableau avec une ligne par circuit avec ses infos 
        if (isset($_SESSION['type'])) {
            if ($_SESSION['type'] == "Administrateur") {
                echo "<a href=./ajout_circuit.php?c=def>ajouter un circuit</a>";
            }
        }
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
                            <td>Nombre de places restantes</td>
                            <td>Prix</td>
                        </tr>

                <?php
                $today = date("Y-m-d");
                while ($row = sqlsrv_fetch_array($stmt)) {
                    $str_date = $row['Date_Depart']->format('d-m-Y');
                    $str_date2 = $row['Date_Depart']->format('Y-m-d');
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
                            if ($str_date2 > $today){
                                echo '<td><a href=./liste_circuits.php?c=res&id=' . $row['Id_Circuit'] . '>réserver</a></td>';
                            }else{
                                echo '<td>Voyage passé</td>';
                            }
                        }
                    }
                    echo '<td><a href=./detail_circuit.php?id=' . $row['Id_Circuit'] . '>Voir</a></td>';
                    echo '<td><a href=./supprimer_circuit.php?id=' . $row['Id_Circuit'] . '>Supprimer</a></td>';
                }
                
                echo '</tr>';

                }

                            ?>
                                </table>
                            </div>
                        </div>
                    </div>
