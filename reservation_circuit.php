<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Reservation Circuit</title>
</head>

<body>

    <?php
    //ici on se connecte a la base sql
    $serverName = "DESKTOP-GUBKKB7";
    $connectionInfo = array("Database" => "ProjetBD");
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if ($conn) {
        echo 'connection réussie<br>';
    }


    echo 'La liste des circuits<br><br>';
    $sql = 'select Circuit.Descriptif_Circuit FROM Circuit ';
    $stmt = sqlsrv_query($conn, $sql);



    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo $row['Descriptif_Circuit'] . "<br />";
    }


    ?>




</body>

</html>