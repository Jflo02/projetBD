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

    //on include le menu
    include("./menu.php")

    ?>
    <link rel="stylesheet" href="./styles.css" />





    <div class="container">


        <p class="jumbotron">
            Bienvenue sur Epsi voyage, le site numéro 1 de voyage
        </p>

    </div>
    <!--On ferme le div du corps -->
</body>

</html>