<?php
/**
 * Funciones auxiliares generales para el proyecto Vinkelo
 */

/**
 * Sanitiza los datos de entrada
 */
function sanitizarInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

/**
 * Redirecciona a una URL específica
 */
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit;
}

/**
 * Carga una vista
 */
function view($view, $data = []) {
    extract($data);
    $view_path = APP_PATH . '/views/' . $view . '.php';
    
    if (file_exists($view_path)) {
        require_once $view_path;
    } else {
        die("Vista no encontrada: " . $view_path);
    }
}

/**
 * Verifica si un usuario está autenticado
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Verifica si un usuario es administrador
 */
function isAdmin() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
}

/**
 * Obtiene el valor de una variable GET sanitizada
 */
function getParam($key, $default = null) {
    return isset($_GET[$key]) ? sanitizarInput($_GET[$key]) : $default;
}

/**
 * Obtiene el valor de una variable POST sanitizada
 */
function postParam($key, $default = null) {
    return isset($_POST[$key]) ? sanitizarInput($_POST[$key]) : $default;
}

/**
 * Formato de precio
 */
function formatPrice($price) {
    return number_format($price, 2, ',', '.') . ' €';
}

/**
 * Genera URL de un asset
 */
function asset($path) {
    return BASE_URL . 'assets/' . $path;
}

/**
 * Genera URL para subidas
 */
function upload($path) {
    return BASE_URL . 'uploads/' . $path;
}

/**
 * Obtiene vinos por tipo
 */
function obtenerVinosPorTipo($tipo_id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT * FROM vinos WHERE tipo_id = :tipo_id");
        $stmt->execute([':tipo_id' => $tipo_id]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        die("Error al obtener vinos: " . $e->getMessage());
    }
}

/**
 * Obtiene vinos por variedad
 */
function obtenerVinosPorVariedad($variedad_id, $limit = 12, $offset = 0) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM vinos WHERE variedad_id = :variedad_id LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':variedad_id', $variedad_id, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Cuenta vinos por variedad
 */
function contarVinosPorVariedad($variedad_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM vinos WHERE variedad_id = ?");
    $stmt->execute([$variedad_id]);
    return $stmt->fetchColumn();
}

/**
 * Obtiene vinos por región
 */
function obtenerVinosPorRegion($region_id, $limit = 12, $offset = 0) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM vinos WHERE region_id = :region_id LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':region_id', $region_id, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);   
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Obtiene vinos por crianza
 */
function obtenerVinosPorCrianza($crianza_id, $limit = 12, $offset = 0) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM vinos WHERE crianza_id = :crianza_id LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':crianza_id', $crianza_id, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); 
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Obtiene vinos por rango de precio
 */
function obtenerVinosPorPrecio($precio_id, $limit = 12, $offset = 0) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM vinos WHERE precio_id = :precio_id LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':precio_id', $precio_id, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); 
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Obtiene nombre de variedad
 */
function obtenerNombreVariedad($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT nombre FROM variedades_uva WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchColumn() ?: 'Variedad Desconocida';
}

/**
 * Obtiene nombre de región
 */
function obtenerNombreRegion($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT nombre FROM regiones WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchColumn() ?: 'Región Desconocida';
}

/**
 * Obtiene nombre de crianza
 */
function obtenerNombreCrianza($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT nombre FROM crianzas WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchColumn() ?: 'Crianza Desconocida';
}

/**
 * Obtiene nombre de precio
 */
function obtenerNombrePrecio($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT etiqueta FROM precios_rango WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchColumn() ?: 'Precio Desconocido';
}

/**
 * Obtiene todos los vinos
 */
function obtenerTodosLosVinos($limit = 12, $offset = 0) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM vinos LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Busca vinos por término
 */
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

/**
 * Verifica si un usuario es administrador por ID
 */
function esAdmin($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT rol FROM usuarios WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchColumn() === 'admin';
} 