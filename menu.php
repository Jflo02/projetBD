<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="nav-collapse">
        <ul class="nav">
          <li><a href="./index.php">Accueil</a></li>
          <li><a href="./liste_circuits.php?c=default">Circuits</a></li>

          
          <?php
          if (isset($_SESSION['type'])) {
          ?>

            <li><a href="./historique.php">Historique</a></li>
            <li><a href="./planning.php">Planning</a></li>
            <li><a href="./moncompte.php?c=default">Mon compte</a></li>

            <?php
            if ($_SESSION['type'] == "Administrateur") {
            ?>


              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administration</a>
                <ul class="dropdown-menu">
                  <li><a href="./personne.php?c=default">Personnes</a></li>
                  <li><a href="./administrateur.php?c=default">Administrateurs</a></li>
                  <li><a href="./client.php?c=default">Clients</a></li>
                  <li><a href="./passager.php?c=default">Passagers</a></li>
                  <li><a href="./lieu.php?c=default">Lieux</a></li>


                </ul>
              </li>

          <?php
            }
          }
          ?>





        </ul>

      </div><!-- /.nav-collapse -->
    </div>
  </div><!-- /navbar-inner -->
</div>