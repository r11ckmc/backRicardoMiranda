<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../app/core/conexion.php';

// Conectar a la base de datos
$conn = conexion::connect();

// Verificar si se solicita una cerveza específica (por ID)
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitizar el parámetro
    try {
        $stmt = $conn->prepare("SELECT * FROM cervezas WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $cerveza = $stmt->fetch();

        if ($cerveza) {
            echo json_encode([
                'result' => [
                    'codigo' => 200,
                    'mensaje' => 'Cerveza encontrada',
                    'object' => [$cerveza]
                ]
            ]);
        } else {
            echo json_encode([
                'result' => [
                    'codigo' => 404,
                    'mensaje' => 'Cerveza no encontrada',
                    'object' => []
                ]
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'result' => [
                'codigo' => 500,
                'mensaje' => 'Error en la consulta: ' . $e->getMessage(),
                'object' => []
            ]
        ]);
    }
} else {
    // Obtener todas las cervezas
    try {
        $stmt = $conn->query("SELECT * FROM cervezas");
        $cervezas = $stmt->fetchAll();

        echo json_encode([
            'result' => [
                'codigo' => 200,
                'mensaje' => 'Lista de cervezas',
                'object' => $cervezas
            ]
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'result' => [
                'codigo' => 500,
                'mensaje' => 'Error en la consulta: ' . $e->getMessage(),
                'object' => []
            ]
        ]);
    }
}
