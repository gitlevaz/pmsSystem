<?php
$hostname = "db1.tkse.lk";
$username = "Area51";
$password = "D@e5XGnULj";
$database = "Area51";

try {
    $conn = new PDO("sqlsrv:Server=$hostname;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection is OK<br>";

    if (isset($_POST["distance"])) {
        $d = $_POST["distance"];
        $sql = "INSERT INTO hcsr04 (distance) VALUES (?)";
        $stmt = $conn->prepare($sql);

        if ($stmt !== false && $stmt->execute([$d])) {
            echo "New record created successfully";
        } else {
            echo "Error: Unable to insert the record";
        }
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>

