<?php
$nombreU     = $_REQUEST['nombreU'];
$aP          = $_REQUEST['aP'];
$aM          = $_REQUEST['aM'];
$email       = $_REQUEST['email'];
$telefono    = $_REQUEST['telefono'];
$contraseñaL = $_REQUEST['contraseñaL'];
$idRolU      = $_REQUEST['idRolU'];
$nombreL     = $_REQUEST['nombreL'];

// Datos de Clever Cloud
$servername = "bstvndf39q5wtuj2jq3c-mysql.services.clever-cloud.com";
$username   = "unrl4oy6t7svgk6i";
$password   = "E8cg8K1l4HKAMW7E1ndd";
$dbname     = "bstvndf39q5wtuj2jq3c";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $stmt = $conn->prepare("
        CALL sp_crear_cuenta(
            :usuario, 
            :apellidoP, 
            :apellidoM, 
            :email, 
            :tel, 
            :nomL, 
            :con, 
            :idR
        )
    ");

    $stmt->bindParam(':usuario',   $nombreU);
    $stmt->bindParam(':apellidoP', $aP);
    $stmt->bindParam(':apellidoM', $aM);
    $stmt->bindParam(':email',     $email);
    $stmt->bindParam(':tel',       $telefono);
    $stmt->bindParam(':nomL',      $nombreL);
    $stmt->bindParam(':con',       $contraseñaL);
    $stmt->bindParam(':idR',       $idRolU);

    $stmt->execute();

    echo json_encode(["mensaje" => "Cuenta creada con éxito"]);

} catch(PDOException $e) {
    echo json_encode([
        "error" => true,
        "message" => $e->getMessage()
    ]);
}

$conn = null;
?>
