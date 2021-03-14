<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Ma page projet BD</title>
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
        <th><a href="./liste_circuits.php?c=test">Circuits</a></th>
        </tr>
    </table>


   

    <div id="corps">

        <div id="explications">
            <p>
                Bienvenue sur Epsi voyage, le site numéro 1 de voyage</p>

        </div>

    </div>
    <!--On ferme le div du corps -->
</body>

</html>