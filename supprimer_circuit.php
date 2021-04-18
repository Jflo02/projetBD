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

    include('./session.php');
    //on met l'en-tete
    include("./en-tete.php");

    include("./menu.php");

    $sql = 'SELECT * from Reservation where \'' . $_GET['id'] . '\' = Id_Circuit ';
            $resultat = sqlsrv_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                if ($resultat) {
                    $row = sqlsrv_has_rows($resultat);
                    if ($row === TRUE) {                      
                        echo "Vous ne pouvez pas supprimer un voyage comportant des réservations <br><br>";
                        echo '<a href="./liste_circuits.php?c=test">Retour a la liste des circuits</a>';
                    } else {
                        $sql = "DELETE from Etape where Id_Circuit='".$_GET['id']."'";
                        $resultat = sqlsrv_query($conn, $sql);
                        if ($resultat == FALSE) {
                            die("<br>Echec d'execution de la requete : " . $sql);
                        } else { 
                            $sql="DELETE from Circuit where Id_Circuit='".$_GET['id']."'";
                            $resultat = sqlsrv_query($conn, $sql);
                            if ($resultat == FALSE) {
                                            die("<br>Echec d'execution de la requete : " . $sql);
                            } else {
                                echo "Le circuit a bien été supprimé !" ;
                                echo '<a href="./liste_circuits.php?c=test">Retour a la liste des circuits</a>';       
                            }
                        }
                    }
                }
            }
    


    ?>