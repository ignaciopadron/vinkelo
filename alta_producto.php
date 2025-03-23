<?php
session_start();
require 'config.php';
?>
<?php
// Verificar si es admin
if (!isset($_SESSION['user_id']) || !esAdmin($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y sanitizar inputs
    $datos = [
        'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING),
        'precio' => filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_NUMBER_FLOAT),
        // ... otros campos
    ];
    
    $stmt = $pdo->prepare("INSERT INTO vinos (...) VALUES (...)");
    $stmt->execute($datos);
}
?>
<!-- Formulario HTML para añadir productos -->