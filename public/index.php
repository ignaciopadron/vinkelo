<?php
/**
 * Punto de entrada principal para la aplicación Vinkelo
 */

// Cargar configuración y funciones
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/helpers/functions.php';

// Obtener la URL solicitada
$request_uri = $_SERVER['REQUEST_URI'];

// Eliminar query string si existe
$request_uri = preg_replace('/\?.*$/', '', $request_uri);

// Eliminar la base path de la URL si existe
$base_path = parse_url(BASE_URL, PHP_URL_PATH);
if ($base_path && $base_path !== '/') {
    $request_uri = str_replace($base_path, '', $request_uri);
}

// Asegurarse de que siempre empiece con /
$request_uri = '/' . ltrim($request_uri, '/');

// Definir rutas
$routes = [
    '/' => ['HomeController', 'index'],
    '/about' => ['HomeController', 'about'],
    '/contact' => ['HomeController', 'contact'],
    '/wines' => ['WineController', 'index'],
    '/wine/([0-9]+)' => ['WineController', 'detail'],
    '/search' => ['WineController', 'search'],
    '/login' => ['AuthController', 'login'],
    '/register' => ['AuthController', 'register'],
    '/logout' => ['AuthController', 'logout'],
    '/admin' => ['AdminController', 'index'],
    '/admin/create' => ['AdminController', 'create'],
    '/admin/store' => ['AdminController', 'store'],
    '/admin/edit/([0-9]+)' => ['AdminController', 'edit'],
    '/admin/update/([0-9]+)' => ['AdminController', 'update'],
    '/admin/delete/([0-9]+)' => ['AdminController', 'delete']
];

// Buscar una coincidencia de ruta
$route_match = false;
foreach ($routes as $route => $controller_action) {
    // Convertir la ruta a una expresión regular
    $pattern = '#^' . $route . '$#';
    
    // Verificar si la URL coincide con la ruta
    if (preg_match($pattern, $request_uri, $matches)) {
        $route_match = true;
        
        // Obtener controlador y acción
        list($controller_name, $action_name) = $controller_action;
        
        // Cargar el controlador
        require_once APP_PATH . "/controllers/{$controller_name}.php";
        
        // Crear instancia del controlador
        $controller = new $controller_name($pdo);
        
        // Eliminar la coincidencia completa
        array_shift($matches);
        
        // Llamar a la acción con los parámetros
        call_user_func_array([$controller, $action_name], $matches);
        
        break;
    }
}

// Si no hay coincidencia, mostrar página de error 404
if (!$route_match) {
    header("HTTP/1.0 404 Not Found");
    
    // Cargar vista de error 404
    require_once APP_PATH . '/views/components/header.php';
    echo '<div class="container py-5 text-center">';
    echo '<h1 class="display-1">404</h1>';
    echo '<h2>Página no encontrada</h2>';
    echo '<p class="lead">Lo sentimos, la página que estás buscando no existe.</p>';
    echo '<a href="' . BASE_URL . '" class="btn btn-wine mt-3">Volver al inicio</a>';
    echo '</div>';
    require_once APP_PATH . '/views/components/footer.php';
} 