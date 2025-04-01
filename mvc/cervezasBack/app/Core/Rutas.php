<?php
class Rutas {
    private $routes = [];

    public function addRoute($method, $route, $callback) {
        $this->routes[] = [
            'method' => $method,
            'route' => trim($route, '/'),
            'callback' => $callback
        ];
    }

    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // Obtener la URL sin la parte de la carpeta base
        $basePath = '/cervezasBack/public'; // Cambia esto según tu estructura
        $requestUri = trim(str_replace($basePath, '', $_SERVER['REQUEST_URI']), '/');

        // Mostrar en logs la ruta recibida para depuración
        error_log("Método: $requestMethod, URI Procesada: $requestUri");

        // Verificar que solo se permitan solicitudes POST
 

        // Buscar la ruta en las definidas
        foreach ($this->routes as $route) {
            if ($route['route'] === $requestUri) {
                call_user_func($route['callback']);
                return;
            }
        }

        // Si la ruta no existe, mostrar cuál fue solicitada
        echo json_encode([
            'result' => [
                'codigo' => 404,
                'mensaje' => "Ruta no encontrada: $requestUri",
                'object' => []
            ]
        ]);
        exit;
    }
}
