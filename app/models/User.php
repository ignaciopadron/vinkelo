<?php
/**
 * Modelo para gestionar los usuarios
 */
class User {
    private $db;
    
    /**
     * Constructor
     */
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    /**
     * Registrar un nuevo usuario
     */
    public function register($username, $email, $password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            $stmt = $this->db->prepare("
                INSERT INTO usuarios (username, email, password, rol)
                VALUES (:username, :email, :password, 'user')
            ");
            
            return $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $password_hash
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Login de usuario
     */
    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Guardar datos de sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['rol'] = $user['rol'];
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Cerrar sesión
     */
    public function logout() {
        session_unset();
        session_destroy();
        return true;
    }
    
    /**
     * Obtener usuario por ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT id, username, email, rol FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    /**
     * Verificar si el username ya existe
     */
    public function usernameExists($username) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuarios WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Verificar si el email ya existe
     */
    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Verificar si un usuario es administrador
     */
    public function isAdmin($user_id) {
        $stmt = $this->db->prepare("SELECT rol FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $user_id]);
        return $stmt->fetchColumn() === 'admin';
    }
} 