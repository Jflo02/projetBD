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

    switch ($_GET['c']){
        case 'modif':
            foreach ($_GET as $key => $Value) {
                if (empty($Value)) {
                    die("Il manque une valeur pour " . $key);
                }
            }
            $sql = "UPDATE Personne SET Nom='" . $_GET['nom_pers'] . "', Date_Naissance='" . $_GET['DN_pers'] . "', Prenom='" . $_GET['prenom_pers'] . "',Personne_Mail='" . $_GET['mail_pers'] . "',Personne_MDP='" . $_GET['mdp_pers'] . "' where Id_Personne=" . $_GET['id_pers'];
            $stmt = sqlsrv_query($conn, $sql);
            if ($stmt == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Enregistrement mis à jour<br><br>";
                echo '<a href="./moncompte.php?c=default">Retour à mon compte</a>';
            }
        break;

        default:
        echo "<br><br>";
        $sql = "SELECT * FROM Personne WHERE Id_Personne=" . $_SESSION['id_user'];
        $stmt = sqlsrv_query($conn, $sql);
        if ($stmt == FALSE) {
            die("<br>Echec d'execution de la requete : " . $sql);
        } else {
            
            while ($row = sqlsrv_fetch_array($stmt)) {
                $str_date = $row['Date_Naissance']->format('Y-m-d');
?>
                <form action="./moncompte.php" method="get">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom_pers" name="nom_pers" value="<?php echo $row['Nom'] ?>"><br><br>

                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom_pers" name="prenom_pers" value="<?php echo $row['Prenom'] ?>"><br><br>

                    <label for="email">Mail :</label>
                    <input type="email" id="mail_pers" name="mail_pers" value="<?php echo $row['Personne_Mail'] ?>"><br><br>

                    <label for="DN">Date de naissance :</label>
                    <input type="date" id="DN_pers" name="DN_pers" value="<?php echo $str_date ?>"><br><br>
                    
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="mdp_pers" name="mdp_pers" value="<?php echo $row['Personne_MDP'] ?>" minlength="8" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br><br>
                    <p>8 caractères d'au moins un chiffre et une lettre majuscule et minuscule</p>
                    <input type="hidden" name="id_pers" value="<?php echo $row['Id_Personne'] ?>">
                    <input type="hidden" name="c" value="modif">

                    <input type="submit" value="Appuie pour faire les changements">
                </form>
        <?php
            }
        }
        
    }   

?>


</div>
<!--On ferme le div du corps -->
</body>

</html>