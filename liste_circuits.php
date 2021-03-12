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
            <th><a href="./">Circuits</a></th>
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
                <td>Description</td>
                <td>Depart</td>
                <td>Arrivée</td>
            </tr>

            <?php
            while (sqlsrv_fetch_array($stmt)) {
                echo '<tr>';
            }


            ?>
        </table>

        <div id="explications">
            <p>
                Bienvenue sur la liste des circuits
            </p>

        </div>

    </div>
    <!--On ferme le div du corps -->
</body>

</html>