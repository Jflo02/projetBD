<nav>
    <ul>
        <li><a href="./">Acceuil</a></li>
        <li><a href="./liste_circuits.php?c=test">Circuits</a></li>
        <?php

        if (isset($_SESSION['type'])) {
            if ($_SESSION['type'] == "Administrateur") {
        ?>

                <li class="deroulant"><a href="#">Administration</a>
                    <ul class="sous">
                        <li><a href="#">Circuit</a></li>
                        <li><a href="#">Etape</a></li>
                    </ul>
                </li>


        <?php
            }
        }



        ?>
    </ul>
</nav>