<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

// Importar clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar PHPMailer desde tu carpeta
require __DIR__ . '/phpmailer/Exception.php';
require __DIR__ . '/phpmailer/PHPMailer.php';
require __DIR__ . '/phpmailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // El parámetro correcto es "email"
    $correo = $_POST['email'] ?? '';

    if (empty($correo)) {
        echo json_encode(["status" => "error", "message" => "Correo vacío"]);
        exit;
    }

    // Código temporal para recuperar password
    $codigo = rand(100000, 999999);

    $mail = new PHPMailer(true);

    try {

        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'TUCORREO@gmail.com';  
        $mail->Password = 'ohlandlbfqenuwuv';  // CONTRASEÑA DE APLICACIÓN (SIN ESPACIOS)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinatario
        $mail->setFrom('TUCORREO@gmail.com', 'Recuperación de cuenta');
        $mail->addAddress($correo);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Código de recuperación';
        $mail->Body = "<h2>Tu código de recuperación es:</h2>
                       <h1><b>$codigo</b></h1>";

        // Enviar
        $mail->send();

        echo json_encode([
            "status" => "ok",
            "message" => "Código enviado correctamente",
            "codigo" => $codigo
        ]);

    } catch (Exception $e) {

        echo json_encode([
            "status" => "error",
            "message" => "Error enviando correo",
            "debug" => $mail->ErrorInfo
        ]);
    }

} else {

    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>
