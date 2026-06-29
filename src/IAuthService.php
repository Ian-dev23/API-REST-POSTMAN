<?php

namespace Ianed\JwtApi;

interface IAuthService
{
    public function hashPassword(string $password): string;

    public function verifyPassword(string $password, string $hash): bool;

    public function generarToken(string $usuario): string;

    public function validarToken(string $token);
}
