<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'usuario_db'); // Reemplazar con tu usuario
define('DB_PASS', 'password_db'); // Reemplazar con tu contraseña
define('DB_NAME', 'vinkelo');

// Configuración de rutas
define('BASE_URL', '/'); // URL base del sitio
define('ROOT_PATH', dirname(dirname(__DIR__))); // Ruta raíz del proyecto
define('APP_PATH', ROOT_PATH . '/app'); // Ruta de la aplicación
define('PUBLIC_PATH', ROOT_PATH . '/public'); // Ruta pública

// Iniciar sesión
session_start();

// Conexión a la base de datos con PDO
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
} 