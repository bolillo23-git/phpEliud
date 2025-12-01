<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $correo = $_POST['correo'] ?? '';

    if (empty($correo)) {
        echo json_encode(["status" => "error", "message" => "Correo vacío"]);
        exit;
    }

    // Código temporal de recuperación
    $codigo = rand(100000, 999999);

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'TU_CORREO@gmail.com';
        $mail->Password = 'ohlandlbfqenuwuv'; // ← CAMBIA ESTO
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('TU_CORREO@gmail.com', 'Recuperación');
        $mail->addAddress($correo);

        $mail->isHTML(true);
        $mail->Subject = 'Código de recuperación';
        $mail->Body = "<h3>Tu código de recuperación es: <b>$codigo</b></h3>";

        $mail->send();

        echo json_encode([
            "status" => "ok",
            "message" => "Código enviado",
            "codigo" => $codigo
        ]);
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => "mail ERROR",
            "debug" => $mail->ErrorInfo
        ]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>
