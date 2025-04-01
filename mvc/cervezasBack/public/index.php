<?php
header("Access-Control-Allow-Origin: *"); // Permitir acceso desde cualquier origen
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

require_once __DIR__ . '/../app/core/Rutas.php';
require_once __DIR__ . '/../app/controladores/CervezaController.php';

// Capturar el JSON de la solicitud POST
$input = json_decode(file_get_contents("php://input"), true) ?? [];

// Definir rutas disponibles en el router
$router = new Rutas();

$router->addRoute('POST', 'cervezas/listar', callback: function(): void {
    $controller = new CervezaController();
    $controller->index();
});

$router->addRoute('POST', 'cervezas/buscar', function() {
    global $input;
    $controller = new CervezaController();
    $controller->show($input['id'] ?? null);
});

$router->addRoute('POST', 'cervezas/crear', function() {
    global $input;
    $controller = new CervezaController();
    //$controller->store($input);
});

$router->addRoute('POST', 'cervezas/actualizar', function() {
    global $input;
    $controller = new CervezaController();
    //$controller->update($input['id'] ?? null, $input);
});

$router->addRoute('POST', 'cervezas/eliminar', function() {
    global $input;
    $controller = new CervezaController();
    $controller->delete($input['id'] ?? null);
});

$router->addRoute('POST', 'cervezas/actualizarTEMP', function() {
    global $input;
    $controller = new CervezaController();
    
    error_log("Datos recibidos en la API: " . json_encode($input));

    //$controller->update($input);
});

$router->addRoute('POST', 'cervezas/update', function() {
    global $input;
    $controller = new CervezaController();
    
    error_log("Datos recibidos en la API: " . json_encode($input));

    $controller->updateV3($input);
});


$router->addRoute('POST', 'cervezas/agregar', function() {
    global $input;
    $controller = new CervezaController();
    $controller->Insert($input);
});




$router->addRoute('POST', 'TESTING/TEST', function() {
    echo 'testeo pasado';

});


$router->dispatch();
