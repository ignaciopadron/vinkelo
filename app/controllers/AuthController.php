<?php
/**
 * Controlador para la autenticación de usuarios
 */
class AuthController {
    private $userModel;
    
    /**
     * Constructor
     */
    public function __construct($pdo) {
        require_once APP_PATH . '/models/User.php';
        $this->userModel = new User($pdo);
    }
    
    /**
     * Mostrar formulario de login
     */
    public function showLogin() {
        // Si ya está logueado, redirigir al home
        if (isLoggedIn()) {
            redirect('');
        }
        
        // Cargar componentes principales
        require_once APP_PATH . '/views/components/header.php';
        require_once APP_PATH . '/views/auth/login.php';
        require_once APP_PATH . '/views/components/footer.php';
    }
    
    /**
     * Procesar formulario de login
     */
    public function login() {
        // Si ya está logueado, redirigir al home
        if (isLoggedIn()) {
            redirect('');
        }
        
        // Validar formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = sanitizarInput($_POST['username']);
            $password = $_POST['password'];
            
            // Intentar login
            if ($this->userModel->login($username, $password)) {
                redirect('');
            } else {
                $error = 'Credenciales incorrectas';
                
                // Cargar vistas con error
                require_once APP_PATH . '/views/components/header.php';
                require_once APP_PATH . '/views/auth/login.php';
                require_once APP_PATH . '/views/components/footer.php';
            }
        } else {
            // Si no es POST, mostrar el formulario
            $this->showLogin();
        }
    }
    
    /**
     * Mostrar formulario de registro
     */
    public function showRegister() {
        // Si ya está logueado, redirigir al home
        if (isLoggedIn()) {
            redirect('');
        }
        
        // Cargar componentes principales
        require_once APP_PATH . '/views/components/header.php';
        require_once APP_PATH . '/views/auth/register.php';
        require_once APP_PATH . '/views/components/footer.php';
    }
    
    /**
     * Procesar formulario de registro
     */
    public function register() {
        // Si ya está logueado, redirigir al home
        if (isLoggedIn()) {
            redirect('');
        }
        
        // Validar formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = sanitizarInput($_POST['username']);
            $email = sanitizarInput($_POST['email']);
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            
            $errors = [];
            
            // Validar username
            if (empty($username)) {
                $errors['username'] = 'El nombre de usuario es obligatorio';
            } elseif ($this->userModel->usernameExists($username)) {
                $errors['username'] = 'Este nombre de usuario ya está en uso';
            }
            
            // Validar email
            if (empty($email)) {
                $errors['email'] = 'El email es obligatorio';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'El email no es válido';
            } elseif ($this->userModel->emailExists($email)) {
                $errors['email'] = 'Este email ya está registrado';
            }
            
            // Validar password
            if (empty($password)) {
                $errors['password'] = 'La contraseña es obligatoria';
            } elseif (strlen($password) < 6) {
                $errors['password'] = 'La contraseña debe tener al menos 6 caracteres';
            }
            
            // Validar confirmación de password
            if ($password !== $password_confirm) {
                $errors['password_confirm'] = 'Las contraseñas no coinciden';
            }
            
            // Si no hay errores, registrar usuario
            if (empty($errors)) {
                if ($this->userModel->register($username, $email, $password)) {
                    // Login automático
                    $this->userModel->login($username, $password);
                    redirect('');
                } else {
                    $errors['general'] = 'Error al registrar el usuario';
                }
            }
            
            // Si hay errores, mostrar formulario con errores
            if (!empty($errors)) {
                $data = [
                    'username' => $username,
                    'email' => $email,
                    'errors' => $errors
                ];
                
                require_once APP_PATH . '/views/components/header.php';
                require_once APP_PATH . '/views/auth/register.php';
                require_once APP_PATH . '/views/components/footer.php';
            }
        } else {
            // Si no es POST, mostrar el formulario
            $this->showRegister();
        }
    }
    
    /**
     * Cerrar sesión
     */
    public function logout() {
        $this->userModel->logout();
        redirect('');
    }
} 