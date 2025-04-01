<?php
class controladorBase {
    protected $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function index() {
        echo json_encode(['result' => ['codigo' => 200, 'mensaje' => 'Datos obtenidos', 'object' => $this->model->getAll()]]);
    }

    public function show($id) {
        if (!$id) {
            echo json_encode(['result' => ['codigo' => 400, 'mensaje' => 'ID requerido', 'object' => []]]);
            return;
        }

        $data = $this->model->getById($id);
        echo json_encode(['result' => ['codigo' => $data ? 200 : 404, 'mensaje' => $data ? 'Registro encontrado' : 'No encontrado', 'object' => $data ? [$data] : []]]);

    }
    public function delete($id) {
        if (!$id) {
            echo json_encode([
                'result' => [
                    'codigo' => 400,
                    'mensaje' => 'ID requerido para eliminar el registro',
                    'object' => []
                ]
            ]);
            return;
        }

        // Intentar eliminar el registro
        $data = $this->model->deleteByID($id);

        // Respuesta JSON estructurada
        echo json_encode([
            'result' => [
                'codigo' => $data ? 200 : 404,
                'mensaje' => $data ? 'Registro eliminado correctamente' : 'Registro no encontrado',
                'object' => $data ? [$data] : []
            ]
        ]);
    }


    public function updateTest($data) {

        if(true)
        {
            echo json_encode([
                'result' => [
                    'codigo' => 1,
                    'mensaje' => $data["id"],
                    'object' => [$data]
                ]
            ]);
        }
    }




    public function updateV2($data){

        $registroActualizado = $this->model->updateByIDV2($data);

        echo json_encode([
            'result' => [
                'codigo' => $registroActualizado ? 200 : 404,
                'mensaje' => $registroActualizado ? 'Registro eliminado correctamente' : 'Registro no encontrado',
                'object' => $registroActualizado ? [$registroActualizado] : []
            ]
        ]);

    }

    public function updateV3($data) {
        $resultado = $this->model->updateByIDV2($data);
    
        if (isset($resultado['error']) && $resultado['error']) {
            echo json_encode([
                'result' => [
                    'codigo' => 500,
                    'mensaje' => $resultado['mensaje'] ?? 'Error desconocido',
                    'object' => [
                        'exception' => $resultado['exception']
                    ]
                ]
            ]);
        } else {
            echo json_encode([
                'result' => [
                    'codigo' => 200,
                    'mensaje' => 'Registro actualizado correctamente',
                    'object' => [$resultado['registro']]
                ]
            ]);
        }
    }

    public function Insert($data) {
        $resultado = $this->model->insertarV1($data);
    
        if ($resultado['error']) {
            echo json_encode([
                'result' => [
                    'codigo' => 500,
                    'mensaje' => $resultado['mensaje'],
                    'object' => [
                        'exception' => $resultado['exception']
                    ]
                ]
            ]);
        } else {
            echo json_encode([
                'result' => [
                    'codigo' => 201,
                    'mensaje' => 'Registro insertado correctamente',
                    'object' => [$resultado['registro']]
                ]
            ]);
        }
    }
    
    
    
    
    
}
  