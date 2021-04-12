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
    <br>
    <?php
    $sql = "DELETE FROM Etape WHERE Id_Circuit ='" . $_GET['id'] . "' and Ordre_Etape='" . $_GET['ordre'] . "'";
    $sql = $sql . " UPDATE Etape SET Ordre_Etape = Ordre_Etape-1 Where Id_Circuit ='" . $_GET['id'] . "' and Ordre_Etape>'" . $_GET['ordre'] . "'";
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt) {
        echo '<div class="container">';
        echo '<div class="jumbotron">';
        echo 'Suppréssion réussie<br>';
        echo '<td><a href=./detail_circuit.php?id=' . $_GET['id'] . '>Retour au détail du circuit</a></td>';
        echo '</div>';
        echo '</div>';
    } else {
        echo "Un problème est survenu : <br>";
        die(print_r(sqlsrv_errors(), true));
    }
    ?>