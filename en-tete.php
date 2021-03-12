<?php
session_start(); //pour demarrer la session
?>
<div id="en-tete">
    <div class="logo">
        <img src="./logo.png" alt="Logo de Epsi Voyage">
    </div>

    <div class=login>
        <?php
        echo 'connecté en tant que :'.$_SESSION['prenom_user'];
        echo '<br><a href="./login.php?logout=1">Se deconnecter</a><br><br>';
        ?>
    </div>
</div>