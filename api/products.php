<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ianed\JwtApi\AuthService;
use Ianed\JwtApi\ProductController;

header('Content-Type: application/json');

$auth = new AuthService();
$token = null;
$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
if (preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
    $token = trim($matches[1]);
}

if (!$token) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Token de autorización requerido'
    ]);
    exit;
}

$decoded = $auth->validarToken($token);
if (!$decoded) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Token inválido o expirado'
    ]);
    exit;
}

$controller = new ProductController();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $controller->listar();
        break;
    case 'POST':
        $controller->guardar();
        break;
    case 'PUT':
        $controller->editar();
        break;
    case 'DELETE':
        $controller->eliminar();
        break;
    default:
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
        break;
}
