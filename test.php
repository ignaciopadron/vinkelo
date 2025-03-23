<?php
require 'config.php';
require 'funciones.php';

// Test 1: Verificar conexión
echo "<h2>Test de conexión:</h2>";
var_dump($pdo); // Debe mostrar un objeto PDO

// Test 2: Obtener vinos tintos
echo "<h2>Vinos tintos:</h2>";
$vinos = obtenerVinosPorTipo(1);
print_r($vinos);
?>