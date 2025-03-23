<?php

require_once 'config.php';



function sanitizarInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
// Por tipo de Vino
function obtenerVinosPorTipo($tipo_id) {
    global $pdo; // Usamos la conexión PDO

    try {
        $stmt = $pdo->prepare("SELECT * FROM vinos WHERE tipo_id = :tipo_id");
        $stmt->execute([':tipo_id' => $tipo_id]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        die("Error al obtener vinos: " . $e->getMessage());
    }
}
// Por variedad de uva
function obtenerVinosPorVariedad($variedad_id, $limit = 12, $offset = 0) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM vinos WHERE variedad_id = :variedad_id LIMIT :limit OFFSET :offset");
        // Vincular parámetros de forma explícita
    $stmt->bindValue(':variedad_id', $variedad_id, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll();
}
// Función para contar total de vinos por variedad
function contarVinosPorVariedad($variedad_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM vinos WHERE variedad_id = ?");
    $stmt->execute([$variedad_id]);
    return $stmt->fetchColumn();
}

// Por región
function obtenerVinosPorRegion($region_id, $limit = 12, $offset = 0) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM vinos WHERE region_id = :region_id LIMIT :limit OFFSET :offset");
        // Vincular parámetros de forma explícita
    $stmt->bindValue(':region_id', $region_id, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);   
    $stmt->execute();
    return $stmt->fetchAll();
}

// Por crianza
function obtenerVinosPorCrianza($crianza_id, $limit = 12, $offset = 0) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM vinos WHERE crianza_id = :crianza_id LIMIT :limit OFFSET :offset");
        // Vincular parámetros de forma explícita
    $stmt->bindValue(':crianza_id', $crianza_id, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); 
    $stmt->execute();
    return $stmt->fetchAll();
}

// Por rango de precio
function obtenerVinosPorPrecio($precio_id,  $limit = 12, $offset = 0) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM vinos WHERE precio_id = :precio_id LIMIT :limit OFFSET :offset");
        // Vincular parámetros de forma explícita
    $stmt->bindValue(':precio_id', $precio_id, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); 
    $stmt->execute();
    return $stmt->fetchAll();
}



// Función para obtener nombre de variedad
function obtenerNombreVariedad($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT nombre FROM variedades_uva WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchColumn() ?: 'Variedad Desconocida';
}

// Función similar para regiones
function obtenerNombreRegion($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT nombre FROM regiones WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchColumn() ?: 'Región Desconocida';
}

// Función para obtener nombre para Crianza
function obtenerNombreCrianza($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT nombre FROM crianzas WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchColumn() ?: 'Crianza Desconocida';
}

// Función para obtener nombre para Precio
function obtenerNombrePrecio($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT etiqueta FROM precios_rango WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchColumn() ?: 'Precio Desconocido';
}

// Función para obtener todos los vinos (para cuando no hay filtro)
function obtenerTodosLosVinos($limit = 12, $offset = 0) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM vinos LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// FUNCIO PARA BUSCAR VINOS EN EL BUSCADOR =====================================================================
function buscarVinos($termino, $limit = 12, $offset = 0) {
    global $pdo;
    
    $termino = '%' . $termino . '%';
    
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM vinos 
            WHERE 
              nombre LIKE :termino OR
              descripcion LIKE :termino OR
              uva LIKE :termino OR
              region LIKE :termino OR
              tipo_vino LIKE :termino
            LIMIT :limit OFFSET :offset";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':termino', $termino, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    return [
        'vinos' => $stmt->fetchAll(),
        'total' => $pdo->query("SELECT FOUND_ROWS()")->fetchColumn()
    ];
}


// Inicio sesion con permisos admin -=============================================================
function esAdmin($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT rol FROM usuarios WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchColumn() === 'admin';
}







?>
