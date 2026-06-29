<?php

namespace Ianed\JwtApi;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService implements IAuthService
{
    private $secretKey;

    public function __construct()
    {
        require_once __DIR__ . '/../config/config.php';

        $this->secretKey = JWT_SECRET_KEY;
    }

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function generarToken(string $usuario): string
    {
        $payload = [
            "iss" => "JWT_API",
            "iat" => time(),
            "exp" => time() + 3600,
            "usuario" => $usuario
        ];

        return JWT::encode(
            $payload,
            $this->secretKey,
            'HS256'
        );
    }

    public function validarToken(string $token)
    {
        try {
            return JWT::decode(
                $token,
                new Key(
                    $this->secretKey,
                    'HS256'
                )
            );
        } catch (\Exception $e) {
            return false;
        }
    }
}