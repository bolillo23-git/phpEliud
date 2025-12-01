<?php
// Leer variables del .env
$dotenv = __DIR__ . '/.env';
if (file_exists($dotenv)) {
    $lines = file($dotenv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
    }
}

// Obtener API Key desde la variable de entorno
$apiKey = getenv('SENDINBLUE_API_KEY');

$email = $_REQUEST['email'];

$servername = "bstvndf39q5wtuj2jq3c-mysql.services.clever-cloud.com";
$username   = "unrl4oy6t7svgk6i";
$password   = "E8cg8K1l4HKAMW7E1ndd";
$dbname     = "bstvndf39q5wtuj2jq3c";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("CALL sp_recuperar_contrasena(:email)");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $nombre     = $result['nombreUsuario'];
        $contrasena = $result['passwordLogin'];

        // Contenido del correo
        $subject = "Recuperación de contraseña - Sistema de Login";
        $content = "Hola $nombre,\n\nTu contraseña registrada en el sistema es: $contrasena\n\nPor favor, no compartas esta información con nadie.";

        // Preparar datos para Sendinblue API
        $data = [
            'sender' => ['name' => 'Soporte del Sistema', 'email' => 'soporte@tuservidor.com'],
            'to' => [['email' => $email, 'name' => $nombre]],
            'subject' => $subject,
            'textContent' => $content
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.sendinblue.com/v3/smtp/email");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "api-key: $apiKey",
            "Content-Type: application/json",
            "Accept: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            echo json_encode(["mensaje" => "Error envío correo: $err"]);
        } else {
            echo json_encode(["mensaje" => "Se envió la contraseña al correo."]);
        }

    } else {
        echo json_encode(["mensaje" => "Correo no registrado."]);
    }

} catch(PDOException $e) {
    echo json_encode(["mensaje" => "Error DB: " . $e->getMessage()]);
}

$conn = null;
?>
