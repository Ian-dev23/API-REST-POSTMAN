<?php

namespace Ianed\JwtApi;

use PDO;

class DB
{
    protected $conexion;

    public function __construct()
    {
        require_once __DIR__ . '/../config/config.php';

        $this->conexion = new PDO(
            "mysql:host=".DB_HOST.";dbname=".DB_NAME,
            DB_USER,
            DB_PASS
        );

        $this->conexion->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }

    public function getConexion()
    {
        return $this->conexion;
    }
}