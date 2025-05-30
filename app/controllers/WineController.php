<?php
/**
 * Controlador para la gestión de vinos
 */
class WineController {
    private $wineModel;
    
    /**
     * Constructor
     */
    public function __construct($pdo) {
        require_once APP_PATH . '/models/Wine.php';
        $this->wineModel = new Wine($pdo);
    }
    
    /**
     * Mostrar listado de vinos (con filtros)
     */
    public function index() {
        $filtro = isset($_GET['filtro']) ? (int)$_GET['filtro'] : null;
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $pagina_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        
        // Configurar paginación
        $resultados_por_pagina = 12;
        $offset = ($pagina_actual - 1) * $resultados_por_pagina;
        
        // Variables para la vista
        $vinos = [];
        $total_vinos = 0;
        $titulo = 'Todos los vinos';
        $total_paginas = 1;
        
        // Obtener datos según filtro
        if ($filtro && $id) {
            switch ($filtro) {
                case 1: // Por variedad
                    $vinos = $this->wineModel->getByVariety($id, $resultados_por_pagina, $offset);
                    $total_vinos = $this->wineModel->countByVariety($id);
                    break;
                case 2: // Por región
                    $vinos = $this->wineModel->getByRegion($id, $resultados_por_pagina, $offset);
                    $total_vinos = $this->wineModel->countByRegion($id);
                    break;
                case 3: // Por crianza
                    $vinos = $this->wineModel->getByCrianza($id, $resultados_por_pagina, $offset);
                    $total_vinos = $this->wineModel->countByCrianza($id);
                    break;
                case 4: // Por tipo
                    $vinos = $this->wineModel->getByType($id, $resultados_por_pagina, $offset);
                    $total_vinos = $this->wineModel->countByType($id);
                    break;
                default:
                    // Si el filtro no es válido, mostrar todos
                    $vinos = $this->wineModel->getAll($resultados_por_pagina, $offset);
            }
            
            // Calcular total de páginas
            $total_paginas = $total_vinos > 0 ? ceil($total_vinos / $resultados_por_pagina) : 1;
        } else {
            // Si no hay filtro, mostrar todos
            $vinos = $this->wineModel->getAll($resultados_por_pagina, $offset);
        }
        
        // Preparar datos para la vista
        $data = [
            'vinos' => $vinos,
            'titulo' => $titulo,
            'pagina_actual' => $pagina_actual,
            'total_paginas' => $total_paginas,
            'filtro' => $filtro,
            'id' => $id
        ];
        
        // Cargar vistas
        require_once APP_PATH . '/views/components/header.php';
        require_once APP_PATH . '/views/wines/index.php';
        require_once APP_PATH . '/views/components/footer.php';
    }
    
    /**
     * Mostrar detalle de un vino
     */
    public function detail($id) {
        // Obtener el vino
        $vino = $this->wineModel->getById($id);
        
        if (!$vino) {
            // Si no existe, redirigir al listado
            redirect('vinos');
        }
        
        // Preparar datos para la vista
        $data = [
            'vino' => $vino
        ];
        
        // Cargar vistas
        require_once APP_PATH . '/views/components/header.php';
        require_once APP_PATH . '/views/wines/detail.php';
        require_once APP_PATH . '/views/components/footer.php';
    }
    
    /**
     * Buscar vinos
     */
    public function search() {
        $termino = isset($_GET['q']) ? sanitizarInput($_GET['q']) : '';
        $pagina_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        
        // Configurar paginación
        $resultados_por_pagina = 12;
        $offset = ($pagina_actual - 1) * $resultados_por_pagina;
        
        // Buscar vinos
        if (!empty($termino)) {
            $resultado = $this->wineModel->search($termino, $resultados_por_pagina, $offset);
            $vinos = $resultado['vinos'];
            $total_vinos = $resultado['total'];
        } else {
            // Si no hay término, mostrar todos
            $vinos = $this->wineModel->getAll($resultados_por_pagina, $offset);
            $total_vinos = count($vinos);
        }
        
        // Calcular total de páginas
        $total_paginas = $total_vinos > 0 ? ceil($total_vinos / $resultados_por_pagina) : 1;
        
        // Preparar datos para la vista
        $data = [
            'vinos' => $vinos,
            'termino' => $termino,
            'total_vinos' => $total_vinos,
            'pagina_actual' => $pagina_actual,
            'total_paginas' => $total_paginas
        ];
        
        // Cargar vistas
        require_once APP_PATH . '/views/components/header.php';
        require_once APP_PATH . '/views/wines/search.php';
        require_once APP_PATH . '/views/components/footer.php';
    }
} 