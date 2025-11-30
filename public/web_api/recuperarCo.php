<?php
$email = $_REQUEST['email'];

$servername = "bstvndf39q5wtuj2jq3c-mysql.services.clever-cloud.com";
$username   = "unrl4oy6t7svgk6i";
$password   = "E8cg8K1l4HKAMW7E1ndd";
$dbname     = "bstvndf39q5wtuj2jq3c";

try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Llamar a SP corregido
    $stmt = $conn->prepare("CALL sp_recuperar_contrasena(:email)");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {

        $nombre     = $result['nombreUsuario'];
        $contrasena = $result['passwordLogin'];

        // Datos del correo
        $to      = $email;
        $subject = "Recuperación de contraseña - Sistema de Login";

        $txt = "
Hola $nombre,

Tu contraseña registrada en el sistema es:

    $contrasena

Por favor, no compartas esta información con nadie.

Atentamente,
Soporte del Sistema
";

        $headers = "From: soporte@tuservidor.com\r\n" .
                   "Reply-To: soporte@tuservidor.com\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        // Enviar correo
        if (mail($to, $subject, $txt, $headers)) {
            echo json_encode(["mensaje" => "Se envió la contraseña al correo."]);
        } else {
            echo json_encode(["mensaje" => "Error al enviar el correo."]);
        }

    } else {
        echo json_encode(["mensaje" => "Correo no registrado."]);
    }

} catch(PDOException $e) {
    echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
}

$conn = null;
?>

