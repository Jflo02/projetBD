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
            </tr>

            <?php

            while ($row = sqlsrv_fetch_array($stmt)) {
                $str_date = $row['Date_Depart']->format('Y-m-d');
                echo '<tr>';
                echo '<td>' . $row['Descriptif_Circuit'] . '</td>';
                echo '<td>' . $str_date . '</td>';
                echo '<td>' . $row['Duree_Circuit'] . '</td>';

                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] == "Administrateur") {
                        echo '<td>' ?> <a href="">Editer</a> <?php '</td>';
                                                    }
                                                }
                                                echo '</tr>';
                                            }


                                                        ?>
        </table>



    </div>
    <!--On ferme le div du corps -->
</body>

</html>