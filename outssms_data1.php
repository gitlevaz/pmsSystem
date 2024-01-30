<?php


$serverName = "db1.tkse.lk";
$connectionOptions = array(
    "Database" => "Area51",
    "Uid" => "Area51",
    "PWD" => "D@e5XGnULj"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

$sql = "SELECT id, distance, datetime FROM hcsr04 ORDER BY id DESC";

echo '<table style="border-collapse: collapse; width: 40%; border: 1px solid black;">
      <tr> 
        <th style="background-color: skyblue; color: black; padding: 8px;">ID</th> 
        <th style="background-color: skyblue; color: black; padding: 8px;">Distance</th> 
        <th style="background-color: skyblue; color: black; padding: 8px;">Datetime</th>
      </tr>';

$result = sqlsrv_query($conn, $sql);
if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $row_id = $row["id"];
    $row_distance = $row["distance"];
    $row_datetime = $row["datetime"];        

    echo '<tr style="border: 1px solid black;"> 
            <td style="padding: 8px;">' . $row_id . '</td> 
            <td style="padding: 8px;">' . $row_distance . '</td> 
            <td style="padding: 8px;">' . $row_datetime->format('Y-m-d H:i:s') . '</td>                 
          </tr>';
}

sqlsrv_free_stmt($result);
sqlsrv_close($conn);



/*
$serverName = "MSI\SQLEXPRESS";
$connectionOptions = array(
    "Database" => "sensor",
    "Uid" => "",
    "PWD" => ""
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

$sql = "SELECT id, distance, datetime FROM hcsr04 ORDER BY id DESC";

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <th>ID</th> 
        <th>Distance</th> 
        <th>Datetime</th>
      </tr>';

$result = sqlsrv_query($conn, $sql);
if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $row_id = $row["id"];
    $row_distance = $row["distance"];
    $row_datetime = $row["datetime"];        

    echo '<tr> 
            <td>' . $row_id . '</td> 
            <td>' . $row_distance . '</td> 
            <td>' . $row_datetime->format('Y-m-d H:i:s') . '</td>                 
          </tr>';
}

sqlsrv_free_stmt($result);
sqlsrv_close($conn);
*/
?> 