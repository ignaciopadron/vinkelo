<?php
/**
 * Controlador para la administración
 */
class AdminController {
    private $wineModel;
    
    /**
     * Constructor
     */
    public function __construct($pdo) {
        require_once APP_PATH . '/models/Wine.php';
        $this->wineModel = new Wine($pdo);
        
        // Verificar permisos de administrador
        if (!isLoggedIn() || !isAdmin()) {
            redirect('login');
        }
    }
    
    /**
     * Panel de administración principal
     */
    public function index() {
        // Obtener todos los vinos para administrar
        $vinos = $this->wineModel->getAll();
        
        // Cargar la vista
        $data = [
            'vinos' => $vinos
        ];
        
        require_once APP_PATH . '/views/components/header.php';
        require_once APP_PATH . '/views/admin/index.php';
        require_once APP_PATH . '/views/components/footer.php';
    }
    
    /**
     * Formulario para crear un nuevo vino
     */
    public function create() {
        // Obtener opciones para los selects
        $tipos = $this->getTipos();
        $regiones = $this->getRegiones();
        $variedades = $this->getVariedades();
        $crianzas = $this->getCrianzas();
        $precios = $this->getPrecios();
        
        $data = [
            'tipos' => $tipos,
            'regiones' => $regiones,
            'variedades' => $variedades,
            'crianzas' => $crianzas,
            'precios' => $precios,
            'action' => 'create'
        ];
        
        require_once APP_PATH . '/views/components/header.php';
        require_once APP_PATH . '/views/admin/wine_form.php';
        require_once APP_PATH . '/views/components/footer.php';
    }
    
    /**
     * Procesar la creación de un nuevo vino
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesar datos del formulario
            $data = [
                'nombre' => sanitizarInput($_POST['nombre']),
                'tipo_id' => (int)$_POST['tipo_id'],
                'region_id' => (int)$_POST['region_id'],
                'variedad_id' => (int)$_POST['variedad_id'],
                'crianza_id' => (int)$_POST['crianza_id'],
                'descripcion' => sanitizarInput($_POST['descripcion']),
                'precio' => (float)$_POST['precio'],
                'precio_id' => (int)$_POST['precio_id'],
                'imagen' => ''
            ];
            
            // Procesar imagen
            if (!empty($_FILES['imagen']['name'])) {
                $target_dir = PUBLIC_PATH . '/uploads/';
                $file_name = time() . '_' . basename($_FILES['imagen']['name']);
                $target_file = $target_dir . $file_name;
                
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
                    $data['imagen'] = 'uploads/' . $file_name;
                }
            }
            
            // Guardar en la base de datos
            if ($this->wineModel->create($data)) {
                redirect('admin');
            } else {
                // Si hay error, volver al formulario con mensaje
                $error = 'Error al guardar el vino';
                
                // Obtener opciones para los selects
                $tipos = $this->getTipos();
                $regiones = $this->getRegiones();
                $variedades = $this->getVariedades();
                $crianzas = $this->getCrianzas();
                $precios = $this->getPrecios();
                
                $data['tipos'] = $tipos;
                $data['regiones'] = $regiones;
                $data['variedades'] = $variedades;
                $data['crianzas'] = $crianzas;
                $data['precios'] = $precios;
                $data['error'] = $error;
                $data['action'] = 'create';
                
                require_once APP_PATH . '/views/components/header.php';
                require_once APP_PATH . '/views/admin/wine_form.php';
                require_once APP_PATH . '/views/components/footer.php';
            }
        } else {
            redirect('admin/create');
        }
    }
    
    /**
     * Formulario para editar un vino
     */
    public function edit($id) {
        // Obtener el vino a editar
        $vino = $this->wineModel->getById($id);
        
        if (!$vino) {
            redirect('admin');
        }
        
        // Obtener opciones para los selects
        $tipos = $this->getTipos();
        $regiones = $this->getRegiones();
        $variedades = $this->getVariedades();
        $crianzas = $this->getCrianzas();
        $precios = $this->getPrecios();
        
        $data = [
            'vino' => $vino,
            'tipos' => $tipos,
            'regiones' => $regiones,
            'variedades' => $variedades,
            'crianzas' => $crianzas,
            'precios' => $precios,
            'action' => 'edit'
        ];
        
        require_once APP_PATH . '/views/components/header.php';
        require_once APP_PATH . '/views/admin/wine_form.php';
        require_once APP_PATH . '/views/components/footer.php';
    }
    
    /**
     * Procesar la actualización de un vino
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener el vino actual para la imagen
            $vino_actual = $this->wineModel->getById($id);
            
            if (!$vino_actual) {
                redirect('admin');
            }
            
            // Procesar datos del formulario
            $data = [
                'nombre' => sanitizarInput($_POST['nombre']),
                'tipo_id' => (int)$_POST['tipo_id'],
                'region_id' => (int)$_POST['region_id'],
                'variedad_id' => (int)$_POST['variedad_id'],
                'crianza_id' => (int)$_POST['crianza_id'],
                'descripcion' => sanitizarInput($_POST['descripcion']),
                'precio' => (float)$_POST['precio'],
                'precio_id' => (int)$_POST['precio_id'],
                'imagen' => $vino_actual['imagen'] // Mantener la imagen actual por defecto
            ];
            
            // Procesar imagen si se ha subido una nueva
            if (!empty($_FILES['imagen']['name'])) {
                $target_dir = PUBLIC_PATH . '/uploads/';
                $file_name = time() . '_' . basename($_FILES['imagen']['name']);
                $target_file = $target_dir . $file_name;
                
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
                    $data['imagen'] = 'uploads/' . $file_name;
                    
                    // Eliminar la imagen anterior si existe y no es la default
                    if (!empty($vino_actual['imagen']) && file_exists(PUBLIC_PATH . '/' . $vino_actual['imagen'])) {
                        unlink(PUBLIC_PATH . '/' . $vino_actual['imagen']);
                    }
                }
            }
            
            // Actualizar en la base de datos
            if ($this->wineModel->update($id, $data)) {
                redirect('admin');
            } else {
                // Si hay error, volver al formulario con mensaje
                $error = 'Error al actualizar el vino';
                
                // Obtener opciones para los selects
                $tipos = $this->getTipos();
                $regiones = $this->getRegiones();
                $variedades = $this->getVariedades();
                $crianzas = $this->getCrianzas();
                $precios = $this->getPrecios();
                
                $data['vino'] = $vino_actual;
                $data['tipos'] = $tipos;
                $data['regiones'] = $regiones;
                $data['variedades'] = $variedades;
                $data['crianzas'] = $crianzas;
                $data['precios'] = $precios;
                $data['error'] = $error;
                $data['action'] = 'edit';
                
                require_once APP_PATH . '/views/components/header.php';
                require_once APP_PATH . '/views/admin/wine_form.php';
                require_once APP_PATH . '/views/components/footer.php';
            }
        } else {
            redirect('admin/edit/' . $id);
        }
    }
    
    /**
     * Eliminar un vino
     */
    public function delete($id) {
        // Obtener el vino para eliminar la imagen
        $vino = $this->wineModel->getById($id);
        
        if ($vino) {
            // Eliminar la imagen si existe
            if (!empty($vino['imagen']) && file_exists(PUBLIC_PATH . '/' . $vino['imagen'])) {
                unlink(PUBLIC_PATH . '/' . $vino['imagen']);
            }
            
            // Eliminar de la base de datos
            $this->wineModel->delete($id);
        }
        
        redirect('admin');
    }
    
    /**
     * Obtener todos los tipos de vino
     */
    private function getTipos() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM tipos_vinos");
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener todas las regiones
     */
    private function getRegiones() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM regiones");
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener todas las variedades de uva
     */
    private function getVariedades() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM variedades_uva");
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener todos los tipos de crianza
     */
    private function getCrianzas() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM crianzas");
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener todos los rangos de precio
     */
    private function getPrecios() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM precios_rango");
        return $stmt->fetchAll();
    }
} 