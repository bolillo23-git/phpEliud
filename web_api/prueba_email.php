<?php
// Leer API Key desde .env
$dotenv = __DIR__ . '/.env';
if (file_exists($dotenv)) {
    $lines = file($dotenv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
    }
}
$apiKey = getenv('SENDINBLUE_API_KEY');

// Correo de prueba
$toEmail = "tucorreo@ejemplo.com"; // tu email para prueba
$toName  = "Tu Nombre";

$data = [
    'sender' => ['name' => 'Prueba', 'email' => 'soporte@tuservidor.com'],
    'to' => [['email' => $toEmail, 'name' => $toName]],
    'subject' => 'Correo de prueba Sendinblue',
    'textContent' => "Hola $toName,\n\nEste es un correo de prueba para verificar Sendinblue."
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
    echo "Error envío correo: $err";
} else {
    echo "Correo de prueba enviado correctamente. Respuesta API: $response";
}
?>
