<?php
session_start(); //pour demarrer la session

// si l utilisateur clique sur se deconnecter alors on detruit la session et on efface la varible $_SESSION
if (isset($_GET['logout'])) {
    if ($_GET['logout'] == "1") {
        session_destroy();
        unset($_SESSION);
    }
}
?>

<div id="en-tete">
    <div class="logo">
        <img src="./logo.png" alt="Logo de Epsi Voyage">
    </div>

    <div class=login>
        <?php
        if (!isset($_SESSION['id_user'])){
            echo '<a href="./login.php">Se connecter</a>';
            echo '<br>';
            echo '<a href="">S\'inscrire</a>';
        }else{

        echo 'Connecté en tant que :'.$_SESSION['prenom_user'];
        echo '<br>';
        echo  $_SESSION['type'];
        echo '<br><a href="?logout=1">Se deconnecter</a><br><br>';
        }
        ?>
    </div>
</div>