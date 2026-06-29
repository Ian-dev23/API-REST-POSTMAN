<?php

namespace Ianed\JwtApi;

use PDO;

class ProductController extends DB
{
    private function getRequestData(): array
    {
        return json_decode(file_get_contents("php://input"), true) ?? [];
    }

    private function response(array $data, int $status = 200): void
    {
        http_response_code($status);
        echo json_encode($data);
    }

    public function listar()
    {
        try {
            $sql = "SELECT * FROM productos";
            $stmt = $this->getConexion()->query($sql);
            $this->response($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (\Exception $e) {
            $this->response([
                "success" => false,
                "message" => "Error al obtener productos",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function guardar()
    {
        $datos = $this->getRequestData();

        if (empty($datos["nombre"]) || empty($datos["precio"])) {
            $this->response([
                "success" => false,
                "message" => "Todos los campos son obligatorios"
            ], 400);
            return;
        }

        try {
            $sql = "INSERT INTO productos (nombre, precio) VALUES (?, ?)";
            $stmt = $this->getConexion()->prepare($sql);
            $resultado = $stmt->execute([
                $datos["nombre"],
                $datos["precio"]
            ]);

            $this->response([
                "success" => $resultado,
                "message" => "Producto registrado"
            ], $resultado ? 201 : 500);
        } catch (\Exception $e) {
            $this->response([
                "success" => false,
                "message" => "Error al registrar producto",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function editar()
    {
        $datos = $this->getRequestData();

        if (empty($datos["id"]) || empty($datos["nombre"]) || empty($datos["precio"])) {
            $this->response([
                "success" => false,
                "message" => "Datos incompletos"
            ], 400);
            return;
        }

        try {
            $sql = "UPDATE productos SET nombre = ?, precio = ? WHERE id = ?";
            $stmt = $this->getConexion()->prepare($sql);
            $resultado = $stmt->execute([
                $datos["nombre"],
                $datos["precio"],
                $datos["id"]
            ]);

            $this->response([
                "success" => $resultado,
                "message" => "Producto actualizado"
            ], $resultado ? 200 : 500);
        } catch (\Exception $e) {
            $this->response([
                "success" => false,
                "message" => "Error al actualizar producto",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function eliminar()
    {
        $datos = $this->getRequestData();

        if (empty($datos["id"])) {
            $this->response([
                "success" => false,
                "message" => "ID requerido"
            ], 400);
            return;
        }

        try {
            $sql = "DELETE FROM productos WHERE id = ?";
            $stmt = $this->getConexion()->prepare($sql);
            $resultado = $stmt->execute([$datos["id"]]);

            $this->response([
                "success" => $resultado,
                "message" => "Producto eliminado"
            ], $resultado ? 200 : 500);
        } catch (\Exception $e) {
            $this->response([
                "success" => false,
                "message" => "Error al eliminar producto",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
