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

    include('./session.php');
    //on met l'en-tete
    include("./en-tete.php");
    include("./menu.php");

    
    switch ($_GET['c']) {
        case 'add':
            $max_id = "SELECT MAX(Id_Circuit) FROM Circuit";
            $max_id_result = sqlsrv_query($conn, $max_id);
            $max_id = sqlsrv_fetch_array($max_id_result);
            $max_id = $max_id[0] + 1;

            $sql = "INSERT INTO Circuit (Id_Circuit ,Descriptif_Circuit, Date_Depart, Ville_Depart, Ville_Arrivee, Pays_Depart, Pays_Arrivee, Duree_Circuit, Nbr_Place_Totale, Prix_Inscription) values
                ('" . $max_id . "','" . $_GET['desc'] . "','" . $_GET['date_depart'] . "','" . $_GET['ville_depart'] . "','" . $_GET['ville_arrivee'] . "','" . $_GET['pays_depart'] . "','" . $_GET['pays_arrivee'] . "','" . $_GET['duree'] . "','" . $_GET['place'] . "','" . $_GET['prix'] . "')";
                $resultat = sqlsrv_query($conn, $sql);
                if ($resultat == FALSE) {
                    die("<br>Echec d'execution de la requete : " . $sql);
                }else{
                    echo "Le circuit a bien été ajouté <br><br>";
                    echo '<a href="./liste_circuits.php?c=test">Retour a la liste des circuits</a>';
                }
            break;

        default :

    ?>
    <form action="./ajout_circuit.php?c=add" method="get">
        <label for="desc">Descriptif :</label>
        <input type="text" id="desc" name="desc" required="required"><br><br>

        <label for="date_depart">Date:</label>
        <input type="date" id="date_depart" name="date_depart" required="required"><br><br>

        <label for="ville_depart">Ville de Depart :</label>
        <input type="text" id="ville_depart" name="ville_depart" required="required"><br><br>

        <label for="pays_depart">Pays de Depart :</label>
        <input type="text" id="pays_depart" name="pays_depart" required="required"><br><br>

        <label for="ville_arrivee">Ville d'arrivée :</label>
        <input type="text" id="ville_arrivee" name="ville_arrivee" required="required"><br><br>

        <label for="pays_arrivee">Pays d'arrivée :</label>
        <input type="text" id="pays_arrivee" name="pays_arrivee" required="required"><br><br>

        <label for="duree">Duree en jour :</label>
        <input type="number" id="duree" name="duree" min="1" required="required"><br><br>

        <label for="place">Nombre de place totale :</label>
        <input type="number" id="place" name="place" min="1" required="required"><br><br>

        <label for="prix">Prix :</label>
        <input type="number" id="prix" name="prix" min="0" required="required"><br><br>


        <input type="hidden" name="c" value="add">
        <input type="submit" value="Envoyer">
    </form>
<?php
    break;

    }
?>
</body>
</html>