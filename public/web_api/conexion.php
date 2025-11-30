<?php
$host = "bstvndf39q5wtuj2jq3c-mysql.services.clever-cloud.com";
$dbname = "bstvndf39q5wtuj2jq3c";
$username = "unrl4oy6t7svgk6i";
$password = "E8cg8K1l4HKAMW7E1ndd";
$port = "3306";

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode([
        "error" => "Error de conexión: ".$e->getMessage()
    ]);
    exit;
}
?>
