<?php
/**
 * Controlador para la página de inicio
 */
class HomeController {
    private $wineModel;
    
    /**
     * Constructor
     */
    public function __construct($pdo) {
        require_once APP_PATH . '/models/Wine.php';
        $this->wineModel = new Wine($pdo);
    }
    
    /**
     * Mostrar la página de inicio
     */
    public function index() {
        // Obtener vinos destacados para cada tipo
        $vinos_tintos = $this->wineModel->getByType(1, 4, 0); // Asumiendo que 1 es el ID de tintos
        $vinos_blancos = $this->wineModel->getByType(2, 4, 0); // Asumiendo que 2 es el ID de blancos
        $vinos_rosados = $this->wineModel->getByType(3, 4, 0); // Asumiendo que 3 es el ID de rosados
        
        // Cargar la vista
        $data = [
            'vinos_tintos' => $vinos_tintos,
            'vinos_blancos' => $vinos_blancos,
            'vinos_rosados' => $vinos_rosados
        ];
        
        // Cargar componentes principales
        require_once APP_PATH . '/views/components/header.php';
        require_once APP_PATH . '/views/home/index.php';
        require_once APP_PATH . '/views/components/footer.php';
    }
    
    /**
     * Página Quiénes Somos
     */
    public function about() {
        // Cargar componentes principales
        require_once APP_PATH . '/views/components/header.php';
        require_once APP_PATH . '/views/home/about.php';
        require_once APP_PATH . '/views/components/footer.php';
    }
    
    /**
     * Página de contacto
     */
    public function contact() {
        // Cargar componentes principales
        require_once APP_PATH . '/views/components/header.php';
        require_once APP_PATH . '/views/home/contact.php';
        require_once APP_PATH . '/views/components/footer.php';
    }
} 