<?php include("../connection_database.php");

    $sql = 'SELECT max(Duree_Circuit) as DureeMax, min(Duree_Circuit) as DureeMin, max(Prix_Inscription) as PrixMax, min(Prix_Inscription) as PrixMin FROM Circuit;';
    $stmt = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($stmt);
    $DureeMax = $row['DureeMax'];
    $DureeMin = $row['DureeMin'];
    $PrixMax = $row['PrixMax'];
    $PrixMin = $row['PrixMin'];
    $today = date("Y-m-d");
?>

<p>
    Filtrer les voyages :
</p>

<p>
    <table border=1>
        <tr>
            <form action="./resultat_recherche.php?" method="GET">
                <?php
                    if(!isset($_GET['jours']) and !isset($_GET['nombre_passa']) and !isset($_GET['prix'])){
                ?>
                <td><label for="date_debut">Date de début</label></td>
                <td><input type="date" id="date_debut" name="date_debut" value="<?php echo $today ?>"></td>
                <td><label for="date_fin">Date de fin</label></td>
                <td><input type="date" id="date_fin" name="date_fin"></td>
                <td><label for="jours">Nombre de jours maximum</label></td>
                <td><input type="range" id="jours" name="jours" min="<?php echo $DureeMin ?>" max="<?php echo $DureeMax ?>" value="<?php echo $DureeMax ?>" oninput="this.nextElementSibling.value = this.value"><output><?php echo $DureeMax ?></output></td>
                <td><label for="nombre_passa">Nombre de places</label></td>
                <td><input type="range" id="nombre_passa" name="nombre_passa" min="1" max="20" value="1" oninput="this.nextElementSibling.value = this.value"><output>1</output></td>
                <td><label for="prix">Prix maximum</label></td>
                <td><input type="range" id="prix" name="prix" min="<?php echo $PrixMin ?>" max="<?php echo $PrixMax ?>" value="<?php echo $PrixMax ?>" oninput="this.nextElementSibling.value = this.value"><output><?php echo $PrixMax ?></output></td>
                <td><input type="submit" value="Rechercher"></td>
                <?php
                    }else{
                ?>
                 <td><label for="date_debut">Date de début</label></td>
                <td><input type="date" id="date_debut" name="date_debut" value="<?php echo $_GET['date_debut'] ?>"></td>
                <td><label for="date_fin">Date de fin</label></td>
                <td><input type="date" id="date_fin" name="date_fin" value="<?php echo $_GET['date_fin'] ?>"></td>
                <td><label for="jours">Nombre de jours maximum</label></td>
                <td><input type="range" id="jours" name="jours" min="<?php echo $DureeMin ?>" max="<?php echo $DureeMax ?>" value="<?php echo $_GET['jours'] ?>" oninput="this.nextElementSibling.value = this.value"><output><?php echo $_GET['jours'] ?></output></td>
                <td><label for="nombre_passa">Nombre de places</label></td>
                <td><input type="range" id="nombre_passa" name="nombre_passa" min="1" max="20" value="<?php echo $_GET['nombre_passa'] ?>" oninput="this.nextElementSibling.value = this.value"><output><?php echo $_GET['nombre_passa'] ?></output></td>
                <td><label for="prix">Prix maximum</label></td>
                <td><input type="range" id="prix" name="prix" min="<?php echo $PrixMin ?>" max="<?php echo $PrixMax ?>" value="<?php echo $_GET['prix'] ?>" oninput="this.nextElementSibling.value = this.value"><output><?php echo $_GET['prix'] ?></output></td>
                <td><input type="submit" value="Rechercher"></td>
                <?php
                    }
                ?>
            </form>
        </tr>
    </table>

        <br><br>
</p>