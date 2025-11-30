<?php 
$Usuario = $_REQUEST['Usuario'];
$Contraseña = $_REQUEST['Contraseña'];

// DATOS DE CLEVER CLOUD
$servername = "bstvndf39q5wtuj2jq3c-mysql.services.clever-cloud.com";
$username   = "unrl4oy6t7svgk6i";
$password   = "E8cg8K1l4HKAMW7E1ndd";
$dbname     = "bstvndf39q5wtuj2jq3c";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("CALL sp_validar_login(:usuario, :con)");

    $stmt->bindParam(':usuario', $Usuario);
    $stmt->bindParam(':con', $Contraseña);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

} catch(PDOException $e) {
    echo json_encode([
        "error" => true,
        "message" => $e->getMessage()
    ]);
}

$conn = null;
?>
