<nav>
    <table border=1>
        <tr>
            <th><a href="./">Acceuil</a></th>
            <th><a href="./liste_circuits.php?c=default">Circuits</a></th>


            <?php

            if (isset($_SESSION['type'])) {
                if ($_SESSION['type'] == "Administrateur") {
            ?>

                    <th>
                        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
                        <ul class="menulist">
                            <li>
                                <p>Administration</p>
                                <div class="cache">
                                    
                                    <a href="./lieu.php">Lieu</a>
                                    <br>
                                    <a href="./client.php?c=default">Client</a>
                                    <br>
                                    <a href="./administrateur.phpc=default">Administrateur</a>
                                </div>
                            </li>
                        </ul>
                        <script type="text/javascript">
                            $(function() {
                                // Quand on entre dans un item de menu <li>, on affiche
                                $('.menulist li').mouseenter(function() {
                                    $(this).find('.cache').show('slow');
                                });

                                // Quand on en sort, on ferme
                                $('.menulist li').mouseleave(function() {
                                    $(this).find('.cache').hide('slow');
                                });
                            });
                        </script>
                    </th>

            <?php
                }
            }



            ?>

        </tr>
    </table>






</nav>