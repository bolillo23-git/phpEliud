<?php
$idUsuario = $_REQUEST['idUsuario'];

$servername = "bstvndf39q5wtuj2jq3c-mysql.services.clever-cloud.com";
$username   = "unrl4oy6t7svgk6i";
$password   = "E8cg8K1l4HKAMW7E1ndd";
$dbname     = "bstvndf39q5wtuj2jq3c";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Llamar al stored procedure
    $stmt = $conn->prepare("
        CALL sp_eliminar_usuario(:id)
    ");

    $stmt->bindParam(':id', $idUsuario);

    $stmt->execute();

    echo json_encode([
        "mensaje" => "Se eliminó con éxito",
        "idEliminado" => $idUsuario
    ]);

} catch(PDOException $e) {
    echo json_encode([
        "error" => true,
        "message" => $e->getMessage()
    ]);
}

$conn = null;
?>
