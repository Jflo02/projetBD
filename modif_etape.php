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
    <br>
    <?php
    $sql = 'select * FROM Etape WHERE Id_Circuit ='.$_GET['id'].' AND Ordre_Etape ='.$_GET['ordre'];
    $stmt = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($stmt);
    $str_date = $row['Date_Etape']->format('d-m-Y');
    ?>

    <form action="./validation_modif_etape.php?id=<?php echo $_GET['id']?>&ordre=<?php echo $_GET['ordre']?>" method="get">
        <label for="nom">Nom du Lieu :</label>
        <input type="text" id="nom" name="nom" value="<?php echo $row['Nom_Lieu'] ?>"><br><br>
        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" value="<?php echo $row['Ville_Lieu'] ?>"><br><br>
        <label for="pays">Pays :</label>
        <input type="text" id="pays" name="pays" value="<?php echo $row['Pays_Lieu'] ?>"><br><br>
        <label for="date">Date :</label>
        <input type="text" id="date" name="date" value="<?php echo $str_date ?>"><br><br>
        <label for="duree">Durée :</label>
        <input type="text" id="duree" name="duree" value="<?php echo $row['Duree_Etape'] ?>"><br><br>
        <input type="submit" value="Envoyer">
    </form>
