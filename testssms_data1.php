<?php

$serverName = "db1.tkse.lk";
$database = "Area51";
$uid = "Area51";
$pass ="D@e5XGnULj";

$connection =[
    "Database" => $database,
    "Uid" => $uid,
    "PWD" => $pass    
];

$conn = sqlsrv_connect($serverName, $connection);
if( !$conn)
    die(print_r(sqlsrv_errors(),true));
else
echo 'connection established';

$d=2500;
$sql = "INSERT INTO hcsr04 (distance) VALUES (" . $d . ")";

$stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die("Error: " . print_r(sqlsrv_errors(), true));
    } else {
        echo "New record created successfully";
    }

/*

$serverName = "MSI\SQLEXPRESS";
$connectionOptions = array(
    "Database" => "sensor",
    "Uid" => "",
    "PWD" => ""
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

echo "Database connection is OK...  ";
/*
if (isset($_POST["distance"])) {
    $d = $_POST["distance"];
    $sql = "INSERT INTO hcsr04 (distance) VALUES (" . $d . ")";

    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die("Error: " . print_r(sqlsrv_errors(), true));
    } else {
        echo "New record created successfully";
    }
}
sqlsrv_close($conn);
*/

?>

