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
    switch ($_GET['c']) {
        case 'update':
            if ($_GET['ordre']<$_GET['ordre_final']){
                $sql = 'UPDATE Etape Set Ordre_Etape = Ordre_Etape +1 where Id_Circuit ='. $_GET['id']. ' and Ordre_Etape >='. $_GET['ordre_final'];
                $sql = $sql . ' UPDATE Etape Set Ordre_Etape='.$_GET['ordre_final'].' , Date_Etape =\''.$_GET['date'].'\' , Duree_Etape= '.$_GET['duree'].' where Id_Circuit = '.$_GET['id'].' and Ordre_Etape = '.$_GET['ordre'].' ;';
            }elseif($_GET['ordre']>$_GET['ordre_final']){
                $modif=$_GET['ordre']+1;
                $sql = 'UPDATE Etape Set Ordre_Etape = Ordre_Etape +1 where Id_Circuit ='. $_GET['id']. ' and Ordre_Etape >='. $_GET['ordre_final'];
                $sql = $sql . ' UPDATE Etape Set Ordre_Etape='.$_GET['ordre_final'].' , Date_Etape =\''.$_GET['date'].'\' , Duree_Etape= '.$_GET['duree'].' where Id_Circuit = '.$_GET['id'].' and Ordre_Etape = '.$modif.' ;';

            }else{
                $sql =' UPDATE Etape Set Ordre_Etape='.$_GET['ordre_final'].' , Date_Etape =\''.$_GET['date'].'\' , Duree_Etape= '.$_GET['duree'].' where Id_Circuit = '.$_GET['id'].' and Ordre_Etape = '.$_GET['ordre'].' ;';
            }
            echo '</br></br>';
            $stmt = sqlsrv_query($conn, $sql);
            if ($stmt) {
                echo 'Modification reussie<br>';
                echo '<td><a href=./detail_circuit.php?id='.$_GET['id'].'>Retour au détail du circuit</a></td>';
            }else{
                echo "Un problème est survenu : <br>";
                die ( print_r(sqlsrv_errors(), true));
            }
            break;

        default:
            //on cherche combien d'étapes sont dans le circuit pour limiter l'ordre
            $sql = 'SELECT max(Ordre_Etape) as NbrEtape From Etape Where Id_Circuit= '. $_GET['id'];
            $stmt = sqlsrv_query($conn, $sql);
            $row = sqlsrv_fetch_array($stmt);
            $Nbrmax = $row['NbrEtape'];
            //On cherche les valeurs a modifier
            $sql = 'select * FROM Etape WHERE Id_Circuit ='.$_GET['id'].' AND Ordre_Etape ='.$_GET['ordre'];
            $stmt = sqlsrv_query($conn, $sql);
            $row = sqlsrv_fetch_array($stmt);
            $str_date = $row['Date_Etape']->format('Y-m-d');
            ?>

            <form action="./modif_etape.php" method="get">
                <label for="ordre_final">Ordre :</label>
                <input type="number" id="ordre_final" name="ordre_final" min="1" max="<?php echo $Nbrmax ?>"value="<?php echo $row['Ordre_Etape'] ?>"><br><br>
                <label for="date">Date :</label>
                <input type="date" id="date" name="date" value="<?php echo $str_date ?>"><br><br>
                <label for="duree">Durée :</label>
                <input type="number" id="duree" name="duree" value="<?php echo $row['Duree_Etape'] ?>"><br><br>
                <input type="hidden" name="c" value="update">
                <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
                <input type="hidden" name="ordre" value="<?php echo $_GET['ordre']?>">
                <input type="submit" value="Envoyer">
            </form>
        <?php
        break;
    }
        ?>
</body>
</html>