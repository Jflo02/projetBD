<?php
session_start(); //pour demarrer la session

//ici on se connecte a la base sql
$serverName = "DESKTOP-GUBKKB7";
$connectionInfo = array("Database" => "ProjetBD");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if ($conn) {
    echo 'connection réussie<br>';
}
//coucou ici
//A SUPPRIMER QUAND ON AURA LES SESSIONS
$_SESSION['prenom_user'] = 'Flo';
echo 'Bonjour ' . $_SESSION['prenom_user'] . ' voici la liste des circuits actuellement proposés<br>';



?>
<table border=1>
    <tr>
        <th>
            Filtres :
        </th>


        <th>
            <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
            <label for="vehicle1"> I have a bike</label>
        </th>
        <th>
            <input type="checkbox" id="vehicle2" name="vehicle2" value="Car">
            <label for="vehicle2"> I have a car</label>
        </th>
        <th>
            <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
            <label for="vehicle3"> I have a boat</label>
        </th>
    </tr>
</table>