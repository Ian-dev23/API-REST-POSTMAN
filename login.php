<?php

require_once __DIR__ . '/vendor/autoload.php';

use Ianed\JwtApi\DB;
use Ianed\JwtApi\AuthService;

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$usuario = $input['usuario'] ?? $_POST['usuario'] ?? '';
$password = $input['password'] ?? $_POST['password'] ?? '';

if (empty($usuario) || empty($password)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Usuario y contraseña son obligatorios"
    ]);
    exit;
}

try {
    $db = new DB();
    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $db->getConexion()->prepare($sql);
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error al conectar con la base de datos"
    ]);
    exit;
}

if (!$user) {
    http_response_code(404);
    echo json_encode([
        "success" => false,
        "message" => "Usuario no encontrado"
    ]);
    exit;
}

$auth = new AuthService();

if (!$auth->verifyPassword($password, $user['password'])) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "Contraseña incorrecta"
    ]);
    exit;
}

$token = $auth->generarToken($usuario);

echo json_encode([
    "success" => true,
    "token" => $token
]);