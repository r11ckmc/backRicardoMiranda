<?php
require_once __DIR__ . '/../core/conexion.php';

class cervezasModel {
    private $db;

    public function __construct() {
        $this->db = conexion::connect();
    }

    public function getAll() {
        $sql = $this->db->query("SELECT * FROM cervezas");
        return $sql->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM cervezas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function deleteByID($id) {
        // Verificar si el registro existe antes de eliminarlo
        $registro = $this->getById($id);
        if (!$registro) {
            return false; // No encontrado
        }

        // Ejecutar la eliminación
        $stmt = $this->db->prepare("DELETE FROM cervezas WHERE id = ?");
        $stmt->execute(params: [$id]);

        // Devolver el registro eliminado en la respuesta
        return $registro;
    }


    public function test($data) {
        


    }




    
    public function updateByIDV2($data) {


        $id = $data["id"];

        if (!$data["id"] || !is_numeric($data["id"])) {
            error_log("Error: ID inválido en updateByID: " . json_encode($id));
            return $data;
        }
        

        $stmt = $this->db->prepare("UPDATE cervezas SET nombre = ?, marca = ?, ml = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$data['nombre'], $data['marca'], $data['ml'], $id]);
        




        

    if ($stmt->rowCount() > 0) {
        return [
            'result' => [
                'codigo' => 200,
                'mensaje' => 'Registro actualizado correctamente',
                'object' => [$this->getById($id)]
            ]
        ];
    } else {
        return [
            'result' => [
                'codigo' => 404,
                'mensaje' => 'Registro no encontrado o sin cambios',
                'object' => []
            ]
        ];
    }
    
    }

    public function updateByIDV3($data) {
        $id = $data["id"] ?? null;
    
        if (!$id || !is_numeric($id)) {
            error_log("Error: ID inválido recibido en updateByIDV2: " . json_encode($id));
            return [
                'error' => true,
                'mensaje' => 'ID inválido recibido.',
                'exception' => null
            ];
        }
    
        try {
            $stmt = $this->db->prepare("
                UPDATE cervezas 
                SET nombre = ?, marca = ?, ml = ?, updated_at = NOW()
                WHERE id = ?
            ");
    
            $stmt->execute([$data['nombre'], $data['marca'], $data['ml'], $id]);
    
            if ($stmt->rowCount() > 0) {
                $registro = $this->getById($id);
                return [
                    'error' => false,
                    'registro' => $registro
                ];
            } else {
                error_log("No se modificó ninguna fila para ID: $id");
                return [
                    'error' => true,
                    'mensaje' => 'Registro no encontrado o sin cambios',
                    'exception' => null
                ];
            }
    
        } catch (PDOException $e) {
            error_log(" Error en updateByIDV2: " . $e->getMessage());
    
            return [
                'error' => true,
                'mensaje' => 'Error en la base de datos al intentar actualizar',
                'exception' => $e->getMessage()
            ];
        }
    }
    

    public function insertarV1($data) {
        try {
            // Validar campos requeridos
            if (!isset($data['nombre'], $data['marca'], $data['ml'])) {
                return [
                    'error' => true,
                    'mensaje' => 'Faltan campos requeridos (nombre, marca, ml)',
                    'exception' => null
                ];
            }
    
            // Preparar la consulta de inserción
            $stmt = $this->db->prepare("
                INSERT INTO cervezas (nombre, marca, ml, habilitado, updated_at)
                VALUES (?, ?, ?, 1, NOW())
            ");
    
            $stmt->execute([
                $data['nombre'],
                $data['marca'],
                $data['ml']
            ]);
    
            // Obtener el ID generado automáticamente
            $lastId = $this->db->lastInsertId();
    
            return [
                'error' => false,
                'registro' => $this->getById($lastId)
            ];
    
        } catch (PDOException $e) {
            error_log("Error en insertV2: " . $e->getMessage());
    
            return [
                'error' => true,
                'mensaje' => 'Error al insertar el registro',
                'exception' => $e->getMessage()
            ];
        }
    }
    
    
    
    
}
