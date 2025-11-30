<?php
$servername = "bstvndf39q5wtuj2jq3c-mysql.services.clever-cloud.com";
$username   = "unrl4oy6t7svgk6i";
$password   = "E8cg8K1l4HKAMW7E1ndd";
$dbname     = "bstvndf39q5wtuj2jq3c";

try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Llamada al stored procedure (sin nombre de la BD)
    $stmt = $conn->prepare("CALL sp_buscar_usuario()");
    $stmt->execute();

    // Obtener todos los resultados en un array asociativo
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convertir a JSON
    echo json_encode($result);

} catch(PDOException $e) {
    echo json_encode([
        "error" => true,
        "message" => $e->getMessage()
    ]);
}

$conn = null;
?>
